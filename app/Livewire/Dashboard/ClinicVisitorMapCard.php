<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class ClinicVisitorMapCard extends Component
{
    public User $user;
    public $visitorData = [];
    public $totalVisitors = 0;
    public $topCities = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadVisitorData();
    }

    private function loadVisitorData()
    {
        // In a real app, this would fetch geographic data about visitors
        // For demonstration, we'll use placeholder data
        
        // Generate random city data from major Turkish cities
        $cities = [
            'İstanbul' => ['lat' => 41.0082, 'lng' => 28.9784, 'max' => 60],
            'Ankara' => ['lat' => 39.9334, 'lng' => 32.8597, 'max' => 30],
            'İzmir' => ['lat' => 38.4237, 'lng' => 27.1428, 'max' => 25],
            'Antalya' => ['lat' => 36.8969, 'lng' => 30.7133, 'max' => 20],
            'Bursa' => ['lat' => 40.1885, 'lng' => 29.0610, 'max' => 18],
            'Konya' => ['lat' => 37.8715, 'lng' => 32.4846, 'max' => 12],
            'Adana' => ['lat' => 37.0000, 'lng' => 35.3213, 'max' => 15],
            'Gaziantep' => ['lat' => 37.0662, 'lng' => 37.3833, 'max' => 10],
            'Kayseri' => ['lat' => 38.7205, 'lng' => 35.4826, 'max' => 8],
            'Trabzon' => ['lat' => 41.0053, 'lng' => 39.7153, 'max' => 7],
        ];
        
        $this->visitorData = [];
        $this->totalVisitors = 0;
        $this->topCities = [];
        
        foreach ($cities as $city => $info) {
            $visitors = rand(1, $info['max']);
            $this->totalVisitors += $visitors;
            
            $this->visitorData[] = [
                'city' => $city,
                'visitors' => $visitors,
                'lat' => $info['lat'],
                'lng' => $info['lng'],
                // Calculate circle size based on visitor count (for chart visualization)
                'radius' => max(5, sqrt($visitors) * 3), 
            ];
        }
        
        // Sort by visitors count
        usort($this->visitorData, function($a, $b) {
            return $b['visitors'] - $a['visitors'];
        });
        
        // Get top 5 cities
        $this->topCities = array_slice($this->visitorData, 0, 5);
    }

    public function render()
    {
        return view('livewire.dashboard.clinic-visitor-map-card');
    }
} 