<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Ordine')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ordine</h4>
                    @if(strpos(Session()->get('role'), 'ordine_create') > 0)
                    <a style="float:right" onclick="open_modal(0)" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuova Ordine</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" >
                            <table id="tabledata1" class="table " >
                                <thead>
                                    <tr>                                        
                                        <th>Societa</th>
                                        <th>Fornitori</th> 
                                        <th>Numero</th>                                                                             
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key=> $obj)                     
                                        <tr id="row{{$obj->orderid}}">                                            
                                            <td>{{$obj->companyname}}</td>
                                            <td>{{$obj->suppliername}}</td> 
                                            <td>{{$obj->anno}}:{{$obj->no}}</td>                                                                                      
                                            <td>
                                                @if(strpos(Session()->get('role'), 'ordine_edit') > 0)
                                                <a onclick="open_modal('{{$obj->orderid}}')"><i class="fa fa-pencil fa-2x primary" ></i></a>
                                                @endif
                                                @if(strpos(Session()->get('role'), 'ordine_delete') > 0)
                                                <a onclick="deleterow('{{$obj->orderid}}')"><i class="fa fa-trash-o fa-2x danger" ></i></a>               
                                                @endif
                                                <a href="{{url('orderprint/'.$obj->orderid)}}"><i class="fa fa-print fa-2x " ></i></a>
                                                <a href="{{url('shop/'.$obj->orderid)}}"><i class="fa fa-list-alt fa-2x " ></i></a>
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <!--tfoot>
                                    <tr>
                                        <th>Nave</th>
                                        <th>Avatar</th>            
                                        <th width="80"></th>
                                    </tr>
                                </tfoot-->
                            </table>
                            <!-- Modal -->
                            <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary white">
                                            <h5 class="modal-title" id="">Ordine  <i id="orderno"></i></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        
                                        {{ Form::open(array('id'=>'ss_form', 'route'=>'ecommerce.ordersave', 'method'=>'post')) }}
                                            <input type="hidden" id="orderid" name="id">
                                            <label id="warn" style="display:block;color:red"></label>
                                            <label>Societa</label>
                                            <select id="companyid" class="form-control" name="companyid" onchange="getmaxno()">
                                                @if(isset($companies) && count($companies)>0)
                                                    @foreach($companies as $company)
                                                    <option id="company{{$company->id}}" value="{{$company->id}}">{{$company->ragione_sociale}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label>Fornitori</label>
                                            <select id="supplierid" class="form-control" name="supplierid">
                                                @if(isset($supplies) && count($supplies)>0)
                                                    @foreach($supplies as $value)
                                                    <option id="supplier{{$value->id}}" value="{{$value->id}}">{{$value->ragione_sociale}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        {{ Form::close() }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="saveorder()">salvare</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>
<!--/ Description -->
<script type="text/javascript">
    $('#tabledata1').dataTable( {
        "order": [[ 0, 'asc' ],[2, 'asc']]
    } );
    function open_modal(id){
        $("#primary").modal('toggle');
        $("#orderid").val(id);
        $(".modal-body select option").removeAttr('selected');
        if(id == 0){
            $("#ordername").val('');
        }
        else{
            $.ajax({
                url: "{{route('ecommerce.orderedit')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){ 
                    $("#company"+result['data']['companyid']).attr('selected','selected');
                    $("#supplier"+result['data']['supplierid']).attr('selected','selected');
                    getmaxno();
                }
            })
        }
        
    }
    function getmaxno(){
        var id = $("#orderid").val();        
        var companyid = $("#companyid").val();        
        $.ajax({
            url: "{{route('ecommerce.orderno')}}",
            type: 'POST',
            data:{
                    'id' : id,
             'companyid' : companyid,                                  
                 '_token': $("#ss_form input:first-child").val()
            }, 
            success: function(result){                 
                $("#orderno").html(result['anno']+" : "+result['orderno']);
            }
        })
    }
    function saveorder(){
        if($("#ordername").val() == ''){
            $("#warn").html('inserire il nome della ordine');
            $("#ordername").focus();
        }
        else{
            $("#ss_form").submit();
        }
    }
    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('ecommerce.orderdelete')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){ 
                    $("#row"+id).css("display","none");
                }
            })
        }
    }
    $(".modal-body input").keypress(function(e){
        if (e.keyCode == 13) {    
            e.preventDefault();        
            saveorder();
        }
    })
</script>
<style type="text/css">
    select.form-control {
        background-image: url('images/pages/arrow-down.png') !important;   

    } 
</style>

@endsection