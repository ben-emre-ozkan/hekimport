<?php

namespace App\Livewire;

use Livewire\Component;

class VitrinAnalytics extends Component
{
    public $chartData;
    public $filter = 'this_month'; // Default filter

    protected $listeners = ['filterChanged' => 'updateFilter'];

    public function mount()
    {
        $this->loadChartData();
    }

    public function updateFilter($newFilter)
    {
        $this->filter = $newFilter;
        $this->loadChartData();
        $this->dispatch('chartDataUpdated', $this->chartData); // Dispatch event for Alpine
    }

    public function loadChartData()
    {
        // Placeholder for your data fetching logic based on $this->filter
        // Example: Fetch data for 'this_month', 'last_month', 'this_year'
        // This should be replaced with actual data fetching logic
        $data = [];
        $labels = [];

        // Dummy data for demonstration
        switch ($this->filter) {
            case 'last_month':
                $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                $data = [150, 200, 180, 220];
                break;
            case 'this_year':
                $labels = array_map(fn($i) => "Month {$i}", range(1, 12));
                $data = array_map(fn() => rand(100, 500), range(1,12));
                break;
            case 'this_month':
            default:
                $labels = array_map(fn($i) => "Day {$i}", range(1, date('t'))); // Days in current month
                $data = array_map(fn() => rand(5, 30), range(1, date('t')));
                break;
        }

        $this->chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('Vitrin Görüntülenme Sayısı'), // Localization example
                    'data' => $data,
                    'backgroundColor' => 'rgba(0, 200, 179, 0.2)', // #00c8b3 with alpha
                    'borderColor' => 'rgba(0, 200, 179, 1)', // #00c8b3
                    'borderWidth' => 1,
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.vitrin-analytics');
    }
}
