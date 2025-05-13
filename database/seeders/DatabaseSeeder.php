<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First seed roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Create test admin user
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);

        // Assign admin role to test user
        $user->assignRole('admin');

        $this->call([
            // DoctorSeeder::class, // Removed in favor of DummyDentistsSeeder
            DummyDentistsSeeder::class, // Add our new dummy dentists seeder
            ForumCategorySeeder::class, // Ensure forum categories are seeded
            SimpleForumSeeder::class, // Add forum content using our dummy dentists (simpler version)
        ]);
    }
}
