<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

class HuntingBookingFactory extends Factory
{
    protected $model = HuntingBooking::class;

    public function definition(): array
    {
        return [
            'tour_name'          => $this->faker->sentence(3),
            'hunter_name'        => $this->faker->firstName(),
            'guide_id'           => Guide::factory(),
            'date'               => now()->addDays(3)->toDateString(),
            'participants_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
