<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Mandati')

@section('content')

{{ Form::open(array('route' => 'mandati.save','method'=>'post','id'=>'ss_form')) }}
<section>
    <div class="row">
        <div class="col-12">
            <div class="card white background" style="background-image: url('{{ asset('images/pages/knowledge-base-cover.jpg') }}'); background-size: cover; ">
                <div class="card-content">
                    <div class="card-body p-sm-4 p-2">
                        <h1 class="white">
                            Mandato 
                            @if(isset($data))  
                                : <b>Nr {{$data->anno}}.{{$data->no}}</b> 
                            @endif
                            <a href="{{route('mandati.view')}}" class="btn btn-warning" style="float:right" >Annulla</a>
                        </h1>
                        <p class="card-text mb-2">
                            Societa / Fornitore, seleziona le ditte interessate per la registrazione del mandato di pagamento
                        </p>

                        <input type="hidden" id="id" value={{(isset($data))?$data->id:0}} name="id" />
                        <div class="row">
                            <div class="col" >
                                <label for="validationTooltip01">Societa</label>                                
                                <select class="select2 form-control" name="company" id="company">
                                    @foreach($company as $value)
                                    <option value='{{$value->ragione_sociale}}' <?php echo (isset($data)&&($data->company==$value->ragione_sociale)?"selected":"") ?>>{{$value->ragione_sociale}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col" >
                                <label for="validationTooltip01">Fornitore</label>
                                <select class="select2 form-control" id="supplierw" name="supplier">                               
                                    @foreach($supplier as $value)
                                    <option value='{{$value->ragione_sociale}}' <?php echo (isset($data)&&($data->supplier==$value->ragione_sociale)?"selected":"") ?>>{{$value->ragione_sociale}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(!isset($data))
                            <div class="col-2" >
                                <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" data-toggle="modal" data-target="#primary">Salva</button>
                                <!-- Modal -->
                                <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary white">
                                                <h5 class="modal-title" id="">Nuovo Mandati</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Hai creato un nuovo mandati</p>
                                                <h2>NUM: {{date("Y")}}.<span id='maxno'></span></h2>
                                            </div>
                                            <div class="modal-footer">
                                                <a onclick="savemandati()" class="btn btn-primary" >Nuovo Mandati</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($data))
<section id="">
    <div class="row ">
        
        <!-- invoice --> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Elenco Fatture</h3>
                    <button class="btn btn-warning mr-1 mb-1 add" type="button" data-toggle="modal"  onclick="open_invoicemodal(0)">Aggiungi Fattura</button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="invoice" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h5 class="modal-title" id="">Fattura</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <fieldset class="form-group" id="invoicemodal">
                                        <input type="hidden" id="invoiceid">
                                        <label id="invoicewarn" style="display:block;color:red"></label>
                                        <label>numero di fattura</label>
                                        <input type="text" class="form-control" id="invoice_num">
                                        <label>data</label>
                                        <input type="date" class="form-control" id="voicedate" value={{date("Y-m-d")}}>
                                        <label>quantità</label>
                                        <input type="text" class="form-control" id="voiceamount">
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="saveinvoice()">salvare</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tabledata" class="table table-striped table-hover-animation" >
                            <thead>
                                <tr>
                                    <th>Fatture</th>
                                    <th>Data</th>
                                    <th>Quantità</th>                                                                                 
                                    <th width="80px">Azioni</th>
                                </tr>
                            </thead>
                            <tbody id="invoicebody">
                            @if(isset($invoice) && !empty($invoice))
                                @foreach($invoice as $value)                     
                                    <tr id="invoicerow{{$value->id}}">
                                        <td>{{$value->invoice_num}}</td>
                                        <td>{{$value->voicedate}}</td>
                                        <td>{{$value->voiceamount}}</td>                                                                                    
                                        <td>
                                            <a onclick="open_invoicemodal({{$value->id}})"><i class="fa fa-pencil fa-2x" ></i></a>
                                            <a onclick="deleteinvoice({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                        </td>
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
                                    <td id="invoicesubtotal">{{$subtotal}}</td>                             
                                </tr>
                                <tr style="font-weight:bold">
                                    <td>round</td>
                                    <td></td>
                                    <td id="invoiceround">{{$round}}</td>                           
                                </tr>
                                <tr style="font-weight:bold">
                                    <td>total</td>
                                    <td></td>
                                    <td id="invoicetotal">{{$total}}</td>                                                                                
                                </tr>
                            </tbody>
                        </table>        
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- payment -->
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                  
                    <button class="btn btn-warning mr-1 mb-1 add" type="button" onclick="open_paymentmodal(0)">Aggiungi pagamento</button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="payment" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h5 class="modal-title" id="">Pagamento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <fieldset class="form-group" id="paymentmodal">
                                        <input type="hidden" id="paymentid">
                                        <label id="paymentwarn" style="display:block;color:red"></label>
                                        <label>metodo di pagamento</label>
                                        <select id="method" class="custom-select">
                                                <option id="Bonifico" value="Bonifico">Bonifico Bancario</option>
                                                <option id="Assegno" value="Assegno">Assegno</option>
                                                <option id="Sepa" value="Sepa">Sepa</option>
                                                <option id="Riba" value="Riba">Riba</option>
                                                <option id="Carta di Credito" value="Carta di Credito">Carta di Credito</option>  
                                        </select>
                                        <label>data di pagamento</label>
                                        <input type="date" class="form-control" id="paydate" value={{date("Y-m-d")}}>
                                        <label>transazione</label>
                                        <input type="text" class="form-control" id="transaction" >
                                        <label>pagare l'importo</label>
                                        <input type="text" class="form-control" id="payamount">
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="savepayment()">salvare</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tablepayments" class="table" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>Pagamenti</th>
                                    <th>Data</th>
                                    <th>Transazione</th>  
                                    <th>Quantità</th>                                                                               
                                    <th width="80px">Azioni</th>
                                </tr>
                            </thead>
                            <tbody id="paymentbody">
                            @if(isset($payment) && !empty($payment))
                                @foreach($payment as $value)                     
                                    <tr id="paymentrow{{$value->id}}">
                                        <td>{{$value->method}}</td>
                                        <td>{{$value->paydate}}</td>
                                        <td>{{$value->transaction}}</td>   
                                        <td>{{$value->payamount}}</td>                                                                                 
                                        <td>
                                            <a onclick="open_paymentmodal({{$value->id}})"><i class="fa fa-pencil fa-2x" ></i></a>
                                            <a onclick="deletepayment({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                        </td>
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
                                    <td id="paymenttotal">{{$paytotal}}</td>   
                                    <td></td>                                             
                                </tr>
                                <tr style="font-weight:bold">
                                    <td>difference</td>
                                    <td></td>
                                    <td></td>
                                    <td id="difference">{{$difference}}</td>   
                                    <td></td>                                             
                                </tr>
                            </tbody>
                        </table>        
                    </div> 
                    
                </div>
            </div>
        </div>


        <!-- note -->
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    
                    <button class="btn btn-warning mr-1 mb-1 add" type="button" onclick="open_notemodal(0)">Aggiungi nota</button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="note" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h5 class="modal-title" id="">Nota</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <fieldset class="form-group" id="notemodal">
                                        <input type="hidden" id="noteid">
                                        <label id="notewarn" style="display:block;color:red"></label>
                                        <label>nota</label>
                                        <input type="text" class="form-control" id="notes" >
                                        <label>data di nota</label>
                                        <input type="date" class="form-control" id="notedate" value={{date("Y-m-d")}}>                                      
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="savenote()">salvare</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tablenotes" class="table table-striped table-hover-animation" >
                            <thead>
                                <tr>
                                    <th>Data</th>                                                                                                                         
                                    <th>Nota</th>
                                    <th width="80px">Azioni</th>
                                </tr>
                            </thead>
                            <tbody id="notebody">
                            @if(isset($note) && !empty($note))
                                @foreach($note as $value)                     
                                    <tr id="noterow{{$value->id}}">
                                        <td>{{$value->notedate}}</td>                                                                                                                               
                                        <td>{{$value->notes}}</td>
                                        <td>
                                            <a onclick="open_notemodal({{$value->id}})"><i class="fa fa-pencil fa-2x" ></i></a>
                                            <a onclick="deletenote({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                        </td>
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
</section>


<fieldset class="form-group">
    @if(isset($data))
        <button class="btn btn-primary mr-1 mb-1 waves-effect waves-light" type="submit">Salvare</button>
    @else
        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" data-toggle="modal" data-target="#primary">Salva</button>
        <!-- Modal -->
        <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary white">
                        <h5 class="modal-title" id="">Nuovo Mandati</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Hai creato un nuovo mandati</p>
                        <h2>NUM: {{date("Y")}}.<span id='maxno'></span></h2>
                    </div>
                    <div class="modal-footer">
                        <a onclick="savemandati()" class="btn btn-primary" >Nuovo Mandati</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</fieldset>

@endif
{{ Form::close() }}


<script type='text/javascript'>

    $('#tablepayments').dataTable( {
        "order": [[ 1, 'desc' ]]
    } );

    $('#tablenotes').dataTable( {
        "order": [[ 1, 'desc' ]]
    } );

    $(document).ready(function(){
        var company_name = $("#company").val();
        $.ajax({
            url: "{{route('mandati.maxno')}}",
            type: 'POST',
            data:{
                'company' : company_name,                
                  '_token': $("#ss_form input").val()
            }, 
            success: function(result){                
                $("#maxno").html(result['maxno']+1);
                
            }
        });
        
    })

    $("#company").change(function(){
        var company_name = $("#company").val();
        $.ajax({
            url: "{{route('mandati.maxno')}}",
            type: 'POST',
            data:{
                'company' : company_name,                
                  '_token': $("#ss_form input").val()
            }, 
            success: function(result){                
                $("#maxno").html(result['maxno']+1);
                
            }
        });
    })

    function savemandati(){
        $.ajax({
            url: "{{route('mandati.save')}}",
            type: 'POST',
            data:{
                         'id' : $("#id").val(),
                    'company' : $("#company").val(),
                   'supplier' : $("#supplierw").val(),                               
                      '_token': $("#ss_form input:first-child").val()
            }, 
            success: function(result){ 
                document.location = 'mandati_edit/'+result['id'];    
               // console.log(result['msg']);    
            }
        });
    }
    function open_invoicemodal(id){
        $("#invoiceid").val(id);
        $("#invoicewarn").html('');        
        $.ajax({
            url: "{{route('invoice.getinvoice')}}",
            type: 'POST',
            data:{
                   'id' : id,
                '_token': $("#ss_form input").val()                  
            }, 
            success: function(result){ 
                console.log(result['data']); 
                $("#invoice").modal('toggle');
                if(id == 0){
                    $("#invoice_num").val('');
                    $("#voiceamount").val('');
                }
                else{
                    $("#invoice_num").val(result['data']['invoice_num']);
                    $("#voicedate").val(result['data']['voicedate']);
                    $("#voiceamount").val(result['data']['voiceamount']);
                }                    
            }
        });

    }
    function deleteinvoice(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('invoice.delete')}}",
                type: 'POST',
                data:{
                        'id' : id,                               
                     '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']);                   
                    $("#invoicerow"+id).css('display','none');
                    $("#invoicesubtotal").html(result['value']['subtotal']);
                    $("#invoiceround").html(result['value']['round']);
                    $("#invoicetotal").html(result['value']['total']); 
                    $("#difference").html(result['value']['difference']);                  
                }
            });
        }
    }
    function saveinvoice(){
        var id = $("#invoiceid").val();
        if($("#invoice_num").val() == ''){
            $("#invoicewarn").html('inserire il numero della fattura');
            $("#invoice_num").focus();
        }
        else if($("#voiceamount").val() == ''){
            $("#invoicewarn").html('inserire limporto della fattura');
            $("#voiceamount").focus();
        }
        else{
            $.ajax({
                url: "{{route('invoice.save')}}",
                type: 'POST',
                data:{
                            'id' : id,
                    'mandati_id' : $("#id").val(),  
                    'invoice_num': $("#invoice_num").val(),  
                    'voicedate': $("#voicedate").val(),  
                    'voiceamount': $("#voiceamount").val(),              
                    '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']); 
                    if(id == 0){
                        var inserthtm = '<tr id="invoicerow'+result['data']['id']+'"><td>'+result['data']['invoice_num']+'</td>'+
                                                '<td>'+result['data']['voicedate']+'</td>'+
                                                '<td>'+result['data']['voiceamount']+'</td>'+                                                                                    
                                                '<td>'+ 
                                                    '<a onclick="open_invoicemodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deleteinvoice('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                          
                                                '</td></tr>';              
                        $(inserthtm).insertBefore($("#invoicebody tr:first-child"));
                        $("#invoicebody .dataTables_empty").css("display","none");
                    }
                    else{
                        $("#invoicerow"+id).html('<td>'+result['data']['invoice_num']+'</td>'+
                                                '<td>'+result['data']['voicedate']+'</td>'+
                                                '<td>'+result['data']['voiceamount']+'</td>'+                                                                                    
                                                '<td>'+
                                                    '<a onclick="open_invoicemodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deleteinvoice('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                           
                                                '</td>');
                    }
                    $("#invoicesubtotal").html(result['value']['subtotal']);
                    $("#invoiceround").html(result['value']['round']);
                    $("#invoicetotal").html(result['value']['total']);
                    $("#difference").html(result['value']['difference']);
                    $("#invoice").modal('toggle');
                }
            });
        }
        
    }
    //payment
    function open_paymentmodal(id){
        $("#paymentid").val(id);  
        $("#paymentwarn").html('');      
        $.ajax({
            url: "{{route('payment.getpayment')}}",
            type: 'POST',
            data:{
                   'id' : id,
                '_token': $("#ss_form input").val()                  
            }, 
            success: function(result){                 
                $("#payment").modal('toggle');
                if(id == 0){
                    $("#transation").val('');
                    $("#payamount").val('');
                }
                else{
                    $("#method option").removeAttr('selected');
                    $("#transaction").val(result['data']['transaction']);
                    $("#paydate").val(result['data']['paydate']);
                    $("#payamount").val(result['data']['payamount']);
                    $("#"+result['data']['method']).attr('selected','selected');
                    
                }                    
            }
        });

    }
    function deletepayment(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('payment.delete')}}",
                type: 'POST',
                data:{
                        'id' : id,                               
                     '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']);                   
                    $("#paymentrow"+id).css('display','none');
                    $("#paymenttotal").html(result['value']['paytotal']);
                    $("#difference").html(result['value']['difference']);                   
                }
            });
        }
    }
    function savepayment(){
        var id = $("#paymentid").val();
        if($("#transaction").val() == ''){
            $("#paymentwarn").html('inserisci transazione');
            $("#transaction").focus();
        }
        else if($("#payamount").val() == ''){
            $("#paymentwarn").html('inserire limporto della retribuzione');
            $("#payamount").focus();
        }
        else{
            $.ajax({
                url: "{{route('payment.save')}}",
                type: 'POST',
                data:{
                            'id' : id,
                    'mandati_id' : $("#id").val(),  
                        'method' : $("#method").val(),
                    'transaction': $("#transaction").val(),  
                        'paydate': $("#paydate").val(),  
                      'payamount': $("#payamount").val(),              
                         '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']); 
                    if(id == 0){
                        var inserthtm = '<tr id="paymentrow'+result['data']['id']+'"><td>'+result['data']['method']+'</td>'+
                                                '<td>'+result['data']['paydate']+'</td>'+
                                                '<td>'+result['data']['transaction']+'</td>'+ 
                                                '<td>'+result['data']['payamount']+'</td>'+                                                                                   
                                                '<td>'+ 
                                                    '<a onclick="open_paymentmodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deletepayment('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                          
                                                '</td></tr>';              
                        $(inserthtm).insertBefore($("#paymentbody tr:first-child"));
                        $("#paymentbody .dataTables_empty").css("display","none");
                    }
                    else{
                        $("#paymentrow"+id).html('<td>'+result['data']['method']+'</td>'+
                                                '<td>'+result['data']['paydate']+'</td>'+
                                                '<td>'+result['data']['transaction']+'</td>'+ 
                                                '<td>'+result['data']['payamount']+'</td>'+                                                                                   
                                                '<td>'+
                                                    '<a onclick="open_paymentmodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deletepayment('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                           
                                                '</td>');
                    }
                    $("#paymenttotal").html(result['value']['paytotal']);
                    $("#difference").html(result['value']['difference']);
                    $("#payment").modal('toggle');
                }
            });
        }
    }

    //note
    function open_notemodal(id){
        $("#notewarn").html('');
        $("#noteid").val(id);        
        $.ajax({
            url: "{{route('mandatinota.getnote')}}",
            type: 'POST',
            data:{
                   'id' : id,
                '_token': $("#ss_form input").val()                  
            }, 
            success: function(result){                 
                $("#note").modal('toggle');
                if(id == 0){
                    $("#notes").val('');                   
                }
                else{
                   
                    $("#notes").val(result['data']['notes']);
                    $("#notedate").val(result['data']['notedate']);
                                       
                }                    
            }
        });

    }
    function deletenote(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('mandatinota.delete')}}",
                type: 'POST',
                data:{
                        'id' : id,                               
                     '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']);                   
                    $("#noterow"+id).css('display','none');                   
                }
            });
        }
    }
    function savenote(){
        var id = $("#noteid").val();
        if($("#notes").val() == ''){
            $("#notewarn").html('inserire nota');
            $("#notes").focus();
        }        
        else{
            $.ajax({
                url: "{{route('mandatinota.save')}}",
                type: 'POST',
                data:{
                            'id' : id,
                    'mandati_id' : $("#id").val(),  
                         'notes' : $("#notes").val(),                     
                        'notedate': $("#notedate").val(),                                  
                         '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    console.log(result['data']); 
                    if(id == 0){
                        var inserthtm = '<tr id="noterow'+result['data']['id']+'"><td>'+result['data']['notes']+'</td>'+
                                                '<td>'+result['data']['notedate']+'</td>'+                                                                                                                                
                                                '<td>'+ 
                                                    '<a onclick="open_notemodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deletenote('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                          
                                                '</td></tr>';              
                        $(inserthtm).insertBefore($("#notebody tr:first-child"));
                        $("#notebody .dataTables_empty").css("display","none");
                    }
                    else{
                        $("#noterow"+id).html('<td>'+result['data']['notes']+'</td>'+
                                                '<td>'+result['data']['notedate']+'</td>'+                                                                                                                               
                                                '<td>'+
                                                    '<a onclick="open_notemodal('+result['data']['id']+')">' +                                                                                                       
                                                        '<i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i>'+ 
                                                    '</a>'+
                                                    '<a onclick="deletenote('+result['data']['id']+')">'+                                                   
                                                        '<i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>'+
                                                    '</a>'+                                           
                                                '</td>');
                    }
                    
                    $("#note").modal('toggle');
                }
            });
        }
    }

    $(".modal-body input").keypress(function(e){
        if (e.keyCode == 13) {    
            e.preventDefault();        
            var value = $(this).parent().attr('id');
            if(value == 'invoicemodal'){
                saveinvoice();
            }
            else if(value == 'paymentmodal'){
                savepayment();
            }
            else{
                savenote();
            }
        }
    })
    

</script>
<style type="text/css">
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
        color:#fff !important;
    }
    #ss_form table{
        margin-top:20px !important;
    }
    .table-responsive{
        margin-bottom:60px;
    }
    .add{
        font-size:12px;
        padding:10px 15px;
    }
    .select2-container{
        width:315px !important;
    }
</style>

<!--/ Description -->
@endsection