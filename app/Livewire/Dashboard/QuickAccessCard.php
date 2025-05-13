<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class QuickAccessCard extends Component
{
    public User $user;
    public $quickLinks = [];
    public $recentItems = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadQuickLinks();
    }

    private function loadQuickLinks()
    {
        // Define quick access links for the user
        $this->quickLinks = [
            [
                'name' => 'Hizmet Ekle',
                'url' => route('vitrinim') . '?tab=services&action=create',
                'icon' => 'plus-circle',
                'color' => 'text-teal-600 bg-teal-100',
            ],
            [
                'name' => 'Randevu Talepleri',
                'url' => route('vitrinim') . '?tab=appointments&filter=pending',
                'icon' => 'clock',
                'color' => 'text-blue-600 bg-blue-100',
            ],
            [
                'name' => 'Profil Düzenle',
                'url' => route('vitrinim') . '?tab=profile',
                'icon' => 'pencil-alt',
                'color' => 'text-purple-600 bg-purple-100',
            ],
            [
                'name' => 'Konum Güncelle',
                'url' => url('/masam/harita'),
                'icon' => 'location-marker',
                'color' => 'text-yellow-600 bg-yellow-100',
            ],
            [
                'name' => 'Personel Ekle',
                'url' => url('/masam/klinik') . '?tab=staff&action=create',
                'icon' => 'user-add',
                'color' => 'text-indigo-600 bg-indigo-100',
            ],
            [
                'name' => 'Çalışma Saatleri',
                'url' => url('/masam/klinik') . '?tab=hours',
                'icon' => 'calendar',
                'color' => 'text-red-600 bg-red-100',
            ],
        ];
        
        // Mock recent items (these would come from a database in a real app)
        $recentItemTypes = ['Randevu', 'Hizmet', 'Hasta', 'Profil Düzenleme'];
        $actions = ['görüntülendi', 'eklendi', 'güncellendi', 'silindi'];
        
        $this->recentItems = [];
        for ($i = 0; $i < 4; $i++) {
            $this->recentItems[] = [
                'type' => $recentItemTypes[array_rand($recentItemTypes)],
                'name' => 'Örnek ' . rand(1, 100),
                'action' => $actions[array_rand($actions)],
                'time' => now()->subMinutes(rand(5, 240))->diffForHumans(),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.quick-access-card');
    }
} 