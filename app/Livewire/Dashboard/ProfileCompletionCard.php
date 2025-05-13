<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Vitrin;

class ProfileCompletionCard extends Component
{
    public User $user;
    public $completionPercentage = 0;
    public $missingFields = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->calculateCompletionPercentage();
    }

    private function calculateCompletionPercentage()
    {
        $vitrin = $this->user->vitrin;
        $this->missingFields = [];
        
        if (!$vitrin) {
            $this->completionPercentage = 0;
            $this->missingFields[] = 'Vitrin oluşturulmadı';
            return;
        }

        $requiredFields = [
            'bio' => 'Biyografi',
            'specialties' => 'Uzmanlık Alanları',
            'education' => 'Eğitim Bilgileri',
            'certificates' => 'Sertifikalar',
            'working_hours' => 'Çalışma Saatleri',
            'services' => 'Hizmetler',
            'address' => 'Adres Bilgileri',
        ];

        $completedFields = 0;
        
        foreach ($requiredFields as $field => $label) {
            if (!empty($vitrin->$field)) {
                $completedFields++;
            } else {
                $this->missingFields[] = $label;
            }
        }

        // Check for profile photo
        if ($this->user->getFirstMediaUrl('profile_photos') || $this->user->profile_photo_url) {
            $completedFields++;
        } else {
            $this->missingFields[] = 'Profil Fotoğrafı';
        }

        $totalFields = count($requiredFields) + 1; // +1 for profile photo
        $this->completionPercentage = round(($completedFields / $totalFields) * 100);
    }

    public function render()
    {
        return view('livewire.dashboard.profile-completion-card');
    }
} 