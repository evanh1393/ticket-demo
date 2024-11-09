<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Location;

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
            'brand' => $this->faker->word(),
            'display_id' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
