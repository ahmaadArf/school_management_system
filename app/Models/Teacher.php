<?php

namespace App\Models;

use App\Models\Gender;
use App\Models\Quizze;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Specialization;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];
    // علاقة بين المعلمين والتخصصات لجلب اسم التخصص
    public function specializations()
    {
        return $this->belongsTo(Specialization::class, 'Specialization_id');
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'Gender_id');
    }

// علاقة المعلمين مع الاقسام
    public function Sections()
    {
        return $this->belongsToMany(Section::class,'teacher_section');
    }
    public function Quizzes()
    {
        return $this->hasMany(Quizze::class);
    }
    public function Subjects()
    {
        return $this->hasMany(Subject::class);
    }

}
