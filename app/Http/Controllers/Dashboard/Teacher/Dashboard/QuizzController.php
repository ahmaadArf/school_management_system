<?php

namespace App\Http\Controllers\Dashboard\Teacher\Dashboard;

use App\Models\Grade;
use App\Models\Degree;
use App\Models\Quizze;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizzController extends Controller
{
    public function index()
    {
        // $quizzes = Quizze::where('teacher_id',Auth::user()->id)->get();
        $quizzes = Teacher::find(Auth::user()->id)->Quizzes()->get();
        return view('pages.Teachers.dashboard.Quizzes.index', compact('quizzes'));
    }


    public function create()
    {
        $data['grades'] = Grade::all();
        // $data['subjects'] = Subject::where('teacher_id',Auth::user()->id)->get();
        $data['subjects'] = Teacher::find(Auth::user()->id)->Subjects()->get();
        return view('pages.Teachers.dashboard.Quizzes.create', $data);
    }


    public function store(Request $request)
    {
        try {

            Quizze::create([
                'name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'subject_id'=>$request->subject_id,
                'grade_id'=>$request->Grade_id,
                'classroom_id'=>$request->Classroom_id,
                'section_id'=>$request->section_id,
                'teacher_id'=>Auth::user()->id,
            ]);
            // toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.dashboard.quizzes.index')->
            with('msg', trans('messages.success'))->with('type', 'success');;
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    public function edit($id)
    {
        $quizz = Quizze::findorFail($id);
        $data['grades'] = Grade::all();
        $data['subjects'] = Teacher::find(Auth::user()->id)->Subjects()->get();
        return view('pages.Teachers.dashboard.Quizzes.edit', $data, compact('quizz'));
    }

    public function show($id)
    {
        $quizz = Quizze::findorFail($id);
        $questions = $quizz->Questions()->get();
        return view('pages.Teachers.dashboard.Questions.index',compact('questions','quizz'));
    }


    public function update(Request $request)
    {
        try {
            Quizze::findorFail($request->id)->update([
               'name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
               'subject_id'=>$request->subject_id,
               'grade_id'=>$request->Grade_id,
               'classroom_id'=>$request->Classroom_id,
               'section_id'=>$request->section_id,
               'teacher_id'=>Auth::user()->id,
           ]);

           // toastr()->success(trans('messages.Update'));
           return redirect()->route('teacher.dashboard.quizzes.index')->
           with('msg', trans('messages.Update'))->with('type', 'success');;
       } catch (\Exception $e) {
           return redirect()->back()->with(['error' => $e->getMessage()]);
       }
    }


    public function destroy($id)
    {
        try {
            Quizze::destroy($id);
            // toastr()->error(trans('messages.Delete'));
            return redirect()->back()->
            with('msg', trans('messages.Delete'))->with('type', 'danger');;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function student_quizze($quizze_id)
    {
        $degrees = Degree::where('quizze_id', $quizze_id)->get();
        return view('pages.Teachers.dashboard.Quizzes.student_quizze', compact('degrees'));
    }

    public function repeat_quizze(Request $request)
    {
        Degree::where('student_id', $request->student_id)->where('quizze_id', $request->quizze_id)->delete();
        // toastr()->success('تم فتح الاختبار مرة اخرى للطالب');
        return redirect()->back();
    }
}
