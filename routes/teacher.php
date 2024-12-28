<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\QuizzController;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\TeacherDashboardController;
use App\Http\Controllers\Dashboard\Teacher\Dashboard\OnlineZoomClassesController;

Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:teacher'])->group(function () {

    Route::prefix('/teacher/dashboard')->name('teacher.dashboard.')->group(function(){

        Route::get('/',[TeacherDashboardController::class,'index'])->name('index');
        Route::get('students',[StudentController::class,'index'])->name('students.index');
        Route::get('sections',[StudentController::class,'sections'])->name('sections');
        Route::post('attendance',[StudentController::class,'attendance'])->name('attendance');
        Route::get('attendance_report',[StudentController::class,'attendanceReport'])->name('attendance.report');
        Route::post('attendance_report',[StudentController::class,'attendanceSearch'])->name('attendance.search');
        Route::resource('quizzes', QuizzController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('online_zoom_classes', OnlineZoomClassesController::class);
        Route::get('/indirect', [OnlineZoomClassesController::class,'indirectCreate'])->name('indirect.create');
        Route::post('/indirect', [OnlineZoomClassesController::class,'storeIndirect'])->name('indirect.store');
        Route::get('profile', [ProfileController::class,'index'])->name('profile.show');
        Route::post('profile/{id}',[ProfileController::class,'update'])->name('profile.update');

        Route::get('/getevents', [EventController::class, 'getEvents'])->name('getEvents');
        Route::post('/addevent', [EventController::class, 'addEvent'])->name('addEvent');
        Route::post('/updateevent', [EventController::class, 'updateEvent'])->name('updateEvent');

        Route::get('student_quizze/{id}',[QuizzController::class,'student_quizze'])->name('student.quizze');
        Route::post('repeat_quizze', [QuizzController::class,'repeat_quizze'])->name('repeat.quizze');


    });

});
