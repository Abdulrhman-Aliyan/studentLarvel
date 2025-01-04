<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\UserSubject; // Add this line
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'pass_grade' => 'required|integer',
        ]);

        $subject = Subject::create([
            'subject_name' => $request->subject_name,
            'pass_grade' => $request->pass_grade,
        ]);

        return response()->json(['success' => 'Subject added successfully.', 'subject' => $subject]);
    }

    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects);
    }

    public function getAvailableSubjects($studentId)
    {
        $assignedSubjectIds = UserSubject::where('user_id', $studentId)->pluck('subject_id');
        $availableSubjects = Subject::whereNotIn('id', $assignedSubjectIds)->get();
        return response()->json($availableSubjects);
    }
}
