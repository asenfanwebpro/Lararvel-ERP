<!-- Description -->
@extends('layouts/contentLayoutMaster')

@section('title', 'Negozio')

@section('content')

<div id="shop" class="ecommerce-application" >      
            
    <div class="content-detached content-right ">
        <div class="content-body">
            <!-- Ecommerce Content Section Starts -->
            <section id="ecommerce-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ecommerce-header-items">
                            
                            <div class="result-toggler">
                                <button class="navbar-toggler shop-sidebar-toggler" type="button" data-toggle="collapse">
                                    <span class="navbar-toggler-icon d-block d-lg-none"><i class="feather icon-menu"></i></span>
                                </button>
                                <div class="search-results">
                                   <b id="nums">{{$count}}</b> results found
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
            <!-- Ecommerce Content Section Starts -->
            <!-- background Overlay when sidebar is shown  starts-->
            <div class="shop-content-overlay"></div>
            <!-- background Overlay when sidebar is shown  ends-->
            
            <!-- Ecommerce Search Bar Starts -->
            <section id="ecommerce-searchbar">
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <fieldset class="form-group position-relative">
                            <input type="text" class="form-control" id="search_product" placeholder="Search here" onkeyup="search_product()">
                            <div class="form-control-position">
                                <i class="feather icon-search"></i>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </section>
            <!-- Ecommerce Search Bar Ends -->

            <!-- Ecommerce Products Starts -->
            <section id="ecommerce-product" class="grid-view">
            @if(isset($products) && count($products)>0)
            @foreach($products as $key => $product)
                
                <div class="card ecommerce-card">
                    <input type="hidden" class='productid' value="{{$product->productid}}">
                    <div class="card-content">
                        <div class="item-img text-center">
                            <a onclick="show_detail('{{$product->productid}}')">
                                <img class="img-fluid" src="{{asset('uploads/product/'.$product->image)}}" alt="img-placeholder" >
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="item-wrapper">                               
                                <div>
                                    <h6 >
                                        $<i class="item-price" style="top:0">{{number_format($product->cost, 2, '.', '')}}</i> 
                                    </h6>
                                </div>
                            </div>
                            <div class="item-name">
                                <a onclick="show_detail('{{$product->productid}}')">{{ucfirst($product->product) }}</a>
                                <p class="item-company" style="display:block">By <span class="company-name">{{$product->brand}}</span></p>
                                <i class="item-category">{{ucfirst($product->category)}}</i>
                            </div>
                            <div>
                                <p class="item-description">
                                    {{ucfirst($product->productdescription)}}
                                </p>
                            </div>
                        </div>
                        <div  class="item-options text-center">                            
                            <div id='cart{{$product->productid}}' class="cart">
                                <i class="feather icon-shopping-cart"></i> 
                                <span  class="add-to-cart"  <?php echo (array_search($product->productid,$product_arr) !== FALSE)?"style='display: none'":""; ?> >Add to cart</span> 
                                <a class="view-in-cart d-none" <?php echo (array_search($product->productid,$product_arr) !== FALSE)?"style='display: inline !important'":""; ?> >View In Cart</a>
                            </div>
                        </div>
                    </div>
                    <span class="row"></span>
                </div>     
                
            @endforeach
            @endif
            </section>
            <!-- Ecommerce Products Ends -->

            <!-- Ecommerce Pagination Starts -->
            <section >
                <div class="text-center">                    
                    <input type="hidden" id="page1-content" value="0">
                    <ul class="pagination justify-content-center page1-links"></ul>
                </div>
            </section>
            <!-- Ecommerce Pagination Ends -->

        </div>
    </div>
    <div class="sidebar-detached sidebar-left">
        <div class="sidebar">
            <!-- Ecommerce Sidebar Starts -->
            <div class="sidebar-shop" id="ecommerce-sidebar-toggler">

                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                    </div>
                </div>
                <span class="sidebar-close-icon d-block d-md-none">
                    <i class="feather icon-x"></i>
                </span>
                <div class="card">
                    <div class="card-body">
                        
                        <div class="price-slider">
                            <div class="price-slider-title mt-1">
                                <h6 class="filter-title mb-0">Price</h6>
                            </div>
                            <div class="price-slider">
                                <div class="price_slider_amount mb-2">
                                </div>
                                <div class="form-group">
                                    <div class="slider-sm my-1 range-slider" id="price-slider"></div>
                                </div>
                            </div>
                            <div class="price-slider-txt" style="margin-bottom: 50px;">
                                <label style="float:left;"><i id="minprice">0</i>($)</label>
                                <label style="float:right"><i id="maxprice">1000</i>($)</label>
                            </div>
                        </div>
                        <!-- /Price Range -->
                        <hr>
                        <!-- Categories Starts -->
                        <div id="product-categories">
                            <div class="product-category-title">
                                <h6 class="filter-title mb-1">Categories</h6>
                            </div>
                            <ul class="list-unstyled categories-list">
                                <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="category-filter" value="All" onclick="category_product('All')">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">All</span>
                                    </span>
                                </li>
                                @if(isset($categories) && count($categories)>0)
                                @foreach($categories as $category)
                                <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="category-filter" value="{{ucfirst($category->category)}}" onclick="category_product('{{ucfirst($category->category)}}')">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">{{ucfirst($category->category)}}</span>
                                    </span>
                                </li>
                                @endforeach
                                @endif

                            </ul>
                        </div>
                        <!-- Categories Ends -->
                        <hr>
                        <!-- Brands -->
                        <div class="brands">
                            <div class="brand-title mt-1 pb-1">
                                <h6 class="filter-title mb-0">Brands</h6>
                            </div>
                            <div class="brand-list" id="brands">
                                <ul class="list-unstyled">
                                    @if(isset($brands) && count($brands)>0)
                                    @foreach($brands as $brand)
                                    <li class="d-flex justify-content-between align-items-center py-25">
                                        <span class="vs-checkbox-con vs-checkbox-primary">
                                            <input id="{{ucfirst($brand->brand)}}" class="brandchk" type="checkbox" onclick="brand_product('{{ucfirst($brand->brand)}}')">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span >{{ucfirst($brand->brand)}}</span>
                                        </span>
                                       
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        
                        <!-- /Brand -->
                        <hr>
                       
                        <!-- Clear Filters Starts -->
                        <div id="clear-filters">
                            <button class="btn btn-block btn-primary" onclick="clearfilter()">CLEAR ALL FILTERS</button>
                        </div>
                        <!-- Clear Filters Ends -->

                    </div>
                </div>
            </div>
            <!-- Ecommerce Sidebar Ends -->

        </div>
    </div>
    
