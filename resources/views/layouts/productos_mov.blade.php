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
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Productos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Movimientos</li>
                        </ol>
                    </nav>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Movimientos Productos </div>
                <div class="card-body">
                    <div>
                        <table id="table_productos" name="table_productos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Codigo Ingreso</th>
                                    <th>Responsable</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Creacion</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data))
                                    @foreach($data as $mov)
                                    <tr>
                                        <td>{{$mov->id_movimiento}}</td>
                                        <td>{{$mov->tipo}}</td>
                                        <td>{{$mov->codigo_ingreso}}</td>
                                        <td>{{$mov->Usuarios->name}}</td>
                                        <td>{{substr($mov->fecha_ingreso,0,10)}}</td>
                                        <td>{{$mov->created_at}}</td>
                                        <td>{{$mov->Productos->producto}}</td>
                                        <td>{{$mov->cantidad}}</td>
                                        <td>${{$mov->precio}}</td>
                                        <td>${{str_replace('-','',($mov->precio * $mov->cantidad)) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection