<!-- Description -->
@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('pageStyle')

    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">

@endsection

@section('content')

<section class="row flexbox-container">
    <div class="col-xl-8 col-10 d-flex justify-content-center">
        <div class="card bg-authentication rounded-0 mb-0">
            <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                    <img src="{{asset('/images/pages/register.jpg')}}" alt="branding logo">
                </div>
                <div class="col-lg-6 col-12 p-0">
                    <div class="card rounded-0 mb-0 p-2">
                        <div class="card-header pt-50 pb-1">
                            <div class="card-title">
                                <h4 class="mb-0">Register</h4>
                            </div>
                        </div>
                        <p class="px-2">
                            Compila il modulo sottostante per creare un nuovo account.
                        </p>
                       
                        <div class="card-content">
                            <div class="card-body pt-0">
                                
                            {{ Form::open(array('route' => 'user.resetpassword_post', 'id'=>'ss_form')) }}
                                <input type="hidden" name="remembertoken" value="{{$token}}" />
                                <?php $arr = ['password','confirmpassword']; ?>
                                @for($i=0; $i<count($arr); $i++)
                                    @if ($errors->first($arr[$i]))
                                    <div class="alert alert-danger" style="padding:5px">                                     
                                           
                                        <p style="font-size:10px;">{{ $errors->first($arr[$i])}}</p>                                       
                                       
                                    </div>
                                    @endif   
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" id="{{$arr[$i]}}" name="{{$arr[$i]}}" placeholder="{{$arr[$i]}}" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="{{$arr[$i]}}">{{$arr[$i]}}</label>
                                    </fieldset>
                                @endfor
                                
                                    <a href="{{route('user.login')}}" class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">Go Back to Login</a>
                                    <button type="submit" class="btn btn-primary float-right btn-inline waves-effect waves-light">Reset</button>
                                {{ Form::close() }}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--/ HTML Markup -->


@endsection
