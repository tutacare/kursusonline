<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permission yang tersedia
        $permissions = [
            'view-course',
            'create-course',
            'edit-course',
            'delete-course',
        ];

        // Buat permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role superadmin (hanya bisa melihat)
        $admin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin->syncPermissions([
            'view-course',
        ]);

        // Buat role admin (hanya bisa melihat)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'view-course',
        ]);

        // Buat role instructor (bisa semua)
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $instructor->syncPermissions($permissions);
    }
}
