<?php

namespace App\Http\Controllers;

use App\Models\UserSubject;
use Illuminate\Http\Request;

class UserSubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_grade' => 'required|integer',
        ]);

        UserSubject::create([
            'user_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'user_grade' => $request->user_grade,
        ]);

        return redirect()->route('home');
    }
}
