<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Usergroup;
use DB;

class PermissionController extends Controller
{
    public function group(){
        $data = Usergroup::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"usergroup",'name'=>"Gruppo di utenti"], ['name'=>"Gruppo di utenti"]
        ];
        return view('pages/usergroup')
            ->with('data',$data)
            ->with('page','permission') 
            ->with('breadcrumbs',$breadcrumbs)               
            ->with('subpage','usergroup');
    }
    public function getgroup(Request $request){
        $data = Usergroup :: find($request->id);
        return response()->json(['data' => $data]);
    }
    public function savegroup(Request $request){
        $id = $request->id;        
        $data['group'] = $request->group;
        if($id == 0){
            Usergroup :: create($data);
            $data = Usergroup::where('id', \DB::raw("(select max(`id`) from usergroup )"))->first();
        }
        else{
            Usergroup :: where("id","=",$id)->update($data);
            $data = Usergroup :: find($id);
        }
        return response()->json(['data' => $data]);
    }
    public function deletegroup(Request $request){
        Usergroup :: where("id","=", $request->id)->delete();
        return response()->json(['data' => "successful"]);
    }
    public function getpermission(Request $request){
        $id = $request->id;
        $permission = Usergroup :: find($id)->permission;
        $data = explode(',',$permission);
        return response()->json(['data' => $data]);
    }
    public function savepermission(Request $request){
        $id = $request->id;
        $diss = (strpos($request->permission,'true') > 0)?1:0;
        $permission = ($diss == 1)?substr($request->permission,0,strlen($request->permission)-5):substr($request->permission,0,strlen($request->permission)-6);
        
        $data_permission = Usergroup :: find($id)->permission;
        $data_permission_arr = explode(",",$data_permission);
        
        $index = array_search($permission,$data_permission_arr);

        if($diss == 1){
            $new_permission = array_push($data_permission_arr,$permission); 
        }
        else{            
            $new_permission = array_splice($data_permission_arr,$index,1);                      
        }

         $data['permission'] = implode(',',$data_permission_arr);
         Usergroup :: where("id","=",$id)->update($data);


        return response()->json(['data' => 'success']);
    }

    public function list(){
        $data = Users::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"userlist",'name'=>"Lista degli utenti"], ['name'=>"Lista degli utenti"]
        ];
        $role_arr = [];

        if(count($data) > 0){
            foreach($data as $key => $value){
                $group = Usergroup :: find($value->ruolo);
                $role = (!empty($group))?$group->group:"";
                $role_arr[$key] = $role;
            }
        }
        return view('pages/userlist')
            ->with('data',$data)
            ->with('role',$role_arr)
            ->with('page','permission') 
            ->with('breadcrumbs',$breadcrumbs)               
            ->with('subpage','userlist');
    }
    public function useredit($id){
        $data = Users :: find($id);
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"userlist",'name'=>"Lista degli utenti"], ['name'=>"Lista degli utenti"]
        ];
        $group = Usergroup :: all();
        return view('pages/useredit')
            ->with('data',$data)
            ->with('group',$group)
            ->with('page','permission') 
            ->with('breadcrumbs',$breadcrumbs)               
            ->with('subpage','userlist');
    }
    public function saveuser(Request $request){
        $arr = ['name','lastname','email','status','ruolo'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        Users :: where("id","=",$request->id)->update($data);
        return redirect()->back();
    }
    public function deleteuser(Request $request){
        $id = $request->id;
        Users :: where("id","=",$id)->delete();
        return response()->json(['data' => 'success']);
    }
}
