<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rawJsonFile = File::get(database_path('data/roles_and_permissions.json'));
        $data = json_decode($rawJsonFile, true);

        foreach ($data as $item) {
            // Get the role name and role permissions
            $roleName = data_get($item, 'name');
            $rolePermissions = data_get($item, 'permissions');

            // Create or get the role by name
            /** @var Role $role */
            $role = Role::findOrCreate($roleName);

            // Loop through all role permissions
            foreach ($rolePermissions as $rolePermission) {
                // Create or get the permission
                $permission = Permission::findOrCreate($rolePermission);

                // Assign the permission to the role
                $role->givePermissionTo($permission);
            }
        }
    }
}
