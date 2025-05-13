<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StatisticsPanel extends Component
{
    public $profileViews = 0;
    public $appointments = 0;
    public $patients = 0;
    public $messages = 0;
    
    public $loading = true;
    
    // Polling interval in milliseconds
    public $pollingInterval = 30000; // 30 seconds
    
    protected $listeners = ['refreshStats' => 'loadStats'];
    
    public function mount($analytics = null)
    {
        if ($analytics) {
            $this->profileViews = $analytics['profile_views'] ?? 0;
            $this->appointments = $analytics['appointments'] ?? 0;
            $this->patients = $analytics['patients'] ?? 0;
            $this->messages = $analytics['messages'] ?? 0;
            $this->loading = false;
        } else {
            $this->loadStats();
        }
    }
    
    public function loadStats()
    {
        $this->loading = true;
        
        // In a real app, you would fetch this data from the database
        // For demo purposes, using random numbers or passing from the controller
        $this->profileViews = rand(0, 100);
        $this->appointments = rand(0, 20);
        $this->patients = rand(0, 50);
        $this->messages = rand(0, 10);
        
        $this->loading = false;
    }
    
    public function refreshStats()
    {
        $this->loadStats();
    }
    
    public function render()
    {
        return view('livewire.statistics-panel');
    }
} 