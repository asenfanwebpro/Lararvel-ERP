<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societa;
use App\Models\ProtocolForm;
use App\Models\ProtocolSettings;

class ProtocolFormController extends Controller
{
    public function register(){

        $company = Societa::all();
        $breadcrumbs = [
            ['link'=>"dashboard",'name'=>"Home"],['link'=>"protocolform_register",'name'=>"Form"], ['name'=>"Costruttore di moduli"]
        ];
        return view('pages/protocol/formbuilder')
            ->with('company',$company)
            ->with('breadcrumbs',$breadcrumbs)
            ->with('subpage','formbuilder')
            ->with('page','protocolsettings');
    }
    
    public function section(Request $request){
        $company_name = $request->company;
        $section = ProtocolSettings::where('company','=',$company_name)->get();

        return response()->json(['section' => $section]);
    }
    
    public function load_form(Request $request){
        $company_name = $request->company;
        $section = $request->section;
        $formhtml = ProtocolForm::where('company','=',$company_name)->where('section','=',$section)->first();

        if(empty($formhtml)){
            $data = [];
        }
        else{
            $data = explode(',',$formhtml->formhtml);
        }
        return response()->json(['data' => $data]);
    }
    
    public function save(Request $request){
        $arr = ['company','section'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }

        $data['formhtml'] = implode(',',$request->formhtml);

        $builder = ProtocolForm::where('company','=',$request->company)->where('section','=',$request->section)->first();
        if(empty($builder)){
            ProtocolForm :: create($data);
        }
        else{
            ProtocolForm::where('company','=',$request->company)->where('section','=',$request->section)->update($data);
        }
        return response()->json(['msg' => $data['formhtml']]);
    }
}
