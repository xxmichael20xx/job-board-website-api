<?php

namespace Database\Factories;

use App\Models\EmployerAddress;
use Faker\Provider\en_PH\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployerAddress>
 */
class EmployerAddressFactory extends Factory
{
    protected $model = EmployerAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_1' => $this->faker->streetAddress(),
            'street_2' => $this->faker->randomElement([
                $this->faker->streetAddress(),
                null
            ]),
            'city' => $this->faker->city(),
            'state' => Address::state(),
            'zip' => $this->faker->postcode(),
            'country' => $this->faker->country(),
        ];
    }
}
