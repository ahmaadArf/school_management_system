<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
        return view('pages.Attendance.Sections',compact('Grades','list_Grades'));
    }

    public function show($id)
    {
        $students = Student::with('attendance')->where('section_id',$id)->get();
        return view('pages.Attendance.index',compact('students'));
    }

    public function store(Request $request)
    {
        try {

            foreach ($request->attendences as $attendence) {

                // if( $attendence == 'presence' ) {
                //     $attendence_status = true;
                // } else if( $attendence == 'absent' ){
                //     $attendence_status = false;
                // }

                Attendance::create([
                    'student_id'=> $request->student_id,
                    'grade_id'=> $request->grade_id,
                    'classroom_id'=> $request->classroom_id,
                    'section_id'=> $request->section_id,
                    'teacher_id'=> 2,
                    'attendence_date'=> date('Y-m-d'),
                    'attendence_status'=> $attendence
                ]);

            }

            // toastr()->success(trans('messages.success'));
            return redirect()->back();

        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}
