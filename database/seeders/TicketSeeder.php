<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Check if there are any users and locations
        if (User::count() === 0) {
            throw new \Exception('No users found. Please run the UserSeeder first.');
        }

        if (Location::count() === 0) {
            throw new \Exception('No locations found. Please run the LocationSeeder first.');
        }

        // Log the first user found
        $user = User::inRandomOrder()->first();
        Log::info('First user found:', ['user' => $user]);

        // Create tickets using the factory
        Ticket::factory()->count(5000)->create();
    }
}
