<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('message.{id}', function ($user, $id) {
    return $user;
});
