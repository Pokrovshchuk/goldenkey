<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('orders.updated.{id}', function ($user, $id) {
    $order = $user->orders()->where('id', $id)->first();
    return $order ?? false;
});

Broadcast::channel('user-events.{user_id}', function ($user, $user_id) {
    return (int) $user->id === (int)$user_id;
});
