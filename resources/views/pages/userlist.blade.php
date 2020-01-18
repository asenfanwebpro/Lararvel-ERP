<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Permission')

@section('content')
<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lista degli utenti</h4>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">                       
                        <div class="table-responsive">
                            <table id="tabledata" class="table" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Genere</th>
                                        <th>Datadinascita</th>            
                                        <th>Ruolo</th>                                        
                                        <th style="min-width:32px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key => $value)                     
                                        <tr id="row{{$value->id}}">
                                            <td>{{$value->name}} {{$value->lastname}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>
                                                <?php
                                                if($value->genere == '1'){
                                                    echo "Maschio";
                                                }
                                                else if($value->genere == '0'){
                                                    echo "Femmina";
                                                }
                                                else {echo "";}
                                                ?>
                                            </td>
                                            <td>{{$value->datadinascita}}</td>
                                            <td>{{$role[$key]}}</td>                                            
                                            <td>
                                                @if(strpos(Session()->get('role'), 'lista_edit') > 0)
                                                <a href="{{url('useredit/'.$value->id)}}">                                                                                                        
                                                    <i class="fa fa-pencil-square-o" style="color:red;font-size:25px;top:1px;position:relative"></i> 
                                                       
                                                </a>
                                                @endif
                                                @if(strpos(Session()->get('role'), 'lista_delete') > 0)
                                                <a href='#' onclick="deleterow({{$value->id}})">                                                   
                                                    <i class="fa fa-trash-o" style="color:#000;font-size:25px;"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Genere</th>
                                        <th>Datadinascita</th>            
                                        <th>Ruolo</th>                                        
                                        <th style="min-width:32px"></th>
                                    </tr>
                                </tfoot>
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
<script type="text/javascript">
    

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            
            $.ajax({
                url: "{{route('permission.deleteuser')}}",
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
</script>
@endsection
