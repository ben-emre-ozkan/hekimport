<?php

namespace App\Http\Controllers;

use App\Models\Vitrin;
use App\Models\VitrinAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VitrinimController extends Controller
{
    /**
     * Display the vitrinim management page
     */
    public function index(): View
    {
        // Check if user has a vitrin
        $user = Auth::user();
        $vitrin = Vitrin::firstOrNew(['user_id' => $user->id]);
        
        // Get analytics data for the past 7 days if vitrin exists and has an ID
        $analyticsData = [];
        if ($vitrin->exists) {
            $analyticsData = $this->getAnalyticsData($vitrin);
        }
        
        return view('vitrinim', [
            'meta' => [
                'title' => 'Vitrinim - Hekimport',
                'description' => 'Online görünürlüğünüzü artırın',
                'keywords' => 'vitrin, profil, diş hekimi profili',
            ],
            'vitrin' => $vitrin,
            'analytics' => $analyticsData
        ]);
    }
    
    /**
     * Get analytics data for a vitrin
     */
    private function getAnalyticsData(Vitrin $vitrin): array
    {
        $startDate = now()->subDays(7)->toDateString();
        $endDate = now()->toDateString();
        
        // Get visits for the past 7 days
        $visits = VitrinAnalytic::where('vitrin_id', $vitrin->id)
            ->where('metric', 'visits')
            ->whereBetween('date', [$startDate, $endDate])
            ->select('date', \DB::raw('SUM(value) as total'))
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
            
        // Get total visits
        $totalVisits = VitrinAnalytic::where('vitrin_id', $vitrin->id)
            ->where('metric', 'visits')
            ->sum('value');
            
        // Get total clicks (if tracked)
        $totalClicks = VitrinAnalytic::where('vitrin_id', $vitrin->id)
            ->where('metric', 'clicks')
            ->sum('value');
            
        // Calculate percent change if we have enough data
        $previousPeriodVisits = VitrinAnalytic::where('vitrin_id', $vitrin->id)
            ->where('metric', 'visits')
            ->whereBetween('date', [now()->subDays(14)->toDateString(), now()->subDays(8)->toDateString()])
            ->sum('value');
            
        $percentChange = 0;
        if ($previousPeriodVisits > 0) {
            $percentChange = round((($totalVisits - $previousPeriodVisits) / $previousPeriodVisits) * 100);
        }
        
        return [
            'visits' => $visits,
            'totalVisits' => $totalVisits,
            'totalClicks' => $totalClicks,
            'percentChange' => $percentChange,
        ];
    }
} 