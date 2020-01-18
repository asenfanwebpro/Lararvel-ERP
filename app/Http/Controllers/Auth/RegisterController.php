<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    

    /**
     * Where to redirect users after registration.
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

    
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function store(){
        return view("auth/register");
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirmpassword' => 'required_with:password|same:password|min:8'
        ]);
        $arr = ['name','lastname','email'];
        for ($i=0; $i < count($arr); $i++) { 
            $data[$arr[$i]] = $request[$arr[$i]];
           
        }
        $data['password'] = md5($request['password']);
        $data['remember_token'] = $request['_token'];
        Users :: insert($data);

        return redirect()->route('user.login');
    }

    
}
