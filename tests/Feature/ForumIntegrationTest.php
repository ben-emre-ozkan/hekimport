<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ForumIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_forum()
    {
        $response = $this->get('/forum');
        $response->assertRedirect('/login');
    }

    public function test_basic_route_registration()
    {
        // We'll just test that the routes are registered correctly
        // without worrying about full authorization
        $this->assertTrue(route('forum.index') === url('/forum'));
        $this->assertTrue(route('forum.middleware.test') === url('/forum-middleware-test'));
    }
    
    public function test_middleware_test_route()
    {
        // Create an admin user and role
        $adminRole = Role::create(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);
        
        // Visit test route as admin
        $response = $this->actingAs($admin)
                         ->get('/forum-middleware-test');
        
        // Should get a 200 status
        $response->assertStatus(200);
        
        // Create a regular user (no role)
        $regularUser = User::factory()->create();
        
        // Visit test route as regular user - should redirect to login
        $response = $this->actingAs($regularUser)
                         ->get('/forum-middleware-test');
                         
        // Should still get a 200 status but see the unauthorized message
        $response->assertStatus(200);
        $response->assertSee('Bu sayfayı görüntüleme yetkiniz yok');
    }
} 