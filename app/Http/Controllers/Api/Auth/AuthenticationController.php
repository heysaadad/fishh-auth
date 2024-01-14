<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    function Register(Request $request){
        $request->validate([
            "email"=> "email|string|unique:users|required",
            "name" => "string|required",
            "username" => "string|required|unique:users",
            "password" => "required|string|min:8",
            "age" => "integer|required",
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $profile = new Profile();
        $profile->age = $request->age;
        $user->save();
        $profile->user_id = $user->id;
        $ip = $this->getIp();
        $profile->user_ip = $ip;
        $profile->last_login_ip = $ip;
        $profile->save();
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json([
            "status"=> "success",
            "message"=> "Registration Successful",
            "token"=> $token,
        ]);
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    function Login(Request $request){
        $request->validate([
            "email"=> "email|required",
            "password" => "required|min:8",
        ]);
        $user = User::where("email", $request->email)->first();
        if($user){
            $auth = Auth::attempt(["email"=> $request->email,"password"=> $request->password]);
            if ($auth) {
                $user = User::with("profiles")->find($user->id);
                $user->profiles->last_login_ip = $user->profiles->user_ip;
                $user->profiles->user_ip = $this->getIp();
                $user->profiles->update();
                $token = $user->createToken("auth_token")->accessToken;
                return response()->json([
                    "status"=> "success",
                    "message"=> "Login Successfull",
                    "token"=> $token,
                    "profile" => $user->profiles,
                ]);
            }
            else{
                return response()->json([
                    "status"=> "error",
                    "message"=> "Wrong credentials"
                ]);
            }
        }
        else{
            return response()->json([
                "status"=> "error",
                "message"=> "User Not Found",
            ]);
        }
    }
    function Logout(Request $request){
        if (!$request->user()){
            return response()->json([
                "status"=> "error",
                "message"=> "You are not logged in."
            ]);
        }
        $request->user()->tokens()->delete();
        return response()->json([
              "status"=>"success",
              "message"=> "Logout Successfull",
        ]);
    }

    function sendEmailVerificationLink($email){
        $user = User::where("email", $email)->first();
        if (!$user){
            return response()->json([
                "status"=> "error",
                "message"=> "User Not Found",
            ]);
        }
        if ($user->hasVerifiedEmail()){
            return response()->json([
                "status"=> "error",
                "message"=> "Email Already Verified",
            ]);
        }
        $random = Str::random(40);
        $domainPrefix = URL::to('/auth/verify');
        $urlToVerify = $domainPrefix . '/' . $random;
        $mailData = [
            "title" => "Fishh Email Verification",
            "body" => "Please click the link below to verify your email address.",
            "url" => $urlToVerify,
            "user" => $user->name,
        ];
        Mail::send('auth.emailVerify', ['data' => $mailData], function($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Fishh Email Verification');
        });
        $user->remember_token = $random;
        $user->save();
        return response()->json([
            "status"=> "success",
            "message"=> "Email Verification Link Sent",
        ]);
    }

    function verifyEmail($token){
        $user = User::where("remember_token", $token)->first();
        if (!$user){
            echo "<h1>User Not Found</h1>";
        }
        if ($user->hasVerifiedEmail()){
            echo "<h1>Email Already Verified</h1>";
        }
        else
        {
            $user->email_verified_at = Carbon::now();
            $user->save();
            echo "<h1>Email Verified</h1>";
        }
    }
}
