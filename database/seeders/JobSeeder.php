<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Picklist;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::factory()
            ->count(10)
            ->create()
            ->each(function (Job $job) {
                /** @var Picklist $jobSkills */
                $jobSkills = Picklist::query()
                    ->where('slug', 'job-skills')
                    ->first();

                // Get random skills
                $skills = $jobSkills->items()
                    ->inRandomOrder()
                    ->limit(rand(1, 5))
                    ->pluck('id')
                    ->toArray();

                $job->skills()->sync($skills);
            });
    }
}
