<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'Admin',
            'Dentist',
            'Personnel',
            'Student'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $this->command->info('Roles created successfully!');
    }
} 