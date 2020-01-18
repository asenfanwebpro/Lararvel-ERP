<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Negozio')

@section('content')

<div class="ecommerce-application">      
    <div class="app-content ">        
        <div class="content-detached content-right "></div>
            <div class="content-body">
                
                {{ Form::open(array('id'=>'ss_form','route'=>'ecommerce.checkoutsave','method'=>'post','class'=>'icons-tab-steps checkout-tab-steps wizard-circle')) }}
                    <!-- Checkout Place order starts -->
                    <input type="hidden" id="orderid" name="orderid" value={{$orderid}}>
                    <input type="hidden" id="productids" name="productids" >
                    <input type="hidden" id="amounts" name="amounts" >
                    <h6><i class="step-icon step feather icon-shopping-cart"></i>Cart</h6>
                    <fieldset class="checkout-step-1 px-0">
                        <section id="place-order" class="list-view product-checkout">
                            <div class="checkout-items">
                                @if(isset($products) && count($products)>0)
                                @foreach($products as $product)
                                <div class="card ecommerce-card">
                                    <input type="hidden" class='productid' value="{{$product->productid}}">
                                    <div class="card-content">
                                        <div class="item-img text-center">                                            
                                            <img src="{{asset('uploads/product/'.$product->image)}}" alt="img-placeholder">                                            
                                        </div>
                                        <div class="card-body">
                                            <div class="item-name">
                                                <b>{{ucfirst($product->brand)}} - {{ucfirst($product->product)}}</b>
                                                <span></span>                                               
                                            </div>
                                            <div class="item-quantity">
                                                <p class="quantity-title">Quantity</p>
                                                <div class="input-group quantity-counter-wrapper">
                                                    <input type="text" class="quantity-counter" value="1" onchange="cal_total_cost()">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="item-options text-center">
                                            <div class="item-wrapper">                                                
                                                <div class="item-cost">
                                                    <h6 class="item-price">
                                                        $<i class="unit">{{number_format($product->cost, 2, '.', '')}}</i>
                                                    </h6>
                                                    
                                                </div>
                                            </div>
                                            <div class="wishlist remove-wishlist">
                                                <i class="feather icon-x align-middle"></i> Remove
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="checkout-options">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">                                            
                                            <div class="detail">
                                                <div class="detail-title detail-total">Total</div>
                                                <div id="total_cost" class="detail-amt total-amt"></div>
                                            </div>
                                            <hr>
                                            <div class="btn btn-primary btn-block place-order" onclick="register_product()">PLACE ORDER</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </fieldset>
                    <!-- Checkout Place order Ends -->

                    <!-- Checkout Customer Address Starts -->
                    <h6><i class="step-icon step feather icon-home"></i>Address</h6>
                    <fieldset class="checkout-step-2 px-0">
                        <section id="checkout-address" class="product-checkout">
                            <div class="card">
                                <div class="card-header flex-column align-items-start">
                                    <h4 class="card-title">Add Address</h4>                                    
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-name">Full Name:</label>
                                                    <input type="text" id="checkout-name" class="form-control required" name="fname" value={{(!empty($data)?$data->fname:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-number">Mobile Number:</label>
                                                    <input type="number" id="checkout-number" class="form-control required" name="mnumber" value={{(!empty($data)?$data->mnumber:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-apt-number">Flat, House No:</label>
                                                    <input type="number" id="checkout-apt-number" class="form-control required" name="aptnumber" value={{(!empty($data)?$data->aptnumber:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-landmark">Landmark e.g. near apollo hospital:</label>
                                                    <input type="text" id="checkout-landmark" class="form-control required" name="landmark" value={{(!empty($data)?$data->landmark:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-city">Town/City:</label>
                                                    <input type="text" id="checkout-city" class="form-control required" name="city" value={{(!empty($data)?$data->city:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-pincode">Pincode:</label>
                                                    <input type="number" id="checkout-pincode" class="form-control required" name="pincode" value={{(!empty($data)?$data->pincode:'')}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="checkout-state">State:</label>
                                                    <input type="text" id="checkout-state" class="form-control required" name="state" value={{(!empty($data)?$data->state:'')}}>
                                                </div>
                                            </div>                                           
                                            <div class="col-sm-6 offset-md-6">
                                                <div class="btn btn-primary delivery-address float-right">
                                                    SAVE AND DELIVER HERE
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </section>
                    </fieldset>

                    <!-- Checkout Customer Address Ends -->

                    <!-- Checkout Payment Starts -->
                    <h6><i class="step-icon step feather icon-credit-card"></i>Payment</h6>
                    <fieldset class="checkout-step-3 px-0">
                        <section id="checkout-payment" class="product-checkout">
                            <div class="payment-type">
                                <div class="card">
                                    <div class="card-header flex-column align-items-start">
                                        <h4 class="card-title">Payment options</h4>                                        
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">                                           
                                            <ul class="other-payment-options list-unstyled">
                                                <li>
                                                    <div class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="payment" value="Bonifico" {{(!empty($data) && $data->payment == 'Bonifico')?'checked':''}}>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span>
                                                            Bonifico Bancario
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="payment" value="Assegno" {{(!empty($data) && $data->payment == 'Assegno')?'checked':''}}>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span>
                                                            Assegno
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="payment" value="Sepa" {{(!empty($data) && $data->payment == 'Sepa')?'checked':''}}>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span>
                                                            Sepa
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="payment" value="Riba" {{(!empty($data) && $data->payment == 'Riba')?'checked':''}}>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                                        <span>
                                                            Riba
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <hr>
                                            <button type="submit" class="btn btn-primary btn-cvv ml-50 mb-50 waves-effect waves-light">Save</button type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </section>
                    </fieldset>

                    <!-- Checkout Payment Starts -->
                    {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function cal_total_cost(){
        var total_cost = 0;
        $('.ecommerce-card').each(function(i, obj) {
                        
            var productid = $(obj).find(".productid").val(),
                price = $(obj).find(".unit").html(),
                quantity = $(obj).find(".quantity-counter").val();
                
            total_cost += parseFloat(price)*parseFloat(quantity);
        });
        $("#total_cost").html(total_cost.toPrecision(5));
    }
    function register_product(){
        var productids = [],
            amounts = [];
        $('.ecommerce-card').each(function(i, obj) {
                        
            var productid = $(obj).find(".productid").val(),                
                quantity = $(obj).find(".quantity-counter").val();
                
            productids.push(productid);
            amounts.push(quantity);
        });
        $("#productids").val(productids);
        $("#amounts").val(amounts);        
    }
    $(document).ready(function(){
        cal_total_cost();
    })
    
    
</script>
<style type="text/css">
    select.form-control {
        background-image: url('images/pages/arrow-down.png') !important;   

    } 
</style>
@endsection