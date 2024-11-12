<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserLocAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users who are designated as store managers
        $storeManagers = User::role('Store Manager')->get();
        $locations = Location::all();

        $storeManagers->each(function ($storeManager) {
            $location = Location::factory()->create();

            $storeManager->locations()->attach($location);
        });

        $twoStoreManagers = $storeManagers->random(25);
        $twoStoreManagers->each(function ($storeManager) use ($locations) {
            $storeManager->locations()->attach($locations->random()->id);
        });

        $threeStoreManagers = $twoStoreManagers->random(5);
        $threeStoreManagers->each(function ($storeManager) use ($locations) {
            $storeManager->locations()->attach($locations->random()->id);
        });

        // Add 3 stores to the user with the email jheary@ivyhilltech.com
        $joeUser = User::where('email', 'jheary@ivyhilltech.com')->first();
        if ($joeUser) {
            $joeUserLocations = Location::inRandomOrder()->take(3)->pluck('id');
            $joeUser->locations()->attach($joeUserLocations);
        }
    }
}
