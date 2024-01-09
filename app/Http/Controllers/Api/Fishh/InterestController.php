<?php

namespace App\Http\Controllers\Api\Fishh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Interest;
use App\Models\UserInterest;

class InterestController extends Controller
{
    public function getUserInterests(Request $request, $id){
        $user = User::with("interests")->find($id);
        $interests = $user->interests;
        return response()->json([
            "status"    => "success",
            "interests" => $interests,
        ]);
    }


}
