<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societa;
use App\Models\Protocol;
use App\Models\ProtocolData;
use App\Models\ProtocolSettings;
use App\Models\ProtocolForm;
use File;


class ProtocolController extends Controller
{
    public function register(Request $request){

        $company_name = Societa::find($request->companyid)->ragione_sociale;
        $sections = ProtocolSettings::where('company','=',$company_name)->get();
        $maxno = Protocol::where('company','=',$company_name)->where('section','=',$request->section)->max('no');
        $progressive = ProtocolSettings::where('company','=',$company_name)->where('section','=',$request->section)->first();
        $progressive = (!empty($progressive))?$progressive->progress:'';
        $anno = (strtolower($progressive) == "year")?date("Y"):"0000";
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocol_views/".$request->companyid.'/'.$request->section,'name'=>"Protocollo"], ['name'=>"Nuovo Protocollo"]
        ];
        return view('pages/protocol/protocol_register')               
                ->with('company',$company_name)
                ->with('section',$request->section)
                ->with('sections',$sections)
                ->with('maxno',$maxno+1)
                ->with('page','protocoll')
                ->with('anno', $anno)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','protocoll_li'.$request->companyid);
    }

    public function formhtml(Request $request){
        $data = ProtocolForm::where('company','=',$request->company)
                ->where('section','=',$request->section)
                ->first();
        if(isset($data) && !empty($data)){
            $formhtml = $data->formhtml;
            $formhtml = explode(',', $formhtml);
        }
        else{
            $formhtml = [];
        }
        return response()->json(['formhtml' => $formhtml]);
    }

    public function view($companyid){

        $company_name = Societa::find($companyid)->ragione_sociale;
        $sections = ProtocolSettings::where('company','=',$company_name)->get();
        $section = ProtocolSettings::where('company','=',$company_name)->first();
        $section = (!empty($section))?$section->section:'';
        
        $data = ProtocolSettings::where('company','=',$company_name)->where('section','=',$section)->get();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocol_view/".$companyid,'name'=>"Protocollo"], ['name'=>"Protocollo"]
        ];
        return view('pages/protocol/protocol')
                ->with('data',$data)
                ->with('companyid',$companyid)
                ->with('company',$company_name)
                ->with('section',$section)
                ->with('sections',$sections)
                ->with('page','protocoll')
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','protocoll_li'.$companyid);
    }

    public function views($companyid,$section){

        $company_name = Societa::find($companyid)->ragione_sociale;
        $sections = ProtocolSettings::where('company','=',$company_name)->get();
        $section = $section;
        
        $data = Protocol::where('company','=',$company_name)->where('section','=',$section)->get();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocoll_views/".$companyid.'/'.$section,'name'=>"Protocoll"], ['name'=>"Protocoll"]
        ];
        return view('pages/protocol/protocol')
                ->with('data',$data)
                ->with('companyid',$companyid)
                ->with('company',$company_name)
                ->with('section',$section)
                ->with('sections',$sections)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','protocoll')
                ->with('subpage','protocoll_li'.$companyid);
    }
    
    public function edit($companyid,$id){
        $company_name = Societa::find($companyid)->ragione_sociale;
        $sections = ProtocolSettings::where('company','=',$company_name)->get();
        $data = Protocol::find($id);
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocoll_views/".$companyid.'/'.$data->section,'name'=>"Protocoll"], ['name'=>"Protocoll"]
        ];
        return view('pages/protocol/protocol_register')
                ->with('sections',$sections)
                ->with('company',$company_name)
                ->with('section',$data->section)
                ->with('data',$data)
                ->with('maxno','')
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','protocoll_li'.$companyid)
                ->with('page','protocoll');
    }

    public function delete(Request $request){
        Protocol::find($request->id)->delete();
        return response()->json(['msg' => 'success']);
    }

    public function data(Request $request){
        $data = Protocol::find($request->id)->extra;
        $data = explode(',',$data);
        return response()->json(['data' => $data]);
    }

    public function note(Request $request){
        $data = ProtocolData::where('protocollid','=',$request->protocollid)->where('note','!=','')->get();
        return response()->json(['data' => $data]);
    }
    public function note_post(Request $request){
        $data['protocollid'] = $request->protocollid;
        $data['note'] = $request->note;
        ProtocolData :: create($data);
        return response()->json(['data' => 'success']);
    }
    public function note_delete(Request $request){
       
        ProtocolData :: where('id','=',$request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function file_read(Request $request){
        $data = ProtocolData::where('protocollid','=',$request->protocollid)->where('filename','!=','')->get();
        return response()->json(['data' => $data]);
    }
    public function file_post(Request $request){
        $data['protocollid'] = $request->protocollid;
        
        $files = $request->file('docs');
       
        if ($files) {
            foreach($files as $file) {
            
                $name = $file->getClientOriginalName();
                 
                $data['filename'] = $name;
                
                ProtocolData :: create($data);

                $destinationPath =  public_path('uploads/protocol'); // upload path            
                $file->move($destinationPath, $name);            
            }
        }
        
        return redirect()->back();
       
    }
    public function file_delete(Request $request){
       
        $file = ProtocolData :: where('id','=',$request->id);
        $file_path = public_path('uploads/protocol/'.$file->first()->filename);
        if (File::exists($file_path)) {
            File::delete($file_path);            
        }
        $file->delete();
        return response()->json(['data' => 'success']);
    }
}
