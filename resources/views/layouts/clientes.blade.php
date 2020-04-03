@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#table_cliente').DataTable({   
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
                            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                        </ol>
                </nav>

                <form action="{{url('clientes/create')}}" method="GET">
                    <button type="submit" class="btn btn-success">Nuevo</button>
                </form>
      
                        <table id="table_cliente" name="table_cliente" class="table table-striped hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Codigo</th>
                                    <th>Estado</th>
                                    <th>Logo</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($clientes))
                                    @foreach($clientes as $data)
                                    <tr>
                                        <td>{{$data->id_cliente}}</td>
                                        <td>{{$data->cliente}}</td>
                                        <td>{{$data->descripcion}}</td>
                                        <td>{{$data->codigo}}</td>
                                        <td>@if($data->estado) activo @else inactivo @endif</td>  
                                        <td><img src="{{asset('images/clientes/'.$data->imagen)}}" width="70px" height="60px" /></td>
                                        <td>
                                            <form action="{{url('clientes/'.$data->id_cliente)}}" method="GET">
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
