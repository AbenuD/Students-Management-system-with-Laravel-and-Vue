<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  \App\Models\MarkList::factory()->create();
        //  \App\Models\TeacherCourses::factory()->create();
        //  \App\Models\StudentRequest::factory(50)->create();
         \App\Models\User::factory(3)->create();

        //  \App\Models\Course::factory(12)->create();
        //  \App\Models\Department::factory(2)->create();
        //  \App\Models\DepartmentCourses::factory(5)->create();
        //  $this->call([
        //     PermissionSeeder::class,
        //     RoleSeeder::class,
        //     SuperAdminSeeder::class,
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
