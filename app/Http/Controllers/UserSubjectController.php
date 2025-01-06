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

    public function storeWithoutGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        UserSubject::create([
            'user_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('home');
    }

    public function getSubjects($id)
    {
        $subjects = UserSubject::where('user_id', $id)->with('subject')->get();
        return response()->json($subjects);
    }

    public function getSubjectColleaguesWithSharedSubjects($student_id)
    {
    // Step 1: Get all subject IDs the user is enrolled in
    $subjectIds = UserSubject::where('user_id', $student_id)
                             ->pluck('subject_id');

    // Step 2: Get colleagues who share at least one subject with the user
    $colleagues = UserSubject::whereIn('subject_id', $subjectIds)
                             ->where('user_id', '!=', $student_id)
                             ->with(['user', 'subject']) // Eager load related user and subject data
                             ->get();

    // Step 3: Group colleagues by user_id and collect shared subjects
    $colleagueData = $colleagues->groupBy('user_id')->map(function ($colleagueSubjects) {
        $user = $colleagueSubjects->first()->user; // Get the colleague's details
        $sharedSubjects = $colleagueSubjects->pluck('subject.subject_name'); // Get shared subject names

        return [
            'colleague' => $user,
            'shared_subjects' => $sharedSubjects
        ];
    });

    // Step 4: Return the results as JSON
    return response()->json($colleagueData);
    }

    public function updateGrade(Request $request, $student_id, $subject_id)
    {
        $request->validate([
            'user_grade' => 'required|integer',
        ]);

        $userSubject = UserSubject::where('user_id', $student_id)
                                  ->where('subject_id', $subject_id)
                                  ->firstOrFail();

        $userSubject->update([
            'user_grade' => $request->user_grade,
        ]);

        return response()->json();
    }

    public function updateAllGrades(Request $request, $student_id)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*.subject_id' => 'required|exists:subjects,id',
            'grades.*.user_grade' => 'required|integer',
        ]);

        foreach ($request->grades as $grade) {
            $userSubject = UserSubject::where('user_id', $student_id)
                                      ->where('subject_id', $grade['subject_id'])
                                      ->firstOrFail();

            $userSubject->update([
                'user_grade' => $grade['user_grade'],
            ]);
        }

        return response()->json();
    }
}
