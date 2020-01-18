<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Order')

@section('content')


<div class="content-body">
    
    <!-- invoice functionality start -->
    <section class="invoice-print mb-1">
        <div class="row">

            

            <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                <button class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light" onclick="dataprint();" > <i class="feather icon-file-text"></i> Print</button>
                <button class="btn btn-outline-primary  ml-0 ml-md-1 waves-effect waves-light"> <i class="feather icon-download"></i> Download</button>
                <a href="{{route('ecommerce.order')}}" class="btn btn-primary  ml-0 ml-md-1 waves-effect waves-light"> OrderList</a>
            </div>

        </div>
    </section>
    <!-- invoice functionality end -->

    <!-- invoice page -->
    <section class="card" id="printcontent" >
        <div id="invoice-template" class="card-body" style="padding-bottom:100px">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-sm-6 col-12 text-left pt-1">
                    <div class="media pt-1">
                        <img src="{{ asset('uploads/logo/'.$order->companylogo) }}" style="max-height: 100px;"> 
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h1>Order {{$order->anno}}.{{$order->no}}</h1>
                    <div class="invoice-details mt-2">
                        Emesso il: {{$order->createdate}}
                    </div>
                </div>
            </div>
            
            <hr />
           
            <div class="row">
                <div class="col-4 " ></div>
                <div class="col-8 " >
                    <div class="company-info">
                        
                        <dl class="row">
                            <dt class="col text-right">
                                <h5>{{$order->suppliername}}</h5><br />
                                
                            </dt>
                            <dd class="col-3">
                                <img src="{{ asset('uploads/logo/'.$order->supplierlogo) }}" width="100%" class="pull-right" style="margin:0; " >
                            </dd>
                        </dl>
                        
                    </div>
                </div>
            </div>

            <div id="" class="pt-0">
                <div class="row">
                    <div class="table-responsive col-12">
                        
                        <!--START TABLE -->
                        <h3>Products</h3>
                        <div class="xtable-responsive">
                            <table class="table table-hover-animation table-striped">
                                <thead >
                                    <tr>
                                        <th>Product</th>
                                        <th>Unit</th>
                                        <th>Amount</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($products) && !empty($products))
                                    <?php $total = 0; ?>
                                    @foreach($products as $value)
                                    <?php $total +=  $value->cost * $value->amount; ?>                    
                                        <tr class="invoicerow" id="invoicerow{{$value->id}}">
                                            <td>{{$value->product}}</td>
                                            <td>{{$value->cost}}</td>
                                            <td>{{$value->amount}}</td>
                                            <td>{{$value->brand}}</td>
                                            <td>{{$value->category}}</td>
                                            <td>{{$value->payment}}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan='3' style="text-align:right">Total</td>
                                            <td colspan='3' style="text-align:center">{{$total}}</td>
                                        </tr>
                                @endif
                                
                                </tbody>
                            </table>        
                        </div>  
                        <!--END TABLE -->

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- invoice page end -->

</div>
<!--/ Description -->
@endsection


<script type='text/javascript'> 
    function dataprint(){
        var printContents = document.getElementById('printcontent').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<style type="text/css">
.row{
    font-size: 16px;
    color: #000;
}

</style>