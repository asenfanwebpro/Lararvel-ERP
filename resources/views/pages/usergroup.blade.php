<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Permission')

@section('content')
<div class="content-body">
    <section class="users-list-wrapper">
        <!-- users filter start -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Gruppo di utenti</h4>
            </div>
            <div class="card-content" style="padding-bottom:30px">
                <div class="card-body card-dashboard" >
                    <div class="table-responsive col-md-6 left">
                        <div style="width:100%;margin-bottom:45px">
                            @if(strpos(Session()->get('role'), 'groupp_create') > 0)
                            <a style="float:right" onclick="open_modal(0)" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuovo Gouppo</a>
                            @endif
                        </div>
                        <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary white">
                                        <h5 class="modal-title" id="">porta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">                                    
                                    
                                        <input type="hidden" id="groupid" name="id">
                                        <label id="warn" style="display:block;color:red"></label>
                                        <label>grupp</label>
                                        <input type="text" class="form-control" id="group" name="group">                                           
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="savegroup()">salvare</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="tabledata" class="table" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>Gruppo</th>                                        
                                    <th style="min-width:32px"></th>
                                </tr>
                            </thead>
                            <tbody id="groupbody">
                                @if(isset($data) && !empty($data))
                                    @foreach($data as $value)                                                        
                                    <tr id="row{{$value->id}}">
                                        <td style="cursor:pointer" onclick="view_permission({{$value->id}})">{{$value->group}}</td>                                   
                                        <td>
                                            @if(strpos(Session()->get('role'), 'groupp_edit') > 0)
                                            <a onclick="open_modal({{$value->id}})">                                                                                                        
                                                <i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i> 
                                                    
                                            </a>
                                            @endif
                                            @if(strpos(Session()->get('role'), 'groupp_delete') > 0)
                                            <a href='#' onclick="deleterow({{$value->id}})">                                                   
                                                <i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>                                   
                                    @endforeach
                                @endif
                            </tbody>                                
                        </table>
                    </div>
                    <div class="col-md-6 left">
                        <div class="col-12">
                            <div class="table-responsive border rounded px-1 ">
                                <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>Permission</h6>
                                <table id="permissiontable" class="table table-borderless" style="display:none">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Read</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Societa</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="societa_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="societa_read"></label>
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Societalist</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="societalist_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="societalist_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="societalist_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="societalist_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="societalist_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="societalist_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="societalist_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="societalist_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fornitori</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="fornitori_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="fornitori_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="fornitori_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="fornitori_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="fornitori_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="fornitori_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="fornitori_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="fornitori_delete"></label>
                                                </div>
                                            </td>
                                        </tr>      
                                        <tr>
                                            <td>Protocolli</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocolli_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="protocolli_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocolli_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="protocolli_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocolli_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="protocolli_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocolli_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="protocolli_delete"></label>
                                                </div>
                                            </td>
                                        </tr>                                       
                                        <tr>
                                            <td>Mandati</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="mandati_read" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="mandati_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="mandati_create" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="mandati_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="mandati_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="mandati_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="mandati_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="mandati_delete"></label>
                                                </div>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>Monitor</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="monitor_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="monitor_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="monitor_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="monitor_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="monitor_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="monitor_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="monitor_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="monitor_delete"></label>
                                                </div>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <td>Impostazioni</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="impostazioni_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="impostazioni_read"></label>
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Protocollo</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocollo_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="protocollo_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocollo_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="protocollo_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocollo_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="protocollo_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="protocollo_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="protocollo_delete"></label>
                                                </div>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>Ecommorce</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ecommerce_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="ecommerce_read"></label>
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Categoria</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="categoria_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="categoria_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="categoria_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="categoria_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="categoria_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="categoria_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="categoria_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="categoria_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Marca</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="marca_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="marca_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="marca_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="marca_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="marca_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="marca_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="marca_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="marca_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prodotto</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="prodotto_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="prodotto_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="prodotto_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="prodotto_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="prodotto_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="prodotto_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="prodotto_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="prodotto_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ordine</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ordine_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="ordine_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ordine_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="ordine_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ordine_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="ordine_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ordine_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="ordine_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Utente</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="utente_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="utente_read"></label>
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Groupp</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="groupp_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="groupp_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="groupp_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="groupp_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="groupp_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="groupp_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="groupp_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="groupp_delete"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lista</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="lista_read" class="custom-control-input permissioncheck " >
                                                    <label class="custom-control-label" for="lista_read"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="lista_create" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="lista_create"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="lista_edit" class="custom-control-input permissioncheck">
                                                    <label class="custom-control-label" for="lista_edit"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="lista_delete" class="custom-control-input permissioncheck" >
                                                    <label class="custom-control-label" for="lista_delete"></label>
                                                </div>
                                            </td>
                                        </tr>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::open(array('id'=>'ss_form')) }}
        {{ Form::close() }}
