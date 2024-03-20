<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => fake('tr_TR')->text(20),
            'image' => "https://picsum.photos/640/480?random=" . rand(1, 1000),
            'description' => fake('tr_TR')->text(),
            'price' => rand(1, 1000)
        ];
    }
}