</div>
<div id="shopdetail" class="ecommerce-application" style="display: none;"> 
    
    <div class="content-body">
        <!-- app ecommerce details start -->
        <section class="app-ecommerce-details">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="productid" >
                    <div class="row mb-5 mt-2">
                        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center">
                                <img id="productimage" src="" class="img-fluid" alt="product image">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <a onclick="show_shop()" style="float:right;" class="btn btn-warning mr-1"><i class="feather icon-star"></i>Visualizza Carrello</a>
                            <h5 id="productname" style="margin-top:70px"></h5>
                            <hr>
                            <div class="ecommerce-details-price d-flex flex-wrap">

                                <p id="productcost" class="text-primary font-medium-3 mr-1 mb-0"></p>
                                
                            </div>
                            <hr>
                            <p id="productdescription"></p>                               
                            <hr>                                
                            <div  class="d-flex flex-column flex-sm-row">
                                <button id="addcart" class="btn btn-primary mr-0 mr-sm-1 mb-1 mb-sm-0"><i class="feather icon-shopping-cart mr-25"></i>ADD TO CART</button>
                                <button id="viewcart" class="btn btn-primary mr-0 mr-sm-1 mb-1 mb-sm-0" style="display:none"><i class="feather icon-shopping-cart mr-25"></i>VIEW CART</button>
                            </div>
                           
                        </div>
                    </div>
                   
                </div>                    
            </div>
        </section>        
    </div>
