<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // ...existing code...

    public function index()
    {
        $students = User::where('user_type', 1)->get(); // Fetch only students
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'Student added successfully.', 'student' => $student]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $student = User::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_active' => $request->user_active,
        ]);

        return response()->json(['success' => 'Student updated successfully.', 'student' => $student]);
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return response()->json(['success' => 'Student deleted successfully.']);
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        return response()->json($student);
    }
}
