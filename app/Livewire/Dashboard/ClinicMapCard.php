<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class ClinicMapCard extends Component
{
    public User $user;
    public $latitude = null;
    public $longitude = null;
    public $address = '';
    public $hasAddress = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadMapData();
    }

    private function loadMapData()
    {
        // This would ideally come from a related clinic or address model
        // For demonstration, we'll assume clinic location is in the vitrin model
        if ($this->user->vitrin) {
            // Usually these would be explicit fields in the DB
            // For now, checking if address exists and has coordinates
            $this->address = $this->user->vitrin->address ?? '';
            
            // Parse coordinates (assuming they might be in JSON, or separate fields)
            // In a real app, these would be explicit lat/lng fields
            $this->hasAddress = !empty($this->address);
            
            if ($this->hasAddress) {
                // For demo, using fixed coordinates if no real ones exist
                // In production, this should use actual stored coordinates
                $this->latitude = $this->user->vitrin->latitude ?? 41.0082;  // Default to Istanbul
                $this->longitude = $this->user->vitrin->longitude ?? 28.9784;
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.clinic-map-card');
    }
} 