@extends('layouts.master')
@section('css')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }
    .container {
        max-width: 800px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .question {
        font-size: 1.2em;
        margin-bottom: 15px;
    }
    .answers {
        margin-bottom: 20px;
    }
    .answers label {
        display: block;
        margin: 5px 0;
    }
    button {
        display: block;
        width: 100%;
        padding: 10px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
    }
    button:hover {
        background: #0056b3;
    }
    .result {
        display: none;
        padding: 10px;
        margin-top: 20px;
        background: #e7f3e7;
        border: 1px solid #d4edda;
        border-radius: 5px;
        color: #155724;
    }
</style>
    @section('title')
        إجراء اختبار
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
     إجراء اختبار :{{$current_question->quizze->name}}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

<div>
    <div>
        <div class="card card-statistics mb-30 ">
            <div class="card-body">
                <form method="POST" action="{{ route('student.dashboard.quiz.answer', ['quizze_id' => $quizze_id, 'question_index' => $question_index]) }}">
                    @csrf
                    <div class="question">
                        <p>{{ $question_index + 1 }}. {{ $current_question->title }}</p>
                        <div class="answers">
                            @foreach(preg_split('/(-)/', $current_question->answers) as $index => $answer)
                                <label>
                                    <input type="radio" name="answer" value="{{ $answer }}"> {{ $answer }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- زر الإرسال -->
                    @if($next_index !== null)
                    <button type="submit" class="col-3">Next</button>
                    @else
                    <button type="submit" onclick="alertEndExam()" class="col-3">Submit</button>
                    @endif

                </form>


            </div>
        </div>
    </div>

</div>


{{-- <div class="container">
    <h1>Quiz</h1>

    <div id="result" class="result"></div>
</div> --}}
@endsection
@section('js')
<script>
    function alertEndExam() {
        alert(" هل انت متاكد من تسليم الاختبار؟");
    }
</script>
@endsection

