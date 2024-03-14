<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentRequest>
 */
class StudentRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'department_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 departments
            'semister' => $this->faker->numberBetween(1, 2), // Assuming 1 or 2 semesters
            'year' => $this->faker->numberBetween(1, 5), // Assuming 5 years of study
            'cafe' => $this->faker->boolean(), // Randomly true or false
            'status' => 'pending', // Default status is 'pending'
        ];
    }
}
