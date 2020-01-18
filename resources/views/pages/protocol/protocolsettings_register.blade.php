@extends('layouts/contentLayoutMaster') 

@section('title', 'Fornitore')  

@section('breadcrum')

@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Sezione Protocollo</h4>
        <a href="{{ route('protocolsettings.view') }}" class="btn btn-warning" >Annulla</a>
    </div>
    <div class="card-content">
        <div class="card-body">
        
            {{ Form::open(array('route' => 'protocolsettings.save', 'method'=>'post', 'id'=>'ss_form', 'files'=>'false', 'class'=>'form form-horizontal')) }}
            <input type="hidden" value={{(isset($data))?$data->id:0}} name="id" />
            <div class="form-body">
                <div class="row">
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label for="company">Ragione Sociale</label>
                            <select name="company" id="company" class="custom-select form-control" >                               
                                @foreach($company as $value)
                                    <option value="{{ $value['ragione_sociale'] }}" @if(isset($data) && $data['company']==$value['ragione_sociale']){{"selected"}} @endif > {{$value->ragione_sociale}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">
                            <label for="company">Sezione Protocollo</label>
                            <input type="text" name="section" id="section" class="form-control" value="{{isset($data)?$data['section']:''}}" required data-validation-required-message="Campo obbligatorio">
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">                      
                            <label for="progress">Progressione {{(isset($data))?$data['progress']:''}} </label>
                            <select name="progress" id="progress" class="form-control" >                               
                                <option value="year" @if(isset($data) && $data=="year"){{"selected"}} @endif >Anno</option>
                                <option value="continuous" @if(isset($data) && $data=="continuous"){{"selected"}} @endif >Continuo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group" style="text-align:right">
                            <button class="btn btn-primary" type="submit">Salva</button>
                        </div>
                    </div>
                
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>
@endsection

@section('mystyle')

@endsection

@section('myscript')

@endsection