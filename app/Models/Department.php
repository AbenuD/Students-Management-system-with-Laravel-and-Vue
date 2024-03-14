<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

       protected $fillable = [
        'departmentName',
        'noYears',
    ];
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'department_courses')
                    ->withPivot('semister', 'year');
    }

    public function students(){
        return $this->hasMany(User::class, 'department_id')->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        });
    }
    public function teachers()
    {
        return $this->hasMany(User::class, 'department_id')->whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        });
    }
    public function advisors()
    {
        return $this->hasMany(User::class, 'department_id')->whereHas('roles', function ($query) {
            $query->where('name', 'advisor');
        });
    }
    public function dep_head()
    {
        return $this->hasOne(User::class, 'department_id')->whereHas('roles', function ($query) {
            $query->where('name', 'dep_head');
        });
    }
}
