<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Protocoll')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="margin-bottom:50px">
                    <h4 class="card-title">Protocollo {{$company}} <i>({{$section}})</i></h4>
                </div>
                
                <div class="card-content">
                    
                    {{ Form::open(array('route' => 'protocol.save','method'=>'post','id'=>'ss_form')) }}
                        @if(session('errors'))
                            <div class="alert alert-danger">                                   
                                <p>{{session('errors')->first('msg')}}</p>                        
                            </div>
                        @endif
                        @if(isset($msg))
                            <div class="alert alert-danger">                                   
                                <p>{{$msg}}</p>                        
                            </div>
                        @endif

                        <input type="hidden" id="id" value={{(isset($data))?$data->id:0}} name="id" />
                        <!-- <input type="hidden" value={{$company}} name="company" /> -->
                        <textarea name="company" style="display:none">{{$company}}</textarea>
                        
                        <fieldset class="form-group">
                            <label for="validationTooltip01">section</label>
                            <select class="custom-select" id="section" name="section">                               
                                @foreach($sections as $value)
                                <option value='{{$value->section}}' <?php echo ((isset($data)&&($data->section==$value->section) || $section == $value->section)?"selected":"") ?>>{{$value->section}}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        
                        <div id="formhtml"></div>
                        <input type="hidden" id="requiretags" name="requiretags" value="">
                        <fieldset class="form-group" style="text-align:center">
                            @if(isset($data))
                            <button class="btn btn-primary mr-1 mb-1 waves-effect waves-light" type="button" onclick="formsubmit()">Salvare</button>
                            @else
                            <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" data-toggle="modal" data-target="#primary">
                                salvare
                            </button>

                            <!-- Modal -->
                            <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary white">
                                            <h5 class="modal-title" id="myModalLabel160">Nuovo Protocollo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Hai creato un nuovo protocollo</p>
                                            <h2>NUM: {{$anno}}.{{$maxno}}</h2>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="formsubmit()">Nuovo Protocollo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
<script type='text/javascript'>

    function formsubmit(){
        $("#formhtml input:checkbox").each(function( index, obj ) {
            if($(this). prop("checked") == true){
                $(this).val('TRUE');
            }else{
                $(this). prop("checked",true);
                $(this).val('FALSE');
            }
            
        });
        $("#ss_form").submit();
    }
    $(document).ready(function(){
        $("#formhtml").html('');
        var company = '<?php echo $company; ?>';
        var section = $("#section").val();       
        $.ajax({
            url: "{{route('protocol.formhtml')}}",
            type: 'POST',
            data:{
                'company' : company,
                'section' : section,
                '_token'  : $("#ss_form input:first-child").val()
            }, 
            success: function(result){
                var requiretags = "";
                $.each( result['formhtml'], function( key, value ) {
                    $("#formhtml").append('<fieldset class="form-label-group form-group>'+value+'</fieldset>');
                    
                    if(value.indexOf("required") != -1){
                        var tagname = $.parseHTML(value)[2]['name'];
                        requiretags += (tagname+",");
                        console.log($.parseHTML(value));
                    }
                    
                });
                datadeploy();
                $("#requiretags").val(requiretags);
               
            }
        })
    })

    $("#section").change(function(){
        $("#formhtml").html('');
        var company = '<?php echo $company; ?>';
        var section = $("#section").val();       
        $.ajax({
            url: "{{route('protocol.formhtml')}}",
            type: 'POST',
            data:{
                'company' : company,
                'section' : section,
                '_token'  : $("#ss_form input:first-child").val()
            }, 
            success: function(result){
                $.each( result['formhtml'], function( key, value ) {
                    $("#formhtml").append('<fieldset class="form-group">'+value+'</fieldset>');
                });
                datadeploy();
            }
        })
    })
    function datadeploy(){
        var id = $("#id").val();
        if(id != 0){
            $.ajax({
                url: "{{route('protocol.data')}}",
                type: 'POST',
                data:{
                    'id' : id,
                    '_token'  : $("#ss_form input:first-child").val()
                }, 
                success: function(result){
                   //console.log(result['data']);
                   $.each(result['data'],function(i, obj){
                        var index = obj.indexOf(":");
                        
                        var tagname = obj.substr(0,index);
                        var tagvalue = obj.substr(index+1,obj.length);
                        if($("[name="+tagname+"]").attr("type") == "radio" ){
                                                    
                        }
                        else{
                            $("[name="+tagname+"]").val(tagvalue);
                            if($("[name="+tagname+"]").attr("type") == "checkbox"){
                                if(tagvalue == "TRUE"){
                                    $("[name="+tagname+"]"). prop("checked",true); 
                                }
                            }
                        }                     
                   })
                }
            })
        }
    }

    

</script>
<style type="text/css">
    #ss_form{
        width:70%;
        margin:auto;
        padding-bottom:70px;
    }
    #ss_form input{
        width:80%;
        float:right;        
    }
    #ss_form textarea{
        width:80%;
        float:right;
        padding-bottom:0;
    }
    #ss_form select{
        width:80%;
        float:right;
    }
    #ss_form input[type="radio"]{
        float: none;
        width: 24px;
        display: inline;        
    }
    #ss_form input[type="checkbox"]{
        float: none;
        width: 24px;
        display: inline;
        
    }
    
</style>

<!--/ Description -->
@endsection