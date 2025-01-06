<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Models\Message;

class SaveMessage
{
    public function handle(MessageSent $event)
    {
        Message::create([
            'sender_id' => $event->user->id,
            'recipient_id' => $event->recipientId,
            'message' => $event->message
        ]);
    }
}
