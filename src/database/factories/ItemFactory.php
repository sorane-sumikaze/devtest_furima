<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seller_id'   => User::factory(),
            'image'       => 'items/test.jpg',
            'item_name'   => fake()->unique()->word() . fake()->numerify('###'),
            'brand_name'  => fake()->company(),
            'price'       => fake()->numberBetween(100, 100000),
            'description' => fake()->sentence(),
            'condition'   => fake()->numberBetween(1, 4),
            'sold'        => false,
        ];
    }

    public function sold(): static
    {
        return $this->state(['sold' => true]);
    }
}
