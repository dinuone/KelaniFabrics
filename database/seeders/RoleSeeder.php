<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Admin gets everything
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Manager gets selected permissions
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = [
            'view dashboard',
            'manage employees',
            'manage customers',
            'manage orders',
            'manage payments',
            'view reports',
    
        ];
        $managerRole->syncPermissions($managerPermissions);

        // Staff gets limited permissions
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffPermissions = [
            'manage orders',
            'manage payments',
        ];
        $staffRole->syncPermissions($staffPermissions);
    }
}
