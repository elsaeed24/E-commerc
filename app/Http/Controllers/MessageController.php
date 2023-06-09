<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('messages.index');
    }

    public function show($peer_id)
    {
        $user_id = Auth::id();
       // $peer_id = Auth::guard('store')->id();

          /*
        SELECT * FROM messages
        WHERE
        (sender_id = $user_id AND recpient_id = $peer_id)
        OR
        (sender_id = $peer_id AND recpient_id = $user_id)
        */


        $messages = Message::with('sender:id,name', 'recipient:id,name')

            ->where(function($query) use ($user_id, $peer_id) {
                $query->where('sender_id', '=', $user_id)
                    ->where('recipient_id', '=', $peer_id);
            })
            ->orWhere(function($query) use ($user_id, $peer_id) {
                $query->where('sender_id', '=', $peer_id)
                    ->where('recipient_id', '=', $user_id);
            })
            ->latest()
            ->get();

        return $messages;
    }

    public function store(Request $request,$peer_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
       // $peer_id = Auth::guard('store')->id();

        $message = $user->sentMessages()->create([
            'recipient_id' => $peer_id,
            'message' => $request->post('message'),
        ]);

        broadcast(new MessageSent($message));

        return Response::json($message, 201);

    }
}
