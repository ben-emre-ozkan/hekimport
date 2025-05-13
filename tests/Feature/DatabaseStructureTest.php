<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DatabaseStructureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the permission tables exist, and create them if they don't.
     */
    public function test_permission_tables_exist_or_are_created(): void
    {
        // RefreshDatabase trait should have created the roles table
        $this->assertTrue(Schema::hasTable('roles'), 'Roles table should exist after migration');
        
        // Check if model_has_roles table exists
        $this->assertTrue(Schema::hasTable('model_has_roles'), 'Model has roles table should exist');
        
        // Check if permissions table exists
        $this->assertTrue(Schema::hasTable('permissions'), 'Permissions table should exist');
        
        // Create roles if they don't exist
        Role::firstOrCreate(['name' => 'dentist']);
        Role::firstOrCreate(['name' => 'assistant']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'personnel']);
        
        // Check that roles were created
        $this->assertGreaterThan(0, Role::count(), 'Roles should be created');
    }
    
    /**
     * Test if required base tables for authentication exist.
     */
    public function test_authentication_tables_exist(): void
    {
        $this->assertTrue(Schema::hasTable('users'), 'Users table should exist');
        $this->assertTrue(Schema::hasTable('password_reset_tokens') || 
                        Schema::hasTable('password_resets'), 
                        'Password reset table should exist');
    }
} 