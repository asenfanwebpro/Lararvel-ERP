<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Mandati')

@section('content')


<div class="content-body">
    
    <!-- invoice functionality start -->
    <section class="invoice-print mb-1">
        <div class="row">

            <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Email" aria-describedby="button-addon2">
                    <div class="input-group-append" id="button-addon2">
                        <button class="btn btn-outline-primary waves-effect waves-light" type="button">Invia Mandato</button>
                    </div>
                </div>
            </fieldset>

            <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                <button class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light" onclick="dataprint();" > <i class="feather icon-file-text"></i> Print</button>
                <button class="btn btn-outline-primary  ml-0 ml-md-1 waves-effect waves-light"> <i class="feather icon-download"></i> Download</button>
                <a href="{{route('mandati.view')}}" class="btn btn-primary  ml-0 ml-md-1 waves-effect waves-light"> Torna all'elenco</a>
            </div>

        </div>
    </section>
    <!-- invoice functionality end -->

    <!-- invoice page -->
    <section class="card invoice-page" id="printcontent">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-sm-6 col-12 text-left pt-1">
                    <div class="media pt-1">
                        <img src="{{ asset('uploads/logo/'.$company->logo) }}" style="max-height: 100px;"> 
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h1>Mandato {{$data->anno}}.{{$data->no}}</h1>
                    <div class="invoice-details mt-2">
                        Emesso il: {{$data->created_at}}
                    </div>
                </div>
            </div>
            <!--/ Invoice Company Details -->
            <hr />
            <!-- Invoice Recipient Details -->
            <div id="invoice-customer-details" class="row">
                <div class="col-4 " ></div>
                <div class="col-8 " >
                    <div class="company-info">
                        
                        <dl class="row">
                            <dt class="col text-right">
                                <h5>{{$supplier->ragione_sociale}}</h5><br />
                                {{$supplier->indirizzo}}<br />
                                {{$supplier->cap}} {{$supplier->citta}} <br />
                                {{$supplier->iva}} - {{$supplier->sdi}} <br />
                                <!--
                                    <i class="feather icon-mail"></i> {{$supplier->mail}} <br />
                                    <i class="feather icon-mail"></i> {{$supplier->pec}}  <br />
                                    <i class="feather icon-phone"></i> {{$supplier->tel}}
                                -->
                            </dt>
                            <dd class="col-3">
                                <img src="{{ asset('uploads/logo/'.$supplier->logo) }}" width="100%" class="pull-right" style="margin:0; " >
                            </dd>
                        </dl>
                        
                    </div>
                </div>
            </div>
            <!--/ Invoice Recipient Details -->

            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-0 invoice-items-table">
                <div class="row">
                    <div class="table-responsive col-12">
                        
                        <!--START TABLE -->
                        <h3>Elenco Fatture</h3>
                        <div class="xtable-responsive">
                            <table class="table table-hover-animation table-striped">
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
                                        <tr class="invoicerow" id="invoicerow{{$value->id}}">
                                            <td>{{$value->invoice_num}}</td>
                                            <td>{{$value->voicedate}}</td>
                                            <td>{{$value->voiceamount}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                        <tr style="height:1 px !important;">
                                            <td colspan="2"></td>
                                            <td><hr style="color:#000; background-color:#000; margin:0; "></td>                                    
                                        </tr>
                                        <tr>
                                            <td colspan="2">Totale fatture</td>
                                            <td>{{$subtotal}}</td>                                        
                                        </tr>
                                        <tr>
                                            <td colspan="2">Arrotondamento</td>
                                            <td>{{$round}}</td>                           
                                        </tr>
                                        <tr style="font-weight:bold">
                                            <td colspan="2">Totale</td>
                                            <td><b style="font-size: 20px !important;">{{$total}}</b></td>                                                                                
                                        </tr>
                                </tbody>
                            </table>        
                        </div>  
                        <!--END TABLE -->

                    </div>
                </div>
            </div>
            
            <br /><br />

            <div class="row">

                <div id="invoice-items-details" class="col-7 invoice-items-table">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="table-responsive">
                                
                            <!--START TABLE -->
                            <h3>Elenco Pagamenti</h3>
                            <div class="xtable-responsive">
                                <table class="table table-hover-animation table-striped ">
                                    <thead >
                                            <tr>
                                                <th>Pagamenti</th>
                                                <th>Data</th>
                                                <th>Transazione</th>  
                                                <th>Importo</th>
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
                            <!--END TABLE -->


                            </div>
                        </div>
                    </div>
                </div>

                
                <div id="invoice-items-details" class="col-5 invoice-items-table">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="table-responsive">
                                
                                <!--START TABLE -->
                                <h3>Note</h3>
                                <div class="xtable-responsive">
                                    <table class="table table-hover-animation table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($note) && !empty($note))
                                            @foreach($note as $value)                     
                                                <tr id="noterow{{$value->id}}">
                                                    <td>{{$value->notedate}}</td>  
                                                    <td>{{$value->notes}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>   
                                    </table>        
                                </div>  
                                <!--END TABLE -->


                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Firma -->
            <div id="invoice-items-details" class="invoice-items-table">
                <div class="row">
                        <div class="col-6 text-right">
                                
                        </div>
                        <div class="col-6 text-right">
                                <br ><br ><br ><br ><br ><br >
                                <hr style="color:#000; background-color:#000; margin:0; ">
                                (firma)
                                <br ><br ><br ><br ><br ><br >
                        </div>
                </div>
            </div>

            <!-- Invoice Footer -->
            <div id="invoice-footer" class="pt-3">
                <p>
                    <h5>{{$company->ragione_sociale}}</h5> {{$company->indirizzo}} - {{$company->cap}} {{$company->citta}} <b>/</b> Iva: {{$company->iva}} SDI: {{$company->sdi}}
                </p>
                <p class="bank-details mb-0">
                    <span class="mr-4"><i class="fa fa-leaf fa-2x success"></i> <strong>Rispetta l'ambiente: </strong>Non stampare questa pagina se non è necessario </span>
                </p>
            </div>
            <!--/ Invoice Footer -->

        </div>
    </section>
    <!-- invoice page end -->

</div>
<!--/ Description -->
@endsection


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
.row{
    font-size: 16px;
    color: #000;
}
.invoicerow{
    border-bottom: 1px solid #000 !important;
    font-size: 20px !important;
}
</style>