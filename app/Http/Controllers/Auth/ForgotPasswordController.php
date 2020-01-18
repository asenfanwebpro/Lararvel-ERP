<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;



class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    public function index(){
        
    }
    public function store(){
        return view('auth/passwords/forgotpassword');
    }
    public function forgotpassword(Request $request){
        
        $user = Users::where("email",'=',$request->email)->first();
        if(empty($user)){
            return back();
        }
        $token = $user->remember_token;
        $senduri = $request->uri;
        $email = $request->email;
        Mail::to($email)->send(new SendMailable($senduri.'/'.$token));
        return view('auth/passwords/forgotpassword')->with("msg","Email inviata");
    }
}
