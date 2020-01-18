<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mandati;
use App\Models\Societa;
use App\Models\SocietaFornitori;
use App\Models\MandatiInvoice;
use App\Models\MandatiPayment;
use App\Models\MandatiNota;


class MandatiController extends Controller
{
    public function register(){
        $company = Societa :: all();
        $supplier = SocietaFornitori :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"mandati_view",'name'=>"Mandati"], ['name'=>"Nuovo Mandato"]
        ];

        return view('pages/mandati/mandati_register')
                ->with('company',$company)
                ->with('supplier',$supplier)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','mandati');
    }

    public function view(){
        $data = Mandati::all();
        $value = [];

        if(count($data)>0){
            foreach($data as $key=>$obj){
                $value[$key]['sumtotal'] = MandatiInvoice::where('mandati_id','=',$obj->id)->sum('voiceamount');
                $value[$key]['subtotal'] = number_format($value[$key]['sumtotal'],2);
                $value[$key]['total'] = (int)($value[$key]['sumtotal']);               

                $value[$key]['paysumtotal'] = MandatiPayment::where('mandati_id','=',$obj->id)->sum('payamount');
                $value[$key]['paytotal'] = (int)($value[$key]['paysumtotal']);
                $value[$key]['difference'] = $value[$key]['total']-$value[$key]['paytotal'];
            }
        }
        
        $company = Societa :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"mandati_view",'name'=>"Mandati"], ['name'=>"Mandati"]
        ];
        
        return view('pages/mandati/mandati')
                ->with('data',$data)
                ->with('valuem',$value)
                ->with('company',$company)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','mandati');
    }

    public function maxno(Request $request){
        $no = Mandati::where('company','=', $request->company)->where('anno','=',date('Y'))->max('no');
        return response()->json(['maxno' => $no]);
    }
    
    public function companymandati(Request $request){
        $data = Mandati::where('company','=',$request->company)->get();
        $value = [];

        if(count($data)>0){
            foreach($data as $key=>$obj){
                $value[$key]['sumtotal'] = MandatiInvoice::where('mandati_id','=',$obj->id)->sum('voiceamount');
                $value[$key]['subtotal'] = number_format($value[$key]['sumtotal'],2);
                $value[$key]['total'] = (int)($value[$key]['sumtotal']);               

                $value[$key]['paysumtotal'] = MandatiPayment::where('mandati_id','=',$obj->id)->sum('payamount');
                $value[$key]['paytotal'] = (int)($value[$key]['paysumtotal']);
                $value[$key]['difference'] = $value[$key]['total']-$value[$key]['paytotal'];
            }
        }
        return response()->json(['data' => $data, 'value' => $value]);
    }

    public function save(Request $request){
        
        $arr = ['company','supplier'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }      

        if($request->id == 0){

            $data['anno'] = date('Y');
            $maxno = Mandati::where('company','=', $request->company)->where('anno','=',date('Y'))->max('no');
            $data['no'] = $maxno+1;
            Mandati :: create($data);
            $maxid =  Mandati::where('company','=', $request->company)->where('anno','=',date('Y'))->max('id');
            
            return response()->json(['id' => $maxid]);
        }
        else{
            $company = Mandati :: find($request->id)->company;
            if($data['company'] != $company){
                $maxno = Mandati::where('company','=', $request->company)->where('anno','=',date('Y'))->max('no'); 
                $data['no'] = $maxno+1;
            }
            Mandati :: where('id','=',$request->id)->update($data);
            
            return redirect()->route('mandati.view'); 
        } 
    }
    
    public function edit($id){
        $company = Societa :: all();
        $supplier = SocietaFornitori :: all();
        $data = Mandati::find($id);
        $invoice = MandatiInvoice::where('mandati_id','=',$id)->get();
        $payment = MandatiPayment::where('mandati_id','=',$id)->get();
        $note = MandatiNota::where('mandati_id','=',$id)->get();
        $sumtotal = MandatiInvoice::where('mandati_id','=',$id)->sum('voiceamount');
        $subtotal = number_format($sumtotal,2);
        $total = (int)($sumtotal);
        $rounding = round($sumtotal,0)-$sumtotal;
        $round = ($rounding<0)?abs(number_format($rounding,2)):abs(number_format(1-$rounding,2));        

        $paysumtotal = MandatiPayment::where('mandati_id','=',$id)->sum('payamount');
        $paytotal = (int)($paysumtotal);
        $difference = $total-$paytotal;

        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"mandati_view",'name'=>"Mandati"], ['name'=>"Edit Mandati"]
        ];

        return view('pages/mandati/mandati_register')
                ->with('company',$company)
                ->with('supplier',$supplier)
                ->with('data',$data)
                ->with('invoice',$invoice)
                ->with('payment',$payment)
                ->with('note',$note)
                ->with('subtotal',$subtotal)
                ->with('total',$total)
                ->with('round',$round)
                ->with('paytotal',$paytotal)
                ->with('difference',$difference)
                ->with('breadcrumbs',$breadcrumbs)
                ->with('page','mandati');
    }

    public function delete(Request $request){
        Mandati::find($request->id)->delete();
        return response()->json(['msg' => 'success']);
    }

    //invoice
    public function getinvoice(Request $request){
        $data = MandatiInvoice::find($request->id);
        return response()->json(['data' => $data]);
    }

    public function saveinvoice(Request $request){
        $id = $request->id;
        $arr = ['mandati_id','invoice_num','voicedate','voiceamount'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        if($id == 0){
            MandatiInvoice :: create($data);
            $finaldata = MandatiInvoice :: orderBy('id','desc')->first();
        }
        else{
            MandatiInvoice::find($id)->update($data);
            $finaldata = MandatiInvoice::find($id);
        }
        
        $value['sumtotal'] = MandatiInvoice::where('mandati_id','=',$request->mandati_id)->sum('voiceamount');
        $value['subtotal'] = number_format($value['sumtotal'],2);
        $value['total'] = (int)($value['sumtotal']);
        
        $value['rounding'] = round($value['sumtotal'],0)-$value['sumtotal'];
        $value['round'] = ($value['rounding']<0)?abs(number_format($value['rounding'],2)):abs(number_format(1-$value['rounding'],2)); 

        $value['paysumtotal'] = MandatiPayment::where('mandati_id','=',$request->mandati_id)->sum('payamount');
        $value['paytotal'] = (int)($value['paysumtotal']);
        $value['difference'] = $value['total']-$value['paytotal'];

        return response()->json(['data' => $finaldata,'value'=>$value]);
    }

    public function deleteinvoice(Request $request){
        $mandati_id = MandatiInvoice::find($request->id)->mandati_id;
        MandatiInvoice::find($request->id)->delete();
        
        $value['sumtotal'] = MandatiInvoice::where('mandati_id','=',$mandati_id)->sum('voiceamount');
        $value['subtotal'] = number_format($value['sumtotal'],2);
        $value['total'] = (int)($value['sumtotal']);
        $value['rounding'] = abs(round($value['sumtotal'],0)-$value['sumtotal']);
        $value['round'] = number_format($value['rounding'],2);

        $value['paysumtotal'] = MandatiPayment::where('mandati_id','=',$mandati_id)->sum('payamount');
        $value['paytotal'] = (int)($value['paysumtotal']);
        $value['difference'] = $value['total']-$value['paytotal'];

        return response()->json(['data' => 'success','value'=>$value]);
    }

    //payment
    public function getpayment(Request $request){
        $data = MandatiPayment::find($request->id);
        return response()->json(['data' => $data]);
    }
    
    public function savepayment(Request $request){
        $id = $request->id;
        $arr = ['mandati_id','method','paydate','transaction','payamount'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        if($id == 0){
            MandatiPayment::create($data);
            $finaldata = MandatiPayment::orderBy('id','desc')->first();
        }
        else{
            MandatiPayment::find($id)->update($data);
            $finaldata = MandatiPayment::find($id);
        }

        $value['sumtotal'] = MandatiInvoice::where('mandati_id','=',$request->mandati_id)->sum('voiceamount');        
        $value['total'] = (int)($value['sumtotal']);

        $value['paysumtotal'] = MandatiPayment::where('mandati_id','=',$request->mandati_id)->sum('payamount');
        $value['paytotal'] = (int)($value['paysumtotal']);
        $value['difference'] = $value['total']-$value['paytotal'];

        return response()->json(['data' => $finaldata,'value'=>$value]);
    }

    public function deletepayment(Request $request){
        $mandati_id = MandatiPayment::find($request->id)->mandati_id;
        MandatiPayment::find($request->id)->delete();

        $value['sumtotal'] = MandatiInvoice::where('mandati_id','=',$mandati_id)->sum('voiceamount');        
        $value['total'] = (int)($value['sumtotal']);
        

        $value['paysumtotal'] = MandatiPayment::where('mandati_id','=',$mandati_id)->sum('payamount');
        $value['paytotal'] = (int)($value['paysumtotal']);
        $value['difference'] = $value['total']-$value['paytotal'];
        return response()->json(['data' => 'success','value'=>$value]);
    }
    //note
    public function getnote(Request $request){
        $data = MandatiNota::find($request->id);
        return response()->json(['data' => $data]);
    }

    public function savenote(Request $request){
        $id = $request->id;
        $arr = ['mandati_id','notes','notedate'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }
        if($id == 0){
            MandatiNota :: create($data);
            $finaldata = MandatiNota :: orderBy('id','desc')->first();
        }
        else{
            MandatiNota::find($id)->update($data);
            $finaldata = MandatiNota::find($id);
        }
        
        return response()->json(['data' => $finaldata]);
    }

    public function deletenote(Request $request){
        MandatiNota::find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function dataprint($id){
        $data = Mandati::find($id);
        $company = Societa :: where('ragione_sociale','=',$data->company)->first();
        $supplier = SocietaFornitori :: where('ragione_sociale','=',$data->supplier)->first();

        $invoice = MandatiInvoice::where('mandati_id','=',$id)->get();
        $payment = MandatiPayment::where('mandati_id','=',$id)->get();
        $note = MandatiNota::where('mandati_id','=',$id)->get();
        $sumtotal = MandatiInvoice::where('mandati_id','=',$id)->sum('voiceamount');
        $subtotal = number_format($sumtotal,2);
        $total = (int)($sumtotal);
        $rounding = round($sumtotal,0)-$sumtotal;
        $round = ($rounding<0)?abs(number_format($rounding,2)):abs(number_format(1-$rounding,2));  

        $paysumtotal = MandatiPayment::where('mandati_id','=',$id)->sum('payamount');
        $paytotal = (int)($paysumtotal);
        $difference = $total-$paytotal;
        return view('pages/mandati/mandati_print')
                ->with('data',$data)
                ->with('company',$company)
                ->with('supplier',$supplier)
                ->with('invoice',$invoice)
                ->with('payment',$payment)
                ->with('note',$note)
                ->with('subtotal',$subtotal)
                ->with('total',$total)
                ->with('round',$round)
                ->with('paytotal',$paytotal)
                ->with('difference',$difference)
                ->with('page','mandati');
    }
}