<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarkList>
 */
class MarkListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mid' => $this->faker->numberBetween(10, 30),
            'assignment' => $this->faker->numberBetween(5, 10),
            'project' => $this->faker->numberBetween(15, 20),
            'final' => $this->faker->numberBetween(1, 5),
            'stu_id' => 46,
            'teacher_id' => 76,
            'teacher_courses_id' => 1,
            // 'stu_id' => function () {
            //     return \App\Models\User::factory()->create()->id;
            // },
            // 'teacher_id' => function () {
            //     return \App\Models\User::factory()->create()->id;
            // },
            // 'department_courses' => function () {
            //     return \App\Models\Course::factory()->create()->id;
            // },
            'status' => 'pending',
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
