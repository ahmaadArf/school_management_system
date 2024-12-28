<?php

namespace App\Http\Controllers\Dashboard\Teacher\Dashboard;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        try {
            Question::create([
                'title'=>$request->title,
                'answers'=>$request->answers,
                'right_answer'=>$request->right_answer,
                'score'=>$request->score,
                'quizze_id'=>$request->quizz_id,
            ]);

            // toastr()->success(trans('messages.success'));
            return redirect()->route('teacher.dashboard.quizzes.show',$request->quizz_id)->
            with('msg', trans('messages.success'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function show($id)
    {
        $quizz_id = $id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function edit($id)
    {
        $question = Question::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }


    public function update(Request $request, $id)
    {
        try {
            Question::findorfail($id)->update([
                'title'=>$request->title,
                'answers'=>$request->answers,
                'right_answer'=>$request->right_answer,
                'score'=>$request->score,
                'quizze_id'=>$request->quizze_id,
            ]);

            // toastr()->success(trans('messages.Update'));
            return redirect()->route('teacher.dashboard.quizzes.show',$request->quizze_id)->
            with('msg', trans('messages.Update'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Question::destroy($id);
            // toastr()->error(trans('messages.Delete'));
            return redirect()->back()->
            with('msg', trans('messages.Delete'))->with('type', 'success');;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
