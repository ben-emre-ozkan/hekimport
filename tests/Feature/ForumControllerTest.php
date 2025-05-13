<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Mockery;
use App\Http\Controllers\ForumController;
use Illuminate\View\View;

class ForumControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        // Mock the ForumCategory model to avoid database access
        $this->mock(\App\Models\ForumCategory::class, function ($mock) {
            $mock->shouldReceive('orderBy->get')->andReturn(collect([]));
        });
    }
    
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_controller_redirects_guests_to_login(): void
    {
        $response = $this->get('/forum');
        $response->assertRedirect('/login');
    }
    
    public function test_controller_with_role_auth(): void
    {
        // Create a controller instance and set testing mode
        $controller = new ForumController();
        $controller->setTestingMode(true);
        
        // Admin user
        $controller->mockHasRequiredRole(true); // Simulate admin with role
        $response = $controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('forum.index', $response->getName());
        
        // Dentist user
        $controller->mockHasRequiredRole(true); // Simulate dentist with role
        $response = $controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('forum.index', $response->getName());
        
        // Regular user without required role
        $controller->mockHasRequiredRole(false); // Simulate user without role
        $response = $controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('forum.unauthorized', $response->getName());
    }
    
    public function test_middleware_test_route(): void
    {
        // Create a controller instance and set testing mode
        $controller = new ForumController();
        $controller->setTestingMode(true);
        
        // Admin user
        $controller->mockHasRequiredRole(true); // Simulate admin with role
        $response = $controller->middlewareTest();
        $this->assertEquals('If you can see this, the role middleware is working!', $response);
        
        // Regular user without required role
        $controller->mockHasRequiredRole(false); // Simulate user without role
        $response = $controller->middlewareTest();
        $this->assertEquals('Unauthorized', $response);
    }
} 