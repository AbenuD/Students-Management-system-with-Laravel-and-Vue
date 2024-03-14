<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCourses extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function markLists()
    {
        return $this->belongsToMany(MarkList::class, 'department_course_mark_lists', 'department_course_id', 'mark_list_id');
    }
    // protected $fillable = ['year', 'semester', 'department_id', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_courses');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'mark_lists')->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        });
    }
}
