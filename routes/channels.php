<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Message;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.Store.{id}', function ($user, $id) {
    $user = Auth::guard('store')->id();
  //  return (int) $user->id === (int) $id;
  return (int) $user === (int) $id;

});

Broadcast::channel('messages', function ($user) {
    return $user;
  /*  $message = Message::findOrFail($id);
    if ($message->sender_id == $user->id || $message->recipient_id == $user->id) {
        return $user;
    }*/
});
