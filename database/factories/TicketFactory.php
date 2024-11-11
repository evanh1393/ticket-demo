<?php

namespace Database\Factories;

use App\Enums\TicketDepartment;
use App\Enums\TicketStatus;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

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
        $createdAt = $this->faker->dateTimeBetween('-2 years', 'now');
        $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');

        $user = User::inRandomOrder()->first();
        Log::info('User in TicketFactory:', ['user' => $user]);

        if (!$user) {
            throw new \Exception('No users found. Please ensure users exist before running the TicketFactory.');
        }

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'priority' => $this->faker->word(),
            'department' => $this->faker->randomElement(TicketDepartment::cases())->value,
            'location_id' => Location::inRandomOrder()->first()->id,
            'display_id' => Ticket::generateDisplayId(),
            'category' => $this->faker->word(),
            'sub_category' => $this->faker->word(),
            'assigned_to' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(TicketStatus::cases())->value,
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
