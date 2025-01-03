<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserSubject extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject_id', 'user_grade'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function index()
    {
        $user = Auth::user();
        $userSubjects = UserSubject::with('subject')
            ->where('user_id', $user->id)
            ->get();

        $userType = UserType::where('id', $user->user_type_id)->first();

        return view('Home', compact($user, $userSubjects, $userType));
    }
}