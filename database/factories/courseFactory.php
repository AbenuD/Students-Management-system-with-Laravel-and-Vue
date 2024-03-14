<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class courseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'courseName' => fake()->word(),
            'courseCode' => fake()->unique()->word() ,
            'creditHour' => $this->faker->numberBetween(1, 5),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }

}
