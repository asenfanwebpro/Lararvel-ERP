<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\Users;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    public function store($token){
        $user = Users::where('remember_token','=',$token)->first();
        if(empty($user)){
            return redirect()->route('user.login');
        }
        return view('auth/passwords/reset')->with('token',$token);
    }
    public function resetpassword_post(Request $request){
        $this->validate($request, [            
            'password' => 'required|min:8',
            'confirmpassword' => 'required_with:password|same:password|min:8'
        ]);
        
        $data['password'] = md5($request['password']);
        $data['remember_token'] = $request['_token'];
       
        Users :: where('remember_token','=',$request->remembertoken)->update($data);

        return redirect()->route('user.login');
    }


}
