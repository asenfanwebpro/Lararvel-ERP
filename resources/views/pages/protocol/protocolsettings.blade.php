<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Societa')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Setting Protocoll</h4>
                    @if(strpos(Session()->get('role'), 'protocollo_create') > 0)
                    <a style="float:right" href="{{route('protocolsettings.register')}}" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuovo</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Section</th>
                                        <th>Progressive</th>                                       
                                        <th width="80px">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $value)                     
                                        <tr id="row{{$value->id}}">
                                            <td>{{$value->company}}</td>
                                            <td>{{$value->section}}</td>
                                            <td>{{$value->progress}}</td>                                           
                                            <td>
                                                @if(strpos(Session()->get('role'), 'protocollo_edit') > 0)
                                                <a href="{{route('protocolsettings.edit', $value->id)}}"><i class="fa fa-pencil fa-2x" ></i></a>
                                                @endif
                                                @if(strpos(Session()->get('role'), 'protocollo_delete') > 0)
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
    {{ Form::open(array('id'=>'ss_form')) }}
    {{ Form::close() }}
</section>
<!--/ Description -->
<script type="text/javascript">

    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            
            $.ajax({
                url: "{{route('protocolsettings.delete')}}",
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