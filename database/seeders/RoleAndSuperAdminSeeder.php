<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;  // <--- Add this line

class RoleAndSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        $admin = User::firstOrCreate([
            'email' => 'admin@kelanifabrics.com',
        ], [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'password' => bcrypt('123456'),
        ]);

        $admin->assignRole($role);
        $role->givePermissionTo(['view dashboard', 
                                 'manage roles',
                                 'manage employees', 
                                 'manage customers', 
                                 'manage products', 
                                 'manage orders', 
                                 'manage payments', 
                                 'manage stock', 
                                 'manage categories', 
                                 'view reports',
                                 'manage sub categories',]);
    }
}
