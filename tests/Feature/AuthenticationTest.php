<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Check if roles table exists before trying to create roles
        if (!Schema::hasTable('roles')) {
            // Run the permission tables migration
            Artisan::call('migrate', ['--path' => 'database/migrations/2025_04_26_104624_create_permission_tables.php']);
        }
        
        // Create roles needed for testing
        Role::firstOrCreate(['name' => 'dentist']);
        Role::firstOrCreate(['name' => 'assistant']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'personnel']);
    }

    public function test_users_can_login_with_correct_credentials(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('/masam');
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_cannot_login_with_incorrect_password(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_users_cannot_login_with_email_that_does_not_exist(): void
    {
        // Arrange - No user created

        // Act
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_unauthenticated_user_redirected_to_login_when_accessing_protected_route(): void
    {
        // Act - Try to access a protected route
        $response = $this->get('/masam/vitrinim');

        // Assert - Should redirect to login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_protected_route(): void
    {
        // Arrange - Create and log in a user
        $user = User::factory()->create();
        
        // Act - Try to access a protected route as authenticated user
        $response = $this->actingAs($user)->get('/masam/vitrinim');

        // Assert - Should allow access (200 OK)
        $response->assertStatus(200);
    }

    public function test_logout_functionality(): void
    {
        // Arrange - Create and log in a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act - Logout
        $response = $this->post('/logout');

        // Assert
        $response->assertStatus(302); // Redirect after logout
        $this->assertGuest(); // User should be logged out
    }

    // New tests for registration flow

    public function test_user_can_register_with_valid_data(): void
    {
        // Act - Submit registration form
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => true, // Accept terms
        ]);

        // Assert - Should be registered and redirected
        $response->assertStatus(302);
        $response->assertRedirect('/masam'); // Should redirect to dashboard
        
        // Verify in database
        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
        
        // Check that the user is authenticated after registration
        $this->assertAuthenticated();
    }

    public function test_newly_registered_user_has_dentist_role(): void
    {
        // Act - Register a new user
        $this->post('/register', [
            'name' => 'Role Test User',
            'email' => 'roletest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => true, // Accept terms
        ]);
        
        // Verify role assignment
        $user = User::where('email', 'roletest@example.com')->first();
        $this->assertTrue($user->hasRole('dentist'));
    }

    public function test_registration_validates_email_format(): void
    {
        // Act - Submit registration with invalid email
        $response = $this->post('/register', [
            'name' => 'Invalid Email User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => true,
        ]);
        
        // Assert - Should return with validation errors
        $response->assertSessionHasErrors('email');
        
        // Verify user was not created
        $this->assertDatabaseMissing('users', [
            'name' => 'Invalid Email User',
        ]);
    }

    public function test_registration_validates_matching_passwords(): void
    {
        // Act - Submit registration with mismatched passwords
        $response = $this->post('/register', [
            'name' => 'Mismatched Passwords',
            'email' => 'mismatch@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
            'terms' => true,
        ]);
        
        // Assert - Should return with validation errors
        $response->assertSessionHasErrors('password');
        
        // Verify user was not created
        $this->assertDatabaseMissing('users', [
            'email' => 'mismatch@example.com',
        ]);
    }

    // New tests for password reset flow

    public function test_user_can_request_password_reset_link(): void
    {
        // Arrange
        Notification::fake();
        $user = User::factory()->create([
            'email' => 'reset-test@example.com',
        ]);
        
        // Act - Request password reset
        $response = $this->post('/forgot-password', [
            'email' => 'reset-test@example.com',
        ]);
        
        // Assert
        $response->assertStatus(302); // Redirect back
        $response->assertSessionHas('status'); // Should have status message
        
        // Verify notification was sent
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'password-reset@example.com',
        ]);
        
        // Create a password reset token
        $token = Password::createToken($user);
        
        // Mock the password reset event
        Event::fake([PasswordReset::class]);
        
        // Act - Reset password
        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'password-reset@example.com',
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ]);
        
        // Assert
        $response->assertStatus(302);
        
        // Refresh user from database
        $user->refresh();
        
        // Check password was updated
        $this->assertTrue(Hash::check('new-password123', $user->password));
        
        // Verify event was dispatched
        Event::assertDispatched(PasswordReset::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    public function test_password_reset_requires_valid_token(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'invalid-token@example.com',
        ]);
        
        // Act - Attempt reset with invalid token
        $response = $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => 'invalid-token@example.com',
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ]);
        
        // Assert
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        
        // Verify password was not changed
        $user->refresh();
        $this->assertFalse(Hash::check('new-password123', $user->password));
    }

    // New tests for session management

    public function test_logout_invalidates_session(): void
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Store session data
        session(['test_key' => 'test_value']);
        
        // Act - Logout
        $this->post('/logout');
        
        // Assert - Session should be invalidated
        $this->assertFalse(session()->has('test_key'));
        $this->assertGuest();
    }

    public function test_login_from_another_device_maintains_both_sessions(): void
    {
        // This test simulates login from multiple devices
        
        // Arrange - Create a user
        $user = User::factory()->create([
            'email' => 'multi-device@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // First device login
        $this->post('/login', [
            'email' => 'multi-device@example.com',
            'password' => 'password',
        ]);
        
        // Store first session ID
        $firstSessionId = session()->getId();
        
        // Clear session to simulate second device
        $this->flushSession();
        
        // Second device login
        $this->post('/login', [
            'email' => 'multi-device@example.com',
            'password' => 'password',
        ]);
        
        // Store second session ID
        $secondSessionId = session()->getId();
        
        // Assert - Sessions should be different but both valid
        $this->assertNotEquals($firstSessionId, $secondSessionId);
        $this->assertAuthenticated();
    }

    // New tests for role-based access

    public function test_user_with_dentist_role_redirected_to_masam(): void
    {
        // Arrange
        $user = User::factory()->create();
        $user->assignRole('dentist');
        
        // Act - Login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        // Assert
        $response->assertRedirect('/masam');
    }

    public function test_user_with_assistant_role_still_redirected_to_masam(): void
    {
        // Arrange
        $user = User::factory()->create();
        $user->assignRole('assistant');
        
        // Act - Login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        // Assert
        $response->assertRedirect('/masam');
    }

    public function test_user_with_no_roles_still_has_basic_access(): void
    {
        // Arrange
        $user = User::factory()->create();
        // No role assigned
        
        // Act - Login and access dashboard
        $this->actingAs($user);
        $response = $this->get('/masam');
        
        // Assert - Should still have access
        $response->assertStatus(200);
    }

    public function test_login_and_db_structure(): void
    {
        // Ensure roles table exists and has data
        $this->assertTrue(Schema::hasTable('roles'), 'Roles table must exist for role-based authentication');
        $this->assertTrue(Schema::hasTable('model_has_roles'), 'Model has roles table must exist for role assignments');
        
        // Ensure at least one role exists
        $roleCount = Role::count();
        $this->assertGreaterThan(0, $roleCount, 'At least one role must exist for role-based authentication');
        
        // Create and login a user
        $user = User::factory()->create([
            'email' => 'db-test@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Assign dentist role
        $user->assignRole('dentist');
        
        // Test login and role-based redirection
        $response = $this->post('/login', [
            'email' => 'db-test@example.com',
            'password' => 'password',
        ]);
        
        // Should redirect to masam
        $response->assertRedirect('/masam');
        $this->assertAuthenticatedAs($user);
        
        // Verify the user has the role
        $this->assertTrue($user->hasRole('dentist'), 'User should have dentist role');
    }

    /**
     * Helper method to flush the session
     */
    public function flushSession()
    {
        $this->app['session']->flush();
        $this->app->instance('session.store', $this->app['session']);
    }
} 