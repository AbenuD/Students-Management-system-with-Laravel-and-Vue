<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherCourses>
 */
class TeacherCoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_courses_id' => 1,
            'teacher_id' => 76,

            // 'department_courses_id' => function () {
            //     return \App\Models\Course::factory()->create()->id;
            // },
            // 'teacher_id' => function () {
            //     return \App\Models\User::factory()->create()->id;
            // },
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
