<?php

namespace App\Http\Controllers;

use App\Models\Vitrin;
use Illuminate\Http\Request;

class VitrinController extends Controller
{
    public function show(Request $request, $slug)
    {
        $vitrin = Vitrin::where('subdomain', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Record analytics
        $vitrin->analytics()->create([
            'metric' => 'visits',
            'value' => 1,
            'date' => now()->toDateString(),
        ]);

        return view('vitrin', compact('vitrin'));
    }
} 