<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Prodotto')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Prodotto</h4>
                    @if(strpos(Session()->get('role'), 'prodotto_create') > 0)
                    <a style="float:right" onclick="open_modal(0)" class="btn btn-warning mr-1 mb-1"><i class="feather icon-star"></i> Nuova Prodotto</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" >
                            <table id="tabledata" class="table table-striped table-hover-animation" >
                                <thead>
                                    <tr>                                        
                                        <th>Prodotto</th>
                                        <th>Categoria</th>
                                        <th>Descrizione</th>
                                        <th>Costo</th>
                                        <th>Marca</th>
                                        <th>Immagine</th>                                                                              
                                        <th width="80">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody id="productlist">
                                   @if(isset($data) && !empty($data))
                                     @foreach($data as $key=> $obj)                     
                                        <tr id="row{{$obj->productid}}">                                            
                                            <td>{{$obj->product}}</td>
                                            <td>{{$obj->category}}</td>
                                            <td>{{$obj->productdescription}}</td> 
                                            <td>{{number_format($obj->cost, 2, '.', '')}}</td>
                                            <td>{{$obj->brand}}</td> 
                                            <td>{{$obj->image}}</td>                                                                                     
                                            <td>
                                                @if(strpos(Session()->get('role'), 'prodotto_edit') > 0)
                                                <a onclick="open_modal('{{$obj->productid}}')"><i class="fa fa-pencil fa-2x primary" ></i></a>
                                                @endif
                                                @if(strpos(Session()->get('role'), 'prodotto_delete') > 0)
                                                <a onclick="deleterow('{{$obj->productid}}')"><i class="fa fa-trash-o fa-2x danger" ></i></a>               
                                                @endif
                                            </td>
                                        </tr>
                                      @endforeach
                                   @endif
                                </tbody>
                                <!--tfoot>
                                    <tr>
                                        <th>Prodotto</th>
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
                                            <h5 class="modal-title" id="">Prodotto</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        
                                        {{ Form::open(array('id'=>'ss_form', 'route'=>'ecommerce.productsave', 'method'=>'post','files'=>'true')) }}
                                            <input type="hidden" id="productid" name="id">
                                            <label id="productwarn" style="display:block;color:red"></label>
                                            <label>Prodotto</label>
                                            <input type="text" class="form-control" id="productname" name="product">
                                            <label>Categoria</label>
                                            <select id="categoryid" name="categoryid" class="form-control">
                                                @foreach($categories as $value)
                                                <option id="category{{$value->id}}" value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
                                            <label>Descrizione</label>
                                            <textarea id="productdescription" name="productdescription" class="form-control"></textarea>
                                            <label>Costo</label>
                                            <input type="number" class="form-control" id="cost" name="cost">
                                            <label>Marca</label>
                                            <select id="brandid" name="brandid" class="form-control">
                                                @foreach($brands as $value)
                                                <option id="brand{{$value->id}}" value="{{$value->id}}">{{$value->brand}}</option>
                                                @endforeach
                                            </select>
                                            <label>immagine</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image" id="imagelabel">Choose file</label>
                                            </div>
                                        {{ Form::close() }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="saveproduct()">salvare</button>
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
        $("#productid").val(id);
        $(".modal-body select option").removeAttr('selected');
        if(id == 0){
            $("#productname").val('');
            $("#productdescription").val('');
            $("#cost").val('');
            $("#imagelabel").html('Choose file');
        }
        else{
            $.ajax({
                url: "{{route('ecommerce.productedit')}}",
                type: 'POST',
                data:{
                       'id' : id,                                  
                    '_token': $("#ss_form input:first-child").val()
                }, 
                success: function(result){ 
                    $("#productname").val(result['data']['product']);
                    $("#category"+result['data']['categoryid']).attr('selected','selected');
                    $("#productdescription").val(result['data']['productdescription']);
                    $("#cost").val(result['data']['cost']);
                    $("#brand"+result['data']['brandid']).attr('selected','selected');
                    $("#imagelabel").html(result['data']['image']);
                }
            })
        }
    }

    function saveproduct(){
        if($("#productname").val() == ''){
            $("#productwarn").html('inserire il nome della Prodotto');
            $("#productname").focus();
        }
        else{
            $("#ss_form").submit();
        }
    }
    function deleterow(id){
        if(confirm("Cancellare davvero i dati?")){
            $.ajax({
                url: "{{route('ecommerce.productdelete')}}",
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
            saveproduct();
        }
    })
</script>
<style type="text/css">
    select.form-control {
        background-image: url('images/pages/arrow-down.png') !important;   

    } 
</style>

@endsection