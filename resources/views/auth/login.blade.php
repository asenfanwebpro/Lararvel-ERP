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
                                <h4 class="mb-0">Login</h4>
                            </div>
                        </div>
                        <p class="px-2">Compila il modulo per accedere.</p>
                        @if(session('errors'))
                            <div class="alert alert-danger">                                   
                                <p>{{session('errors')->first('msg')}}</p>                        
                            </div>
                        @endif
                        <div class="card-content">
                            <div class="card-body pt-0">
                                
                                {{ Form::open(array('route' => 'user.login_post')) }}
                                

                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required="" value=''>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="email">email</label>
                                    </fieldset>
                              
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="password" required="" value=''>
                                        <div class="form-control-position">
                                            <i class="feather icon-unlock"></i>
                                        </div>
                                        <label for="password">password</label>
                                    </fieldset>
                                    <div class="form-group d-flex justify-content-between align-items-center">
                                        <div class="text-left">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="rememberme">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">Remember me</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="text-right"><a href="{{route('user.forgotpassword')}}" class="card-link">Forgot Password?</a></div>
                                    </div>
                                    <a href="{{route('user.register')}}" class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">Register</a>
                                    <button type="submit" class="btn btn-primary float-right btn-inline waves-effect waves-light">Login</button>
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
