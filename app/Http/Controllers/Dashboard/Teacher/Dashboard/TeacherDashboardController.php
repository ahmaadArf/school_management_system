<?php

namespace App\Http\Controllers\Dashboard\Teacher\Dashboard;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()  {
        $ids = Teacher::findorFail(Auth::user()->id)->Sections()->pluck('section_id');
        $data['count_sections']= $ids->count();
        $data['count_students']= Student::whereIn('section_id',$ids)->count();
        return view('pages.Teachers.dashboard.dashboard',$data);
    }
}
