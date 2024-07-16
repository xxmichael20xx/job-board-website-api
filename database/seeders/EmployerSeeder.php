<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\EmployerAddress;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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
            $this->setupUser($user, $employerRole);
        });

        // Create default user
        $employerTest = User::factory()->create([
            'name' => 'Employer Test',
            'email' => 'employer@domain.com',
            'password' => 'Password1'
        ]);

        $this->setupUser($employerTest, $employerRole);
    }

    /**
     * Set up the user
     *
     * @param User $user
     * @param Role|\Spatie\Permission\Models\Role $role
     * @return void
     */
    public function setupUser(User $user, Role|\Spatie\Permission\Models\Role $role): void
    {
        // Assign the role
        $user->assignRole($role);

        // Create api token
        $user->createToken('seeder-data', expiresAt: Carbon::now()->addHour());

        // Create user employer
        /** @var Employer $employer */
        $employer = $user->employer()->create(Employer::factory()->make()->toArray());

        // Create employer address
        $employer->address()->create(EmployerAddress::factory()->make()->toArray());
    }
}
