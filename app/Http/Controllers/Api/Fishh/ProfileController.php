<?php

namespace App\Http\Controllers\Api\Fishh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getUserProfile(Request $request, $id){
        $user = User::with("profiles")->find($id);
        if($user){
            $profile = $user->profiles;
            return response()->json([
                "status"    => "success",
                "profile" => $profile,
            ]);
        }
        else{
            return response()->json([
                "status"=> "error",
                "message"=> "User Not Found",
                ]);
        }
    }
}
