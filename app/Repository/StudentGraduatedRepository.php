<?php


namespace App\Repository;


use App\Models\Grade;
use App\Models\Student;
use App\Repository\StudentGraduatedRepositoryInterface;

class StudentGraduatedRepository implements StudentGraduatedRepositoryInterface
{

    public function index()
    {
        $students = Student::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }

    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Students.Graduated.create',compact('Grades'));
    }

    public function SoftDelete($request)
    {
        $students = Student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();
        if(count($students) < 1){
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }

        foreach ($students as $student){
            Student::find($student->id)->Delete();
        }

        return redirect()->route('dashboard.graduated.index')->
        with('msg', trans('messages.Update'))->with('type', 'success');
    }

    public function ReturnData($id)
    {

        Student::onlyTrashed()->find($id)->restore();
        return redirect()->back()->
        with('msg', trans('messages.Update'))->with('type', 'success');;
    }

    public function destroy($id)
    {
        Student::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->
        with('msg', trans('messages.Delete'))->with('type', 'danger');
    }


}
