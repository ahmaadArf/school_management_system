<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Dashboard\Student\ExamsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Student\ProfileController;
Route::prefix(LaravelLocalization::setLocale())
->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:student'])->group(function () {

    Route::prefix('student/dashboard')->name('student.dashboard.')->group(function(){

    Route::get('/', function () {
        return view('pages.Students.dashboard');
    })->name('index');

    Route::get('/getevents', [EventController::class, 'getEvents'])->name('getEvents');
    Route::get('/quiz/{quizze_id}/{question_index?}', [ExamsController::class, 'show'])
     ->name('quiz.show');

    Route::resource('student_exams', ExamsController::class);
    Route::post('/quiz/{quizze_id}/{question_index}/answer', [ExamsController::class, 'storeAnswer'])->name('quiz.answer');
    Route::resource('profile-student', ProfileController::class);


    });

});
