<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'pass_grade' => 'required|integer',
        ]);

        Subject::create([
            'subject_name' => $request->subject_name,
            'pass_grade' => $request->pass_grade,
        ]);

        return redirect()->route('home')->with('success', 'Subject added successfully.');
    }

    public function index()
    {
        $subjects = Subject::all();
        return view('welcome', compact('subjects'));
    }
}
