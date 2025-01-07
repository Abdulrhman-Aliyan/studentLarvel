<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $recipientId;

    public function __construct(User $user, Message $message, $recipientId)
    {
        $this->user = $user;
        $this->message = $message;
        $this->recipientId = $recipientId;
    }

    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }

    public function broadcastAs()
    {
        return 'message-sent';
    }
}