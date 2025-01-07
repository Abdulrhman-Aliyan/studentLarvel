<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User; // Add this line
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
        public function showChat()
        {
            $user = auth()->user();
            return view('chat.index', compact('user'));
        }

        public function authenticate(Request $request)
        {
            $user = $request->user(); // Get the authenticated user

            // Example: Authorize user for a private channel like 'private-chat.{user_id}'
            if ($user && $request->channel_name === 'private-chat.' . $user->id) {
                return response()->json([
                    'auth' => (new \Pusher\Pusher(
                        config('broadcasting.connections.pusher.key'),
                        config('broadcasting.connections.pusher.secret'),
                        config('broadcasting.connections.pusher.app_id'),
                        config('broadcasting.connections.pusher.options')
                    ))->socket_auth($request->channel_name, $request->socket_id)
                ]);
            }

            // Return 403 Forbidden if the user is not authorized
            return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function sendMessage(Request $request, $recipientId = null)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $Content = $request->input('message');
        $user = auth()->user();
        $recipientId = $recipientId ?? $request->input('recipient_id');

        // Check if the recipient exists
        $recipient = User::find($recipientId);
        if (!$recipient) {
            return response()->json(['error' => 'Recipient not found'], 404);
        }

        try {
            // Save the message to the database
            $message = Message::create([
                'sender_id' => $user->id,
                'recipient_id' => $recipientId,
                'content' => $Content,
            ]);

            // Broadcast the event
            broadcast(new MessageSent($user, $Content, $recipientId))->toOthers();

            return response()->json(['status' => 'Message Sent!', 'message' => $message]);
        } catch (\Exception $e) {
            Log::error('Failed to send message: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message', 'details' => $e->getMessage()], 500);
        }
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

