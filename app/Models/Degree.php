<?php

namespace App\Models;

use App\Models\Quizze;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $guarded=[];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function quizze()
    {
        return $this->belongsTo(Quizze::class, 'quizze_id');
    }
}
