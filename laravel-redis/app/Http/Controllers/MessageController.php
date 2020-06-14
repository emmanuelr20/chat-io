<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class MessageController extends Controller
{
    public function list(Request $request, Chat $chat)
    {
        if (!$chat || !$chat->users->contains('id', auth()->id())) {
            return response()->json([
                "messages" => [],
                "status" => "success"
            ], 200);
        }
        $messages = $chat->messages()->orderBy("created_at", "desc")->paginate(10);
        return response()->json([
            "messages" => $messages,
            "status" => "success"
        ], 200);
    }
}
