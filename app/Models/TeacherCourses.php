<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourses extends Model
{
    use HasFactory;

    // protected $table = 'teacher_courses';

    public function markLists()
    {
        return $this->hasMany(MarkList::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function departmentCourse()
    {
        return $this->belongsTo(DepartmentCourses::class, 'department_courses_id');
    }
}
