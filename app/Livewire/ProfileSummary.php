<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileSummary extends Component
{
    public $user;
    public $lastLogin;
    public $roleLabel;
    public $profilePhoto;
    
    public function mount()
    {
        $this->user = Auth::user();
        
        // Get last login time - in a real app you would store this in the database
        $this->lastLogin = now()->subHours(rand(1, 48))->diffForHumans();
        
        // Get role label
        $this->roleLabel = $this->user->hasRole('dentist') ? 'Diş Hekimi' : 'Kullanıcı';
        
        // Get profile photo if using media library
        if (method_exists($this->user, 'getFirstMediaUrl')) {
            $this->profilePhoto = $this->user->getFirstMediaUrl('profile_photos');
        } else {
            $this->profilePhoto = 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&color=7F9CF5&background=EBF4FF';
        }
    }
    
    public function render()
    {
        return view('livewire.profile-summary');
    }
} 