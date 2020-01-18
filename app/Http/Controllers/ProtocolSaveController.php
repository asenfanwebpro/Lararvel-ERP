<?php
namespace App\Http\Controllers;

use Request;
use App\Models\Societa;
use App\Models\Protocol;
use App\Models\ProtocolSettings;


class ProtocolSaveController extends Controller
{

    public function save(Request $request){
        
        $requiretags = explode(",",Request::post('requiretags'));

        $data = Request::all();
        $arr = ['_token','id','company','section','requiretags'];
        $extra = [];

        $id = Request::post('id');
        $companyid = Societa :: where('ragione_sociale','=',$data['company'])->first()->id;

         foreach($data as $key=>$value){

            foreach($requiretags as $tags){
                //required
                if($key == $tags && $value == ''){
                    if($id != 0){
                        return redirect()->back()->withErrors(['msg'=> $key.' è obbligatorio.']);
                    }
                    else{
                        $company_name = Societa::find($companyid)->ragione_sociale;
                        $sections = ProtocolSettings::where('company','=',$company_name)->get();
                        $maxno = Protocol::where('company','=',$company_name)->where('section','=',Request::post('section'))->max('no');
                        $progressive = ProtocolSettings::where('company','=',$company_name)->where('section','=',Request::post('section'))->first()->progress;

                        $anno = (strtolower($progressive) == "year")?date("Y"):"0000";
                        return view('pages/protocol/protocol_register')               
                                ->with('company',$company_name)
                                ->with('section',Request::post('section'))
                                ->with('sections',$sections)
                                ->with('maxno',$maxno+1)
                                ->with('page','protocoll')
                                ->with('subpage','protocoll_li'.$companyid)
                                ->with('anno', $anno)
                                ->with('msg', $key.' è obbligatorio.');
                    }                    
                    
                }
            }

            if(array_search($key,$arr) === false){
                
                array_push($extra, $key.':'.$value);
                
            }
        }
        
        $inputdata['company'] = $data['company'];
        $inputdata['section'] = $data['section'];
          $inputdata['extra'] = implode(',', $extra);
          
        $progressive = ProtocolSettings::where('company','=',$data['company'])->where('section','=',$data['section'])->first()->progress;
        if(strtolower($progressive) == "year"){
            $inputdata['anno'] = date('Y');
        }  
        else{
            $inputdata['anno'] = '0000';
        }
        
        if($id == 0){
            $inputdata['no'] =  Protocol ::where('company','=',$data['company'])->where('section','=',$data['section'])->max('no') + 1;
            
            Protocol :: create($inputdata);
        }
        else{
            Protocol :: where('id','=',$id)->update($inputdata);
        }
        return redirect('protocol_views/'.$companyid.'/'.Request::post('section'));
       // return response()->json(['msg' => "dsfasdf"]);         
    }
    
    
}
