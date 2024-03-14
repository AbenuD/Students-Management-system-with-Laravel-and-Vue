<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkList extends Model
{
    use HasFactory;

    public function courses(){
        return $this->hasMany(Course::class, 'mark_lists');
    }
    public function students()
    {
        return $this->hasMany(User::class, 'mark_lists', 'student_id', 'mark_list_id')->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        });
    }
}
