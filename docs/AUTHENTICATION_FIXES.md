# Authentication System Fixes for Hekimport

## Issue

The authentication system was facing an issue where the login process would throw an error after successful authentication:

```
Internal Server Error

Illuminate\Database\QueryException
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'hekimpor_main.roles' doesn't exist
```

This error occurred in the `FortifyServiceProvider.php` file when trying to check the user's role after successful login. The specific issue was that while authentication tests were passing, the actual database was missing the required `roles` table for the Spatie Permission package.

## Root Cause

1. The test environment used the `RefreshDatabase` trait, which created all necessary database tables for testing, including those for the permission system.
2. However, the production/development database hadn't run the `create_permission_tables` migration yet.
3. In the `FortifyServiceProvider`, there was no check to see if the roles table existed before attempting to call `$user->hasRole()`, leading to the error.

## Solutions Implemented

### 1. Fixed the FortifyServiceProvider

Updated the `toResponse` method in `FortifyServiceProvider.php` to check if the roles table exists before trying to use it:

```php
public function toResponse($request)
{
    $user = $request->user();
    $redirectUrl = '/masam'; // Default for dentists

    // Check if roles table exists before trying to check roles
    if (Schema::hasTable('roles') && Schema::hasTable('model_has_roles')) {
        try {
            if ($user->hasRole('admin')) {
                $redirectUrl = '/admin';
            } elseif ($user->hasRole('student') || $user->hasRole('personnel')) {
                $redirectUrl = '/dashboard';
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the login process
            Log::error('Error checking user roles: ' . $e->getMessage());
        }
    } else {
        // Log that roles table doesn't exist
        Log::warning('Roles or model_has_roles table does not exist. Using default redirection.');
    }

    return redirect()->intended($redirectUrl);
}
```

### 2. Created Database Fix Scripts

Created a `fix-permissions.php` script that can be run to check and create the necessary permission tables:

```php
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
    }
    
    // Create default roles if needed
    // ...
}
```

### 3. Added New Tests

Created new tests to specifically check for database structure issues and role-based redirection:

1. `DatabaseStructureTest.php` - Ensures all required tables exist
2. `LoginWithRolesTest.php` - Tests login and redirection for different user roles

### 4. Updated Existing Tests

Modified the `AuthenticationTest.php` to check for database structure before running role-based tests.

## How to Use the Fix

1. **Run the fix script**: `php fix-permissions.php` - This will create the needed tables and default roles
2. **Update the test user**: `php test-login.php` - This ensures a test user exists with proper role
3. **Run the tests**: `php artisan test tests/Feature/LoginWithRolesTest.php` - Verify everything is working

## Preventing Similar Issues

1. **Add Database Structure Tests**: Always include tests that verify the required database structure exists
2. **Defensive Programming**: Always check if tables exist before querying them in critical paths
3. **Run All Migrations**: Ensure that all migrations are run before deploying the application
4. **Test with Real Database**: Occasionally test with a copy of the production database schema, not just the test database

## Credits

This fix was implemented on: 2025-05-09 