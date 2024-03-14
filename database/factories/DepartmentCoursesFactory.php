<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentCourses>
 */
class DepartmentCoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->numberBetween(1, 5),
            'semister' => $this->faker->numberBetween(1, 2),
            'department_id' => function () {
                return \App\Models\Department::factory()->create()->id;
            },
            'course_id' => function () {
                return \App\Models\Course::factory()->create()->id;
            },
            'updated_at' => now(),
            'created_at' => now(),
        ];

    }
}
