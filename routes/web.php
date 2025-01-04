<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserSubjectController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

// Authentication Routes
// Display login page
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

// Handle login form submission
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');

// Handle logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Home Route
// Display home page
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Registration Routes
// Display registration page
Route::get('/register', function () {
    return view('register');
})->name('register');

// Handle registration form submission
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Chat Route
// Display chat page
Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// Student Routes
// Add a new student
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

// Update an existing student
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');

// Delete a student
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

// Fetch student data for editing
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');

// Fetch all students
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// Subject Routes
// Add a new subject
Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');

// Fetch all subjects
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

// User Subject Routes
// Add a subject to a user
Route::post('/userSubjects', [UserSubjectController::class, 'store'])->name('userSubjects.store');

// Add a subject to a user without a grade
Route::post('/userSubjects', [UserSubjectController::class, 'storeWithoutGrade'])->name('userSubjects.storeWithoutGrade');

// Fetch subjects for a specific student
Route::get('/students/{id}/subjects', [UserSubjectController::class, 'getSubjects'])->name('students.subjects');

// Update grade for a specific subject of a student
Route::put('/students/{student_id}/subjects/{subject_id}', [UserSubjectController::class, 'updateGrade'])->name('students.subjects.update');

// Update all grades for a specific student
Route::put('/students/{student_id}/subjects/updateAll', [UserSubjectController::class, 'updateAllGrades'])->name('students.subjects.updateAll');

// User Routes
// Fetch user information
Route::get('/user/info', [UserController::class, 'getUserInfo'])->name('user.info');

// Fetch subjects for the logged-in user
Route::get('/user/subjects', [UserController::class, 'getUserSubjects'])->name('user.subjects');

// Fetch subjects and grades for a specific student
Route::get('/students/{id}/subjects/grades', [UserSubjectController::class, 'getSubjectsAndGrades'])->name('students.subjects.grades');

// Fetch available subjects for a specific student
Route::get('/students/{studentId}/available-subjects', [SubjectController::class, 'getAvailableSubjects']);