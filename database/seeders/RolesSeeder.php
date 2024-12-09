<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        $adminPermissions = [
            'manage products',
            'manage orders',
            'manage users',
            'manage brands',
            'manage categories',
        ];

        $adminRole->syncPermissions($adminPermissions);

        $vendorRole = Role::create(['name' => 'vendor']);
        $vendorPermissions = ['manage products', 'manage orders'];
        $vendorRole->syncPermissions($vendorPermissions);

        Role::create(['name' => 'customer']);
    }
}
