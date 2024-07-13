<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\EmployerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employer>
 */
class EmployerFactory extends Factory
{
    protected $model = Employer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'logo' => null,
            'description' => $this->faker->realText(),
        ];
    }

    /**
     * Configure what to do after creating
     *
     * @return Factory
     */
    public function configure(): Factory
    {
        return $this->afterCreating(function (Employer $employer) {
            $employer->address()->save(EmployerAddress::factory()->make());
        });
    }
}
