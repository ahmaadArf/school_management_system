<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class ReceiptStudent extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
