<?php

namespace App\Services;

use App\Models\SmsLog;

class SmsService
{
    public function send($vitrin_id, $phone, $message)
    {
        // Log the SMS
        SmsLog::create([
            'vitrin_id' => $vitrin_id,
            'phone' => $phone,
            'message' => $message,
            'sent_at' => now(),
        ]);

        // In a real application, you would integrate with an SMS provider here
        // For now, we'll just log it
        \Log::info("SMS to {$phone}: {$message}");

        return true;
    }
} 