<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'type' => fake()->randomElement(['deposit', 'withdrawal']),
            'status' => fake()->randomElement(['pending', 'completed']),
            'payment_method' => fake()->randomElement(['bank_transfer', 'credit_card', 'paypal']),
            'description' => fake()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
} 