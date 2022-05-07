<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomDigit(),
            'brand_id' => $this->faker->unique()->randomDigit(),
            'name' => $this->faker->name(),
            'slug' => Str::slug($this->faker->sentence()),
            'quantity' => $this->faker->numberBetween(10, 50),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100000, 200000),
            'image_thumbnail' => $this->faker->imageUrl(),
            'sold' => 0,
        ];
    }
}
