<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\HuntingBooking;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $guides = Guide::factory(10)->create();

        $guides->each(function (Guide $guide) {
            $count = fake()->numberBetween(1, 3);
            $offsets = collect(range(1, 60))->shuffle()->take($count);

            foreach ($offsets as $d) {
                HuntingBooking::factory()->create([
                    'guide_id' => $guide->id,
                    'date'     => now()->addDays($d)->toDateString(), // только дата
                ]);
            }
        });
    }
}
