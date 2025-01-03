<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserSubjectController;

use Illuminate\Support\Facades\Route;


// Login page
// Get
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

// Post
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');

route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Register page
//get
Route::get('/register', function () {
    return view('register');
})->name('register');

//post
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Add student
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

// Update student
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');

// Delete student
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

// Fetch student data for editing
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');

// Add subject
Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');

// Fetch subjects
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

// Add user subject
Route::post('/userSubjects', [UserSubjectController::class, 'store'])->name('userSubjects.store');