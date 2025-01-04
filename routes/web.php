<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserSubjectController;
use App\Http\Controllers\UserController;

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

// Fetch students
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// Add subject
Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');

// Fetch subjects
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

// Add user subject
Route::post('/userSubjects', [UserSubjectController::class, 'store'])->name('userSubjects.store');

// Add user subject without grade
Route::post('/userSubjects', [UserSubjectController::class, 'storeWithoutGrade'])->name('userSubjects.storeWithoutGrade');

// Fetch subjects for a student
Route::get('/students/{id}/subjects', [UserSubjectController::class, 'getSubjects'])->name('students.subjects');

// Update grade for a subject
Route::put('/students/{student_id}/subjects/{subject_id}', [UserSubjectController::class, 'updateGrade'])->name('students.subjects.update');

// Update all grades for a student
Route::put('/students/{student_id}/subjects/updateAll', [UserSubjectController::class, 'updateAllGrades'])->name('students.subjects.updateAll');

// Fetch user information
Route::get('/user/info', [UserController::class, 'getUserInfo'])->name('user.info');

// Fetch user subjects
Route::get('/user/subjects', [UserController::class, 'getUserSubjects'])->name('user.subjects');

// Fetch subjects and grades for a student
Route::get('/students/{id}/subjects/grades', [UserSubjectController::class, 'getSubjectsAndGrades'])->name('students.subjects.grades');

// Fetch available subjects for a student
Route::get('/students/{studentId}/available-subjects', [SubjectController::class, 'getAvailableSubjects']);