<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'courseName',
        'courseCode',
        'creditHour',
    ];
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_courses')->withPivot('year', 'semister');
    }
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_courses', 'course_id', 'teacher_id');
    }

    public function departmentCourses()
    {
        return $this->hasMany(DepartmentCourses::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'mark_lists', 'course_id', 'student_id')->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })
            ->withTimestamps();
    }
}
