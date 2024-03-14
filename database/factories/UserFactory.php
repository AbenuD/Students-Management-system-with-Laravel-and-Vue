<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'f_name' => fake()->name(),
            'address' => fake()->address(),
            'gender' => $this->faker->boolean(),
            'phone' => 911,
             'department_id' => 1,
            'age' => $this->faker->numberBetween(21, 55),
            'cafe' => $this->faker->boolean(),
            'batch' => $this->faker->numberBetween(2020, 2025),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Assign a role to the user after it has been created
            $user->assignRole('teacher'); // Replace 'student' with the actual role name
        });
    }
}
