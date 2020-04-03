@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#table_productos').DataTable({   
                responsive: true, 
                language: {
                    "url": rootpath+'/js/lang_datatable_esp.js'
                }
            });
        });
        function getimagen(img){
            $('#div_imagen_producto').html("<img src='"+rootpath+"/images/productos/"+img+"' width='100%' height='100%'/>");
            $('#modal_imagen_producto').modal('show');
        }
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Stock en bodega</li>
                        </ol>
                </nav>

                <form action="{{url('productos/create')}}" method="GET">
                    <button type="submit" class="btn btn-success">Nuevo</button>
                </form>
                        <table id="table_productos" name="table_productos" class="table table-striped hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Descripcion</th>
                                    <th>Codigo</th>
                                    <th>Stock Mínimo</th>
                                    <th>Precio</th>
                                    <th>Logo</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Stock</th>
                                    <th>Ver Detalle Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($productos))
                                    @foreach($productos as $data)
                                    <tr>
                                        <td>{{$data->id_producto}}</td>
                                        <td>{{$data->producto}}</td>
                                        <td>{{$data->Categorias->nombre}}</td>
                                        <td>{{$data->descripcion}}</td>
                                        <td>{{$data->codigo}}</td>         
                                        <td>{{$data->min_stock}}</td>
                                        <td>{{$data->precio}}</td>
                                        <td><a onclick="getimagen('{{$data->imagen}}')"><img src="{{asset('images/productos/'.$data->imagen)}}" width="70px" height="60px"  /></a></td>
                                        <td>@if($data->estado) activo @else inactivo @endif</td>  
                                        <td>
                                            <form action="{{url('productos/'.$data->id_producto)}}" method="GET">
                                                <button type="submit" class="btn btn-success btn-xs">Editar</button>
                                            </form>
                                        </td>
                                        <td>{{$data->GetStock($data->id_producto)}}</td>
                                        <td>
                                            <form action="{{url('productos_mov/'.$data->id_producto)}}" method="GET">
                                                <button type="submit" class="btn btn-success btn-xs">Ver</button>
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
