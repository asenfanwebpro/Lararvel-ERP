<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Departure_list')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Departure_List</h4>
                    <a style="float:right" href="{{url('departure/info/0')}}" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuova Partenza</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" >
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>                                        
                                        <th>Porta</th>                                       
                                        <th>Tempo</th>    
                                        <th>Etichetta</th>  
                                        <th>Stato</th>
                                        <th width="80">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody id="shiplist">
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key=> $obj)                     
                                        <tr id="row{{$obj->id}}">                                            
                                            <td>{{$ports[$key]}}</td>                                          
                                            <td>{{$obj->time}}</td>
                                            <td>{{$obj->group}}</td>
                                            <td>{{($obj->status==1)?'Active':'Inactive'}}</td>
                                            <td style="text-align:center">
                                                <a href="{{route('departure.infoid', $obj->id)}}"><i class="fa fa-pencil fa-2x primary" ></i></a>
                                                <a onclick="deleterow({{$obj->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>                                                
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <!--tfoot>
                                    <tr>
                                    <th>Porta</th>                                       
                                        <th>Tempo</th>    
                                        <th>Etichetta</th>  
                                        <th>Stato</th>                                                                  
                                        <th width="80">Azioni</th>
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

<script type="text/javascript">

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('departure.delete')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input").val()
                }, 
                success: function(result){ 
                    $("#row"+id).css("display","none");
                }
            })
        }
    }
</script>
@endsection