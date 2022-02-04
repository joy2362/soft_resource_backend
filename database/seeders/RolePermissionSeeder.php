<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'edit category']);

        Permission::create(['name' => 'view sub-category']);
        Permission::create(['name' => 'create sub-category']);
        Permission::create(['name' => 'delete sub-category']);
        Permission::create(['name' => 'edit sub-category']);

        Permission::create(['name' => 'view item']);
        Permission::create(['name' => 'create item']);
        Permission::create(['name' => 'delete item']);
        Permission::create(['name' => 'edit item']);

        Permission::create(['name' => 'view setting']);
        Permission::create(['name' => 'create setting']);
        Permission::create(['name' => 'delete setting']);
        Permission::create(['name' => 'edit setting']);

        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'create admin']);
        Permission::create(['name' => 'delete admin']);
        Permission::create(['name' => 'edit admin']);

        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'edit role']);

        $systemAdmin = Role::create(['name' => 'System Admin']);
        $systemAdmin->givePermissionTo(Permission::all());
        $SuperAdmin = Role::create(['name' => ' Super Admin']);
        $SuperAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

    }
}
