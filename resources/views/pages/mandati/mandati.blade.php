<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Mandati')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mandati</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div style="width:100%">
                            @if(strpos(Session()->get('role'), 'mandati_create') > 0)
                            <a style="float:right" href="{{route('mandati.register')}}" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuovo Mandati</a>
                            @endif
                            <select class="form-control " name="company" id="company" style="float:right;width:150px;margin-right:10px">
                                <option value="" disabled selected hidden>Choose...</option>
                                @foreach($company as $value)
                                <option value='{{$value->ragione_sociale}}' >{{$value->ragione_sociale}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>
                                        <th style="display:none"></th>
                                        <th>Societa</th>
                                        <th>Fornitrice</th>
                                        <th>Numero</th>
                                        <th>Totale</th>
                                        <th>Pagato</th>
                                        <th>Differenza</th>                                       
                                        <th width="80px">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody id="mandatilist">
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key=> $obj)                     
                                        <tr id="row{{$obj->id}}">
                                            <td style="display:none">{{$obj->id}}</td>
                                            <td>{{$obj->company}}</td>
                                            <td>{{$obj->supplier}}</td>
                                            <td>{{$obj->anno}}:{{$obj->no}}</td>
                                            <td>{{$valuem[$key]['total']}}</td>
                                            <td>{{$valuem[$key]['paytotal']}}</td>
                                            <td>{{$valuem[$key]['difference']}}</td>                                            
                                            <td>
                                                @if(strpos(Session()->get('role'), 'mandati_edit') > 0)
                                                <a href="{{route('mandati.edit', $obj->id)}}"><i class="fa fa-pencil fa-2x" ></i></a>
                                                @endif
                                                <a href="{{route('mandati.print', $obj->id)}}"><i class="fa fa-print fa-2x " ></i></a>
                                                @if(strpos(Session()->get('role'), 'mandati_delete') > 0)
                                                <a onclick="deleterow({{$obj->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <!--tfoot>
                                    <tr>
                                        <th>Societa</th>
                                        <th>Fornitrice</th>
                                        <th>Numero</th>
                                        <th>Totale</th>
                                        <th>Pagato</th>
                                        <th>Differenza</th>                                       
                                        <th></th>
                                    </tr>
                                </tfoot-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::open(array('id'=>'ss_form')) }}
    {{ Form::close() }}
   
</section>
<!--/ Description -->
<script type="text/javascript">

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            
            $.ajax({
                url: "{{route('mandati.delete')}}",
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

    $("#company").change(function(){
        $("#mandatilist").html('');
        $.ajax({
            url: "{{route('mandati.companymandati')}}",
            type: 'POST',
            data:{
                'company' : $("#company").val(),
                  '_token':$("#ss_form input").val()
            }, 
            success: function(result){
               
               $.each(result['data'], function(i,obj){                
                   $("#mandatilist").append('<tr id="row{{$obj->id}}">'+
                                            '<td style="display:none">'+obj['id']+'</td>'+
                                            '<td>'+obj['company']+'</td>'+
                                            '<td>'+obj['supplier']+'</td>'+
                                            '<td>'+obj['anno']+':'+obj['no']+'</td>'+
                                            '<td>'+result['value'][i]['total']+'</td>'+
                                            '<td>'+result['value'][i]['paytotal']+'</td>'+
                                            '<td>'+result['value'][i]['difference']+'</td> '+                                           
                                            '<td>'+
                                               ' <a href={{route("mandati.edit", 1 )}}><i class="fa fa-pencil fa-2x" ></i></a>'+
                                                '<a href={{route("mandati.print", 1 )}}><i class="fa fa-print fa-2x" ></i></a>'+
                                                '<a onclick="deleterow('+obj['id']+')"><i class="fa fa-trash-o fa-2x danger" ></i></a>'+
                                            '</td>'+
                                       '</tr>');
               })
            }
        });
    })
</script>

<style type="text/css">
    select{
        width: 150px;
        height: 30px;
        padding: 5px;
        color: #e4e4e4e0;
        }
    select option { color: black; font-weight:bold}
    select option:first-child{
        color: #e4e4e4e0;
    }
</style>

@endsection