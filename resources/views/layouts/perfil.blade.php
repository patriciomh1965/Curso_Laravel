@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#table_perfil').DataTable({   
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
                    <li class="breadcrumb-item active" aria-current="page">Perfiles</li>
                </ol>
        </nav>

        <form action="{{url('perfiles/create')}}" method="GET">
            <button type="submit" class="btn btn-success">Nuevo</button>
        </form>

        <table id="table_perfil" name="table_perfil" class="table table-striped hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($perfiles))
                        @foreach($perfiles as $data)
                        <tr>
                            <td>{{$data->id_perfil}}</td>
                            <td>{{$data->perfil}}</td>
                            <td>@if($data->estado) activo @else inactivo @endif</td>  
                            <td>
                                <form action="{{url('perfiles/'.$data->id_perfil)}}" method="GET">
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
