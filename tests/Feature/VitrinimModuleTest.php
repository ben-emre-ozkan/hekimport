<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vitrin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VitrinimModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_vitrinim_page_loads_for_authenticated_user(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/masam/vitrinim');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('masam.vitrinim');
    }

    public function test_vitrinim_page_contains_livewire_component(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/masam/vitrinim');

        // Assert
        $response->assertSeeLivewire('vitrinim-page');
    }

    public function test_can_update_vitrin_bio(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'title' => 'Dr. Test User',
            'description' => 'Professional dentist with expertise in various treatments.',
            'content' => [
                'bio' => 'Original bio',
                'specialty' => 'ortodonti',
                'city' => 'Istanbul',
                'address' => 'Test Address 123'
            ],
            'contact_info' => [
                'phone' => '5551234567',
                'email' => 'test@example.com'
            ]
        ]);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('vitrinim-page')
            ->assertSee('Original bio')  // Should see original bio
            ->set('bio', 'Updated bio with more than twenty characters to pass validation')
            ->set('title', 'Dr. Test User')
            ->set('description', 'Professional dentist with expertise in various treatments.')
            ->set('specialty', 'ortodonti')
            ->set('city', 'Istanbul')
            ->set('contact_info.phone', '5551234567')
            ->set('contact_info.email', 'test@example.com')
            ->call('saveProfile')       // Call the save method
            ->assertHasNoErrors()       // No validation errors
            ->assertDispatched('profile-saved'); // Should dispatch the saved event

        // Check database was updated
        $this->assertDatabaseHas('vitrins', [
            'id' => $vitrin->id,
            'user_id' => $user->id,
        ]);

        // Refresh the vitrin model
        $vitrin->refresh();
        $this->assertEquals('Updated bio with more than twenty characters to pass validation', $vitrin->content['bio']);
    }

    public function test_bio_validation_error_when_empty(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'title' => 'Dr. Test User',
            'description' => 'Professional dentist with expertise in various treatments.',
            'content' => [
                'bio' => 'Original bio',
                'specialty' => 'ortodonti',
                'city' => 'Istanbul',
                'address' => 'Test Address 123'
            ],
            'contact_info' => [
                'phone' => '5551234567',
                'email' => 'test@example.com'
            ]
        ]);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('vitrinim-page')
            ->set('bio', '') // Set empty bio
            ->set('title', 'Dr. Test User')
            ->set('description', 'Professional dentist with expertise in various treatments.')
            ->set('specialty', 'ortodonti')
            ->set('city', 'Istanbul')
            ->set('contact_info.phone', '5551234567')
            ->set('contact_info.email', 'test@example.com')
            ->call('saveProfile') // Try to save
            ->assertHasErrors(['bio' => 'required']); // Should have validation error
    }

    public function test_can_add_appointment_slot(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'working_hours' => [
                'Monday' => ['09:00-10:00'],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => [],
                'Saturday' => [],
                'Sunday' => []
            ]
        ]);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('vitrinim-page')
            ->set('selectedDay', 'Tuesday')
            ->set('startTime', '14:00')
            ->set('endTime', '15:00')
            ->call('addSlot') // Use the correct method name
            ->assertDispatched('slots-saved'); // Should dispatch the updated event

        // Refresh the vitrin model
        $vitrin->refresh();
        $this->assertArrayHasKey('Tuesday', $vitrin->working_hours);
        $this->assertContains('14:00-15:00', $vitrin->working_hours['Tuesday']);
    }

    public function test_can_remove_appointment_slot(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'working_hours' => [
                'Monday' => ['09:00-10:00', '10:00-11:00'],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => [],
                'Saturday' => [],
                'Sunday' => []
            ]
        ]);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('vitrinim-page')
            ->call('removeSlot', 'Monday', '09:00-10:00') // Use the correct method name
            ->assertDispatched('slots-saved'); // Should dispatch the updated event

        // Refresh the vitrin model
        $vitrin->refresh();
        $this->assertArrayHasKey('Monday', $vitrin->working_hours);
        $this->assertNotContains('09:00-10:00', $vitrin->working_hours['Monday']);
        $this->assertContains('10:00-11:00', $vitrin->working_hours['Monday']);
    }

    public function test_can_toggle_vitrin_active_status(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create([
            'user_id' => $user->id,
            'is_active' => false
        ]);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('vitrinim-page')
            ->call('toggleVisibility') // Use the correct method name
            ->assertSet('is_active', true); // Verify the value was changed

        // Refresh the vitrin model
        $vitrin->refresh();
        $this->assertTrue($vitrin->is_active);
    }
} 