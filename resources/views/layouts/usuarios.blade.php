@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
             $('#table_usuario').DataTable({   
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
                            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                        </ol>
                </nav>

                <form action="{{url('usuarios/create')}}" method="GET">
                    <button type="submit" class="btn btn-success">Nuevo</button>
                </form>


      
                        <table id="table_usuario" name="table_usuario" class="table table-striped hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Perfil</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Roles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($usuarios))
                                    @foreach($usuarios as $data)
                                    <tr>
                                        <td>{{$data->id_user}}</td>
                                        <td>{{$data->Perfiles->perfil}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>@if($data->estado) activo @else inactivo @endif</td>  
                                        <td>
                                            <form action="{{url('usuarios/'.$data->id_user)}}" method="GET">
                                                <button type="submit" class="btn btn-success btn-xs">Editar</button>
                                            </form>
                                        </td>
                                        <td>
                                            @if($data->id_perfil == env('PERFIL_CLIENTE'))
                                            <form action="{{url('usuarios/clientes/'.$data->id_user)}}" method="GET">
                                                <button type="submit" class="btn btn-success btn-xs">Roles</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    
    </div>
</div>
@endsection
