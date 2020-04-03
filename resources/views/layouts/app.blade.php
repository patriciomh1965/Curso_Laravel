<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Llama') }}</title>
    <link href="{{ URL::asset('sb/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('sb/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('sb/css/sb-admin.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/datetimepicker.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/dataTable_1.10.15.css')}}"  rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/dataTable_responsive_1.10.15.css')}}"  rel="stylesheet" type="text/css">

    <script src="{{ asset('sb/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('sb/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('sb/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('sb/js/sb-admin.min.js')}}"></script>
    <!--datime-->
     <script src="{{ asset('js/jquery.datetimepicker.js')}}"></script>
    <!-- Data Table -->
    <script type="text/javascript" src="{{ asset('js/dataTables.js')}}"></script>   
    <script type="text/javascript" src="{{ asset('js/dataTables.responsive.min.js')}}"></script>   
    <script type="text/javascript">
        var rootpath = '{{URL::to('')}}'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
    </script>
    @stack('js')
</head>
<body id="page-top">
    @include('modal.modals')
    <nav class="navbar navbar-expand navbar-dark bg-danger static-top">
      @guest
        <a class="navbar-brand mr-1" href="#">Llama</a>
      @else
        <a class="navbar-brand mr-1" href="#"><img src="{{ URL::asset('sb/logo03.png')}}"  /></a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
           <i class="fas fa-bars"></i>
        </button>
      @endif
    </nav>
    <div id="wrapper">
      <ul class="sidebar navbar-nav">
        @guest
        @else
            @if (Auth::user()->id_perfil == env('PERFIL_ADMIN'))
                <li class="nav-item active"><a class="nav-link" href="{{ url('home') }}"><i class="fas fa-fw fa-tachometer-alt"></i><span> Home</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('perfiles') }}"><i class="fas fa-fw fa-wrench"></i><span> Perfil</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('usuarios') }}"><i class="fas fa-fw fa-user"></i><span> Usuarios</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('clientes') }}"><i class="fas fa-fw fa-table"></i><span> Clientes</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('sucursales') }}"><i class="fas fa-fw fa-bell"></i><span> Salas</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('categorias') }}"><i class="fas fa-fw fa-list"></i><span> Categorias</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('productos') }}"><i class="fas fa-fw fa-cog"></i><span> Stock en Bodega</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('movproductos') }}"><i class="fas fa-fw fa-cogs"></i><span> Ingreso Productos</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('ordenes') }}"><i class="fas fa-fw fa-table"></i><span> Generar Ordenes</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('ordenes/list') }}"><i class="fas fa-fw fa-clipboard-list"></i><span> Ver Ordenes</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('clientepresupuesto') }}"><i class="fas fa-fw fa-dollar-sign"></i><span>Presupuestos</span></a></li>
            @endif
            @if (Auth::user()->id_perfil == env('PERFIL_BODEGA'))
                <li class="nav-item active"><a class="nav-link" href="{{ url('productos') }}"><i class="fas fa-fw fa-cog"></i><span>Stock en Bodega</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('movproductos') }}"><i class="fas fa-fw fa-cogs"></i><span> Ingreso Productos</span></a></li>
            @endif
            @if (Auth::user()->id_perfil == env('PERFIL_ORDEN'))
                <li class="nav-item active"><a class="nav-link" href="{{ url('ordenes') }}"><i class="fas fa-fw fa-table"></i><span> Generar Servicio</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('clientepresupuesto') }}"><i class="fas fa-fw fa-dollar-sign"></i><span>Presupuestos</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('ordenes/list') }}"><i class="fas fa-fw fa-clipboard-list"></i><span> Editar Ordenes</span></a></li>
            @endif
            @if (Auth::user()->id_perfil == env('PERFIL_CLIENTE'))
                <li class="nav-item active">
                </br>
                    <div id="divcarousel01" class="carousel slide col-md-12" data-ride="carousel">
                       <div class="carousel-inner">
                        @php($aux=0)
                        @foreach(Auth::user()->GetClienteUser() as $data)
                            <div class="carousel-item @if($aux==0)active @endif">
                               @php($aux=1)
                               <img class="img-profile rounded-circle" src="{{ asset('images')}}/clientes/{{$data->imagen}}" class="d-block w-100" alt="..." width="90%">
                            </div>
                        @endforeach            
                       </div>
                    </div> 
                </li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('clienteproductos') }}"><i class="fas fa-fw fa-table"></i> <span> Productos</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('clientepresupuesto') }}"><i class="fas fa-fw fa-dollar-sign"></i> <span> Presupuestos</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="{{ url('ordenes/list') }}"><i class="fas fa-fw fa-clipboard-list"></i><span> Ver Ordenes</span></a></li>
            @endif
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-fw fa-sign-out-alt"></i> {{ __('Salir') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </li>                           
        @endif
      </ul>
      <div id="content-wrapper">
            @yield('content')

            <footer class="sticky-footer">
              <div class="container my-auto">
                  
              </div>    
            </footer>
        </div>
    </div>
</body>
</html>