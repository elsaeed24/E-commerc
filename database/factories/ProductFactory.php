<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;
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
        $name = $this->faker->words(2,true);
        return [
            'store_id' => Store::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $name,
            'description' => $this->faker->words(100, true),
            'slug' => Str::slug($name),
            'price' => $this->faker->numberBetween(50, 500),
            'sale_price' => $this->faker->numberBetween(50, 500),
            'quantity' => $this->faker->numberBetween(0, 20),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
