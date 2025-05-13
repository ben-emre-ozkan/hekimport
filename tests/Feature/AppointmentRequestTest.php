<?php

namespace Tests\Feature;

use App\Models\AppointmentRequest;
use App\Models\User;
use App\Models\Vitrin;
use App\Notifications\NewAppointmentRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AppointmentRequestTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A test for creating an appointment request without authentication.
     */
    public function test_can_create_appointment_request_without_authentication(): void
    {
        Notification::fake();

        // Create a dentist user with a vitrin
        $user = User::factory()->create();
        
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'subdomain' => 'testdentist',
            'is_active' => true,
            'working_hours' => [
                'Pazartesi' => ['09:00-10:00', '10:00-11:00', '11:00-12:00'],
                'Salı' => ['13:00-14:00', '14:00-15:00', '15:00-16:00'],
            ],
        ]);

        // Test data
        $requestData = [
            'patient_name' => 'Test Patient',
            'patient_phone' => '+905551234567',
            'requested_slot' => 'Pazartesi 09:00-10:00',
        ];

        // Send request
        $response = $this->postJson('/appointment/request/testdentist', $requestData);

        // Assert response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Randevu talebiniz başarıyla gönderildi!'
            ]);

        // Assert database
        $this->assertDatabaseHas('appointment_requests', [
            'vitrin_id' => $vitrin->id,
            'patient_name' => 'Test Patient',
            'patient_phone' => '+905551234567',
            'requested_slot' => 'Pazartesi 09:00-10:00',
            'status' => AppointmentRequest::STATUS_PENDING,
        ]);

        // Assert notification
        Notification::assertSentTo(
            $user,
            NewAppointmentRequestNotification::class,
            function ($notification, $channels) use ($vitrin) {
                return $notification->appointmentRequest->vitrin_id === $vitrin->id;
            }
        );
    }

    /**
     * A test for validation errors.
     */
    public function test_appointment_request_validation(): void
    {
        // Create a dentist user with a vitrin
        $user = User::factory()->create();
        
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'subdomain' => 'testdentist',
            'is_active' => true,
            'working_hours' => [
                'Pazartesi' => ['09:00-10:00'],
            ],
        ]);

        // Invalid test data (missing name)
        $requestData = [
            'patient_phone' => '+905551234567',
            'requested_slot' => 'Pazartesi 09:00-10:00',
        ];

        // Send request
        $response = $this->postJson('/appointment/request/testdentist', $requestData);

        // Assert validation error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_name']);

        // Invalid phone format
        $requestData = [
            'patient_name' => 'Test Patient',
            'patient_phone' => '5551234567', // Missing +90 prefix
            'requested_slot' => 'Pazartesi 09:00-10:00',
        ];

        // Send request
        $response = $this->postJson('/appointment/request/testdentist', $requestData);

        // Assert validation error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_phone']);

        // Invalid slot
        $requestData = [
            'patient_name' => 'Test Patient',
            'patient_phone' => '+905551234567',
            'requested_slot' => 'Pazartesi 14:00-15:00', // Not available
        ];

        // Send request
        $response = $this->postJson('/appointment/request/testdentist', $requestData);

        // Assert validation error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['requested_slot']);
    }

    /**
     * A test for appointment request with non-existent vitrin.
     */
    public function test_appointment_request_with_non_existent_vitrin(): void
    {
        // Test data
        $requestData = [
            'patient_name' => 'Test Patient',
            'patient_phone' => '+905551234567',
            'requested_slot' => 'Pazartesi 09:00-10:00',
        ];

        // Send request to non-existent vitrin
        $response = $this->postJson('/appointment/request/nonexistentvitrin', $requestData);

        // Assert response
        $response->assertStatus(404);
    }
}
