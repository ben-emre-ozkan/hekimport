<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\User;
use App\Models\Vitrin;
use App\Notifications\NewAppointmentRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AppointmentRequestController extends Controller
{
    /**
     * Store a new appointment request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $username)
    {
        // Find the vitrin by username
        $vitrin = Vitrin::where('subdomain', $username)
            ->where('is_active', true)
            ->firstOrFail();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|min:2|max:255',
            'patient_phone' => 'required|string|regex:/^\+905[0-9]{9}$/',
            'requested_slot' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate that the requested slot exists in the vitrin's working hours
        $validSlot = false;
        $workingHours = $vitrin->working_hours;
        
        if (is_array($workingHours)) {
            foreach ($workingHours as $day => $slots) {
                if (is_array($slots) && in_array($request->requested_slot, $slots)) {
                    $validSlot = true;
                    break;
                } elseif (is_string($slots) && $slots == $request->requested_slot) {
                    $validSlot = true;
                    break;
                }
            }
        }

        if (!$validSlot) {
            return response()->json([
                'success' => false,
                'errors' => ['requested_slot' => ['Seçilen randevu saati geçerli değil.']]
            ], 422);
        }

        try {
            // Create a new appointment request
            $appointmentRequest = new AppointmentRequest([
                'patient_name' => $request->patient_name,
                'patient_phone' => $request->patient_phone,
                'requested_slot' => $request->requested_slot,
                'status' => AppointmentRequest::STATUS_PENDING,
                'notes' => $request->notes ?? null,
            ]);

            $vitrin->appointmentRequests()->save($appointmentRequest);

            // Send notification to the dentist
            $user = $vitrin->user;
            if ($user) {
                $user->notify(new NewAppointmentRequestNotification($appointmentRequest));
            }

            return response()->json([
                'success' => true,
                'message' => 'Randevu talebiniz başarıyla gönderildi!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating appointment request: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Randevu talebi oluşturulurken bir hata oluştu. Lütfen daha sonra tekrar deneyin.'
            ], 500);
        }
    }
}
