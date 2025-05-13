<?php

namespace App\Notifications;

use App\Models\AppointmentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The appointment request instance.
     *
     * @var \App\Models\AppointmentRequest
     */
    protected $appointmentRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(AppointmentRequest $appointmentRequest)
    {
        $this->appointmentRequest = $appointmentRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $vitrin = $this->appointmentRequest->vitrin;
        
        return (new MailMessage)
            ->subject('Yeni Randevu Talebi')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Yeni bir randevu talebi aldınız:')
            ->line('Hasta: ' . $this->appointmentRequest->patient_name)
            ->line('Telefon: ' . $this->appointmentRequest->patient_phone)
            ->line('Talep Edilen Slot: ' . $this->appointmentRequest->requested_slot)
            ->action('Randevu Talebini Görüntüle', url('/masam/randevular'))
            ->line('Bu talebi masam panelinizden görüntüleyebilir, onaylayabilir veya reddedebilirsiniz.')
            ->salutation('Saygılarımızla, Hekimport Ekibi');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->appointmentRequest->id,
            'patient_name' => $this->appointmentRequest->patient_name,
            'patient_phone' => $this->appointmentRequest->patient_phone,
            'requested_slot' => $this->appointmentRequest->requested_slot,
            'vitrin_id' => $this->appointmentRequest->vitrin_id,
            'status' => $this->appointmentRequest->status,
            'created_at' => $this->appointmentRequest->created_at,
        ];
    }
}
