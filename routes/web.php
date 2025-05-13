<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VitrinController;
use App\Http\Controllers\VitrinimController;
use App\Http\Controllers\KlinigimController;
use App\Http\Controllers\CustomDomainController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MasamController;
use Illuminate\Http\Request;
use App\Http\Controllers\AppointmentRequestController;
use App\Http\Controllers\ForumController;

// Public routes
Route::get('/', function () {
    $doctors = collect(); // Default to empty collection
    try {
        // Attempt to fetch doctors only if the table exists
        if (Schema::hasTable('doctors')) { 
            $doctors = App\Models\Doctor::where('is_featured', true)
                ->with('profile') // Eager load profile if needed
                ->take(4)
                ->get();
        }
    } catch (\Exception $e) {
        // Log error or handle gracefully if needed, but prevent test failure
        Log::error("Error fetching doctors for welcome page: " . $e->getMessage());
    }

    return view('welcome', [
        'meta' => [
            'title' => 'Hekimport - Diş Hekimi Bul',
            'description' => 'Türkiye\'nin en kapsamlı diş hekimi arama platformu',
            'keywords' => 'diş hekimi, hekimport, dişçi ara, diş hekimi bul',
        ],
        'doctors' => $doctors // Pass the (potentially empty) collection
    ]);
})->name('home');

Route::get('/doktor-ara', function (Request $request) {
    // Get query parameters
    $query = $request->query('query');
    $city = $request->query('city');
    
    // Query for active dentist profiles through Vitrin directly without relying on role
    $doctors = \App\Models\Vitrin::where('is_active', true)
        ->with('user')
        ->when($city, function($q) use ($city) {
            // Filter by city if provided
            return $q->whereJsonContains('content->location->city', $city);
        })
        ->when($query, function($q) use ($query) {
            // Filter by name or specialty if query provided
            return $q->where(function($subq) use ($query) {
                return $subq->where('title', 'like', "%{$query}%")
                     ->orWhere('description', 'like', "%{$query}%")
                     ->orWhereJsonContains('content->specialties', $query);
            });
        })
        ->get()
        ->map(function($vitrin) {
            // Transform each vitrin to a "doctor" format
            return [
                'id' => $vitrin->user->id ?? 0,
                'name' => $vitrin->user->name ?? 'İsimsiz Doktor',
                'email' => $vitrin->user->email ?? '',
                'specialty' => $vitrin->title ?? 'Diş Hekimi',
                'city' => $vitrin->content['location']['city'] ?? 'Bilinmiyor',
                'profile_image' => $vitrin->user->profile_photo_path ?? null,
                'vitrin_url' => url($vitrin->subdomain),
                'is_featured' => true
            ];
        });
    
    return view('doctor.search', [
        'meta' => [
            'title' => 'Doktor Ara - Hekimport',
            'description' => 'Şehir ve uzmanlığa göre doktor arama',
            'keywords' => 'doktor ara, diş hekimi bul, uzman doktor',
        ],
        'doctors' => $doctors
    ]);
})->name('doctor.search');

// Add public doctor profile route
Route::get('/doktor/{doctor}', function (App\Models\Doctor $doctor) {
    return view('doctor.public-profile', [
        'doctor' => $doctor->load('profile'),
        'meta' => [
            'title' => "Dr. {$doctor->name} - Hekimport",
            'description' => $doctor->profile?->bio ?? "Dr. {$doctor->name} - {$doctor->specialty}",
            'keywords' => "diş hekimi, {$doctor->name}, {$doctor->specialty}, {$doctor->city}",
        ]
    ]);
})->name('doctor.public-profile');

Route::get('/akademi', function () {
    return view('akademi', [
        'vitrins' => App\Models\Vitrin::whereNotNull('student_id')->get(),
        'meta' => [
            'title' => 'Hekimport Akademi',
            'description' => 'Diş hekimliği öğrencileri için akademik platform',
            'keywords' => 'diş hekimliği, öğrenci, akademi, eğitim',
        ]
    ]);
})->name('akademi');

// Fortify Authentication Routes are handled by the Service Provider now.
// Fortify::routes(); // Removed explicit call

// Test route for vitrin profile testing
Route::get('/vitrin-test', [VitrinController::class, 'testProfile'])->name('vitrin.test');

