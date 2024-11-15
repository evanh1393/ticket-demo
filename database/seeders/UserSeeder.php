<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Retrieve roles
        $adminRole = Role::findByName('Admin');
        $distManagerRole = Role::findByName('District Manager');
        $facilitiesRole = Role::findByName('Facilities Agent');
        $itRole = Role::findByName('IT Agent');
        $basicRole = Role::findByName('Basic User');
        $storeManagerRole = Role::findByName('Store Manager');

        // Create users and assign roles
        User::factory()->count(4)->create()->each(function ($user) use ($adminRole) {
            $user->assignRole($adminRole);
        });

        User::factory()->count(6)->create()->each(function ($user) use ($distManagerRole) {
            $user->assignRole($distManagerRole);
        });

        User::factory()->count(2)->create()->each(function ($user) use ($facilitiesRole) {
            $user->assignRole($facilitiesRole);
        });

        User::factory()->count(2)->create()->each(function ($user) use ($itRole) {
            $user->assignRole($itRole);
        });

        User::factory()->count(6)->create()->each(function ($user) use ($basicRole) {
            $user->assignRole($basicRole);
        });

        User::factory()->count(105)->create()->each(function ($user) use ($storeManagerRole) {
            $user->assignRole($storeManagerRole);
        });

        // Create or update a specific user with known credentials
        $evanAdmin = User::updateOrCreate(
            ['email' => 'evanh1393@gmail.com'],
            [
                'name' => 'Evan Hoefling',
                'password' => config('defaults.default_user_password'),
                'email_verified_at' => now(),
                'email' => 'evanh1393@gmail.com'
            ]
        );

        $evanAdmin->assignRole($adminRole);

        $joeUser = User::updateOrCreate(
            ['email' => 'jheary@ivyhilltech.com'],
            [
                'name' => 'Joseph Heary',
                'password' => 'password123',
                'email_verified_at' => now(),
                'email' => 'jheary@ivyhilltech.com'
            ]
        );

        $joeUser->assignRole($storeManagerRole);
    }
}
