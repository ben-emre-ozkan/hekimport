<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlinigimPlaceholderTest extends TestCase
{
    use RefreshDatabase;

    public function test_klinigim_page_loads_for_authenticated_user(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/masam/kliniğim');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('masam.klinigim');
    }

    public function test_klinigim_page_contains_coming_soon_message(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/masam/kliniğim');

        // Assert
        $response->assertSee('Yakında'); // Looking for a "Coming Soon" text in Turkish
    }

    public function test_klinigim_page_is_protected_from_guest_users(): void
    {
        // Act
        $response = $this->get('/masam/kliniğim');

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_feedback_form_submission_success(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act - Submit feedback form
        $response = $this->actingAs($user)
            ->post('/masam/kliniğim/feedback', [
                'feedback' => 'Bu özelliği çok beğendim, harika olmuş.',
                'feature_request' => 'Randevu hatırlatma özelliği eklerseniz sevinirim.',
            ]);
            
        // Assert - If form submission is implemented, it would redirect or return success
        // If not implemented yet, this would fail and should be commented out
        $response->assertStatus(302); // Redirects after successful submission
        $response->assertSessionHas('success'); // Session has success message
    }

    public function test_feedback_form_validation_error(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act - Submit invalid feedback form (empty feedback)
        $response = $this->actingAs($user)
            ->post('/masam/kliniğim/feedback', [
                'feedback' => '', // Empty, should fail validation
                'feature_request' => 'Please add more features.',
            ]);
            
        // Assert - If validation is implemented, it would show errors
        // If not implemented yet, this would fail and should be commented out
        $response->assertStatus(302); // Redirects back with errors
        $response->assertSessionHasErrors(['feedback']); // Has validation errors
    }
} 