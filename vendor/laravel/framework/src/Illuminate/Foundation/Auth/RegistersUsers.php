<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Crypt;
use App\UserVerification;
use URL;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //Auth::login($this->create($request->all()));

        $this->create($request->all());


        //Send confirmation mail/////////////////////////////////////////////////////////////////////////////////
        $email = $request['email'];
        //creating the token
        $token = substr(Crypt::encrypt($email.str_random(10)), 0, 100);

        //Enter the token and email into database
        $user_verification = new UserVerification;
        $user_verification->email               = $email;
        $user_verification->verification_token  = $token;
        $user_verification->save();

        //return URL::to('/')."/email_confirmation/".$token;  //for fast testing

        //Now send the mail
        Mail::send('auth.emails.welcome', ['url' => URL::to('/').'/email_confirmation/'.$token], function ($message) use ($email)
        {
            $message->to($email,'Laravel 5.2 App')
                    ->subject('Activate Your Account !');
        });

        return redirect($this->redirectPath());
    }
}
