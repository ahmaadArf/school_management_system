<?php

namespace App\Http\Controllers\Dashboard\Teacher\Dashboard;

use App\Models\Section;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()

    {
        $ids=Teacher::find( Auth::user()->id)->Sections->pluck('id');
        $students = Student::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.index', compact('students'));
    }

    public function sections()
    {
        $sections = Teacher::find( Auth::user()->id)->Sections;
        return view('pages.Teachers.dashboard.sections.index', compact('sections'));
    }

    public function attendance(Request $request)
    {

        try {

            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence) {


                Attendance::updateorCreate(
                    [
                        'student_id' => $studentid,
                        'attendence_date' => $attenddate
                    ],
                    [
                    'student_id' => $studentid,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => Auth::user()->id,
                    'attendence_date' => $attenddate,
                    'attendence_status' => $attendence
                ]);
            }
            // toastr()->success(trans('messages.success'));
            return redirect()->back()->
            with('msg', trans('messages.Update'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function attendanceReport()
    {

        $ids=Teacher::find( Auth::user()->id)->Sections->pluck('id');
        $students = Student::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));

    }

    public function attendanceSearch(Request $request)
    {

        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);


        $ids=Teacher::find( Auth::user()->id)->Sections->pluck('id');
        $students = Student::whereIn('section_id', $ids)->get();

        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));
        } else {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));


        }


    }
}
