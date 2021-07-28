<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::create(['name' => 'admin']);
        Permission::create(['name'=> 'admin.products.index'])->assignRole($role_admin);
        Permission::create(['name'=> 'admin.products.create'])->assignRole($role_admin);
        Permission::create(['name'=> 'admin.products.edit'])->assignRole($role_admin);
        Permission::create(['name'=> 'admin.products.destroy'])->assignRole($role_admin);
    }
}
