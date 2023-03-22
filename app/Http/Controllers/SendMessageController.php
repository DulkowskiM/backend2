<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\SendMessage;
use App\Models\User;
use App\Models\Chat;

class SendMessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $fromId = auth()->user()->id;
        $toUserId = $request->touserId;
        $message = $request->message;
        $status = $request->status;

        $user = auth()->user()->name;
        $id = $request->roomid;

        $save_message = Message::create([
            'message' => $message,
            'from_id' => $fromId,
            'to_id' => $toUserId,
            'chat_id' => $id,
            'is_readed' => $status,
        ]);
        event(new SendMessage($message, $user, $id, $fromId, $status));
        return null;
    }

    //show room by user
    public function show_room($id)
    {

        $user = User::findOrfail($id);

        //select room if there exist , if not create new one 
        $room = Chat::where([
            ['user_1', auth()->user()->id],
            ['user_2', $id]

        ])->orWhere([
            ['user_1', $id],
            ['user_2', auth()->user()->id]
        ])->with('user_1', 'user_2')->first();
        if ($room == null) {
            $room = Chat::create([
                'user_1' => auth()->user()->id,
                'user_2' => $id
            ]);
        }

        return response()->json([
            'user' => $user,
            'room_id' => $room->id,
            'messages' => $room->messages
        ]);
    }

    //update message status to => is_readed 
    function read_all_messages(Request $request)
    {
        $to_id = $request->toId;
        $room_id = $request->roomId;
        $update = Message::where([
            ['chat_id', $room_id],
            ['from_id', auth()->user()->id],
            ['to_id', $to_id],
            ['is_readed', 0],
        ])->update([
            'is_readed' => 1
        ]);
        return null;
    }


    function chats(Request $request)
    {
        $id =   auth()->user()->id;
        $user = User::findOrfail($id);
        $rooms = Chat::where([
            ['user_1', $user->id, $user->name],
        ])
            ->orWhere([
                ['user_2', $user->id, $user->name]
            ])->with('user_1', 'user_2')->get();


        return response()->json([
            'rooms' => $rooms,
        ]);
    }
}
