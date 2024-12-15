<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;

    public $translatable = ['Name'];
    protected $guarded=[];
    public function Classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
     // علاقة المراحل الدراسية لجلب الاقسام المتعلقة بكل مرحلة
     public function Sections()
     {
         return $this->hasMany(Section::class, 'Grade_id');
     }
}
