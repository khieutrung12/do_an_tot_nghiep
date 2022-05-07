<?php

namespace Database\Factories;

// use Illuminate\Support\S
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'code' => createCode($this->faker->name() . time()),
            'voucher_id' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
        ];
    }
}
