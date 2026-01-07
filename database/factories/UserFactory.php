<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->attach(Role::where('name', Role::ADMIN)->first());
        });
    }

    public function client(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->attach(Role::where('name', Role::CLIENT)->first());
        });
    }
} 