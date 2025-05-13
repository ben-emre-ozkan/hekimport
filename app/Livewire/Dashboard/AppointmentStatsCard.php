<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;

class AppointmentStatsCard extends Component
{
    public User $user;
    public $todayAppointments = 0;
    public $weeklyAppointments = 0;
    public $upcomingAppointments = [];
    public $todayDate;

    public function mount()
    {
        $this->user = auth()->user();
        $this->todayDate = Carbon::now()->format('d.m.Y');
        $this->loadAppointmentData();
    }

    private function loadAppointmentData()
    {
        // In a real app, this would query a proper appointments table
        // For demonstration, we'll use placeholder data
        
        // Today's appointments count
        $this->todayAppointments = rand(0, 5);
        
        // Weekly appointments count
        $this->weeklyAppointments = $this->todayAppointments + rand(2, 10);
        
        // Sample upcoming appointments
        $times = ['09:30', '11:00', '14:15', '16:45', '17:30'];
        $patientNames = ['Ahmet Yılmaz', 'Ayşe Kara', 'Mehmet Demir', 'Zeynep Çelik', 'Ali Öztürk'];
        $treatments = ['Diş Çekimi', 'Dolgu', 'Kanal Tedavisi', 'Diş Taşı Temizliği', 'Kontrol'];
        
        $this->upcomingAppointments = [];
        
        // Create a few sample appointments for today
        $appointmentCount = min($this->todayAppointments, 3); // Show at most 3 appointments
        for ($i = 0; $i < $appointmentCount; $i++) {
            $randomIndex = array_rand($times);
            $this->upcomingAppointments[] = [
                'time' => $times[$randomIndex],
                'patient' => $patientNames[array_rand($patientNames)],
                'treatment' => $treatments[array_rand($treatments)],
            ];
            
            // Remove used time slot to prevent duplicates
            unset($times[$randomIndex]);
            if (empty($times)) break;
        }
        
        // Sort by time
        usort($this->upcomingAppointments, function($a, $b) {
            return strtotime($a['time']) - strtotime($b['time']);
        });
    }

    public function render()
    {
        return view('livewire.dashboard.appointment-stats-card');
    }
} 