<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class NotificationsDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    
    public function mount()
    {
        // In a real app, fetch from the database
        // For demo, using dummy data
        $this->notifications = [
            [
                'id' => 1,
                'type' => 'appointment',
                'message' => 'Yeni randevu talebi alındı',
                'time' => Carbon::now()->subHours(2)->diffForHumans(),
                'read' => false,
            ],
            [
                'id' => 2,
                'type' => 'message',
                'message' => 'Ali Yılmaz size bir mesaj gönderdi',
                'time' => Carbon::now()->subHours(5)->diffForHumans(),
                'read' => false,
            ],
            [
                'id' => 3,
                'type' => 'system',
                'message' => 'Sistem bakımı yapılacak',
                'time' => Carbon::now()->subDay()->diffForHumans(),
                'read' => true,
            ],
        ];
        
        $this->unreadCount = collect($this->notifications)->where('read', false)->count();
    }
    
    public function markAsRead($id)
    {
        $index = collect($this->notifications)->search(function ($notification) use ($id) {
            return $notification['id'] === $id;
        });
        
        if ($index !== false) {
            $this->notifications[$index]['read'] = true;
            $this->unreadCount = collect($this->notifications)->where('read', false)->count();
        }
    }
    
    public function markAllAsRead()
    {
        foreach ($this->notifications as $key => $notification) {
            $this->notifications[$key]['read'] = true;
        }
        
        $this->unreadCount = 0;
    }
    
    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
} 