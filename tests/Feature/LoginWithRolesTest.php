<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginWithRolesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles needed for testing
        Role::firstOrCreate(['name' => 'dentist']);
        Role::firstOrCreate(['name' => 'assistant']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'personnel']);
    }
    
    /**
     * Test that a user with dentist role can login and is redirected to /masam
     */
    public function test_dentist_login_and_redirect(): void
    {
        // Create a user with dentist role
        $user = User::factory()->create([
            'email' => 'dentist@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('dentist');
        
        // Attempt login
        $response = $this->post('/login', [
            'email' => 'dentist@example.com',
            'password' => 'password',
        ]);
        
        // Verify redirect
        $response->assertStatus(302);
        $response->assertRedirect('/masam');
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test that a user with admin role can login and is redirected to /admin
     */
    public function test_admin_login_and_redirect(): void
    {
        // Create a user with admin role
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');
        
        // Attempt login
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        
        // Verify redirect
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test that a user with student role can login and is redirected to /dashboard
     */
    public function test_student_login_and_redirect(): void
    {
        // Create a user with student role
        $user = User::factory()->create([
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('student');
        
        // Attempt login
        $response = $this->post('/login', [
            'email' => 'student@example.com',
            'password' => 'password',
        ]);
        
        // Verify redirect
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test that a simulated test user works just like the real one
     */
    public function test_simulated_test_user_login(): void
    {
        // Create a test user equivalent
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test-simulated@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('dentist');
        
        // Attempt login with the test user
        $response = $this->post('/login', [
            'email' => 'test-simulated@example.com',
            'password' => 'password',
        ]);
        
        // Verify redirect
        $response->assertStatus(302);
        $response->assertRedirect('/masam');
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test edge case: what happens if user has multiple roles with different redirects
     */
    public function test_user_with_multiple_roles(): void
    {
        // Create a user with multiple roles
        $user = User::factory()->create([
            'email' => 'multi-role@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('dentist');
        $user->assignRole('admin'); // Admin should take precedence
        
        // Attempt login
        $response = $this->post('/login', [
            'email' => 'multi-role@example.com',
            'password' => 'password',
        ]);
        
        // Should redirect to admin since that check comes first in the provider
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }
} 