<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\EmployerAddress;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the employer role
        $employerRole = Role::findByName(Role::EMPLOYER);

        // Create users
        User::factory()->count(10)->create()->each(function (User $user) use ($employerRole) {
            // Assign the role
            $user->assignRole($employerRole);

            // Create user employer
            /** @var Employer $employer */
            $employer = $user->employer()->create(Employer::factory()->make()->toArray());

            // Create employer address
            $employer->address()->create(EmployerAddress::factory()->make()->toArray());
        });
    }
}
