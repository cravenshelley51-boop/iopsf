<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'rate' => fake()->randomFloat(2, 1, 100),
            'valid_from' => now()->subDay(),
            'valid_to' => now()->addDay(),
        ];
    }
} 