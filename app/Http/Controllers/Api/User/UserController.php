<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getProfile($id){
        $profile = \App\Models\Profile::find($id);
        return response()->json($profile);
    }

    public function updateUserProfile(Request $request, $id){
        // if (auth()->user()->id == $id) {
        //     $profile = \App\Models\Profile::find($id);

        //     $profile->save();
        // }

        $user = User::with("profiles")->findOrFail($id);
        $profile = $user->profiles;
        $profile->about = $request->input('about');
        $profile->job_title = $request->input('job_title');
        $profile->job_place = $request->input('job_place');
        $profile->school_name = $request->input('school_name');
        $profile->grad_year = $request->input('grad_year');
        $profile->custom_username = $request->input('custom_username');
        $profile->current_city = $request->input('current_city');
        $profile->photo_1 = $request->input('photo_1');
        $profile->photo_2 = $request->input('photo_2');
        $profile->photo_3 = $request->input('photo_3');
        $profile->photo_4 = $request->input('photo_4');
        $profile->photo_5 = $request->input('photo_5');
        $profile->update();
        return response()->json($user);
    }

    public function recommendProfile(Request $request, $id){
        //Profile Recomendation Algorithm.
    }

}
