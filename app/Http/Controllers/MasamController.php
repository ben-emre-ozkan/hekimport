<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class MasamController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is already applied in route definition
        // No need to apply it here
    }

    /**
     * Show the main dashboard for Masam.
     */
    public function dashboard(): View
    {
        // Get user analytics data - in real app would fetch from database
        $analytics = [
            'profile_views' => 0,
            'appointments' => 0,
            'patients' => 0,
            'messages' => 0,
        ];
        
        return view('masam.dashboard', [
            'analytics' => $analytics
        ]);
    }

    /**
     * Show the vitrinim management page.
     */
    public function vitrinim(): View
    {
        // Simplified controller method - logic is now in the Livewire component
        return view('masam.vitrinim');
    }

    /**
     * Show the klinik management page.
     */
    public function klinik(): View
    {
        return view('masam.klinik', [
            'meta' => [
                'title' => 'Kliniğim - Hekimport',
                'description' => 'Klinik yönetim paneli',
                'keywords' => 'klinik, yönetim, hekimport',
            ]
        ]);
    }

    /**
     * Show the kliniğim management page.
     */
    public function klinigim(): View
    {
        return view('masam.klinigim', [
            'meta' => [
                'title' => 'Kliniğim - Hekimport',
                'description' => 'Klinik yönetim merkezi',
                'keywords' => 'klinik, yönetim, hasta kayıtları, randevu, hekimport',
            ]
        ]);
    }
} 