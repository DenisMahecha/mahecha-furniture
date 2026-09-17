<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Viti', 'Meza', 'Vitanda', 'Makabati']),
            'price' => fake()->randomFloat(2, 50000, 500000),
            'description' => fake()->sentence(),
            'image_path' => null,
            'in_stock' => true,
        ];
    }
}
