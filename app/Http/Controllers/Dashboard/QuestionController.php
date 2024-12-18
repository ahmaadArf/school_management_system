<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Quizze;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::get();
        return view('pages.Questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quizze::get();
        return view('pages.Questions.create',compact('quizzes'));
    }

    public function store(Request $request)
    {
        try {
            Question::create([
                'title'=>$request->title,
                'answers'=>$request->answers,
                'right_answer'=>$request->right_answer,
                'score'=>$request->score,
                'quizze_id'=>$request->quizze_id,
            ]);

            // toastr()->success(trans('messages.success'));
            return redirect()->route('dashboard.questions.index')->
            with('msg', trans('messages.success'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $question = Question::findorfail($id);
        $quizzes = Quizze::get();
        return view('pages.Questions.edit',compact('question','quizzes'));
    }

    public function update(Request $request)
    {
        try {
            Question::findorfail($request->id)->update([
                'title'=>$request->title,
                'answers'=>$request->answers,
                'right_answer'=>$request->right_answer,
                'score'=>$request->score,
                'quizze_id'=>$request->quizze_id,
            ]);

            // toastr()->success(trans('messages.Update'));
            return redirect()->route('dashboard.questions.index')->
            with('msg', trans('messages.Update'))->with('type', 'success');;
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            Question::destroy($request->id);
            // toastr()->error(trans('messages.Delete'));
            return redirect()->back()->
            with('msg', trans('messages.Delete'))->with('type', 'success');;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
