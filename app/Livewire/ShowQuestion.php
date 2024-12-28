<?php

namespace App\Livewire;

use App\Models\Degree;
use Livewire\Component;
use App\Models\Question;

class ShowQuestion extends Component
{
    public $quizze_id, $student_id, $question, $counter = 0, $questioncount = 0;

    public function render()
    {
        $this->question = Question::where('quizze_id', $this->quizze_id)->get();
        $this->questioncount = $this->question->count();
        return view('livewire.show-question', ['question']);
    }

    public function nextQuestion($question_id, $score, $answer, $right_answer)
    {
        $stuDegree = Degree::where('student_id', $this->student_id)
            ->where('quizze_id', $this->quizze_id)
            ->first();
        // insert
        if ($stuDegree == null) {
            $degree = new Degree();
            $degree->quizze_id = $this->quizze_id;
            $degree->student_id = $this->student_id;
            $degree->question_id = $question_id;
            if (strcmp(trim($answer), trim($right_answer)) === 0) {
                $degree->score += $score;
            } else {
                $degree->score += 0;
            }
            $degree->date = date('Y-m-d');
            $degree->save();
        } else {

            // update
            if ($stuDegree->question_id >= $this->question[$this->counter]->id) {
                $stuDegree->score = 0;
                $stuDegree->abuse = '1';
                $stuDegree->save();
                // toastr()->error('تم إلغاء الاختبار لإكتشاف تلاعب بالنظام');
                return redirect('student_exams');
            } else {

                $stuDegree->question_id = $question_id;
                if (strcmp(trim($answer), trim($right_answer)) === 0) {
                    $stuDegree->score += $score;
                } else {
                    $stuDegree->score += 0;
                }
                $stuDegree->save();
            }
        }

        if ($this->counter < $this->questioncount - 1) {
            $this->counter++;
        } else {
            // toastr()->success('تم إجراء الاختبار بنجاح');
            return redirect('student_exams');
        }

    }
}
