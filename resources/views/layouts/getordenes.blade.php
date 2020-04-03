@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#tlb_orden').DataTable({   
                responsive: true, 
                language: {
                   "url": rootpath+'/js/lang_datatable_esp.js'
                }
            });
        });
        function getdetalle(id){
            $.ajax({
                url: rootpath+'/verordenes/'+id,
                type: "GET",
                async:false,
                dataType: 'json',  
                beforeSend: function() {
                },
                error: function (xhr, ajaxOptions, thrownError) {   
                },
                complete : function(){
                },success : function(response){
                    $.each(response, function(i, item) {
                        $('#tlb_orden_detalle').append("<tr><td>"+item.id_producto+"</td><td>"+item.cantidad+"</td><td>$"+item.valor_unitario+"</td><td>$"+item.valor_total+"</td><tr>");
                    });
                    $('#modal_detalle_orden').modal('show');
                }
            });
        }
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Detalle Ordenes</div>
                <div class="card-body">
                    <table id="tlb_orden" name="tlb_orden" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID ORDEN</th>
                                    <th>FECHA ESTIMADA</th>
                                    <th>CLIENTE</th>
                                    <th>SUCURSAL</th>
                                    <th>REGIÓN</th>
                                    <th>CIUDAD</th>
                                    <th>COMUNA</th>
                                    <th>DIRECCIÓN</th>
                                    <th>TOTAL PRODUCTOS</th>
                                    <th>VALOR</th>
                                    <th>OBSERVACIÓN</th>
                                    <th>ESTADO</th>
                                    <th>DETALLE PRODUCTOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($ordenes))
                                    @foreach($ordenes as $data)
                                    <tr>
                                        <td>{{$data->id_orden}}</td>
                                        <td>{{substr($data->fecha_estimada,0,10)}}</td>
                                        <td>{{$data->Clientes->cliente}}</td>
                                        <td>{{$data->Sucursales->Comunas->Ciudades->Regiones->region}}</td>
                                        <td>{{$data->Sucursales->Comunas->Ciudades->ciudad}}</td>
                                        <td>{{$data->Sucursales->Comunas->comuna}}</td>
                                        <td>{{$data->Sucursales->nombre}} @if($data->Sucursales->casa_matriz) <b>(CASA MATRIZ)</b> @endif</td>
                                        <td>{{$data->Sucursales->direccion}}</td>
                                        <td>{{$data->totalproductos}}</td>
                                        <td>{{$data->totalvalor}}</td>
                                        <td><small>{{$data->observacion}}</small></td>
                                        <td>{{$data->Estados->estado}}</td>  
                                        <td>
                                            <button type="submit" class="btn btn-success btn-xs" onclick="getdetalle({{$data->id_orden}})">Ver Detalle</button>
                                        </td>
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