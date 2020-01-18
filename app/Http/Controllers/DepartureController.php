<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartureShip;
use App\Models\DeparturePort;
use App\Models\DepartureTime;
use App\Models\DepartureInfo;
use App\Models\DepartureBackground;
use DateTime;
use DateTimeZone;

class DepartureController extends Controller
{
    public function ship(){
        $ships = DepartureShip :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"departure/ship",'name'=>"Departure Nave"], ['name'=>"Departure Nave"]
        ];

        return view('pages/monitor/departureship')
                ->with('data', $ships)
                ->with('page','departure') 
                ->with('breadcrumbs',$breadcrumbs)               
                ->with('subpage','departureship');
    }
    
    public function shipedit(Request $request){
        $ship = DepartureShip :: find($request->id);
        return response()->json(['data' => $ship]);
    }
    
    public function shipsave(Request $request){
        $arr = ['ship'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        $file = $request->file('avatar');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['avatar']= $filename;
            $file->move('uploads/departure',$filename);
        }
        
        if($request->id == 0){     
            DepartureShip :: create($data);       
        }
        else{
            DepartureShip :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('departure.ship');  

    }
    
    public function shipdelete(Request $request){
        DepartureShip :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }
    
    public function port(){
        $ports = DeparturePort :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"departure/port",'name'=>"Departure Port"], ['name'=>"Departure Port"]
        ];

        return view('pages/monitor/departureport')
                ->with('data', $ports)
                ->with('page','departure') 
                ->with('breadcrumbs',$breadcrumbs)               
                ->with('subpage','departureport');
    }
    
    public function portedit(Request $request){
        $port = DeparturePort :: find($request->id);
        return response()->json(['data' => $port]);
    }
    
    public function portsave(Request $request){
        $arr = ['port'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }       
        if($request->id == 0){         
            DeparturePort :: create($data);            
        }
        else{
            DeparturePort :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('departure.port');  

    }
    
    public function portdelete(Request $request){
        DeparturePort :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function time(){
        $times = DepartureTime :: all();
        $ports = [];
        if(count($times) > 0){
            foreach($times as $key=>$value){
                $port = DeparturePort :: find($value->route_id)->port;
                $ports[$key] = $port;
            }
        }
        
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>'departure/time','name'=>'Lista Partenze'], ['name'=>'Lista Partenze']
        ];

        return view('pages/monitor/departuretime')
                ->with('data', $times)     
                ->with('ports',$ports)           
                ->with('page','departure')  
                ->with('breadcrumbs',$breadcrumbs)              
                ->with('subpage','departuretime');
    }

    public function info($id){
        $data = DepartureTime :: find($id);
        $ports = DeparturePort :: all();
        $ships = DepartureShip :: all();

        $infos = DepartureInfo :: where("departure_id",'=',$id)->get();
        $subpage = ($id == -1)?'departureadvertise':'departuretime';

        $link = ($id == -1)?"departure/info/".$id:'departure/time';
        
        if($id == -1){
            $name = 'Nota';
            $name1 = 'Annuncio pubblicitario';
        }
        else if($id == 0){
            $name = 'Departure_list';
            $name1 = 'Nuova Partenza';
        }
        else{
            $name = 'Departure_list';
            $name1 = 'Departure_modificare';
        }
    
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>$link,'name'=>$name], ['name'=>$name1]
        ];
    
        return view('pages/monitor/departureinfo')
                ->with('data', $data)
                ->with('ports', $ports)
                ->with('ships', $ships)
                ->with('id', $id)
                ->with('infos',$infos)
                ->with('page','departure')
                ->with('breadcrumbs',$breadcrumbs)                
                ->with('subpage',$subpage);
    }

    public function save(Request $request){
        $arr = ['route_id','ship_id','time','group','status'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }

        $arrweek = [];
        $week = ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'];
        for($i=0; $i<count($week); $i++){
            if($request[$week[$i]] != ''){
                array_push($arrweek, $request[$week[$i]]);
            }            
        }

        $data['week'] = implode(',',$arrweek);

        $id = $request->id;
        if($id == 0){
            DepartureTime :: create($data);
        }
        else{
            DepartureTime :: where('id','=',$id)->update($data);
        }
        
        return redirect()->route('departure.time');
    }

    public function delete(Request $request){
        $id = $request->id;
        DepartureTime :: where('id','=',$id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function notesave(Request $request){
        $arr = ['departure_id','date_from','date_to','type','status','text'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        $id = $request->id;
        if($id == 0){
            DepartureInfo :: create($data);
            $maxid = DepartureInfo :: max('id');
            $info = DepartureInfo :: find($maxid);
        }
        else{
            DepartureInfo :: where('id','=', $id)->update($data);
            $info = DepartureInfo :: find($id);
        }
        return response()->json(['data' => $info]);
    }
    
    public function noteedit(Request $request){
        $data = DepartureInfo :: find($request->id);
        return response()->json(['data' => $data]);
    }

    public function notedelete(Request $request){
        DepartureInfo :: where('id','=',$request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function background(){
        $data = DepartureBackground :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"departure/background",'name'=>"Departure_Sfondo"], ['name'=>"Departure_Sfondo"]
        ];

        return view('pages/monitor/departurebackground')
                ->with('data', $data)        
                ->with('page','departure')   
                ->with('breadcrumbs',$breadcrumbs)             
                ->with('subpage','departurebackground');
    }

    public function backgroundsave(Request $request){
        $file = $request->file('picturename');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['picturename']= $filename;
            $file->move('uploads/departure',$filename);
        }

        $id = $request->id;
        if($id == 0){
            DepartureBackground :: create($data);            
        }
        else{
            DepartureBackground :: where('id','=', $id)->update($data);           
        }
        return redirect()->route("departure.background");
        
    }
    
    public function backgrounddelete(Request $request){
        DepartureBackground :: where('id','=',$request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function monitor($port){       
        $week_arr = ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'];
        $gmtTimezone = new DateTimeZone('Europe/Berlin');            
        $date = new DateTime('',$gmtTimezone);
        $www = $date->format('w');
        $day = $date->format('Y-m-d');
        $hour = $date->format('H:i');

        //$ports = explode(".",$port);
        $today = $date->format('d').' '.$date->format('F').' '.$date->format('Y');
       
        //background images
        $bgs = DepartureBackground :: all();

        //next hours
        $nexthours = [];
        $nextports = [];
        $ports = explode('+',$port);
        $arrr = $ports;

        //ports
        $data = DepartureTime::join('departure_port','departure_port.id','=','departure_time.route_id')
                            ->join('departure_ship','departure_ship.id','=','departure_time.ship_id')
                            ->whereIn("departure_port.port",$ports)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')
                            ->orderBy('departure_time.time','asc')
                            ->select(
                                '*',
                                'departure_time.id as departureid')
                            ->get();

        $displaydata = [];
        $group = [];
        $note = [];
        $nextarr = [];

        if(count($data) > 0){
            foreach($data as $key => $value){
                $to_time = strtotime($hour);
                $from_time = strtotime($value->time);
                $diff = round(($to_time - $from_time) / 60,2);
                $diff = ($diff>0)?$diff:10000;
               
                $delay = DepartureInfo :: where('departure_id','=', $value->departureid)
                                        ->where('type','=','delay')                                       
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)                                       
                                        ->where('text','>=',$diff)
                                        ->orderBy('id','desc')
                                        ->first();
                
                $suspend = DepartureInfo :: where('departure_id','=', $value->departureid)                                        
                                        ->where('type','=','suspend')
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)
                                        ->get();       
                $displaydata[$key]['tag'] = '';
                
                if(!empty($delay)){
                    $displaydata[$key]['tag'] = 'delay';
                    
                }
                
                if(count($suspend)>0){
                    $displaydata[$key]['tag'] = 'suspend';
                }

                if( $displaydata[$key]['tag'] == 'delay'){
                    $add = substr($value->time,0,5);
                    $add .= ($delay->text).'min Ritardo/Delay';
                    array_push($nexthours,$add);
                    array_push($nextarr,$value->departure_id);

                    $groupval = explode(',', $value->group); 
                    array_push($nextports,implode('-',$groupval)); 

                    $note[$add] = DepartureInfo::where('departure_id','=',$value->departureid)                            
                        ->where('departure_info.type','=','note')
                        ->where('departure_info.status','=', '1')
                        ->get();
                }
                $grouparr = explode(',', $value->group);
                array_push($group, implode('-',$grouparr));

            }
        }

        $nextdata = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
                            ->whereIn("departure_port.port",$ports)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')
                            ->where('departure_time.time','>',$hour)
                            ->orderBy('departure_time.time','asc')
                            ->select('*','departure_time.id as departureid')
                            ->get();

        if(count($nextdata) == 0){
            $nextdata = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
                            ->whereIn("departure_port.port",$ports)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')                           
                            ->orderBy('departure_time.time','asc')
                            ->select('*', 'departure_time.id as departureid')
                            ->get();
        }

        if(count($nextdata)>0){
            foreach($nextdata as $value){
                $checksuspend = DepartureInfo :: where('departure_id','=', $value->id)                                        
                                        ->where('type','=','suspend')
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)
                                        ->get(); 
                if(count($checksuspend) >0){
                    continue;
                    
                }  
                array_push($nexthours,substr($value->time,0,5)); 

                array_push($nextarr,$value->departureid);

                $groupval = explode(',', $value->group);
                array_push($nextports,implode('-',$groupval));
                $note[substr($value->time,0,5)] = Departureinfo::where('departure_id','=',$value->id)                            
                            ->where('departure_info.type','=','note')
                            ->where('departure_info.status','=', '1')
                            ->get();
                break;
            }
        }
        
        //advertisement
        $adv = DepartureInfo :: where('departure_id','=','-1')
                            ->where('date_from','<=',$day)
                            ->where('date_to','>=',$day)
                            ->where('type','=','note')
                            ->where('status','=', '1')
                            ->get();
        $shiparr = DepartureTime :: join('departure_ship','departure_time.ship_id','=','departure_ship.id')
                            ->whereIn('departure_time.id',$nextarr)->get();
                            //return response()->json(['data' => $arr]);
        
        return view('pages/monitor/monitor')
                ->with('data',$data)
                ->with('group',$group)
                ->with('displaydata',$displaydata)
                ->with('note',$note)
                ->with('adv',$adv)
                ->with('nexthours',$nexthours)
                ->with('nextports',$nextports)
                ->with('today',$today)
                ->with('port',$port)
                ->with('shiparr',$shiparr)
                ->with('bgs',$bgs);
    }
    
    public function monitor_tag($port,$tag){       
        $week_arr = ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'];
        $gmtTimezone = new DateTimeZone('Europe/Berlin');            
        $date = new DateTime('',$gmtTimezone);
        $www = $date->format('w');
        $day = $date->format('Y-m-d');
        $hour = $date->format('H:i');
        
        $today = $date->format('d').' '.$date->format('F').' '.$date->format('Y');
       
        //background images
        $bgs = DepartureBackground :: all();
        $ports = explode('+',$port);
        $tags = explode('+',$tag);
        
        //next hours
        $nexthours = [];
        $nextports = [];
        
        //ports
        $data = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
                            ->join('departure_ship','departure_ship.id','=','departure_time.ship_id')
                            ->whereIn("departure_port.port",$ports)
                            ->whereIn("departure_time.group",$tags)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')
                            ->orderBy('departure_time.time','asc')
                            ->select(
                                '*',
                                'departure_time.id as departureid')
                            ->get();
        $displaydata = [];
        $group = [];
        $note = [];
        $nextarr = [];

        if(count($data) > 0){
            foreach($data as $key => $value){
                $to_time = strtotime($hour);
                $from_time = strtotime($value->time);
                $diff = round(($to_time - $from_time) / 60,2);
                $diff = ($diff>0)?$diff:10000;
                $delay = DepartureInfo :: where('departure_id','=', $value->departureid)
                                        ->where('type','=','delay')                                       
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)                                       
                                        ->where('text','>=',$diff)
                                        ->orderBy('id','desc')
                                        ->first();
                $suspend = DepartureInfo :: where('departure_id','=', $value->departureid)                                        
                                        ->where('type','=','suspend')
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)
                                        ->get();       
                $displaydata[$key]['tag'] = '';

                if(!empty($delay)){
                    $displaydata[$key]['tag'] = 'delay';
                    
                }

                if(count($suspend)>0){
                    $displaydata[$key]['tag'] = 'suspend';
                }

                if( $displaydata[$key]['tag'] == 'delay'){
                    $add = substr($value->time,0,5);
                    $add .= ($delay->text).'min Ritardo/Delay';
                    array_push($nexthours,$add); 
                    array_push($nextarr,$value->departure_id);

                    $groupval = explode(',', $value->group); 
                    array_push($nextports,implode('-',$groupval));

                    $note[$add] = DepartureInfo::where('departure_id','=',$value->departureid)                            
                        ->where('departure_info.type','=','note')
                        ->where('departure_info.status','=', '1')
                        ->get();
                }
                $grouparr = explode(',', $value->group);
                array_push($group, implode('-',$grouparr));

            }
        }
        $nextdata = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
                            ->whereIn("departure_port.port",$ports)
                            ->whereIn("departure_time.group",$tags)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')
                            ->where('departure_time.time','>',$hour)
                            ->orderBy('departure_time.time','asc')
                            ->select('*', 'departure_time.id as departureid')
                            ->get();
        
        if(count($nextdata) == 0){
            $nextdata = DeparturePort::join('departure_time','departureport.id','=','departure_time.route_id')
                            ->whereIn("departureport.port",$ports)
                            ->whereIn("departure_time.group",$tags)
                            ->where("departure_time.week",'LIKE', "%$www%")
                            ->where('departure_time.status','=','1')                           
                            ->orderBy('departure_time.time','asc')
                            ->select('*', 'departure_time.id as departureid')
                            ->get();
        }
        if(count($nextdata)>0){
            foreach($nextdata as $value){
                $checksuspend = DepartureInfo :: where('departure_id','=', $value->id)                                        
                                        ->where('type','=','suspend')
                                        ->where('date_from','<=',$day)
                                        ->where('date_to','>=',$day)
                                        ->get(); 
                if(count($checksuspend) >0){
                    continue;
                    
                }  
                array_push($nexthours,substr($value->time,0,5)); 

                array_push($nextarr,$value->departureid); 

                $groupval = explode(',', $value->group);
                array_push($nextports,implode('-',$groupval));
                $note[substr($value->time,0,5)] = DepartureInfo::where('departure_id','=',$value->id)                            
                            ->where('departure_info.type','=','note')
                            ->where('departure_info.status','=', '1')
                            ->get();
                break;
            }
        }
        
        //advertisement
        $adv = DepartureInfo :: where('departure_id','=','-1')
                            ->where('date_from','<=',$day)
                            ->where('date_to','>=',$day)
                            ->where('type','=','note')
                            ->where('status','=', '1')
                            ->get();
        $shiparr = DepartureTime :: join('departure_ship','departure_time.ship_id','=','departure_ship.id')
                            ->whereIn('departure_time.id',$nextarr)->get();
        
        return view('pages/monitor/monitor_tag')
                ->with('data',$data)
                ->with('group',$group)
                ->with('displaydata',$displaydata)
                ->with('note',$note)
                ->with('adv',$adv)
                ->with('nexthours',$nexthours)
                ->with('nextports',$nextports)
                ->with('today',$today)
                ->with('tag',str_replace(" ", "%20", $tag))
                ->with('port',$port)
                ->with('shiparr',$shiparr)
                ->with('bgs',$bgs);
    }

    public function monitor_table($port1, $port2){
        $bgs = DepartureBackground :: all();
        $data1 = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
            ->where("departure_time.group",'like','%'.$port1)       
            ->where('departure_time.status','=','1')
            ->orderBy('departure_time.time','asc')
            ->get();
        $tag1 = [];
        $many1 = [];
        if(count($data1)>0){
            foreach ($data1 as $key=>$value){
                $tagarr = explode(',',$value->group);
                $tag = implode('-', $tagarr);
                $tag1[$key] = $tag;
                if($value->week == '0,1,2,3,4,5,6'){
                    $many1[$key] = "Tutti i giorni";
                }
                else{
                    $many1[$key] = "Solo feriale"; 
                }
            }
        }

        $data2 = DeparturePort::join('departure_time','departure_port.id','=','departure_time.route_id')
            ->where("departure_time.group",'like','%'.$port2)       
            ->where('departure_time.status','=','1')
            ->orderBy('departure_time.time','asc')
            ->get();
        $tag2 = [];
        $many2 = [];
        if(count($data2)>0){
            foreach ($data2 as $key=>$value){
                $tagarr = explode(',',$value->group);
                $tag = implode('-', $tagarr);
                $tag2[$key] = $tag;
                if($value->week = '0,1,2,3,4,5,6'){
                    $many2[$key] = "Tutti i giorni";
                }
                else{
                    $many2[$key] = "Solo feriale"; 
                }
            }
        }

        return view('pages/monitor/monitor_table')
            ->with('data1',$data1)
            ->with('tag1',$tag1)
            ->with('data2',$data2)
            ->with('tag2',$tag2)
            ->with('port1',$port1)
            ->with('port2',$port2)
            ->with('many1',$many1)
            ->with('many2',$many2)
            ->with("bgs", $bgs);
    }
}
