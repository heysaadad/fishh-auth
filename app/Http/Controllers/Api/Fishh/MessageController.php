<?php

namespace App\Http\Controllers\Api\Fishh;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;

class MessageController extends Controller
{
    function getUserMessages(Request $request){
        $user_1 = $request->sender_id;
        $user_2 = $request->receiver_id;
        $messages = Message::whereIn('user_id_1', [$user_1, $user_2])
        ->whereIn('user_id_2', [$user_1, $user_2])
        ->orderBy('created_at')
        ->get();
        // $messages = Message::where('user_id_1', $user_1)->orderBy('created_at')->get();
        return response()->json($messages);
    }
}
