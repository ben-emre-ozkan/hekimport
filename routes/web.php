<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VitrinController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome', [
        'meta' => [
            'title' => 'Hekimport - Diş Hekimi Bul',
            'description' => 'Türkiye\'nin en kapsamlı diş hekimi arama platformu',
            'keywords' => 'diş hekimi, hekimport, dişçi ara, diş hekimi bul',
        ]
    ]);
})->name('home');

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
            return redirect()->route('filament.admin.pages.masam-dashboard');
        })->name('masa');

        Route::get('/vitrinim', function () {
            return view('vitrinim', [
                'meta' => [
                    'title' => 'Vitrinim - Hekimport',
                    'description' => 'Online görünürlüğünüzü artırın',
                    'keywords' => 'vitrin, profil, diş hekimi profili',
                ]
            ]);
        })->name('vitrinim');

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
