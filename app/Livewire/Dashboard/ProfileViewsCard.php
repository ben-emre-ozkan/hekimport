<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;

class ProfileViewsCard extends Component
{
    public User $user;
    public $totalViews = 0;
    public $dailyViews = [];
    public $weeklyChange = 0;
    public $popularPages = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadViewData();
    }

    private function loadViewData()
    {
        // In a real app, this would query analytics data from database
        // For demonstration, we'll use placeholder data
        
        // Total profile views
        $this->totalViews = rand(100, 500);
        
        // Generate some random daily view data for the chart
        $this->dailyViews = [];
        $today = Carbon::today();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $views = rand(5, 30);
            
            $this->dailyViews[] = [
                'date' => $date->format('d.m'),
                'day' => $date->locale('tr')->shortDayName,
                'count' => $views,
            ];
        }
        
        // Calculate weekly change percentage
        $lastWeekViews = rand(80, 150);
        $thisWeekViews = array_sum(array_column($this->dailyViews, 'count'));
        $this->weeklyChange = round((($thisWeekViews - $lastWeekViews) / $lastWeekViews) * 100);
        
        // Popular pages
        $this->popularPages = [
            [
                'name' => 'Profil Sayfası',
                'views' => round($this->totalViews * 0.6),
                'percentage' => 60,
            ],
            [
                'name' => 'Hizmetler',
                'views' => round($this->totalViews * 0.25),
                'percentage' => 25,
            ],
            [
                'name' => 'Randevu Sayfası',
                'views' => round($this->totalViews * 0.15),
                'percentage' => 15,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.profile-views-card');
    }
} 