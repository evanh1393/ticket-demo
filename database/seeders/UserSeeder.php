<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $numUsers = 125;

        // Create 125 random users using the factory
        User::factory()->count($numUsers)->create();

        // Create or update a specific user with known credentials
        User::updateOrCreate(
            ['email' => 'your-email@example.com'], // Specify your email
            [
                'name' => 'Evan Hoefling',
                'password' => config('defaults.default_user_password'), // Specify your password
                'email_verified_at' => now(),
                'email' => 'evanh1393@gmail.com'
            ]
        );
    }
}
