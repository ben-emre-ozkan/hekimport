<?php

namespace App\Services;

use App\Models\Appointment;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;

class GoogleCalendarService
{
    protected $calendar;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->setScopes(Calendar::CALENDAR);
        $this->calendar = new Calendar($client);
    }

    public function addEvent(Appointment $appointment)
    {
        $event = new Event([
            'summary' => "Randevu: {$appointment->name}",
            'description' => "Telefon: {$appointment->phone}\nHizmet: {$appointment->service->name}",
            'start' => new EventDateTime([
                'dateTime' => $appointment->date->format('c'),
                'timeZone' => 'Europe/Istanbul',
            ]),
            'end' => new EventDateTime([
                'dateTime' => $appointment->date->addHour()->format('c'),
                'timeZone' => 'Europe/Istanbul',
            ]),
        ]);

        return $this->calendar->events->insert('primary', $event);
    }
} 