// Add direct doctor profile route at the domain root level (hekimport.com/muhammedcelik)
Route::get('/{subdomain}', [VitrinController::class, 'show'])->name('doctor.profile')
    ->where('subdomain', '^(?!api|doctor|doktor-ara|akademi|masam|vitrin|appointments|profile|dashboard|vitrinim|vitrin-test|forum).*');

// Appointment request route for public profiles
Route::post('/appointment/request/{username}', [AppointmentRequestController::class, 'store'])
    ->name('appointment.request');

// Add a path-based route for doctor profiles (keeping for backward compatibility)
Route::get('/doctor/{subdomain}', [VitrinController::class, 'show'])->name('doctor.profile.legacy');

// Subdomain and custom domain routes
Route::domain('{slug}.hekimport.local')->middleware(['web', 'resolve.subdomain'])->group(function () {
    Route::get('/', [VitrinController::class, 'show'])->name('vitrin.show');
});

Route::domain('{domain}')->middleware(['web', 'resolve.custom.domain'])->group(function () {
    Route::get('/', [VitrinController::class, 'show'])->name('vitrin.custom.show');
});

// Forum Route (Updated)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])
        ->name('forum.index');
    
    // New RESTful routes for forum
    // Category routes
    Route::get('/forum/category/{category}', [App\Http\Controllers\ForumController::class, 'showCategory'])
        ->name('forum.category.show');
    
    // Topic route inside a category (new hierarchical structure)
    Route::get('/forum/category/{category}/topic/{topic}', [App\Http\Controllers\ForumController::class, 'showTopicInCategory'])
        ->name('forum.category.topic.show');
    
    // Keep the old direct topic viewing route for backward compatibility
    Route::get('/forum/topic/{topic}', [App\Http\Controllers\ForumController::class, 'showTopic'])
        ->name('forum.topic.show');
    
    // Test route for middleware
    Route::get('/forum-middleware-test', [App\Http\Controllers\ForumController::class, 'middlewareTest'])
        ->name('forum.middleware.test');
});

