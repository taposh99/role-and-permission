<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = Role::create(['name' => 'admin']);
        // $user = Role::create(['name' => 'user']);

        // // Create Permissions
        // $permissions = [
        //     'edit articles',
        //     'delete articles',
        //     'publish articles',
        //     'unpublish articles',
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // // Assign all permissions to admin
        // $admin->givePermissionTo(Permission::all());

        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $roleUser = Role::create(['name' => 'user']);
    
        // Create Permissions
        $permissionCreateProduct = Permission::create(['name' => 'create product']);
        $permissionEditProduct = Permission::create(['name' => 'edit product']);
    
        // Assign Permissions to Roles
        $roleSuperAdmin->givePermissionTo($permissionCreateProduct);
        $roleSuperAdmin->givePermissionTo($permissionEditProduct);
    
        // Optionally, directly assign permissions to a super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $superAdmin->assignRole($roleSuperAdmin);

    
    }
    
}
