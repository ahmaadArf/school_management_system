<?php

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Parent\ChildrenController;
Route::prefix(LaravelLocalization::setLocale())
->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:parent'])->group(function () {

    Route::prefix('parent/dashboard')->name('parent.dashboard.')->group(function(){

    Route::get('/', function () {
        $sons = Student::where('parent_id',Auth::user()->id)->get();
        return view('pages.parents.dashboard',compact('sons'));
    })->name('index');
    Route::get('children', [ChildrenController::class,'index'])->name('sons.index');
    Route::get('results/{id}', [ChildrenController::class,'results'])->name('sons.results');
    Route::get('attendances', [ChildrenController::class,'attendances'])->name('sons.attendances');
    Route::post('attendances',[ChildrenController::class,'attendanceSearch'])->name('sons.attendance.search');
    Route::get('fees',[ChildrenController::class,'fees'])->name('sons.fees');
    Route::get('receipt/{id}',[ChildrenController::class,'receiptStudent'])->name('sons.receipt');
    Route::get('profile/parent',[ChildrenController::class,'profile'])->name('profile.show.parent');
    Route::post('profile/parent/{id}',[ChildrenController::class,'update'])->name('profile.update.parent');
    });

});
