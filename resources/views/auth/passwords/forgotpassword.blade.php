<!-- Description -->
@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('pageStyle')

    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">

@endsection

@section('content')

<section class="row flexbox-container">
                    <div class="col-xl-7 col-md-9 col-10 d-flex justify-content-center px-0">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                                    <img src="{{asset('images/pages/forgot-password.png')}}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2 py-1">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Recupera la tua password</h4>
                                            </div>
                                        </div>
                                        <p class="px-2 mb-0">Inserisci il tuo indirizzo e-mail e ti invieremo le istruzioni su come reimpostare la password</p>
                                        <div class="card-content">
                                            <div class="card-body">
                                            @if(isset($msg))
                                            <div class="alert alert-success">                                   
                                                <p>{{$msg}}</p>                        
                                            </div>
                                            @endif
                                            {{ Form::open(array('route' => 'user.forgotpassword_post','method'=>'post', 'id'=>'ss_form')) }}
                                                    <input type="hidden" name="uri" value="{{url('resetpassword')}}" />
                                                    <div class="form-label-group">
                                                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required>
                                                        <label for="inputEmail">Email</label>
                                                    </div>
                                                
                                                    <div class="float-md-left d-block mb-1">
                                                        <a href="{{route('user.login')}}" class="btn btn-outline-primary btn-block px-75 waves-effect waves-light">Back to Login</a>
                                                    </div>
                                                    <div class="float-md-right d-block mb-1">
                                                        <button type="submit" class="btn btn-primary btn-block px-75 waves-effect waves-light">Recupera la password</button>
                                                    </div>
                                            {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
       
@endsection
