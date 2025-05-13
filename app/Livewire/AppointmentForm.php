<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class AppointmentForm extends Component
{
    public $name = '';
    public $phone = '';
    public $date = '';
    public $service = '';
    public $search = '';
    public Collection $services;

    protected $rules = [
        'name' => 'required|min:3',
        'phone' => 'required|regex:/^[0-9]{10}$/',
        'date' => 'required|date|after:today',
        'service' => 'required|exists:services,id',
    ];

    public function mount(Collection $services)
    {
        $this->services = $services;
    }

    public function storeAppointment()
    {
        $this->validate();

        // Check if the time slot is available
        if (!$this->isTimeSlotAvailable()) {
            $this->addError('date', 'Seçilen tarih ve saat dolu. Lütfen başka bir zaman seçin.');
            return;
        }

        // Create appointment
        $appointment = Appointment::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'date' => $this->date,
            'service_id' => $this->service,
            'status' => 'pending',
        ]);

        // Add to Google Calendar
        $calendar = app(GoogleCalendarService::class);
        $calendar->addEvent($appointment);

        // Clear form
        $this->reset(['name', 'phone', 'date', 'service']);

        // Show success message
        session()->flash('message', 'Randevunuz başarıyla oluşturuldu. En kısa sürede sizinle iletişime geçeceğiz.');
    }

    protected function isTimeSlotAvailable()
    {
        return Cache::remember("time_slot_{$this->date}", 60, function () {
            return !Appointment::where('date', $this->date)
                ->where('status', '!=', 'cancelled')
                ->exists();
        });
    }

    public function render()
    {
        $filteredServices = $this->search
            ? collect($this->services)->filter(function ($service) {
                return str_contains(strtolower($service['name']), strtolower($this->search));
            })
            : $this->services;

        return view('components.profile.booking-form', [
            'services' => $filteredServices
        ]);
    }
} 