<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\GradeController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Student\FeesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Student\PaymentController;
use App\Http\Controllers\Dashboard\Student\StudentController;
use App\Http\Controllers\Dashboard\Student\GraduatedController;
use App\Http\Controllers\Dashboard\Student\PromotionController;
use App\Http\Controllers\Dashboard\Student\FeesInvoicesController;
use App\Http\Controllers\Dashboard\Student\ProcessingFeeController;
use App\Http\Controllers\Dashboard\Student\ReceiptStudentController;

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
// Route::get('/', function () {
//     return view('dashboard');
// });
Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('dashboard')->name('dashboard.')->group(function () {

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





        });


    });
Route::view('add_parent','livewire.show_Form');
