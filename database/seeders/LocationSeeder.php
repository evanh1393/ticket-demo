<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users who are designated as store managers
        $storeManagers = User::role('Store Manager')->get();

        // Assign each store manager to a location
        foreach ($storeManagers as $index => $storeManager) {
            $location = Location::factory()->create();

            $storeManager->locations()->attach($location);
        }
    }
}