</div>
<script type="text/javascript">
    function open_modal(id){
        $("#primary").modal('toggle');
        $("#groupid").val(id);
        if(id == 0){
            $("#group").val('');
        }
        else{
            $.ajax({
                url: "{{route('permission.getgroup')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    $("#group").val(result['data']['group']);
                }
            })
        }
    }

    function savegroup(){
        id = $("#groupid").val();        
        group = $("#group").val();
        if(group == ''){
            $("#warn").html('inserisci il nome del gruppo');
            $("#group").focus();
        }
        else{
            $.ajax({
                url: "{{route('permission.savegroup')}}",
                type: 'POST',
                data:{
                        'id' : id,  
                     'group' : group,                                
                     '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    if(id == 0){
                        var inserthtml = "<tr id='row"+result['data']['id']+"'>"+
                                            "<td style='cursor:pointer' onclick='view_permission("+result['data']['id']+")'>"+result['data']['group']+"</td> "+                                  
                                            "<td>"+
                                                "<a onclick='open_modal("+result['data']['id']+")'>"+                                                                                                        
                                                    "<i class='fa fa-pencil-square-o' style='color:red;font-size:25px;top:1px;position:relative'></i> "+
                                                                       
                                                "</a>"+
                                                "<a href='#' onclick='deleterow("+result['data']['id']+")'> "+                                                  
                                                    "<i class='fa fa-trash-o' style='color:#000;font-size:25px;'></i>"+
                                                "</a>"+
                                            "</td>"+
                                        "</tr>";
                        $("#groupbody").append(inserthtml);
                    }
                    else{
                        $("#row"+result['data']['id']).html("<td style='cursor:pointer' onclick='view_permission("+result['data']['id']+")'>"+result['data']['group']+"</td> "+                                  
                                                            "<td>"+
                                                                "<a onclick='open_modal("+result['data']['id']+")'>"+                                                                                                        
                                                                    "<i class='fa fa-pencil-square-o' style='color:red;font-size:25px;top:1px;position:relative'></i> "+
                                                                        
                                                                "</a>"+
                                                                "<a href='#' onclick='deleterow("+result['data']['id']+")'> "+                                                  
                                                                    "<i class='fa fa-trash-o' style='color:#000;font-size:25px;'></i>"+
                                                                "</a>"+
                                                            "</td>");
                    }
                    $("#primary").modal('toggle');
                }
            })
        }        
    }

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('permission.deletegroup')}}",
                type: 'POST',
                data:{
                        'id' : id,                               
                     '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    //console.log(result['data']);                   
                    $("#row"+id).css('display','none');                              
                }
            });
        }
    }
    function view_permission(id){
        $("#groupid").val(id);
        $("#permissiontable").css("display","");
        $(".permissioncheck"). prop("checked", false)
       
        $("#groupbody td").css("color","#000");
        $("#row"+id+" td:first-child").css("color","red");
        $.ajax({
            url: "{{route('permission.getpermission')}}",
            type: 'POST',
            data:{
                    'id' : id,                                    
                 '_token': $("#ss_form input").val()
            }, 
            success: function(result){ 
                for(var i=0; i<result['data'].length; i++){
                    if(result['data'][i] != ''){
                        $("#"+result['data'][i]+""). prop("checked", true);                     

                    }
                }               
                                       
            }
        });
    }

    $(".permissioncheck").click(function(e){
        var id = $("#groupid").val();
        var permission;
        if($(this). prop("checked") == true){
            permission = e.target.id + "_true";
        }
        else{
            permission = e.target.id + "_false";
        }
        $.ajax({
            url: "{{route('permission.savepermission')}}",
            type: 'POST',
            data:{
                    'id' : id, 
            'permission' : permission,                             
                 '_token': $("#ss_form input").val()
            }, 
            success: function(result){ 
                console.log(result['data']);                  
                                       
            }
        });

    })

    $(".modal-body input").keypress(function(e){
        if (e.keyCode == 13) {    
            e.preventDefault();        
            savegroup();
        }
    })


</script>
@endsection
<style type="text/css">
    .left{
        float:left;
    }
    .btn{
        font-size:13px !important;
        padding:10px 15px !important;
        color:#fff !important;
    }
    
    
</style>
