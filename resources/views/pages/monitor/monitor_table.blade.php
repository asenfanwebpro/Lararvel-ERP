
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - Vuesax HTML Laravel admin dashboard template</title>
        <link rel="shortcut icon" type="image/x-icon" href="../images/logo/favicon.ico">

        {{-- Include core + vendor Styles --}}
        @include('panels/styles')
       

    </head>

    {{-- {!! Helper::applClasses() !!} --}}
    @php 
    $configData = Helper::applClasses();
    @endphp
    
    <body class="vertical-layout vertical-menu-modern 1-column blank-page {{ $configData['bodyClass'] }} {{ $configData['theme'] }}" data-menu="vertical-menu-modern" data-col="1-column">

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-body">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" >
                        <div id="bgdiv" class="carousel-inner">
                        @if(isset($bgs) && count($bgs)>0)
                            @foreach($bgs as $value)
                            <div class="carousel-item " data-interval="10000">
                                <img src='{{asset("uploads/departure/".$value->picturename)}}' class="d-block w-100" >
                            </div>  
                            @endforeach
                        @endif                     
                        </div>                       
                    </div>
                    <div id="content">
                        <div class="col-md-6 left" style="padding-left:0">                   
                            <br>
                            @if(isset($data1) && count($data1)>0)
                                <div class="box content">
                                    <div class="tratta" align="center"> Per {{ucfirst($port1)}} </div>
                                </div>
                                <br>
                                @foreach($data1 as $key => $value)
                                
                                <div class="box title" align="left">
                                    <b>&nbsp;&nbsp; 
                                        <span style="font-size:26px">{{substr($value->time,0,5)}}</span> 
                                    </b> 
                                    <span style="font-size:18px">{{$tag1[$key]}}</span>  
                                    <span clss="" style="float:right; font-size:18px">{{$many1[$key]}}</span>
                                </div>
                                <hr>
                                @endforeach
                            @else
                                <div>&nbsp;&nbsp;</div>
                            @endif
                           
                        </div>
                        <div class="col-md-6 left" style="padding-right:0">                   
                            <br>
                            @if(isset($data2) && count($data2)>0)
                                <div class="box content">
                                    <div class="tratta" align="center"> Per {{ucfirst($port2)}} </div>
                                </div>
                                <br>
                                @foreach($data2 as $key => $value)
                               
                                <div class="box title" align="left">
                                    <b>&nbsp;&nbsp; 
                                        <span style="font-size:26px">{{substr($value->time,0,5)}}</span> 
                                    </b> 
                                    <span style="font-size:18px">{{$tag2[$key]}}</span>  
                                    <span clss="" style="float:right; font-size:18px">{{$many2[$key]}}</span>
                                </div>
                                <hr>
                                @endforeach
                            @else
                                <div>&nbsp;&nbsp;</div>
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::open(array('id'=>'ss_form')) }}
            {{ Form::close() }}
        </div>
         <script>
            $("#carouselExampleFade .carousel-item:first-child").addClass("active");
            setInterval(() => {
                document.location = '../../../monitor/table/{{$port1}}/{{$port2}}';
            }, 300000);
            
         </script>  
        <!-- End: Content-->
        <style type="text/css">
            #carouselExampleFade{
                position:fixed;
                left:0;
                top:0;
                width:100%;
                z-index:0;
            }
            #carouselExampleFade img{               
                height: 100vh; /* For 100% screen height */
                width:  100vw;
            }
            .left{
                float:left;
            }
            .box {
                /* width: 60% !important; */
                background-color: #00204a !important;
                color: #fff;
                /* margin-top: -2em !important; */
                opacity: 0.8;
            }
            .tratta {
                font-size: 4em;
                font-weight: bold;
                margin-top: -10px;
            }
            .title {
                font-size: 25px;
                margin: 0px;
                padding: 5px;
            }
            hr {
                border-top: 1px solid #8c8b8b;
                margin: 0;
            }
        </style>
        {{-- include default scripts --}}
        @include('panels/scripts')

    </body>
</html>
