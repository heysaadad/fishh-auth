<?php

namespace App\Http\Controllers\Api\Fishh;

use App\Http\Controllers\Controller;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use App\Models\User;

class MatchController extends Controller
{
    public function getUserMatches(Request $request, $id){
        $user = User::with("matches")->find($id);
        return response()->json($user->matches);
    }

    public function createUserMatch(Request $request){

        $match = new UserMatch();
        $match->user_id_1 = $request->user_1;
        $match->user_id_2 = $request->user_2;
        $match->save();
        $match = new UserMatch();
        $match->user_id_1 = $request->user_2;
        $match->user_id_2 = $request->user_1;
        $match->save();
        return response()->json([
            "status" => "success",
            "message" => "User Matched"
        ]);
    }
}
