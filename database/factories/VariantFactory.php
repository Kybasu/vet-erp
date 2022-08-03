<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'default_code' => $this->faker->unique()->randomNumber(6),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'weight' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
