<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Societa')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Fornitori</h4>
                    @if(strpos(Session()->get('role'), 'fornitori_create') > 0)
                    <a style="float:right" href="{{route('fornitori.register')}}" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuovo Fornitore</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>
                                        <th>Ragione_sociale</th>
                                        <th>Citta</th>
                                        <th>Indirizzo</th>
                                        <th>Cap</th>
                                        <th>Mail</th>
                                        <th>Tel</th>
                                        <th>Fax</th>
                                        <th width="80px">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $value)                     
                                        <tr id="row{{$value->id}}">
                                            <td>{{$value->ragione_sociale}}</td>
                                            <td>{{$value->citta}}</td>
                                            <td>{{$value->indirizzo}}</td>
                                            <td>{{$value->cap}}</td>
                                            <td>{{$value->mail}}</td>
                                            <td>{{$value->tel}}</td>
                                            <td>{{$value->fax}}</td>
                                            <td>
                                                @if(strpos(Session()->get('role'), 'fornitori_edit') > 0)
                                                <a href="{{route('fornitori.edit',$value->id)}}"><i class="fa fa-pencil fa-2x" ></i></a> &nbsp;
                                                @endif
                                                @if(strpos(Session()->get('role'), 'fornitori_delete') > 0)
                                                <a href='#' onclick="deleterow({{$value->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <!--tfoot>
                                    <tr>
                                        <th>Ragione_sociale</th>
                                        <th>Citta</th>
                                        <th>Indirizzo</th>
                                        <th>Cap</th>
                                        <th>Mail</th>
                                        <th>Tel</th>
                                        <th>Fax</th>
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
                url: "{{route('societa.delete')}}",
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