<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Formbuilder')

@section('content')

<section id="row-grouping">
    <div class="card">  
        <div class="card-header">
            <h4 class="card-title">Costruttore di moduli</h4>
        </div>
        <div class="card-body">
            <div class="sub-main">
                <div class="col-sm-4">
                    <fieldset class="form-group">
                        <label for="validationTooltip01">Societa</label>
                        <select class="custom-select" id="company" name="company">                               
                            @foreach($company as $value)
                            <option >{{$value->ragione_sociale}}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col-sm-4">
                    <fieldset class="form-group">
                        <label for="validationTooltip01">Sezione</label>
                        <select class="custom-select" id="section" name="section" onchange="load_previous_form()">                              
                           
                        </select>
                    </fieldset>
                </div>
                <div class="col-sm-4">
                    <fieldset class="form-group" style="text-align:center">
                        @if(strpos(Session()->get('role'), 'protocollo_create') > 0 && strpos(Session()->get('role'), 'protocollo_edit') > 0 && strpos(Session()->get('role'), 'protocollo_delete') > 0) 
                        <button id="formbuilder_post"  class="btn btn-primary" type="button" >Salva</button>
                        @endif
                    </fieldset>
                </div>
                
            </div>
            <iframe id="formframe" src="{{url('formbuilder.html')}}" style="width:100%; height:534px;" frameborder="0" style="background:#fff"></iframe>
        </div>
    </div>
    
    {{ Form::open(array('id'=>'ss_form')) }}
    {{ Form::close() }}
</section>
<style type="text/css">
    .col-sm-4{
        float:left;
    }
    .col-sm-4 select{
        width:70%;
        float:right;
    }
    
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("#section").html('');
        var company = $("#company").val();
        $.ajax({
            url: "{{route('protocolform.section')}}",
            type: 'POST',
            data:{
                'company' : company,
                '_token':$("#ss_form input").val()
            }, 
            success: function(result){
                $.each( result['section'], function( key, value ) {
                    $("#section").append("<option value='"+value['section']+"'>"+value['section']+"</option>");
                });
                load_previous_form();
            }
        })
    })

    function load_previous_form(){
        $('iframe').contents().find(".col-md-9 .form-body .col-md-12").html('');
        var company = $("#company").val();
        var section = $("#section").val();
        $(".col-md-9 .form-body .col-md-12").html('');
        $.ajax({
            url: "{{route('protocolform.form')}}",
            type: 'POST',
            data:{
                'company' : company,
                'section' : section,
                '_token':$("#ss_form input").val()
            }, 
            success: function(result){
                console.log(result['data']);
                $.each( result['data'], function( key, value ) {
                    $('iframe').contents().find(".col-md-9 .form-body .col-md-12").append('<div class="form-group draggable ui-draggable dropped" style="postition:static">'+value+'<p class="tools">						<a class="edit-link">Edit HTML</a><a>|</a><a class="remove-link">Remove</a></p></div>')
                });
                
            }
        })
    }

    $('#company').change(function(){
        $("#section").html('');
        var company = $("#company").val();        
        $.ajax({
            url: "{{route('protocolform.section')}}",
            type: 'POST',
            data:{
                'company' : company,
                '_token':$("#ss_form input").val()
            }, 
            success: function(result){
                $.each( result['section'], function( key, value ) {
                    $("#section").append("<option value="+value['section']+">"+value['section']+"</option>");
                });
                load_previous_form();
               
            }
        })
    })

    $("#formbuilder_post").click(function(){

        var formhtml = [];

        var $copy = $("#formframe").contents().find('.col-md-9 .form-group');
        $copy.find(".tools, .remove-link").remove();

        $( $copy ).each(function( index, obj ) {
            console.log( obj );
            formhtml.push(obj['innerHTML']);
        });
        

        $.ajax({
            url: "{{route('protocolform.save')}}",
            type: 'POST',
            data:{
                'company' : $("#company").val(),
                'section' : $("#section").val(),
                formhtml  : formhtml,
                 '_token' :$("#ss_form input").val()
            }, 
            success: function(result){
                console.log(result);
               
            }
        })
        
    })
</script>

<!--/ Description -->
@endsection