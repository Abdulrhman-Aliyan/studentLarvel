<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ...existing code...

    public function getUserInfo()
    {
        try {
            $user = Auth::user();
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserSubjects()
    {
        try {
            $userSubjects = Auth::user()->userSubjects()->with('subject')->get();
            return response()->json($userSubjects);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ...existing code...
}
