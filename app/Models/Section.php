<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;
    public $translatable = ['Name_Section'];

    protected $guarded=[];

    public function My_classs()
    {
        return $this->belongsTo(Classroom::class, 'Class_id');
    }

    // علاقة الاقسام مع المعلمين
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'teacher_section');
    }

    public function Grades()
    {
        return $this->belongsTo(Grade::class,'Grade_id');
    }
    public function Students()
    {
        return $this->belongsToMany(Student::class);
    }
}
