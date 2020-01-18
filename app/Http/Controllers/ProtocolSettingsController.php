<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societa;
use App\Models\ProtocolSettings;

class ProtocolSettingsController extends Controller
{
    public function register(){
        $company = Societa::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocolsettings_view",'name'=>"Setting Protocollo"], ['name'=>"Nuovo"]
        ];
        return view('pages/protocol/protocolsettings_register')
                ->with('company',$company)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('subpage','protocollo')
                ->with('page','protocolsettings');
    }

    public function view(){
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocolsettings_view",'name'=>"Setting Protocollo"], ['name'=>"Setting Protocollo"]
        ];

        $data = ProtocolSettings::all();
        return view('pages/protocol/protocolsettings')
                ->with('breadcrumbs',$breadcrumbs)
                ->with('data',$data)
                ->with('subpage','protocollo')
                ->with('page','protocolsettings');
    }

    public function save(Request $request){
        $arr = ['company','section','progress'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        if($request->id == 0){
            ProtocolSettings :: create($data);
        }
        else{
            ProtocolSettings :: where('id','=',$request->id)->update($data);
        }
        return redirect()->route('protocolsettings.view');           
    }
    
    public function edit($id){
        $data = ProtocolSettings::find($id);
        $company = Societa::all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"protocolsettings_view",'name'=>"Setting Protocollo"], ['name'=>"Setting Protocollo"]
        ];

        return view('pages/protocol/protocolsettings_register')
                ->with('data',$data)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('company',$company)
                ->with('subpage','protocollo')
                ->with('page','protocolsettings');
    }

    public function delete(Request $request){
        ProtocolSettings::find($request->id)->delete();
        return response()->json(['msg' => 'success']);
    }
}
