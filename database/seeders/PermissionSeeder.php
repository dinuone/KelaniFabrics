<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view dashboard',
            'manage employees',
            'manage customers',
            'manage products',
            'manage orders',
            'manage payments',
            'manage stock',
            'manage categories',
            'manage sub categories',
            'view reports',
            'manage roles'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
