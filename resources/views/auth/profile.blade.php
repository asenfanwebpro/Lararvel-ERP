<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Profilo')

@section('content')

<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">                    
                    <h4 class="card-title">Profilo</h4>                    
                </div>
                <div class="card-content">
                    {{ Form::open(array('route' => 'user.profile','method'=>'post','id'=>'ss_form', 'files'=>'true')) }}
                        <input type="hidden" value="{{$data->id}}" name="id" />
                        <div class="fieldset mb-3">
                            @if ($errors->first('name'))
                                <div class="alert alert-danger" style="padding:5px">                              
                                    <p style="font-size:10px;">{{ $errors->first('name')}}</p>                  
                                </div>
                            @endif
                            <label for="validationTooltip01">First Name</label>
                            <input type="text" class="form-control" id='name' name='name' value="{{$data->name}}" >
                        </div>
                        <div class="fieldset mb-3">
                            @if ($errors->first('lastname'))
                                <div class="alert alert-danger" style="padding:5px">                              
                                    <p style="font-size:10px;">{{ $errors->first('lastname')}}</p>                  
                                </div>
                            @endif
                            <label for="validationTooltip01">Last Name</label>
                            <input type="text" class="form-control" id='lastname' name='lastname' value="{{$data->lastname}}" >
                        </div>
                        <div class="fieldset mb-3">
                            @if ($errors->first('email'))
                                <div class="alert alert-danger" style="padding:5px">                              
                                    <p style="font-size:10px;">{{ $errors->first('email')}}</p>                  
                                </div>
                            @endif
                            <label for="validationTooltip01">Email</label>
                            <input type="email" class="form-control" id='email' name='email' value="{{$data->email}}" disabled>
                        </div>
                        <div class="fieldset mb-3">
                            
                            <label for="validationTooltip01">Genere</label>
                            <select id="genere" name="genere" class="form-control">
                                <option value="1" <?php echo ($data->genere == 1)?'selected':'';?>>Maschio</option>
                                <option value="2" <?php echo ($data->genere == 2)?'selected':'';?>>Femmina</option>
                            </select>
                        </div>
                        <div class="fieldset mb-3">
                            
                            <label for="validationTooltip01">Datadinascita</label>
                            <input type="date" class="form-control" id='datadinascita' name='datadinascita' value="{{$data->datadinascita}}" >
                        </div>
                        <div class="fieldset mb-3">
                            <label>Avatar</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>
                        <div class="fieldset mb-3" style="text-align:center">
                            <button class="btn btn-primary" type="submit">salvare</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
    #ss_form{
        width:70%;
        margin:auto;
        padding-bottom:70px;
    }
    #ss_form textarea, #ss_form input[type='file']{
        width:80%;
        float:right;
        padding-bottom:0;
    }
    .fieldset{
        margin-top:50px;
        
    }
    select.form-control {
        background-image: url('../images/arrow-down.png') !important;   

    }  
</style>
<!--/ Description -->
@endsection