</div> 
{{ Form::open(array('id'=>'ss_form','route'=>'ecommerce.checkout','method'=>'post')) }}
    <input type="hidden" id="orderid" value="{{(isset($orderid))?$orderid:0}}" name="orderid">
    <input type="hidden" id="productids" name="productids" value="<?php echo implode(',',$product_arr); ?>">       
{{ Form::close() }}
<script>

    var pros = $("#productids").val();
    var productids = (pros != '')?pros.split(','):[];

    var slider = document.getElementById('price-slider');
    noUiSlider.create(slider, {
        start: [0, 1000],
        connect: true,
        tooltips: [true, wNumb({decimals: 0})],
        range: {
            'min': 0,
            'max': 1000
        },
        format: wNumb({
            decimals: 0, // default is 2           
        })
    });

    slider.noUiSlider.on("update",function(){
        $("#minprice").html(slider.noUiSlider.get()[0]);
        $("#maxprice").html(slider.noUiSlider.get()[1]);
        price_product();
    })

    function clearfilter(){
        slider.noUiSlider.reset();
        $("#search_product").val('');
        $(".categories-list li:first-child input").prop("checked", true);
        $(".brandchk").prop("checked", false);
        search_product();
        category_product('All');
        brand_product();
    }   

    $(".ecommerce-card").click(function(e){
        var $this = $(this),
            addToCart = $this.find(".add-to-cart"),
            viewInCart = $this.find(".view-in-cart"),
            productid = $this.find(".productid").val();
        if(e.target.id == 'cart'+productid){
            if (addToCart.is(':visible')) {
                productids.push(productid);
                addToCart.addClass("d-none");
                viewInCart.addClass("d-inline-block");
            } else {
                // var href = viewInCart.attr('href');
                // window.location.href = href;
                checkout();
            }
        }
        
    }) 
    function checkout(){ 
        $("#productids").val(productids);
        $("#ss_form").submit();
    }

    function search_product(){
        var word = $("#search_product").val();
        
        $('.ecommerce-card').each(function(i, obj) {
            $this = $(obj);
            
            var productname = $this.find(".item-name a").html();
            if(productname.indexOf(word) == -1){
                $this.find(".item-name a").css("display","none");
            }
            else{
                $this.find(".item-name a").css("display","");                
            }                      
        })
        display_product();
        
    }
    function price_product(){
        
        var min = $("#minprice").html(), max = $("#maxprice").html();        
        $('.ecommerce-card').each(function(i, obj) {
            $this = $(obj);           
            var price = $this.find(".item-price").html();                      
            if(parseInt(min) <= parseFloat(price) && parseFloat(price) < parseInt(max)){                
                $this.find(".item-price").css("display","");
            }
            else{
                $this.find(".item-price").css("display","none");                
            }                      
        })
        display_product();

    }
    function category_product(category){
        $('.ecommerce-card').each(function(i, obj) {
            $this = $(obj);           
            var item_category = $this.find(".item-category").html();                      
            if(category == item_category || category == 'All'){                
                $this.find(".item-category").css("display","");
            }
            else{
                $this.find(".item-category").css("display","none");                
            }                      
        })
        display_product();
    }
    function brand_product(brand){
        $('.ecommerce-card').each(function(i, obj) {
            $this = $(obj);           
            var item_brand = $this.find(".company-name").html();
            if($("#"+brand).prop("checked") == true){                
                if(brand == item_brand){                
                    $this.find(".company-name").css("display","");
                }
                else{
                    $this.find(".company-name").css("display","none");                
                }  
            }
            else{                
                if(brand != item_brand){                
                    $this.find(".company-name").css("display","");
                }                
            }                      
                                
        })
        display_product();
    }
    

    function display_product(){
        var nums = 0;
        $('.ecommerce-card').each(function(i, obj) {
            $this = $(obj);
            if($this.find(".item-name a").css("display") == "none" || $this.find(".company-name").css("display") == 'none' || $this.find(".item-price").css("display") == 'none' || $this.find(".item-category").css("display") == 'none' || $this.find(".company-name").css("display") == 'none'){
                $this.css("display","none");
                
            }
            else{
                $this.css("display","flex");
                nums++;
                
            }
        })
        
        $("#nums").html(nums);
        pagenation();
    }
    function pagenation(){
        var ff= $("#nums").html();
        $('.page1-links').twbsPagination('destroy');       
        $('.page1-links').twbsPagination({
            totalPages: Math.floor(ff/9)+1,
            visiblePages: 4,
            prev: 'Prev',
            first: null,
            last: null,
            startPage: 1,
            onPageClick: function (event, page) {
                $('#page1-content').val(page);
                $(".pagination").find('li').addClass('page-item');
                $(".pagination").find('a').addClass("page-link");
                var j = 0;
                $('.ecommerce-card').each(function(i, obj) {
                    $this = $(obj);
                    if($this.find(".item-name a").css("display") == "none" || $this.find(".company-name").css("display") == 'none' || $this.find(".item-price").css("display") == 'none' || $this.find(".item-category").css("display") == 'none' || $this.find(".company-name").css("display") == 'none'){
                        
                    }
                    else{
                        if(j >= 9*(page-1) && j < 9*page){
                            $this.css("display","flex");
                        }
                        else{
                            $this.css("display","none");
                        } 
                        j++;                       
                    }
                })
                    
            }
        });
        
    }

    function show_detail(productid){
        $("#shop").css('display','none');
        $("#shopdetail").css('display','');
        $.ajax({
            url: "{{route('ecommerce.productdetail')}}",
            type: 'POST',
            data:{
                    'id' : productid,                                  
                '_token': $("#ss_form input:first-child").val()
            }, 
            success: function(result){ 
                $("#productid").val(result['data']['productid']);
                $("#productname").html(result['data']['brand']+' - '+result['data']['product']);
                $("#productcost").html('$'+result['data']['cost'].toPrecision(5));
                $("#productdescription").html(result['data']['productdescription']);
                $("#productimage").attr('src','{{asset("uploads/product")}}/'+result['data']['image']);
                var id = result['data']['productid'];                
                if(productids.indexOf(id.toString()) != -1){
                    
                    $("#addcart").css('display','none');
                    $("#viewcart").css('display','');
                }
                else{
                    $("#addcart").css('display','');
                    $("#viewcart").css('display','none');
                }
            }
        })
    }
    $("#addcart").click(function(){
        var productid = $("#productid").val();
        productids.push(productid);
        $("#addcart").css('display','none');
        $("#viewcart").css('display','');
    })
    $("#viewcart").click(function(){
        $("#productids").val(productids);
        $("#ss_form").submit();
    })
    function show_shop(){
        $("#shop").css('display','');
        $("#shopdetail").css('display','none');
    }
    
</script>  
<style type="text/css">
    .prev-item .page-link::before {
        content: "\e843";
        font-family: 'feather';
    }
    .next-item .page-link::after {
        content: "\e844";
        font-family: 'feather';
    }
    
</style> 

@endsection