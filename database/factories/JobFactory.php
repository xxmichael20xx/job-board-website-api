<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $htmlContent = $this->faker->randomHtml();
        $cleanHtml = preg_replace('/<form\b[^>]*>(.*?)<\/form>/is', '', $htmlContent);

        return [
            'employer_id' => Employer::query()->inRandomOrder()->first()->id,
            'title' => $this->faker->jobTitle(),
            'description' => $cleanHtml,
            'expected_salary' => $this->faker->randomElement(Job::salaryRange()),
            'vacancy' => $this->faker->numberBetween(1, 100),
            'requires_resume' => $this->faker->randomElement([true, false]),
            'status' => 0,
            'expire_at' => Carbon::now()->addMonths(rand(1, 4)),
        ];
    }
}
