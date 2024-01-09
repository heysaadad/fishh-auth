<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationController extends Controller
{
    function Register(Request $request){
        $request->validate([
            "email"=> "email|string|unique:users",
            "name" => "string",
            "password" => "required|string|min:8",
            "age" => "integer",
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $profile = new Profile();
        $profile->age = $request->age;
        $user->save();
        $profile->user_id = $user->id;
        $profile->save();
        return response()->json([
            "status"=> "success",
            "message"=> "Registration Successful",
            "profile"=> $profile
        ]);
    }

    function Login(Request $request){
        $request->validate([
            "email"=> "email|required",
            "password" => "required|min:8",
        ]);
        $user = User::where("email", $request->email)->first();
        if($user){
            $token = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                "status"=> "success",
                "message"=> "Login Successfull",
                "token"=> $token,
            ]);
        }else{
            return response()->json([
                "status"=> "error",
                "message"=> "Login Failed",
            ]);
        }
    }
    function Logout(Request $request){
        // auth()->user()->tokens()->delete();
        return response()->json([
              "status"=>"success",
              "message"=> "Logout Successfull",
        ]);
    }
}
