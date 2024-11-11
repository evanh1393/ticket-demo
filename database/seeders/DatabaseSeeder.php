<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            $this->call([
                UserSeeder::class,
                LocationSeeder::class,
                UserLocAssignmentSeeder::class,
                TicketSeeder::class,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Database seeding failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
