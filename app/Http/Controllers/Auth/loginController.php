<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{   
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Check if the user is active
            if (!$user->user_active) {
                return back()->withErrors([
                    'inactive' => 'This account is inactive, please wait for the administrator to activate your account.',
                ]);
            }

            Auth::login($user);

            // Regenerate session ID to create a new session
            $request->session()->regenerate();

            // Check if session with a token is created
            if (session()->has('_token')) {
                return redirect()->route('home')->with('success', 'Login successful.');
            } else {
                return back()->withErrors([
                    'session' => 'Failed to create a session.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}