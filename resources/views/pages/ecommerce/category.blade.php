<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Categoria')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Categoria</h4>
                    <!-- @if(strpos(Session()->get('role'), 'monitor_create') > 0) -->
                    @if(strpos(Session()->get('role'), 'categoria_create') > 0)
                    <a style="float:right" onclick="open_modal(0)" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuova Categoria</a>
                    @endif
                    <!-- @endif -->
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" >
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>                                        
                                        <th>Categoria</th>
                                        <th>Description</th>                                                                              
                                        <th width="80">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key=> $obj)                     
                                        <tr id="row{{$obj->id}}">                                            
                                            <td>{{$obj->category}}</td>
                                            <td>{{$obj->description}}</td>                                                                                       
                                            <td>
                                                @if(strpos(Session()->get('role'), 'categoria_edit') > 0)
                                                <a onclick="open_modal({{$obj->id}})"><i class="fa fa-pencil fa-2x primary" ></i></a>
                                                @endif
                                                @if(strpos(Session()->get('role'), 'categoria_delete') > 0)
                                                <a onclick="deleterow({{$obj->id}})"><i class="fa fa-trash-o fa-2x danger" ></i></a>               
                                                @endif
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
                                            <h5 class="modal-title" id="">Categoria</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        
                                        {{ Form::open(array('id'=>'ss_form', 'route'=>'ecommerce.categorysave', 'method'=>'post')) }}
                                            <input type="hidden" id="categoryid" name="id">
                                            <label id="warn" style="display:block;color:red"></label>
                                            <label>Categoria</label>
                                            <textarea class="form-control" id="categoryname" name="category" rows="1"></textarea>
                                            <label>Descrizione</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        {{ Form::close() }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="savecategory()">salvare</button>
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

    function open_modal(id){
        $("#primary").modal('toggle');
        $("#categoryid").val(id);
        if(id == 0){
            $("#categoryname").val('');
        }
        else{
            $.ajax({
                url: "{{route('ecommerce.categoryedit')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){ 
                    $("#categoryname").val(result['data']['category']);
                    $("#description").val(result['data']['description']);
                }
            })
        }
    }

    function savecategory(){
        if($("#categoryname").val() == ''){
            $("#warn").html('inserire il nome della categoria');
            $("#categoryname").focus();
        }
        else{
            $("#ss_form").submit();
        }
    }
    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('ecommerce.categorydelete')}}",
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
            savecategory();
        }
    })
</script>

@endsection