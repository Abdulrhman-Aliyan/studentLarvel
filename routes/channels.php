<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-channel', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
