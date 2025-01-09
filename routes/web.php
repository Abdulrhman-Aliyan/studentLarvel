<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;

use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::view('/register', 'register')->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/broadcasting/auth', [BroadcastController::class, 'authenticate']);

    // Chat Routes
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');
    Route::post('/send-message/{recipientId}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/receive-message', [ChatController::class, 'sendMessage'])->name('chat.receive');
    Route::get('/messages/{friendId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/send-test-message', [ChatController::class, 'sendTestMessage'])->name('chat.sendTest');

    Route::get('/ajax/courses', [CourseController::class, 'getCourses'])->name('ajax.courses');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');});

// Student Routes
Broadcast::routes(['middleware' => 'auth']);

Route::prefix('students')->name('students.')->group(function () {
    Route::post('/', [StudentController::class, 'store'])->name('store');
    Route::put('/{id}', [StudentController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/{id}/subjects', [UserSubjectController::class, 'getSubjects'])->name('subjects');
    Route::get('/{id}/subjects/grades', [UserSubjectController::class, 'getSubjectsAndGrades'])->name('subjects.grades');
    Route::get('/{studentId}/available-subjects', [SubjectController::class, 'getAvailableSubjects']);
    Route::get('/{student_id}/colleagues-with-shared-subjects', [UserSubjectController::class, 'getSubjectColleaguesWithSharedSubjects'])->name('subjects.colleagues');
    Route::put('/{student_id}/subjects/{subject_id}', [UserSubjectController::class, 'updateGrade'])->name('subjects.update');
    Route::put('/{student_id}/subjects/updateAll', [UserSubjectController::class, 'updateAllGrades'])->name('subjects.updateAll');
});

// Subject Routes
Route::prefix('subjects')->name('subjects.')->group(function () {
    Route::post('/', [SubjectController::class, 'store'])->name('store');
    Route::get('/', [SubjectController::class, 'index'])->name('index');
});

// User Subject Routes
Route::post('/userSubjects', [UserSubjectController::class, 'store'])->name('userSubjects.store');
Route::post('/userSubjects', [UserSubjectController::class, 'storeWithoutGrade'])->name('userSubjects.storeWithoutGrade');

// User Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/info', [UserController::class, 'getUserInfo'])->name('info');
    Route::get('/subjects', [UserController::class, 'getUserSubjects'])->name('subjects');
});

// Course Routes
Route::resource('courses', CourseController::class);
