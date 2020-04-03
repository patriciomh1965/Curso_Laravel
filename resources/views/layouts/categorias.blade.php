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
                    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                </ol>
        </nav>

        <form action="{{url('categorias/create')}}" method="GET">
            <button type="submit" class="btn btn-success">Nuevo</button>
        </form>


        <table id="table_cliente" name="table_cliente" class="table table-striped hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($categorias))
                        @foreach($categorias as $data)
                        <tr>
                            <td>{{$data->id_categoria}}</td>
                            <td>{{$data->nombre}}</td>
                            <td>{{$data->descripcion}}</td>
                            <td>@if($data->estado) activo @else inactivo @endif</td>  
                            <td>
                                <form action="{{url('categorias/'.$data->id_categoria)}}" method="GET">
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
