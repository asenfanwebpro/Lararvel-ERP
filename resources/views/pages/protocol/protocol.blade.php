<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Protocoll')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Protocollo: {{$company}} <i>({{$section}})</i> </h4>
                    @if(strpos(Session()->get('role'), 'protocolli_create') > 0)
                    <a style="float:right" href="#" onclick="protocoll_register({{$companyid}},'{{$section}}')" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuovo Protocoll</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div style="width:100%">
                            <span class="dropdown" style="float:right">
                                <button class="btn btn-success dropdown-toggle mr-1" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sezioni
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    @foreach($sections as $value)
                                        <a class="dropdown-item" href="{{route('protocol.views', [$companyid, $value->section])}}">{{$value->section}}</a>                                    
                                    @endforeach
                                </div>
                            </span>
                            
                        </div>
                        
                        <?php 
                            $extra = ''; $formhtml = [];
                            if(isset($data) && count($data)>0){
                                $extra = $data[0]['extra'];
                                $formhtml = explode(',',$extra);
                            }
                        ?> 
                        
                        <div class="table-responsive">
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Anno</th>                                       
                                        @if(isset($data) && count($data)>0)
                                        @for($i=0; $i<count($formhtml); $i++) 
                                        <?php 
                                            $pos = strpos($formhtml[$i],':');
                                            $formhtml[$i] = substr($formhtml[$i],0, $pos); 
                                        ?>  
                                        <th>{{$formhtml[$i]}}</th>                                    
                                        @endfor 
                                        @endif                            
                                        <th width="100">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && count($data)>0)
                                     @foreach($data as $value)                     
                                        <tr id="row{{$value->id}}">
                                            
                                            <td>{{$value->section}}</td>
                                            <td class="yearorder">{{$value->anno}} : {{$value->no}}</td> 
                                            <?php
                                                if(!empty($data)){
                                                    $extra = $value['extra'];
                                                    $formhtml = explode(',',$extra);
                                                }
                                            ?> 
                                            @for($i=0; $i<count($formhtml); $i++)
                                            <?php 
                                                $pos = strpos($formhtml[$i],':');
                                                $formhtml[$i] = substr($formhtml[$i],$pos+1,strlen($formhtml[$i])); 
                                            ?>   
                                            <td>{{$formhtml[$i]}}</td>                                    
                                            @endfor                          
                                            <td>
                                                @if(strpos(Session()->get('role'), 'protocolli_edit') > 0)
                                                <a href="{{url('protocol_edit/'.$companyid.'/'.$value->id)}}"><i class="fa fa-pencil fa-2x" ></i></a>
                                                @endif
                                                <a onclick="open_note({{$value->id}})" data-toggle="modal" data-target="#note"><i class="fa fa-file-text fa-2x primary" ></i></a>
                                                <a onclick="open_file({{$value->id}})" data-toggle="modal" data-target="#filename"><i class="fa fa-upload fa-2x primary" ></i></a>
                                                @if(strpos(Session()->get('role'), 'protocolli_delete') > 0)
                                                <a href='#' onclick="deleterow({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                                @endif
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
    </div>

    <!-- Modal Note -->
    <div class="modal fade text-left" id="note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title" id="myModalLabel160">Gestione Prtocollo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div id="insertnote">
                        
                    </div>
                    <h3 style="text-align:center;margin-top:30px">Aggiungi uan nuova nota</h3>
                    <textarea id="notedata" cols="58"></textarea>
                    <input type="hidden" id="noteid" />
                </div>
                <div class="modal-footer">
                    <button onclick="save_note()" type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Salva</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Files -->
    <div class="modal fade text-left" id="filename" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title" id="myModalLabel160">Gestione Protocollo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="insertfile">
                        
                    </div>
                    <h3 style="text-align:center;margin-top:30px">Aggiungi un nuova file</h3>
                   
                    <form method="post" action="{{route('protocol.file_post')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" id="filedata" name="docs[]" multiple="multiple"/>
                    <input type="hidden" id="fileid" name="protocollid" />
                   
                </div>
                <div class="modal-footer">
                    <button   type="submit" class="btn btn-primary">Salva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{ Form::open(array('id'=>'ss_form','route'=>'protocol.register','method'=>'post')) }}
          <input type="hidden" name="companyid" id="companyid" />
          <input type="hidden" name="section" id="section" />                                     
    {{ Form::close() }}
