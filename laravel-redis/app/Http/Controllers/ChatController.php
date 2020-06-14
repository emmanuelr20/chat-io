<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatController extends Controller
{

    public function craeteGroup(Type $var = null)
    {
        # code...
    }
    
    public function getChat(Request $request)
    {
        $chat = Chat::find($request->chat_id);
        if ($chat) { 
            return $chat;
        }
        $user = User::find($request->user_id);
        if(!$user) {
            return null;
        }
        $chat = Chat::create(["is_group" => false]);
        $chat->users()->attach(auth()->user(), ["chat_name" => $user->name]);
        $chat->users()->attach($user, ["chat_name" => auth()->user()->name]);
        $chat->load('members');
        //emit new chatcreate
        return $chat;
    }

    public function message(Request $request)
    {
        $chat = $this->getChat($request);
        if(!$chat) {
            return $this->apiError([
                "message" => "chat user none found",
                "status" => 404,
                "data" => []
            ]);
        } 

        $message = Message::create([
            "body" => $request->message,
            "user_id" => auth()->user()->id,
            "chat_id" => $chat->id
        ]);
        
        //handle media here 
        
        //emit message sent

        //
        
    }
}