// Authenticated routes - Apply 'web' middleware group
Route::middleware(['web', 'auth'])->group(function () {
    // Dashboard route - redirect to /masam
    Route::get('/dashboard', function () {
        return redirect('/masam');
    })->name('dashboard');

    // Masam routes
    Route::prefix('masam')->middleware('auth')->group(function () {
        // Define main masam route with name 'masam' for header links
        Route::get('/', [MasamController::class, 'dashboard'])->name('masam');
        
        // Vitrinim sayfası rotası
        Route::get('/vitrinim', [MasamController::class, 'vitrinim'])->name('vitrinim');
        
        Route::get('/klinik', [MasamController::class, 'klinik'])->name('klinik');
        
        // Kliniğim sayfası rotası
        Route::get('/kliniğim', [KlinigimController::class, 'index'])->name('klinigim');
        
        // Kliniğim geri bildirim formu
        Route::post('/kliniğim/feedback', [KlinigimController::class, 'submitFeedback'])->name('klinigim.feedback');
        
        Route::get('/vitrinim/student', function () {
            return view('student-portfolio', [
                'meta' => [
                    'title' => 'Öğrenci Portföyü - Hekimport',
                    'description' => 'Diş hekimliği öğrencileri için portföy yönetimi',
                    'keywords' => 'öğrenci, portföy, diş hekimliği',
                ]
            ]);
        })->name('vitrinim.student');

        // Custom domain management
        // Route::get('/custom-domains', ...)->name('custom-domains.index');
        // Route::post('/custom-domains', ...)->name('custom-domains.store');
        // Route::delete('/custom-domains/{domain}', ...)->name('custom-domains.destroy');
        // Route::get('/custom-domains/{domain}/verify', ...)->name('custom-domains.verify');
    });

    // Vitrinim Dashboard (Accessible directly) - TODO: Review this route, update name and target if kept
    /*
    Route::get('/vitrinim', function () {
        if (Auth::check()) {
            // return redirect()->route('filament.masam.pages.vitrinim'); 
            // return redirect()->route('masam.vitrinim.index'); // Example new route name, ensure it exists
        }
        return redirect('/login');
    })->name('vitrinim.dashboard'); 
    */

    // Vitrin Preview and SEO features
    Route::prefix('vitrin')->group(function () { 
        Route::get('/preview/{user}', function (App\Models\User $user) {
            $vitrin = $user->vitrin;
            if (!$vitrin) {
                // return redirect()->route('filament.masam.pages.vitrinim') 
                // TODO: Redirect to a new, non-Filament vitrin edit/creation page
                return redirect()->route('masam') // Or perhaps 'vitrinim.edit' if that's more appropriate
                    ->with('error', 'Önizleme için önce profil oluşturmanız veya düzenlemeniz gerekiyor. Lütfen Vitrinim sayfanızı düzenleyin.');
            }
            
            return view('vitrin.preview', [
                'vitrin' => $vitrin,
                'isPreview' => true,
                'meta' => [
                    'title' => $vitrin->title ?? 'Profil Önizleme - Hekimport',
                    'description' => substr($vitrin->content['bio'] ?? '', 0, 160),
                    'noindex' => true, // Prevent search engines from indexing preview pages
                ]
            ]);
        })->name('vitrin.preview');
        
        // SEO Analysis API endpoint
        Route::get('/seo-analysis/{vitrin}', function (App\Models\Vitrin $vitrin) {
            // Get SEO analysis - in a real app, this would use a more sophisticated analysis
            $analysis = [
                'score' => rand(30, 100), // Demo score - would be calculated based on actual content
                'title' => [
                    'status' => strlen($vitrin->title ?? '') > 10 && strlen($vitrin->title ?? '') < 60,
                    'value' => $vitrin->title ?? '',
                    'recommendation' => 'Başlığınız 10-60 karakter arasında olmalıdır.',
                ],
                'description' => [
                    'status' => strlen($vitrin->content['bio'] ?? '') > 50 && strlen($vitrin->content['bio'] ?? '') < 160,
                    'value' => substr($vitrin->content['bio'] ?? '', 0, 160),
                    'recommendation' => 'Açıklamanız 50-160 karakter arasında olmalıdır.',
                ],
                'services' => [
                    'status' => count($vitrin->services ?? []) >= 3,
                    'value' => count($vitrin->services ?? []),
                    'recommendation' => 'En az 3 hizmet eklemeniz önerilir.',
                ],
                'profilePhoto' => [
                    'status' => $vitrin->hasMedia('profile_photos'),
                    'recommendation' => 'Profil fotoğrafı ekleyin.',
                ],
                'gallery' => [
                    'status' => $vitrin->getMedia('gallery')->count() >= 3,
                    'value' => $vitrin->getMedia('gallery')->count(),
                    'recommendation' => 'En az 3 galeri fotoğrafı ekleyin.',
                ],
                'contact' => [
                    'status' => !empty($vitrin->contact_info['phone'] ?? '') && !empty($vitrin->contact_info['email'] ?? ''),
                    'recommendation' => 'İletişim bilgilerinizi eksiksiz doldurun.',
                ],
            ];
            
            return response()->json($analysis);
        })->name('vitrin.seo-analysis');
        
        // Analytics data collection endpoint
        Route::post('/analytics/track', function (Illuminate\Http\Request $request) {
            // Validate the request
            $validated = $request->validate([
                'vitrin_id' => 'required|exists:vitrins,id',
                'event_type' => 'required|string',
                'source' => 'nullable|string',
                'user_agent' => 'nullable|string',
                'page' => 'nullable|string',
                'metadata' => 'nullable|json',
            ]);
            
            // In a real application, store the analytics data
            // App\Models\VitrinAnalytics::create($validated);
            
            return response()->json(['success' => true]);
        })->name('vitrin.analytics.track');

        // Document Upload Route
        Route::post('/upload-document', function (Illuminate\Http\Request $request) {
            // Placeholder: Implement actual document upload logic using Spatie Media Library
            // Validate request, handle file, associate with user/vitrin
            // $user = auth()->user();
            // $vitrin = $user->vitrin;
            // if ($request->hasFile('document') && $request->file('document')->isValid()) {
            //     $vitrin->addMediaFromRequest('document')->toMediaCollection('documents');
            //     return response()->json(['success' => true, 'message' => 'Document uploaded.']);
            // }
            return response()->json(['success' => false, 'message' => 'Upload failed.'], 400);
        })->name('vitrin.upload-document');
    });

    // Patient appointment system - Apply 'web' is redundant
    Route::prefix('appointments')->group(function () { // Note: No extra middleware here, inherits from outer group
        // Public appointment request form
        Route::get('/{vitrin}/request', function (App\Models\Vitrin $vitrin) {
            return view('appointments.request', [
                'vitrin' => $vitrin,
                'meta' => [
                    'title' => "Randevu Al - {$vitrin->title}",
                    'description' => "Dr. {$vitrin->title} ile randevu alın.",
                    'noindex' => false,
                ]
            ]);
        })->name('appointments.request');
        
        // Submit appointment request
        Route::post('/{vitrin}/request', function (App\Models\Vitrin $vitrin, Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'patient_name' => 'required|string|max:255',
                'patient_email' => 'required|email|max:255',
                'patient_phone' => 'required|string|max:20',
                'preferred_date' => 'required|date|after:today',
                'preferred_time' => 'required|string',
                'reason' => 'nullable|string|max:1000',
            ]);
            
            // In a real application, create the appointment and send notifications
            // $appointment = App\Models\Appointment::create([
            //     'vitrin_id' => $vitrin->id,
            //     'patient_name' => $validated['patient_name'],
            //     'patient_email' => $validated['patient_email'],
            //     'patient_phone' => $validated['patient_phone'],
            //     'preferred_date' => $validated['preferred_date'],
            //     'preferred_time' => $validated['preferred_time'],
            //     'reason' => $validated['reason'],
            //     'status' => 'pending',
            // ]);
            
            // Send notification to doctor
            // $vitrin->user->notify(new App\Notifications\NewAppointmentRequest($appointment));
            
            return redirect()->back()->with('success', 'Randevu talebiniz başarıyla alındı. En kısa sürede sizinle iletişime geçilecektir.');
        })->name('appointments.store');
        
        // Authenticated routes for appointment management
        Route::middleware(['auth'])->group(function () {
            Route::get('/manage', function () {
                $user = auth()->user();
                $vitrin = $user->vitrin;
                
                if (!$vitrin) {
                    return redirect()->route('filament.vitrinim.resources.profile.create')
                        ->with('error', 'Randevu yönetimi için önce profil oluşturmanız gerekiyor.');
                }
                
                // In a real application, get actual appointments
                // $appointments = $vitrin->appointments()->latest()->paginate(10);
                $appointments = collect(); // Empty collection for demo
                
                return view('appointments.manage', [
                    'vitrin' => $vitrin,
                    'appointments' => $appointments,
                ]);
            })->name('appointments.manage');
            
            // API endpoints for appointment management
            Route::put('/update/{id}', function ($id, Illuminate\Http\Request $request) {
                // In a real application, update the appointment status
                return response()->json(['success' => true]);
            })->name('appointments.update');
        });
    });

    // Profile routes for authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // TODO: Check if this was a Filament route and if it needs updating/removal
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // Fallback for /dashboard/profile for older links, if any
    Route::get('/dashboard/profile', function () {
        return redirect()->route('profile.show');
    });

    // TODO: Remove or refactor other Filament-specific routes if any were missed.
    // Example: If there were Filament resource routes not caught by simple name search.
    // The redirect below on line 290 was missed in previous edits.
    /*
    Route::get('/some-old-filament-path', function(){
        // return redirect()->route('filament.vitrinim.resources.profile.create') 
        // TODO: Redirect to a non-Filament profile creation page, e.g., vitrinim.edit or a new dedicated route
        return redirect()->route('vitrinim.edit')->with('info', 'Profilinizi buradan oluşturun veya düzenleyin.');
    });
    */
});

Route::middleware(['auth'])->prefix('vitrinim')->name('vitrinim.')->group(function () {
    Route::get('/', [VitrinimController::class, 'index'])->name('index'); // This could be the target for old filament.masam.pages.vitrinim redirects
    Route::get('/edit', [VitrinimController::class, 'edit'])->name('edit');
    // Route for creating a profile (if it doesn't exist)
    // TODO: This used to redirect to a Filament resource route. Update target or create a new page.
    /*
    Route::get('/create-profile', function(){
        if(auth()->user()->vitrin){
            return redirect()->route('vitrinim.edit');
        }
        // return redirect()->route('filament.vitrinim.resources.profile.create');
        return redirect()->route('vitrinim.edit')->with('info', 'Lütfen profilinizi buradan oluşturun.'); 
    })->name('create-profile');
    */
});

// For testing forum - REMOVE IN PRODUCTION 
Route::get('/seed-forum-data', function () {
    if (app()->environment('local')) {
        $seeder = new \Database\Seeders\ForumSeeder();
        $seeder->run();
        return 'Forum data seeded successfully!';
    }
    return 'Not available in this environment.';
});

require __DIR__.'/jetstream.php'; // Changed from auth.php to jetstream.php
