<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Location;
use App\Models\Ticket;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'priority' => $this->faker->word(),
            'department' => $this->faker->word(),
            'location_id' => Location::factory(),
            'display_id' => $this->faker->word(),
            'category' => $this->faker->word(),
            'sub_category' => $this->faker->word(),
            'assigned_to' => $this->faker->numberBetween(-100000, 100000),
            'status' => $this->faker->word(),
            'created_by' => $this->faker->word(),
            'updated_by' => $this->faker->word(),
        ];
    }
}
