<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Check and fix permission tables
try {
    echo "Checking if permission tables exist...\n";
    
    $hasRolesTable = Illuminate\Support\Facades\Schema::hasTable('roles');
    $hasPermissionsTable = Illuminate\Support\Facades\Schema::hasTable('permissions');
    $hasModelHasRolesTable = Illuminate\Support\Facades\Schema::hasTable('model_has_roles');
    
    if (!$hasRolesTable || !$hasPermissionsTable || !$hasModelHasRolesTable) {
        echo "Missing permission tables detected. Running permission tables migration...\n";
        
        // Run the permission tables migration
        Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/2025_04_26_104624_create_permission_tables.php',
            '--force' => true
        ]);
        
        echo "Permission tables migration completed.\n";
    } else {
        echo "Permission tables already exist.\n";
    }
    
    // Check if roles exist
    if (class_exists('\Spatie\Permission\Models\Role')) {
        $roleCount = \Spatie\Permission\Models\Role::count();
        echo "Found {$roleCount} roles in the database.\n";
        
        if ($roleCount === 0) {
            echo "Creating default roles...\n";
            
            \Spatie\Permission\Models\Role::create(['name' => 'dentist']);
            \Spatie\Permission\Models\Role::create(['name' => 'assistant']);
            \Spatie\Permission\Models\Role::create(['name' => 'admin']);
            \Spatie\Permission\Models\Role::create(['name' => 'student']);
            \Spatie\Permission\Models\Role::create(['name' => 'personnel']);
            
            echo "Default roles created successfully.\n";
        }
    }
    
    echo "Database structure check completed.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 