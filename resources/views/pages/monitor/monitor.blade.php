
 
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
                            @else
                            <div>&nbsp;&nbsp;</div>   
                            @endif                        
                        </div>                       
                    </div>
                    <div id="content">
                        <div class="logo">
                            <img src="{{asset('images/logo/logo-medmar.png')}}" height="120" >
                        </div>
                        <input type = 'hidden' id = 'port' value={{$port}}>
                        <?php
                            $gmtTimezone = new DateTimeZone('Europe/Berlin');            
                            $date = new DateTime('',$gmtTimezone);
                            //echo $date->format('H:i');
                        ?>
                        
                        <div class="col-md-3 left" id="portdiv" style="min-height:400px">                   
                            @if(isset($data) && count($data)>0)
                                
                                @foreach($data as $key => $value)
                                <?php if($value->time > $date->format('H:i')){  ?>
                                <div class="box title text-left">
                                    <b>&nbsp;&nbsp;{{substr($value->time,0,5)}}</b>  
                                    <span style="font-size:18px">{{$group[$key]}}</span>
                                    @if($displaydata[$key]['tag'] == 'suspend')
                                    <i class="fa fa-tag danger blink" ></i><b class="suspend text-danger font-medium-2">Sospesa</b>
                                    @endif
                                </div>
                                <?php } ?>
                                @endforeach
                                
                                @foreach($data as $key => $value)
                                <?php if($value->time < $date->format('H:i')){  ?>
                                <div class="box title text-left">
                                    <b>&nbsp;&nbsp;{{substr($value->time,0,5)}}</b>  
                                    <span style="font-size:18px">{{$group[$key]}}</span>
                                    @if($displaydata[$key]['tag'] == 'suspend')
                                    <i class="fa fa-tag danger blink" ></i><b class="suspend text-danger font-medium-2">Sospesa</b>
                                    @endif
                                </div>
                                <?php } ?>
                                @endforeach

                            @else
                            <div>&nbsp;&nbsp;</div>   
                            @endif  
                        </div>
                        <div class="col-md-6 left">
                            <div class="box content text-center">
                        
                                <h3 class="title">PROSSIMA PARTENZA / NEXT DEPARTURE </h3>
                                <div id="portcarousel"  class="carousel slide" data-ride="carousel">
                                    
                                    <!-- Wrapper for slides -->
                                    @if(isset($nexthours) && count($nexthours)>0)
                                        
                                    <div class="carousel-inner" id="nextdiv" style="padding:20px; margin-top:-10px; font-size:35px;">
                                        @foreach($nexthours as $key => $value)
                                        <div class="carousel-item" data-interval="10000">
                                            <div class="tratta text-center">{{$nextports[$key]}}</div>                                
                                            <div class="time text-center ">{{substr($value,0,5)}}<b style="font-size:65px; display:block">{{substr($value,5,strlen($value))}}</b></div>
                                        </div>                                        
                                        @endforeach 
                                    </div>                                   
                                    @endif  
                                    
                                </div>   
                                <div id="notecarousel"  class="carousel slide" data-ride="carousel">

                                    @if(isset($nexthours) && count($nexthours)>0)
                                    <div class="carousel-inner" id="notediv" >
                                        @foreach($nexthours as $key => $value)                            
                                            @if(isset($note[$value]) && count($note[$value])>0)
                                                @foreach($note[$value] as $key => $value1)
                                                <div class="carousel-item" data-interval="4000"><?php echo $value1->text; ?></div>
                                                @endforeach                                            
                                            @endif                               
                                        @endforeach 
                                    </div>                                     
                                    @endif                                                        

                                </div>                 
                            </div>
                            <!-- <div class="boxNews content">
                                <div class="breakingNews bn-bordernone bn-green" id="bn1">
                                    <div class="bn-title" style="width: auto;float:left">
                                        <h2 style="display: inline-block;"> SkyTg24 </h2> <span> </span>
                                    </div>
                                    <ul style="color: rgb(0, 0, 0); left: 144px;"></ul>
                                    <div class="bn-navi">
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-3 left">
                            <div class="box" > 
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                    <h3><b class="white">{{$today}}</b></h3>
                                    
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" id="advdiv" style="padding: 20px; font-size: 18px; margin-top: -10px;">
                                        @if(isset($adv) && count($adv)>0)
                                            @foreach($adv as $key => $value)
                                            <div class="carousel-item" data-interval="11000">
                                                <?php echo $value->text; ?>
                                            </div>
                                            @endforeach
                                            @if(isset($shiparr) && count($shiparr)>0)
                                                @foreach($shiparr as $key => $value)
                                                <div class="carousel-item" data-interval="11000">
                                                    {{$value->group}} <br> {{substr($value->time,0,5)}}<br> <b style="color:red">{{$value->ship}}</b><br><img width='120' height='60' src='{{asset("uploads/departure/".$value->avatar)}}'>
                                                </div>
                                                @endforeach
                                            @endif
                                        @else
                                        <div>&nbsp;&nbsp;</div>   
                                        @endif                                    
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::open(array('id'=>'ss_form')) }}
            {{ Form::close() }}
        </div>
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
            #content{
                position:relative;
                z-index:1;
                text-align:center;
                padding-top:30px;                
            }
            .logo{
                margin-bottom:10px;
            }
            .title {
                font-size: 25px;
                margin: 0px;
                padding: 5px;
                color:#fff;
            }
            .box {
                /* width: 60% !important; */
                background-color: #00204a !important;
                color: #fff;
                /* margin-top: -2em !important; */
                opacity: 0.8;
                margin-bottom:20px;
            }
            .box.content{
                min-height:400px;
            }
            .left{
                float:left;
            }
            .time {
                font-size:7em;
                color: #fff000;
                font-weight: bold;
                margin-top: -30px;
            }
            .tratta {
                font-size: 2em;
                font-weight: bold;
                margin-top: -10px;
            }
            .boxNews {
                /* width: 60% !important; */
                background-color: #00204a !important;
                color: #fff;
                padding: 2px;
            }
            .breakingNews {
                width: 100%;
                height: 40px;
                background: #FFF;
                position: relative;
                border: none;
                overflow: hidden;
            }
            .breakingNews>.bn-title {
                width: auto;
                height: 40px;
                display: inline-block;
                background: #27ae60;
                position: relative;
            }
            .breakingNews>.bn-title>h2 {
                display: inline-block;
                margin: 0;
                padding: 0 20px;
                line-height: 40px;
                font-size: 20px;
                color: #FFF;
                height: 40px;
                box-sizing: border-box;
            }
            .breakingNews>ul {
                padding: 0;
                margin: 0;
                list-style: none;
                position: absolute;
                left: 210px;
                top: 0;
                right: 40px;
                height: 40px;
                font-size: 16px;
            }
            .breakingNews>.bn-navi {
                width: 40px;
                height: 40px;
                position: absolute;
                right: 0;
                top: 0;
                opacity: 0;
                transition: .25s linear;
                -moz-transition: .25s linear;
                -webkit-transition: .25s linear;
            
            }
            h1, h2, h3, h4, h5{
                color:#fff !important;
            }
            
            .blink {
               animation: blinker 1s step-start infinite;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }

        </style>   
        <script type="text/javascript">
            
            $(function() {

                $("#carouselExampleFade .carousel-item:first-child").addClass("active");
                $("#portcarousel .carousel-item:first-child").addClass("active");
                $("#notecarousel .carousel-item:first-child").addClass("active");
                $("#myCarousel .carousel-item:first-child").addClass("active");

                setInterval(() => {
                    document.location = '../../monitor/biglietteria/{{$port}}';
                }, 300000);

            });
             
            
            
        </script>     
        <!-- End: Content-->
        
        {{-- include default scripts --}}
        @include('panels/scripts')

    </body>
</html>
