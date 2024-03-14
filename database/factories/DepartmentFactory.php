<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'departmentName' => fake()->word(),
            'noYears' => $this->faker->numberBetween(1, 5),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}