<?php

namespace App\Http\Controllers;

use Request;
use App\UserVerification;
use App\User;
use URL;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() //Index page
    {
        return view('welcome');
    }

    public function email_confirmation($token)  //Confirm email verification
    {
        //find verification info
        $user_verification  = UserVerification::where('verification_token', $token);
        if($user_verification->count())
        {
            $user_verification  = $user_verification->first();
            //find user
            $user               = User::where('email', $user_verification->email)->first();
            //update user
            $user->is_active = 'active';
            $user->save();
            //delete verification info - optional
            $user_verification->delete();
            return 'Your account is activated. You can login from <a href="'.URL::to('/login').'" target="_blank">here</a>';
        }
        else
            return "Wrong URL or token";
    }
}
