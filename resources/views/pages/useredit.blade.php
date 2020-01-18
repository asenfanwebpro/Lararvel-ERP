<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'User Edit')

@section('content')


<section id="row-grouping">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="media mb-2">
                        <a class="mr-2 my-25" href="#">
                            <img src="{{asset('uploads/avatar')}}/{{$data->avatar}}" alt="users avatar" class="users-avatar-shadow rounded" height="90" width="90">
                        </a>
                        <div class="media-body mt-50">
                            <h4 class="media-heading">{{$data->name}} {{$data->lastname}}</h4>
                            
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                    {{ Form::open(array('id'=>'ss_form','method'=>'post','route'=>'permission.saveuser')) }}
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>First Name</label>
                                        <input type="text" name="name" class="form-control" value="{{$data->name}}" required data-validation-required-message="This first name field is required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Last Name</label>
                                        <input type="text" name="lastname" class="form-control" value="{{$data->lastname}}" required data-validation-required-message="This last name field is required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control" value="{{$data->email}}" required data-validation-required-message="This email field is required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php echo ($data->status == 1)?"selected":"" ?> >Active</option>                                        
                                        <option value="0" <?php echo ($data->status == 0)?"selected":"" ?> >Deactivated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="ruolo">
                                        @if(isset($group) && count($group) > 0)
                                        @foreach($group as $value)
                                        <option value="{{$value->id}}" <?php echo ($value->id == $data->ruolo)?"selected":"" ?>>{{$value->group}}</option>  
                                        @endforeach
                                        @endif
                                    </select>
                                </div>                                
                            </div>                                                
                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                <button type="reset" class="btn btn-outline-warning">Reset</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>                       
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
    select.form-control {
        background-image: url('../images/arrow-down.png') !important;   

    }  
</style>
@endsection