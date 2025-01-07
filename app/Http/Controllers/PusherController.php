<?php
// filepath: /c:/xampp/htdocs/Projects/myTask/app/Http/Controllers/PusherController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            $pusher = new \Pusher\Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                config('broadcasting.connections.pusher.options')
            );

            $auth = $pusher->socket_auth($request->channel_name, $request->socket_id);
            return response($auth);
        }

        return response('Unauthorized', 403);
    }
}