<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
    Route::post('/create', [CourseController::class, 'store'])->name('store');
    Route::delete('/destroy/{course}', [CourseController::class,'destroy'])->name('destroy');
    Route::get('/edit/{course}', [CourseController::class,'edit'])->name('edit');
    Route::put('/edit/{course}', [CourseController::class,'update'])->name('update');
});

// Route::resource('courses', CourseController::class)->except([
//     'show',
// ]);

Route::get('courses/api',[CourseController::class, 'api'])->name('course.api');

Route::get('/template', function(){
    return view('layout.master');
});