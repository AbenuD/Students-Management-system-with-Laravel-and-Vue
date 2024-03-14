<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Admin = User::create([
            'name' => 'Abenezer', 
            'f_name' => 'Demeke',
            'email' => 'abenu@delta.com',
            'password' => Hash::make('password'),
            'address' => fake()->address(),
            'gender' => 1,
            'phone' => 911,
            'age' => 22,
            // 'cafe' => 1,
            // 'department_id' => 1,
            'batch' => 2016,
            'email_verified_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $Admin->assignRole('Admin');

        $dep_head = User::create([
            'name' => 'Delta', 
            'f_name' => 'Juliet',
            'email' => 'delta@juliet.com',
            'password' => Hash::make('password'),
            'address' => fake()->address(),
            'gender' => 1,
            'phone' => 911,
            'age' => 22,
            'cafe' => 1,
            'department_id' => 1,
            'batch' => 2016,
            'email_verified_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $dep_head->assignRole('dep_head');

        $teacher = User::create([
            'name' => 'Alem', 
            'f_name' => 'Ashu',
            'email' => 'alem@ashu.com',
            'password' => Hash::make('password'),
            'address' => fake()->address(),
            'gender' => 1,
            'phone' => 911,
            'age' => 22,
            'cafe' => 1,
            'department_id' => 1,
            'batch' => 2016,
            'email_verified_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $teacher->assignRole('teacher');

        $student = User::create([
            'name' => 'Belay', 
            'f_name' => 'Zeleke',
            'email' => 'belay@zeleke.com',
            'password' => Hash::make('password'),
            'address' => fake()->address(),
            'gender' => 1,
            'phone' => 911,
            'age' => 22,
            'cafe' => 1,
            'department_id' => 1,
            'batch' => 2016,
            'email_verified_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $student->assignRole('student');

        // $advisor = User::create([
        //     'name' => 'Belay', 
        //     'f_name' => 'Mekonen',
        //     'email' => 'belay@mekonen.com',
        //     'password' => Hash::make('password'),
        //     'address' => fake()->address(),
        //     'gender' => 1,
        //     'phone' => 911,
        //     'age' => 22,
        //     'cafe' => 1,
        //     'batch' => 2016,
        //     'email_verified_at' => now(),
        //     'updated_at' => now(),
        //     'created_at' => now(),
        // ]);
        // $advisor->assignRole('advisor');

      
    }
}