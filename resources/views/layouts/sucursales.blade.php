@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
             $('#table_sucursal').DataTable({   
                responsive: true, 
                language: {
                   "url": rootpath+'/js/lang_datatable_esp.js'
                }
            }); 
        });
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sala</li>
                        </ol>
                    </nav>

                    <form action="{{url('sucursales/create')}}" method="GET">
                        <button type="submit" class="btn btn-success">Nueva Sala</button>
                    </form>


                    <div class="form-group row col-md-12">
                            <form action="{{url('sucursales/clientes/')}}" method="GET" class="form-inline">
                            <div class="form-group mb-3">
                                <label for="clientes"><b>{{ __('Seleccionar Clientes') }}:</b></label>
                            </div>
                            <div class="form-group mx-sm-3 mb-3">
                                <select class="custom-select form-control{{ $errors->has('clientes') ? ' is-invalid' : '' }}" data-live-search="true" name="clientes" id="clientes" autocomplete="select" >
                                    @if(isset($clientes)) 
                                        @foreach($clientes as $data)
                                           <option value='{{$data->id_cliente}}'>{{$data->cliente}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-3">
                                <button type="submit" class="btn btn-success">Buscar</button>
                            </div>
                            </form>
                    </div>


                    <table id="table_sucursal" name="table_sucursal" class="table table-striped hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Region</th>
                                    <th>Ciudad</th>
                                    <th>Comuna</th>
                                    <th>Direccion</th>
                                    <th>Casa Matriz</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($sucursales))
                                    @foreach($sucursales as $data)
                                    <tr>   
                                        <td>{{$data->id_sucursal}}</td>
                                        <td>{{$data->codigo}}</td>
                                        <td>{{$data->Comunas->Ciudades->Regiones->region}}</td>
                                        <td>{{$data->Comunas->Ciudades->ciudad}}</td>
                                        <td>{{$data->Comunas->comuna}}</td>
                                        <td>{{$data->direccion}}</td>
                                        <td>@if($data->casa_matriz) SI @else NO @endif</td>                             
                                        <td>
                                            <form action="{{url('sucursales/'.$data->id_sucursal)}}" method="GET">
                                                <button type="submit" class="btn btn-success btn-xs">Editar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

    </div>
</div>
@endsection
