<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set up the admin user
        $name = 'Admin User';
        $email = 'admin@domain.com';
        $password = Hash::make('password');
        $email_verified_at = now();

        // Check if the admin user exists
        if (! User::where('email', $email)->exists()) {
            // Create the admin user
            /** @var User $adminUser */
            $adminUser = User::create(compact(
                'name', 'email', 'password', 'email_verified_at'
            ));

            // Get the admin role
            $adminRole = Role::findByName(Role::ADMIN);

            // Assign the admin role
            $adminUser->assignRole($adminRole);
        }
    }
}
