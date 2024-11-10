<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'address' => $this->faker->word(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'brand' => $this->faker->randomElement(['BrandA', 'BrandB', 'BrandC', 'BrandD', 'BrandE']),
            'display_id' => Location::generateDisplayId(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
