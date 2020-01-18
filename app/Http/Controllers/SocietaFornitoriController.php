<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocietaFornitori;
use App\Models\EcommerceCategory;

class SocietaFornitoriController extends Controller
{
    public function register(){
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"fornitori_view",'name'=>"Fornitori"], ['name'=>"Nuovo Fornitore"]
        ];
        $categories = EcommerceCategory :: all();
        return view('pages/societa/fornitori_register')
                ->with('categories',$categories)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','fornitori');
    }

    public function view(){
        $data = SocietaFornitori::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"fornitori_view",'name'=>"Fornitori"], ['name'=>"Fornitori"]
        ];
        return view('pages/societa/fornitori')
                ->with('data',$data)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','fornitori');
    }

    public function save(Request $request){
        
        $arr = ['ragione_sociale','citta','indirizzo','cap','iva','cf','sdi','mail','pec','tel','fax'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        $categories = $request['categorylist'];
        if(count($categories) == 0){
            $data['category'] = '';
        }
        else{
            $data['category'] = implode(',',$categories);
        }
        $file = $request->file('logo');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['logo']= $data['ragione_sociale'].'_'.$filename;
            $file->move('uploads/logo',$filename);
        }

        if($request->id == 0){
            SocietaFornitori :: insert($data);
        }
        else{
            SocietaFornitori :: where('id','=',$request->id)->update($data);
        }
        
        return redirect()->route('fornitori.view');  
        //return response()->json(['msg' => $categories]);         
    }
    
    public function edit($id){
        $data = SocietaFornitori::find($id);
        $categories = EcommerceCategory :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"fornitori_view",'name'=>"Fornitori"], ['name'=>"Edit Fornitore"]
        ];
        return view('pages/societa/fornitori_register')
                ->with('data',$data)
                ->with('categories',$categories)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','fornitori');
    }

    public function delete(Request $request){
        SocietaFornitori::find($request->id)->delete();
        return response()->json(['msg' => 'success']);
    }
}
