@extends('layouts/contentLayoutMaster')

@section('title', 'Departure_list')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if($id == 0)
                        <h4 class="card-title">Nuova Partenza</h4>                    
                    @elseif($id == -1)
                        <h4 class="card-title">Annuncio pubblicitario</h4>                    
                    @else
                        <h4 class="card-title">Modifica Partenza</h4>                    
                    @endif
                    @if(strpos(Session()->get('role'), 'monitor_create') > 0)
                    <a onclick="open_modal(0)" style="float:right;color:#fff !important;"  class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Aggiungi Opzione</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                   
                    {{ Form::open(array('route' => 'departure.save','method'=>'post','id'=>'ss_form')) }}
                        <input type='hidden' id='id' name='id' value="{{$id}}">
                        @if($id != '-1' && count($ports)>0 && count($ships)>0)
                        <div class="row">                            
                            <div class="col-4">
                                <label>Porto</label>
                                <select id="port" name="route_id" class="form-control">
                                    @foreach($ports as $value)
                                    <option value="{{$value->id}}" <?php echo (!empty($data) && $data->route_id == $value->id)?'selected':''; ?> >{{$value->port}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Nave</label>
                                <select id="nave" name="ship_id" class="form-control">
                                     @foreach($ships as $value)
                                    <option value="{{$value->id}}" <?php echo (!empty($data) && $data->ship_id == $value->id)?'selected':''; ?> >{{$value->ship}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Orario</label>
                                <input type="time" name="time" id="time" class="form-control" value="<?php echo (!empty($data))?$data->time:''; ?>" required> 
                            </div>
                            <div class="col-8">
                                <label>Etichetta</label>
                                <input id="group" name="group" type="text" class="form-control" value="<?php echo (!empty($data))?$data->group:''; ?>" >
                            </div>
                            <div class="col-4">
                                <label>Stato</label>
                                <select id="status" name="status" class="form-control">
                                    <option value='1' <?php echo (!empty($data) && $data->status == 1)?'selected':''; ?>>Attivo</option>
                                    <option value='0' <?php echo (!empty($data) && $data->status == 0)?'selected':''; ?>>Disattivo</option>
                                </select>
                            </div>
                            
                            <div class="col-12"><hr /></div>
                            
                            <div class="col-12">
                                <ul class="list-unstyled mb-0">
                                    <?php $arr = ['sun','mon','tue','wed','thu','fri','sat']; ?>                                
                                    @for($i=0; $i<count($arr);$i++)
                                        <!--
                                        <div class="custom-control custom-checkbox left" style="width:70px;">                                
                                            <input type='checkbox' class="custom-control-input weekday" id="{{$arr[$i]}}" name='{{$arr[$i]}}' value="{{$i}}" <?php echo (!empty($data) && strpos($data->week,(string)$i) !== false)?'checked':''; ?>>
                                            <label class="custom-control-label" for="{{$arr[$i]}}" <?php echo ($arr[$i] == 'sun')?"style='color:red'":""; ?> >{{ucfirst($arr[$i])}}</label>
                                        </div>
                                        -->
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-primary custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input weekday" id="{{$arr[$i]}}" name='{{$arr[$i]}}' value="{{$i}}" <?php echo (!empty($data) && strpos($data->week,(string)$i) !== false)?'checked':''; ?>>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span>
                                                    </span>
                                                    <label class="custom-control-label" for="{{$arr[$i]}}" <?php echo ($arr[$i] == 'sun')?"style='color:red'":""; ?> >{{ucfirst($arr[$i])}}</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        @endfor  
                                    </ul>
                                <!--
                                <label style="XXXmargin-bottom:20px">Settimana</label><br>
                                <?php $arr = ['sun','mon','tue','wed','thu','fri','sat']; ?>                                
                                @for($i=0; $i<count($arr);$i++)
                                    <div class="custom-control custom-checkbox left" >                                
                                        <input type='checkbox' class="custom-control-input weekday" id="{{$arr[$i]}}" name='{{$arr[$i]}}' value="{{$i}}" <?php echo (!empty($data) && strpos($data->week,(string)$i) !== false)?'checked':''; ?>>
                                        <label class="custom-control-label" for="{{$arr[$i]}}" <?php echo ($arr[$i] == 'sun')?"style='color:red'":""; ?> >{{ucfirst($arr[$i])}}</label>
                                    </div>
                                @endfor
                                -->  
                                <br />
                                <button onclick="selectall()" type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Seleziona Tutto</button>                              
                                <button onclick="deselectall()" type="button" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Deseleziona Tutto</button>
                            </div>
                            
                            <hr />

                            <div class="col-md-12 left">
                                <button type="submit" class="btn btn-primary" style="float:right">salvare</button>
                            </div>
                        </div>
                        @endif
                    {{ Form::close() }}
                    
                    @if($id != 0)
                    <div class="table-responsive" >
                        <table class="table table-striped table-hover-animation" >
                            <thead>
                                <tr>                                        
                                    <th>Data inizio</th>                    
                                    <th>Data fine</th>                                       
                                    <!--th>Opzion</th-->                                        
                                    <!--th>Stato</th-->
                                    <th>Text</th>
                                    <th width="220">Azioni</th>
                                </tr>
                            </thead>
                            <tbody id="infobody">
                                @if(isset($infos) && count($infos) > 0)
                                    @foreach($infos as $key => $value)
                                    <tr id="row{{$value->id}}">
                                        <td>{{$value->date_from}}</td>
                                        <td>{{$value->date_to}}</td>
                                        <!--td>{{$value->type}}</td-->
                                        <!--td>{{($value->status == 1)?"Active":"Inactive"}}</td-->
                                        <td>{{substr($value->text, 0,100)}}</td>
                                        <td style="text-align:center">
                                            
                                            <i class="fa fa-{{($value->status == 1)?"check success":"ban danger"}} fa-2x" >&nbsp;</i>
                                            @if(strpos(Session()->get('role'), 'monitor_edit') > 0)
                                            <a onclick="open_modal({{$value->id}})"><i class="fa fa-pencil fa-2x primary" ></i></a>
                                            @endif
                                            @if(strpos(Session()->get('role'), 'monitor_delete') > 0)
                                            <a onclick="deleterow({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>                                                
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>                                
                        </table>
                           
                        </div>
                         <!-- Modal -->
                         <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary white">
                                            <h5 class="modal-title" id="">Nota</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        
                                            <div class="form-group">
                                                <input type="hidden" id="noteid" name="id" value="0">
                                                <label id="notewarn" style="display:block;color:red"></label>
                                                <label>Data from</label>
                                                <input type="date" class="form-control" id="date_from" name="date_from" > 
                                                <label>Data to</label>
                                                <input type="date" class="form-control" id="date_to" name="date_to" >
                                                <label>Opzion</label>
                                                <select class="form-control" id="type" onchange="controlshtml()">
                                                    <option id="note" value="note">Note</option>
                                                    <option id="delay" value="delay">Ritardo</option>
                                                    <option id="suspend" value="suspend">Sospeso</option>
                                                </select>   
                                                <label>Stato</label>
                                                <select name="notestatus" class="form-control" id="notestatus">
                                                    <option id="note1" value='1'>Active</option>
                                                    <option id="note0" value='0'>Inactive</option>
                                                </select>
                                                <label>Text</label>
                                                <div class="controls">
                                                    <textarea id="notetext" class="form-control" required></textarea>
                                                    <input type="text" id="delaytext" name="text" style="display:none" class="form-control" data-validation-containsnumber-regex="^([0-9]+)$" data-validation-containsnumber-message="The regex field format is invalid." placeholder="Enter specified regular expression" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="savenote()">salvare</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal" aria-label="Close" >annulla</button>
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
</section>
@endsection

<script src="{{ asset('js/jquery.min.js')}}"></script>
<script type='text/javascript'>

    function selectall(){
        $(".weekday").attr('checked','checked');
    }
    function deselectall(){
        $(".weekday").removeAttr('checked');
    }
    function open_modal(id){
        $("#primary").modal('toggle');
        $("#noteid").val(id);
        $("#type option").removeAttr('selected');
        $("#notestatus option").removeAttr('selected');
        $("#noteid").val(id);  
        if(id == 0){ 
            $("#notetext").val('');
            $("#delaytext").val('');
            $("#date_from").val("<?php echo date('Y-m-d'); ?>");
            $("#date_to").val("<?php echo date('Y-m-d'); ?>");
            controlshtml();
        }
        else{
            $.ajax({
                url: "{{route('departure.noteedit')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){                     
                    $("#date_from").val(result['data']['date_from']);
                    $("#date_to").val(result['data']['date_to']);
                    
                    var status = (result['data']['status'] == 1)?'Active':'Inactive';
                    //$("#notestatus").val(status);
                    $("#note"+result['data']['status']).attr('selected','selected');
                    $("#"+result['data']['type']).attr('selected','selected');
                    controlshtml();
                    if(result['data']['type'] == 'delay'){                        
                        $("#delaytext").val(result['data']['text']);
                    }
                    else{                        
                        $("#notetext").val(result['data']['text']);
                    }
                    
                }
            })
        }
    }
    function savenote(){
        
                  var id = $("#noteid").val();
        var departure_id = $("#id").val();
           var date_from = $("#date_from").val();
             var date_to = $("#date_to").val();
                var type = $("#type").val();
              var status = $("#notestatus").val();

        if(type == 'delay'){
                var text = $("#delaytext").val();
        }
        else{
                var text = $("#notetext").val();
        }

        if(text ==''){
            $("#notewarn").html("inserire nota");
        }
        else{
            $.ajax({
                url: "{{route('departure.notesave')}}",
                type: 'POST',
                data:{
                       'id' : id,   
             'departure_id' : departure_id,
                'date_from' : date_from,
                  'date_to' : date_to,
                     'type' : type,
                   'status' : status,
                     'text' : text,                               
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){
                    var status = (result['data']['status'] == 1)?"Active":"Inactive"; 
                    var statico= (result['data']['status'] == 1)?"check success":"ban danger";
                    
                    if(id > 0){
                        $("#primary").modal('toggle');                        
                        $("#row"+result['data']['id']).html('<td>'+result['data']['date_from']+'</td>'+
                                            '<td>'+result['data']['date_to']+'</td>'+
                                            '<!--td>'+result['data']['type']+'</td-->'+
                                            '<!--td>'+status+'</td-->'+
                                            '<td>'+result['data']['text']+'</td>'+
                                            '<td style="text-align:center">'+
                                                '<i class="fa fa-'+statico+' fa-2x" >&nbsp;</i>'+
                                                '<a onclick="open_modal('+result['data']['id']+')"><i class="fa fa-pencil fa-2x primary" ></i></a>'+
                                                '<a onclick="deleterow('+result['data']['id']+')"><i class="fa fa-trash-o fa-2x danger" ></i></a>'+                                               
                                            '</td>');
                    }
                    else{
                        $("#primary").modal('toggle');   
                        $("#infobody").append('<tr id="row'+result['data']['id']+'"><td>'+result['data']['date_from']+'</td>'+
                                            '<td>'+result['data']['date_to']+'</td>'+
                                            '<!--td>'+result['data']['type']+'</td!-->'+
                                            '<!--td>'+status+'</td-->'+
                                            '<td>'+result['data']['text']+'</td>'+
                                            '<td style="text-align:center">'+
                                                '<i class="fa fa-'+statico+' fa-2x" >&nbsp;</i>'+
                                                '<a onclick="open_modal('+result['data']['id']+')"><i class="fa fa-pencil fa-2x primary" ></i></a>'+
                                                '<a onclick="deleterow('+result['data']['id']+')"><i class="fa fa-trash-o fa-2x danger" ></i></a>'+                                               
                                            '</td></tr>');
                    }

                }
            })
        }
            
    }
    function controlshtml(){
        if($("#type").val() == 'delay'){
            $("#notetext").css("display",'none');
            $("#delaytext").css("display","");
        }
        else{
            $("#notetext").css("display",'');
            $("#delaytext").css("display","none");
        }
    }
    $(".modal-body input").keypress(function(e){
        if (e.keyCode == 13) {    
            e.preventDefault();        
            save();
        }
    })
    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('departure.notedelete')}}",
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
</script>
