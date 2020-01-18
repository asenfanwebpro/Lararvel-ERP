<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Cookie;
use App\Models\Users;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   

    /**
     * Where to redirect users after login.
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
    public function store(){       
        
        return view('auth/login');
    }
    public function login(Request $request){
        
        $user = Users::where("email",'=',$request->email)->where("password",'=',md5($request->password))->where('status','=', 1)->first();
        if(empty($user)){
            return redirect()->back()->withErrors(['msg'=>'Nessun utente trovato']);
        }

        $role = Users :: join("usergroup",'users.ruolo','=','usergroup.id')->where('users.id','=', $user->id)->first();
        $myrole = (!empty($role))?$role->permission:"default";

        Session :: put('id',$user->id);
        Session :: put('name',$user->name);
        Session :: put('lastname',$user->lastname);
        Session :: put('email',$user->email);
        Session :: put('role',$myrole);
        Session :: put('avatar',$user->avatar);

        if($request->rememberme != null){
            Session :: put('rememberme',$request->rememberme);
        }
       
         //return response()->json(['rememberme' => Cookie::get('email')]);
        return redirect()->route('dashboard');
    }
    public function logout(){
        
        Session :: flush();
       
        return redirect()->route('/');
    }
    public function profile($id){
        $data = Users :: find($id);
        return view('auth/profile')->with('data',$data)->with('page','')->with('subpage','');
    }
    public function profile_save(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'lastname' => 'required|string',                       
        ]);
        $arr = ['name','lastname','genere','datadinascita'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        $file = $request->file('avatar');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['avatar']= $filename;
            $file->move('uploads/avatar',$filename);
        }

        Users :: where('id','=',$request->id)->update($data);
        return redirect()->back();
    }
}
