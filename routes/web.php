<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\GradeController;
use App\Http\Controllers\Dashboard\QuizzeController;
use App\Http\Controllers\Dashboard\LibraryController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OnlineClasseController;
use App\Http\Controllers\Dashboard\Student\FeesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\Student\PaymentController;
use App\Http\Controllers\Dashboard\Student\StudentController;
use App\Http\Controllers\Dashboard\Teacher\TeacherController;
use App\Http\Controllers\Dashboard\Student\GraduatedController;
use App\Http\Controllers\Dashboard\Student\PromotionController;
use App\Http\Controllers\Dashboard\Student\AttendanceController;
use App\Http\Controllers\Dashboard\Student\FeesInvoicesController;
use App\Http\Controllers\Dashboard\Student\ProcessingFeeController;
use App\Http\Controllers\Dashboard\Student\ReceiptStudentController;



require __DIR__ . '/auth.php';
require __DIR__ . '/student.php';
require __DIR__ . '/teacher.php';
require __DIR__ . '/parent.php';

Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
        Route::prefix('dashboard')->middleware('auth:web,student,parent,teacher')->name('dashboard.')->group(function () {

            Route::resource('grades', GradeController::class);
            Route::resource('classrooms', ClassroomController::class);
            Route::post('Filter_Classes', [ClassroomController::class,'Filter_Classes'])->name('classrooms.filter');
            Route::post('delete_all', [ClassroomController::class,'delete_all'])->name('classrooms.delete_all');
            Route::resource('sections', SectionController::class);
            Route::get('/classes/{id}', [SectionController::class,'getclasses'])->name('sections.getclasses');
            Route::resource('teachers', TeacherController::class);
            Route::resource('students', StudentController::class);
            Route::resource('promotions', PromotionController::class);
            Route::delete('promotion/delete-all',[PromotionController::class,'destroyAllStudents'])->name('promotions.destroyAllStudents');
            Route::get('/Get_classrooms/{id}', [StudentController::class,'Get_classrooms']);
            Route::get('/Get_Sections/{id}', [StudentController::class,'Get_Sections']);
            Route::post('Upload_attachment', [StudentController::class,'Upload_attachment'])->name('students.Upload_attachment');
            Route::get('Download_attachment/{studentsname}/{filename}',
            [StudentController::class,'Download_attachment'])->name('students.Download_attachment');
            Route::post('Delete_attachment', [StudentController::class,'Delete_attachment'])->name('students.Delete_attachment');
            Route::resource('graduated', GraduatedController::class);
            Route::resource('fees', FeesController::class);
            Route::resource('fees_Invoices', FeesInvoicesController::class);
            Route::resource('receipt_students', ReceiptStudentController::class);
            Route::resource('processingFee', ProcessingFeeController::class);
            Route::resource('payment_students', PaymentController::class);
            Route::resource('attendance', AttendanceController::class);
            Route::resource('subjects', SubjectController::class);
            Route::resource('quizzes', QuizzeController::class);
            Route::resource('questions', QuestionController::class);
            Route::resource('online_classes', OnlineClasseController::class);
            Route::get('/indirect', [OnlineClasseController::class,'indirectCreate'])->name('indirect.create');
            Route::post('/indirect', [OnlineClasseController::class,'storeIndirect'])->name('indirect.store');
            Route::resource('library', LibraryController::class);
            Route::get('download_file/{filename}', [LibraryController::class,'downloadAttachment'])->name('downloadAttachment');
            Route::resource('settings', SettingController::class);

            Route::get('/getevents', [EventController::class, 'getEvents'])->middleware('auth:web,teacher')->name('getEvents');
            Route::post('/addevent', [EventController::class, 'addEvent'])->middleware('auth:web,teacher')->name('addEvent');
            Route::post('/updateevent', [EventController::class, 'updateEvent'])->middleware('auth::web,teacher')->name('updateEvent');
        });

});
Route::view('add_parent','livewire.show_Form')->name('add_parent');
Route::get('/', [DashboardController::class,'selection']);
Route::get('/login/{type}',[DashboardController::class,'loginForm'])->middleware('guest')->name('login.show');


