<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societa;

class SocietaController extends Controller
{
    public function register(){
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"societa_view",'name'=>"Societa"], ['name'=>"Nuovo Societa"]
        ];

        return view('pages/societa/societa_register')
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','societar')
                ->with('page','societa');
    }

    public function view(){
        $data = Societa::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"societa_view",'name'=>"Societa"], ['name'=>"Societa"]
        ];

        return view('pages/societa/societa')
                ->with('data',$data)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','societar')
                ->with('page','societa');
    }

    public function save(Request $request){
        
        $arr = ['ragione_sociale','citta','indirizzo','cap','iva','cf','sdi','mail','pec','tel','fax'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 

        $file = $request->file('logo');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['logo']= $data['ragione_sociale'].'_'.$filename;
            $file->move('uploads/logo',$filename);
        }
        
        if($request->id == 0){
            Societa :: insert($data);
        }
        else{
            Societa :: where('id','=',$request->id)->update($data);
        }
        
        return redirect()->route('societa.view');           
    }
    
    public function edit($id){
        $data = Societa::find($id);
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"societa_view",'name'=>"Societa"], ['name'=>"Edit Societa"]
        ];
        return view('pages/societa/societa_register')
                ->with('data',$data)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','societar')
                ->with('page','societa');
    }

    public function delete(Request $request){
        Societa::find($request->id)->delete();
        return response()->json(['msg' => 'success']);
    }
}
