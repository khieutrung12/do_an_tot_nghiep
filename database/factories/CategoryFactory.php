<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
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
            'name' => $this->faker->name(),
            'slug' => Str::slug($this->faker->name()),
            'parent_id' => $this->faker->randomDigit(),
        ];
    }
}
