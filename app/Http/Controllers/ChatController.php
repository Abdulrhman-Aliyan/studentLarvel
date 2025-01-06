<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;

class ChatController extends Controller
{
    public function showChat()
    {
        $user = auth()->user();
        return view('chat.index', compact('user'));
    }

    public function sendMessage(Request $request, $recipientId)
    {
        $message = $request->input('message');
        $user = auth()->user();

        // Broadcast the event
        broadcast(new MessageSent($user, $message, $recipientId))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

    public function getMessages($recipientId)
    {
        $user = auth()->user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Assuming there is a Message model and it has a relationship with User
        $messages = Message::where(function ($query) use ($user, $recipientId) {
            $query->where('sender_id', $user->id)
                  ->where('recipient_id', $recipientId);
        })->orWhere(function ($query) use ($user, $recipientId) {
            $query->where('sender_id', $recipientId)
                  ->where('recipient_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
