<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Degree;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    public $totalCount;
    public $curatCont;
    public function index()
    {
        $quizzes = Quizze::where('grade_id', Auth::user()->Grade_id)
            ->where('classroom_id', Auth::user()->Classroom_id)
            ->where('section_id', Auth::user()->section_id)
            ->orderBy('id', 'DESC')
            ->get();
        $student=Auth::user();
        return view('pages.Students.dashboard.exams.index', compact('quizzes','student'));
    }




    // public function show($quizze_id)
    // {

    //     $student_id = Auth::user()->id;
    //     return view('pages.Students.dashboard.exams.show',compact('quizze_id','student_id'));
    // }


    public function show($quizze_id, $question_index = 0)
{
    // جلب جميع الأسئلة بناءً على الاختبار المحدد
    $questions = Quizze::find($quizze_id)->Questions;

    // إذا لم يوجد أسئلة، إعادة توجيه أو رسالة خطأ
    if ($questions->isEmpty()) {
        return redirect()->back()->with('error', 'No questions available for this quiz.');
    }

    // جلب السؤال الحالي
    $current_question = $questions[$question_index];

    // حساب رقم السؤال التالي
    $next_index = $question_index + 1 < count($questions) ? $question_index + 1 : null;

    return view('pages.Students.dashboard.exams.exam', compact('current_question', 'quizze_id', 'question_index', 'next_index'));
}
public function storeAnswer(Request $request, $quizze_id, $question_index)
{
    // جلب جميع الأسئلة
    $questions = Quizze::find($quizze_id)->Questions;

    // تخزين الإجابة الحالية في الجلسة
    $current_question = $questions[$question_index];
    $correct_answer = $current_question->right_answer;

    $user_answer = $request->input('answer');
    $is_correct = $user_answer === $correct_answer;

    $session_key = "quiz_{$quizze_id}_answers";
    $session_data = session($session_key, []);

    $session_data[$question_index] = [
        'user_answer' => $user_answer,
        'correct_answer' => $correct_answer,
        'is_correct' => $is_correct,
        'score' => $is_correct ? $current_question->score : 0,
    ];

    session([$session_key => $session_data]);

    // إذا انتهى الاختبار، حساب الدرجات
    if ($question_index + 1 >= count($questions)) {
        return $this->calculateScore($quizze_id, $session_data);
    }

    // الانتقال للسؤال التالي
    return redirect()->route('student.dashboard.quiz.show', [
        'quizze_id' => $quizze_id,
        'question_index' => $question_index + 1,
    ]);
}

protected function calculateScore($quizze_id, $session_data)
{
    // حساب الدرجة
    $total_score = collect($session_data)->sum('score');

    // تخزين النتيجة في جدول التقييم
    Degree::create([
        'quizze_id' => $quizze_id,
        'student_id' =>Auth::user()->id,
        'question_id'=>3,
        'score' => $total_score,
        'date' => now(),
    ]);

    // إعادة توجيه لصفحة النتيجة
    return redirect()->route('student.dashboard.student_exams.index');
}





}
