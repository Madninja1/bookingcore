<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'name'             => $this->faker->name(),
            'experience_years' => $this->faker->numberBetween(0, 15),
            'is_active'        => true,
        ];
    }
}
