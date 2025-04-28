<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VitrinController;
use App\Http\Controllers\VitrinimController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome', [
        'meta' => [
            'title' => 'Hekimport - Diş Hekimi Bul',
            'description' => 'Türkiye\'nin en kapsamlı diş hekimi arama platformu',
            'keywords' => 'diş hekimi, hekimport, dişçi ara, diş hekimi bul',
        ],
        'doctors' => App\Models\Doctor::where('is_featured', true)
            ->with('profile')
            ->take(4)
            ->get()
    ]);
})->name('home');

Route::get('/doktor-ara', function () {
    return view('doctor.search', [
        'meta' => [
            'title' => 'Doktor Ara - Hekimport',
            'description' => 'Şehir ve uzmanlığa göre doktor arama',
            'keywords' => 'doktor ara, diş hekimi bul, uzman doktor',
        ]
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

// Subdomain routes
Route::domain('{slug}.hekimport.local')->middleware('web')->group(function () {
    Route::get('/', [VitrinController::class, 'show'])->name('vitrin.show');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Masam routes
    Route::prefix('masa')->group(function () {
        Route::get('/', function () {
            // Direct URL redirect since we couldn't get named routes working
            // This will be more reliable as it doesn't depend on route names
            return redirect('/masa/dashboard');
        })->name('masa');
        
        // Fallback dashboard route in case Filament's routes aren't working
        Route::get('/dashboard', function () {
            return view('filament.pages.masam-dashboard', [
                'title' => 'Masam Dashboard',
                'user' => auth()->user(),
            ]);
        })->name('masa.dashboard');
        
        // Use the controller for vitrinim route
        Route::get('/vitrinim', [VitrinimController::class, 'index'])->name('vitrinim');

        Route::get('/vitrinim/student', function () {
            return view('student-portfolio', [
                'meta' => [
                    'title' => 'Öğrenci Portföyü - Hekimport',
                    'description' => 'Diş hekimliği öğrencileri için portföy yönetimi',
                    'keywords' => 'öğrenci, portföy, diş hekimliği',
                ]
            ]);
        })->name('vitrinim.student');

        Route::get('/klinik', function () {
            return view('klinik', [
                'meta' => [
                    'title' => 'Kliniğim - Hekimport',
                    'description' => 'Klinik yönetimi ve süreç optimizasyonu',
                    'keywords' => 'klinik yönetimi, diş kliniği, randevu yönetimi',
                ]
            ]);
        })->name('klinik');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
