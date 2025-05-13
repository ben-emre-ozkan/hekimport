<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = [
            'admin',
            'dentist',
            'personnel',
            'student'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $this->command->info('Roles created successfully!');

        // Create basic permissions
        $permissions = [
            'manage users',
            'view dashboard',
            'edit profile',
            'manage clinic',
            'manage patients',
            'manage appointments',
            'manage services',
            'view reports'
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $dentistRole = Role::findByName('dentist');
        $dentistRole->givePermissionTo([
            'view dashboard',
            'edit profile',
            'manage clinic',
            'manage patients',
            'manage appointments',
            'manage services',
            'view reports'
        ]);

        $personnelRole = Role::findByName('personnel');
        $personnelRole->givePermissionTo([
            'view dashboard',
            'edit profile',
            'manage patients',
            'manage appointments'
        ]);

        $studentRole = Role::findByName('student');
        $studentRole->givePermissionTo([
            'view dashboard',
            'edit profile'
        ]);

        $this->command->info('Permissions assigned to roles successfully!');
    }
}
