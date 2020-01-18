<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Societa')

@section('content')

<section id="">
    <div class="row">
        
        <div class="col-12">
            <h4 class="card-title">Dati Societa</h4>
        </div>

        <!-- left menu section -->
        <div class="col">
            <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                <li class="nav-item"><a class="nav-link d-flex py-75 active" id="account-general" data-toggle="pill" href="#vertical-general" aria-expanded="true"><i class="feather icon-globe mr-50 font-medium-3"></i>Generale</a></li>
                <li class="nav-item"><a class="nav-link d-flex py-75" id="account-info" data-toggle="pill" href="#vertical-info" aria-expanded="false"><i class="feather icon-info mr-50 font-medium-3"></i>Info</a></li>

                <li class="nav-item"><a class="nav-link d-flex py-75 btn-warning" href="{{route('societa.view')}}" ><i class="fa fa-list mr-50 font-medium-3"></i>Torna alla lista</a></li>
            </ul>

        </div>
        <!-- left menu section -->
        
        <!-- right content section -->
        {{ Form::open(array('route' => 'societa.save','method'=>'post','id'=>'ss_form', 'files'=>'true')) }}
        <div class="col">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="tab-content">
                            
                            <!-- TAB -->
                            <div role="tabpanel" class="tab-pane active" id="vertical-general" aria-labelledby="vertical-general" aria-expanded="true">
                                <div class="media">
                                    
                                    <!--show logo-->    

                                    <div class="media-body mt-75">
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light" for="account-upload">Upload new photo</label>
                                            <input type="file" name="logo" id="logo" hidden="" style="position:absolute;top:-1px;z-index:10;display:inline !important;opacity:0">
                                            <button class="btn btn-sm btn-outline-warning ml-50 waves-effect waves-light" style="position:relative;z-index:20;">Reset</button>
                                        </div>
                                        <p class="text-muted ml-75 mt-50"><small> | Allowed JPG, GIF or PNG. Max size of 800kB</small></p>
                                    </div>
                                </div>

                                <hr>
                                {{ Form::hidden('id', isset($data)?$data['id']:'') }}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ Form::label('ragione_sociale','Ragione Sociale',array( 'id'=>'','class'=>'' )) }}
                                            {{ Form::text('ragione_sociale', isset($data)?$data['ragione_sociale']:'', 
                                                [
                                                    'id'=>'ragione_sociale',
                                                    'class'=>'form-control', 
                                                    'required data-validation-required-message'=>'Campo obbligatorio'
                                                ] ) }}
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">

                                    <?php $arr = ['citta','indirizzo','cap','iva','cf','sdi','mail','pec','tel','fax']; ?>
                                    @for($i=0; $i<count($arr); $i++) 
                                    
                                    <div class="col-6">                       
                                        <div class="form-group mb-6">
                                            {{ Form::label($arr[$i], $arr[$i], array( 'id'=>'','class'=>'' )) }}
                                            {{ Form::text($arr[$i], isset($data)?$data[$arr[$i]]:'', 
                                                [
                                                    'name' => $arr[$i],
                                                    'id' => $arr[$i],
                                                    'class' => 'form-control', 
                                                    'required data-validation-required-message' => 'Campo obbligatorio'
                                                ] ) }} 
                                        </div>
                                    </div>
                                    
                                    @endfor
                                </div>

                                    <!--div class="col-6">
                                        <div class="form-group ">
                                            <label>logo</label>
                                            <input type="file" name="logo" class="form-control">
                                        </div>
                                    </div-->

                            </div>

                            <!-- TAB -->
                            <div class="tab-pane fade" id="vertical-info" role="tabpanel" aria-labelledby="vertical-info" aria-expanded="false">
                                info e other data
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group" style="text-align:right">
                    <button class="btn btn-primary" type="submit">Salva</button>
                </div>
            </div>

        </div>
        {{ Form::close() }}
        <!-- right content section -->
        
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
</style>
<!--/ Description -->
@endsection