<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class ClinicSummaryCard extends Component
{
    public User $user;
    public $workingHours = [];
    public $staffCount = 0;
    public $equipmentCount = 0;
    public $hasClinicInfo = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadClinicData();
    }

    private function loadClinicData()
    {
        // This would ideally come from a Clinic model or similar
        // For now, mocking some data based on expected structure
        
        // Check if clinic info exists
        $this->hasClinicInfo = $this->user->vitrin && !empty($this->user->vitrin->clinic_info);
        
        if ($this->hasClinicInfo) {
            // Parse working hours (assuming JSON structure in DB)
            $workingHoursData = $this->user->vitrin->working_hours ?? '{}';
            if (is_string($workingHoursData)) {
                $workingHoursData = json_decode($workingHoursData, true) ?? [];
            }
            
            $days = [
                'monday' => 'Pazartesi',
                'tuesday' => 'Salı',
                'wednesday' => 'Çarşamba',
                'thursday' => 'Perşembe',
                'friday' => 'Cuma',
                'saturday' => 'Cumartesi',
                'sunday' => 'Pazar',
            ];
            
            foreach ($days as $day => $turkishDay) {
                if (isset($workingHoursData[$day]) && !empty($workingHoursData[$day])) {
                    $this->workingHours[$turkishDay] = $workingHoursData[$day];
                }
            }
            
            // Get staff count (from relationship)
            $this->staffCount = $this->user->personel()->count();
            
            // Equipment count would come from a potential equipment table/relation
            // Mocking for now
            $this->equipmentCount = rand(3, 10);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.clinic-summary-card');
    }
} 