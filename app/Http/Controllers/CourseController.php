<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('subject', 'user')->get();
        return view('courses', compact('courses'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $users = User::all();
        return view('courses.create', compact('subjects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'num_of_students' => 'nullable|integer|min:0',
        ]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $subjects = Subject::all();
        $users = User::all();
        return view('courses.edit', compact('course', 'subjects', 'users'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'num_of_students' => 'nullable|integer|min:0',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function getCourses()
    {
        $courses = Course::with('subject', 'user')->get();
        return response()->json($courses);
    }

    public function getLimitedCourses(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = 4;
        $total = Course::count();
        $courses = Course::with('subject', 'user')->offset($offset)->limit($limit)->get();
        return response()->json(['courses' => $courses, 'total' => $total]);
    }

    public function getPopularCourses()
    {
        $courses = Course::with('subject', 'user')->orderBy('rating', 'desc')->limit(10)->get();
        return response()->json($courses);
    }
}
