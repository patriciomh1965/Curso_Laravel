@extends('layouts.app')
@section('content')
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Detalle Producto </div>
                <div class="card-body">
                    <a class="ajax-link" href="{{url('clienteproductos')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver a Productos</button></a>
                    <hr>
                    <table id="tlb_orden" name="tlb_orden" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ORDEN</th>
                                    <th>FECHA ORDEN</th>
                                    <th>CLIENTE</th>
                                    <th>SUCURSAL</th>
                                    <th>TOTAL PRODUCTOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($getdetalleproductos))
                                    @foreach($getdetalleproductos as $data)
                                    <tr>
                                        <td>{{$data->id_orden}}</td>
                                        <td>{{substr($data->Ordenes->fecha_estimada,0,10)}}</td>
                                        <td>{{$data->Clientes->cliente}}</td>
                                        <td>{{$data->Ordenes->Sucursales->nombre}}</td>
                                        <td>{{$data->cantidad}}</td>
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