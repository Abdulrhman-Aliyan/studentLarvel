<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserSubject;
use App\Models\UserType;
use App\Models\Subject;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $admin = strtoupper(UserType::where('user_type_name', 'admin')->first());

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        if ($user->user_type == 2) {
            // Fetch all students and their grades
            $students = User::with('userSubjects.subject')->where('user_type', 1)->get();
        } else {
            // Fetch only the logged-in user's subjects and grades
            $students = User::with('userSubjects.subject')->where('user_type', 2)->get();
        }

        // Add pass grade to each subject
        $students->each(function ($student) {
            $student->userSubjects->each(function ($userSubject) {
                $userSubject->subject->pass_grade = $userSubject->subject->pass_grade;
            });
        });

        return view('welcome', compact('user', 'students'));
    }
}