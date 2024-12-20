<?php

namespace App\Models;

use App\Models\User;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;

class OnlineClass extends Model
{

    protected $guarded=[];
    // public $fillable= ['Grade_id','Classroom_id','section_id','user_id','meeting_id','topic','start_at','duration','password','start_url','join_url'];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }


    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
