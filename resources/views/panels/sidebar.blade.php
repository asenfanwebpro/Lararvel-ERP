<?php 
    use App\Models\Societa;
    $company = Societa::all();
?>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{route('dashboard')}}">
                    <div class="brand-logo" style="background: url({{asset('images/logo/vuesax-logo.png')}}) no-repeat !important;background-position: -65px -54px !important;height: 24px;width: 35px;"> </div>
                    <h2 class="brand-text mb-0">Medmar</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            
            <li id="dashboard" data-menu="" class="nav-item"><a class="nav-item " href="{{route('dashboard')}}" data-toggle="dropdown" ><i class="feather icon-home"></i>Dashboard </a></li>
            
            <!-- SOCIETA & FORNITORI (SUPPLIER) -->
            @if(strpos(Session()->get('role'), 'societa_read') > 0)
            <li id="societa" class="nav-item">
                <a href=""><i class="fa fa-building-o fa-2x"></i><span class="menu-title">Societa</span></a>
                <ul class="menu-content" style="">
                    @if(strpos(Session()->get('role'), 'societalist_read') > 0)
                    <li id="societar" class="nav-item"><a href="{{route('societa.view')}}"><i class="feather icon-circle"></i><span class="menu-item" >Societa</span></a></li> 
                    @endif
                    @if(strpos(Session()->get('role'), 'fornitori_read') > 0)
                    <li id="fornitori" class="nav-item"><a href="{{route('fornitori.view')}}"><i class="feather icon-circle"></i><span class="menu-item" >Fornitori</span></a></li> 
                    @endif
                </ul>
            </li>
            @endif
            
            <!-- PROTOCOLLI -->
            @if(strpos(Session()->get('role'), 'protocolli_read') > 0)
            <li id="protocoll" class="nav-item"><a href=""><i class="feather icon-share-2"></i><span class="menu-title">Protocolli</span></a>
                <ul class="menu-content" style="">
                    @foreach($company as $value)
                    <li id="protocoll_li{{$value->id}}" class="nav-item"><a href="{{route('protocol.view', $value->id)}}"><i class="feather icon-circle"></i><span class="menu-item" >{{$value->ragione_sociale}}</span></a></li>
                    @endforeach                    
                </ul>
            </li>
            @endif
            <!-- MANDATI -->
            @if(strpos(Session()->get('role'), 'mandati_read') > 0)
            <li id="mandati" data-menu="" class="nav-item"><a class="nav-item " href="{{route('mandati.view')}}" data-toggle="dropdown" ><i class="fa fa-usd"></i><span class="menu-item">Mandati</span></a></li>
            @endif
            <!-- MONITOR -->
            @if(strpos(Session()->get('role'), 'monitor_read') > 0)
            <li id="departure" class="nav-item">
                <a href=""><i class="fa fa-tv fa-2x"></i><span class="menu-title">Monitor</span></a>
                <ul class="menu-content">
                    <li id="departureship" class="nav-item"><a href="{{route('departure.ship')}}"><i class="feather icon-circle"></i><span class="menu-item" >Navi</span></a></li>
                    <li id="departureport" class="nav-item"><a href="{{route('departure.port')}}"><i class="feather icon-circle"></i><span class="menu-item" >Porti</span></a></li> 
                    <li id="departuretime" class="nav-item"><a href="{{route('departure.time')}}"><i class="feather icon-circle"></i><span class="menu-item" >Orari</span></a></li> 
                    <li id="departureadvertise" class="nav-item"><a href="{{route('departure.nota')}}"><i class="feather icon-circle"></i><span class="menu-item" >Note</span></a></li> 
                    <li id="departurebackground" class="nav-item"><a href="{{route('departure.background')}}"><i class="feather icon-circle"></i><span class="menu-item" >Sfondo</span></a></li> 
                    <li id="departurebackground" class="nav-item"><a href="{{route('monitor.biglietteria', 'ischia')}}" target="_blank" ><i class="feather icon-circle"></i><span class="menu-item" >View Biglietteria</span></a></li> 
                    <li id="departurebackground" class="nav-item"><a href="{{route('monitor.table', ['pozzuoli', 'napoli'] )}}" target="_blank" ><i class="feather icon-circle"></i><span class="menu-item" >View Table</span></a></li>      
                </ul>
            </li>
            @endif
            <!-- SETTINGS -->
            @if(strpos(Session()->get('role'), 'impostazioni_read') > 0)
            <li id="protocolsettings" class=" nav-item"><a href="#"><i class="fa fa-cog fa-2x"></i><span class="menu-title" data-i18n="Menu Levels">Impostazioni</span></a>
                <ul class="menu-content">
                    <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">Variabili</span></a></li>
                    @if(strpos(Session()->get('role'), 'protocollo_read') > 0)
                    <li  class="nav-item"><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">Protocollo</span></a>
                        <ul class="menu-content">
                            <li id="protocollo"><a href="{{route('protocolsettings.view')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">Sezioni</span></a></li>
                            <li id="formbuilder"><a href="{{route('protocolform.register')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">Forms</span></a></li>
                        </ul>
                    </li>
                    @endif
                    <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">Monitor</span></a>
                        <ul class="menu-content">
                            
                        </ul>
                    </li>
                </ul>
            </li>
            @endif
            @if(strpos(Session()->get('role'), 'ecommerce_read') > 0)
            <li id="ecommerce" class="nav-item">
                <a href="">
                    <i class="fa fa-shopping-basket"></i>
                    <span class="menu-title">Ecommerce</span>                    
                </a>
                <ul class="menu-content" style="">
                    @if(strpos(Session()->get('role'), 'categoria_read') > 0)
                    <li id="category" class="nav-item">
                        <a href="{{route('ecommerce.category')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Categoria</span>
                        </a>
                    </li> 
                    @endif
                    @if(strpos(Session()->get('role'), 'marca_read') > 0)
                    <li id="brand" class="nav-item">
                        <a href="{{route('ecommerce.brand')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Marca</span>
                        </a>
                    </li> 
                    @endif
                    @if(strpos(Session()->get('role'), 'prodotto_read') > 0)
                    <li id="product" class="nav-item">
                        <a href="{{route('ecommerce.product')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Prodotto</span>
                        </a>
                    </li>
                    @endif
                    @if(strpos(Session()->get('role'), 'ordine_read') > 0) 
                    <li id="order" class="nav-item">
                        <a href="{{route('ecommerce.order')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Ordine</span>
                        </a>
                    </li>                                   
                    @endif
                </ul>
            </li>
            @endif
            @if(strpos(Session()->get('role'), 'utente_read') > 0)
            <li id="permission" class="nav-item">
                <a href="">
                    <i class="fa fa-user"></i>
                    <span class="menu-title">Utente</span>                    
                </a>
                <ul class="menu-content" style="">
                    @if(strpos(Session()->get('role'), 'groupp_read') > 0)
                    <li id="usergroup" class="nav-item">
                        <a href="{{route('permission.group')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Groupp</span>
                        </a>
                    </li>
                    @endif
                    @if(strpos(Session()->get('role'), 'lista_read') > 0)
                    <li id="userlist" class="nav-item">
                        <a href="{{route('permission.list')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" >Lista</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

<style type="text/css">
    .brand-logo{
        /*
        background:url('./images/logo/logoMeD1.jpg') no-repeat !important;
        */
        background:url('./images/logo/vuesax-logo.png') no-repeat !important;
        background-position: -65px -54px !important;
        height: 24px;
        width: 35px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){              
        $(".nav-item").removeClass('active');
        $(".nav-item").removeClass('open');
        $("#{{$page}}").addClass('active');
        $("#{{$page}}").addClass('open');
        @if(isset($subpage))
        $("#{{$subpage}}").addClass('active');
        @endif
    })
</script>