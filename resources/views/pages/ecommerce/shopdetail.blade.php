@extends('layouts/contentLayoutMaster')

@section('title', 'Negozio')

@section('content')
<div class="ecommerce-application"> 
    
        <div class="content-body">
            <!-- app ecommerce details start -->
            <section class="app-ecommerce-details">
                <div class="card">
                    <div class="card-body">
                        @if(!empty($product))
                        <div class="row mb-5 mt-2">
                            <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{asset('uploads/product/'.$product->image)}}" class="img-fluid" alt="product image">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <a style="float:right;margin-bottom: 30px;" href="{{route('mandati.register')}}" class="btn btn-warning mr-1"><i class="feather icon-star"></i>Visualizza Carrello</a>
                                <h5>{{$product->brand}} - {{$product->product}}
                                </h5>
                                <hr>
                                <div class="ecommerce-details-price d-flex flex-wrap">

                                    <p class="text-primary font-medium-3 mr-1 mb-0">${{number_format($product->cost, 2, '.', '')}}</p>
                                    
                                </div>
                                <hr>
                                <p>{{$product->productdescription}}</p>                               
                                <hr>                                
                                <div class="d-flex flex-column flex-sm-row">
                                    <button class="btn btn-primary mr-0 mr-sm-1 mb-1 mb-sm-0"><i class="feather icon-shopping-cart mr-25"></i>ADD TO CART</button>
                                    
                                </div>
                               
                            </div>
                        </div>
                        @endif
                    </div>                    
                </div>
            </section>
            {{ Form::open(array('id'=>'ss_form', 'method'=>'post')) }}
                <input type="hidden" id="orderid" value="{{$orderid}}">
                <input type="hidden" id="productid" value="{{$productid}}">
            {{ Form::close() }}
            <!-- app ecommerce details end -->

        </div>
   
</div>
@endsection