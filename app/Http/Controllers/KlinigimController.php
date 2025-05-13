<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class KlinigimController extends Controller
{
    /**
     * Show the kliniğim page.
     */
    public function index(): View
    {
        return view('masam.klinigim', [
            'meta' => [
                'title' => 'Kliniğim - Hekimport',
                'description' => 'Klinik yönetim merkezi',
                'keywords' => 'klinik, yönetim, hasta kayıtları, randevu, hekimport',
            ]
        ]);
    }
    
    /**
     * Handle feedback form submission.
     */
    public function submitFeedback(Request $request)
    {
        // Validate the feedback submission
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'feature_request' => 'nullable|string|max:1000',
        ]);
        
        // In a real application, store the feedback in the database
        // For testing, log the feedback
        Log::info('Feedback received', [
            'user_id' => Auth::id(),
            'feedback' => $validated['feedback'],
            'feature_request' => $validated['feature_request'] ?? null,
        ]);
        
        // Return with success message
        return redirect()->back()->with('success', 'Geribildiriminiz için teşekkürler!');
    }
} 