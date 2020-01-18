<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Mandati')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
        @if(!empty($company) && !empty($supplier))      
            <div class="card">
                <div class="print col-md-12" style="float:left;padding-top:20px">                    
                    <button type="button" class="btn btn-light mr-1 mb-1 waves-effect waves-light" onclick="dataprint();">Print</button>
                    <button type="button" class="btn btn-success mr-1 mb-1 waves-effect waves-light"><a href="{{route('mandati.view')}}">Lista</a></button>
                </div>
                <div id="printcontent"> 
                    <div class="card-header" style="margin-bottom:50px"> 
                        <div class="col-md-12">
                            <h3>{{$data->anno}}.{{$data->no}}</h3> 
                        </div> 
                                
                        <div class="company col-md-7" style="float:left">  
                            <h3 class="card-title">{{$data->company}}</h3><br>
                            <img src="{{ asset('uploads/logo/'.$company->logo) }}" width="100">     
                        </div>  
                        <div class="supplier col-md-5" style="float:left">  
                            <h3 class="card-title">{{$data->supplier}}</h3><br>
                            <img src="{{ asset('uploads/logo/'.$supplier->logo) }}" width="100">     
                        </div>  
                    
                    
                    </div>                
                    <div class="card-content">               
                        <div id="ss_form">                  
                                <div class="table-responsive">
                                    <table class="table mb-0" style="font-size:12px">
                                        <thead >
                                            <tr>
                                                <th>Fatture</th>
                                                <th>Data</th>
                                                <th>Quantità</th>                                                                      
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="invoicebody">
                                        @if(isset($invoice) && !empty($invoice))
                                            @foreach($invoice as $value)                     
                                                <tr id="invoicerow{{$value->id}}">
                                                    <td>{{$value->invoice_num}}</td>
                                                    <td>{{$value->voicedate}}</td>
                                                    <td>{{$value->voiceamount}}</td>                                                                  
                                                    
                                                </tr>
                                            @endforeach
                                                
                                        @endif
                                        </tbody>                                    
                                    </table>
                                        
                                    
                                </div>  
                                <div class="table-responsive">
                                    <table class="table">                            
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>subtotal</td>
                                                <td></td>                                               
                                                <td>{{$subtotal}}</td>   
                                                                                        
                                            </tr>
                                            <tr style="font-weight:bold">
                                                <td>round</td>
                                                <td></td>
                                                
                                                <td>{{$round}}</td>   
                                                                                    
                                            </tr>
                                            <tr style="font-weight:bold">
                                                <td>total</td>
                                                <td></td>
                                                
                                                <td>{{$total}}</td>                                                                                
                                            </tr>
                                        </tbody>
                                    </table>        
                                </div>             
                            
                                <div class="table-responsive">
                                    <table  class="table mb-0" style="font-size:12px">
                                        <thead >
                                            <tr>
                                                <th>Pagamenti</th>
                                                <th>Data</th>
                                                <th>Transazione</th>  
                                                <th>Quantità</th>       
                                            
                                            </tr>
                                        </thead>
                                        <tbody >
                                        @if(isset($payment) && !empty($payment))
                                            @foreach($payment as $value)                     
                                                <tr>
                                                    <td>{{$value->method}}</td>
                                                    <td>{{$value->paydate}}</td>
                                                    <td>{{$value->transaction}}</td>   
                                                    <td>{{$value->payamount}}</td>                                                                 
                                                
                                                </tr>
                                            @endforeach
                                            
                                        @endif
                                        </tbody>                                    
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">                            
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>total</td>
                                                <td></td>
                                                <td></td>
                                                <td >{{$paytotal}}</td>   
                                                <td></td>                                             
                                            </tr>
                                            <tr style="font-weight:bold">
                                                <td>difference</td>
                                                <td></td>
                                                <td></td>
                                                <td >{{$difference}}</td>   
                                                <td></td>                                             
                                            </tr>
                                        </tbody>
                                    </table>        
                                </div>   
                                <div class="table-responsive">
                                    <table class="table mb-0" style="font-size:12px">
                                        <thead>
                                            <tr>
                                                <th>Nota</th>
                                                <th>Data</th>                                                                                                                         
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($note) && !empty($note))
                                            @foreach($note as $value)                     
                                                <tr id="noterow{{$value->id}}">
                                                    <td>{{$value->notes}}</td>
                                                    <td>{{$value->notedate}}</td>                                                                                                                              
                                                    
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>                                    
                                    </table>
                                </div>
                        
                        </div>
                    
                    </div>
                   
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<script type='text/javascript'> 
    

    function dataprint(){
        var printContents = document.getElementById('printcontent').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>
 <style type="text/css">
    #ss_form{
        width:70%;
        margin:auto;
        padding-bottom:70px;
    }
    
    #ss_form textarea{
        width:80%;
        float:right;
        padding-bottom:0;
    }
    
    #ss_form input[type="radio"]{
        float: none;
        width: 24px;
        display: inline;        
    }
    #ss_form input[type="checkbox"]{
        float: none;
        width: 24px;
        display: inline;
        
    }
    
    .btn{
        float:right;
        
    }
    .btn a{
        color:#fff;
    }
    #ss_form table{
        margin-top:20px !important;
        
    }
    #ss_form table thead{
        background:#00cfe8;
    }
    
    .table-responsive{
        margin-bottom:60px;
    }
    .add{
        font-size:12px;
        padding:10px 15px;
    }
    .select2-container{
        width:332px !important;
    }
    
</style>

<!--/ Description -->
@endsection