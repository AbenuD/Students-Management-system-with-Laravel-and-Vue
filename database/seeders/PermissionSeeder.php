<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'admin.create-role',
            'admin.edit-role',
            'admin.delete-role',
            'admin.create-user',
            'admin.edit-user',
            'admin.delete-user',
            'create-grade',
            'edit-grade',
            'delete-grade',
            'student.view_profile',
            'student.view_grades',
            'student.register_courses',
            'student.communicate_instructors',
            'student.access_resources',
            'student.view_services',
            'teacher.view_class_roster',
            'teacher.submit_grades',
            'teacher.manage_course_content',
            'teacher.communicate_students',
            'advisor.view_student_profile',
            'advisor.track_academic_progress',
            'advisor.provide_advice',
            'advisor.approve_request',
            'dep_head.view_department_courses',
            'dep_head.manage_faculty_workload',
            'dep_head.approve_course_schedules',
            'dep_head.manage_resources',
            'dep_head.assign_advisor',
            'admin.manage_enrollment',
            'admin.manage_class_scheduling',
            'admin.enforce_academic_policies',
            'admin.manage_student_data',
            'super_admin.configure_system_settings',
            'super_admin.manage_user_permissions',
            'super_admin.generate_reports',
            'super_admin.perform_system_maintenance',
         ];
 
          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}