</section>

<!--/ Description -->
<script type="text/javascript">
    /*
    $('#tabledata').dataTable( {
        "order": [[ 2, 'desc' ]],
        'dom': 'Bfrtip',
       'buttons': ['copyHtml5','pdf','print'],
    });   
    */

    function protocoll_register(companyid, section){
        $("#companyid").val(companyid);
        $("#section").val(section);
        $("#ss_form").submit();
    }
    

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            
            $.ajax({
                url: "{{route('protocol.delete')}}",
                type: 'POST',
                data:{
                       'id' : id,
                    '_token':$("#ss_form input").val()
                }, 
                success: function(result){
                    console.log(result);
                    $("#row"+id).css('display','none');
                }
            });
        }
    }

    

    function open_note(id){
        $("#noteid").val(id);
        $("#insertnote").html('');
        $.ajax({
            url: "{{route('protocol.note')}}",
            type: 'POST',
            data:{
                'protocollid' : $("#noteid").val(),                      
                      '_token': $("#ss_form input").val()
            }, 
            success: function(result){
                $.each(result['data'],function(i,obj){
                    $("#insertnote").append('<div id="div'+obj['id']+'" style="padding-bottom:10px;border-bottom:1px solid #ccc;min-height:25px">'+
                                            '<span style="float:left">'+obj['note']+'</span>'+
                                            '<i style="float:right" class="fa fa-trash" onclick="delete_note('+obj['id']+')"></i>'+
                                            '<span style="float:right;font-size:10px">'+obj['created_at']+'</span>'+
                                           '</div>');
                })
                
            }
        });
    }

    function save_note(){
        var note = $("#notedata").val();
        var protocollid = $("#noteid").val();
        if(note != ''){
            $.ajax({
                url: "{{route('protocol.note_post')}}",
                type: 'POST',
                data:{
                    'protocollid' : protocollid,
                           'note' : note,
                          '_token': $("#ss_form input").val()
                }, 
                success: function(result){
                    console.log(result);
                    
                }
            });
        }        
    }

    function delete_note(id){  
        
        $.ajax({
            url: "{{route('protocol.note_delete')}}",
            type: 'POST',
            data:{
                'id' : id,                           
            '_token': $("#ss_form input").val()
            }, 
            success: function(result){
                $("#div"+id).css("display","none");
            }
        });
          
    }

    function open_file(id){
        $("#fileid").val(id);
        $("#insertfile").html('');
        $.ajax({
            url: "{{route('protocol.file')}}",
            type: 'POST',
            data:{
                'protocollid' : $("#fileid").val(),                      
                      '_token': $("#ss_form input").val()
            }, 
            success: function(result){
                $.each(result['data'],function(i,obj){
                    $("#insertfile").append('<div id="file'+obj['id']+'" style="padding-bottom:10px;border-bottom:1px solid #ccc;min-height:25px">'+
                                            '<i style="float:left" class="feather icon-file-text"></i>'+
                                            '<a target="blank" href="{{url("uploads/protocoll")}}/'+obj['filename']+'" style="float:left">'+obj['filename']+'</a>'+
                                            '<i style="float:right" class="fa fa-trash" onclick="delete_file('+obj['id']+')"></i>'+
                                            '<span style="float:right;font-size:10px">'+obj['created_at']+'</span>'+
                                           '</div>');
                })
               
                
            }
        });
        
    }

    function delete_file(id){  
        
        $.ajax({
            url: "{{route('protocol.file_delete')}}",
            type: 'POST',
            data:{
                'id' : id,                           
            '_token': $("#ss_form input").val()
            }, 
            success: function(result){
                $("#file"+id).css("display","none");
            }
        });
          
    }
    

    
</script>


@endsection