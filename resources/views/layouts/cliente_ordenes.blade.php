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
                url: rootpath+'/ordenesdetalle/'+id,
                type: "GET",
                async:false,
                dataType: 'json',  
                beforeSend: function() {
                    $('#tlb_orden_detalle tbody > tr').remove();
                },
                error: function (xhr, ajaxOptions, thrownError) {   
                },
                complete : function(){
                },success : function(response){
                    $.each(response, function(i, item) {
                        $('#tlb_orden_detalle').append("<tr><td>"+item.producto+"</td><td>"+item.categoria+"</td><td>"+item.cantidad+"</td><tr>");
                    });
                    $('#modal_detalle_orden').modal('show');
                }
            });
        }
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ordenes</li>
                </ol>
            </nav>


            <table id="tlb_orden" name="tlb_orden" class="table table-striped table-hover" >
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Presupuesto</th>
                        <th>N°Presupuesto</th>
                        <th>Solicitud</th>
                        <th>Cliente</th>
                        <th>Sala</th>
                        <th>Dirección</th>
                        <th>Cantidad</th>
                        <th>observación</th>
                        <th>Estado</th>
                        <th>Productos</th>
                        @if (Auth::user()->id_perfil == env('PERFIL_ADMIN') or Auth::user()->id_perfil == env('PERFIL_ORDEN'))
                            <th>Editar</th>
                            <th>Actualizar</th>
                            <th>Tracking</th>
                        @endif
                        <th>Ver</th>
                    </tr>
                </thead> 
                <tbody>
                    @if(isset($ordenes))
                        @foreach($ordenes as $data)
                        <tr>
                            <td>{{$data->id_orden}}</td>
                            <td>{{$data->id_presupuesto}}</td>
                            <td>{{$data->npresupuesto}}</td>
                            <td>{{substr($data->fecha_estimada,0,10)}}</td>
                            <td>{{$data->Clientes->cliente}}</td>
                            <td>{{$data->Sucursales->codigo}} </td>
                            <td>{{$data->Sucursales->direccion}} </td>
                            <td>{{$data->totalproductos}}</td>
                            <td><small>{{$data->observacion}}</small></td>
                            <td>{{$data->Estados->estado}}</td>  
                            <td>
                                <button type="submit" class="btn btn-success btn-xs" onclick="getdetalle({{$data->id_orden}})">Ver </button>
                            </td>
                            @if (Auth::user()->id_perfil == env('PERFIL_ADMIN') or Auth::user()->id_perfil == env('PERFIL_ORDEN'))
                            <td>
                                @if ($data->id_estado==1 or $data->id_estado==5 or $data->id_estado==6)
                                @else
                                <form action="{{url('ordenes/'.$data->id_orden.'/edit')}}" method="GET">
                                    <button type="submit" class="btn btn-success btn-xs">Editar</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if ($data->id_estado == 5 or $data->id_estado == 6)
                                @else
                                  <form action="{{url('ordenes/getactualizar/'.$data->id_orden)}}" method="GET">
                                    <button type="submit" class="btn btn-success btn-xs">Actualizar</button>
                                  </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{url('ordenes/tracking/'.$data->id_orden)}}" method="GET">
                                  <button type="submit" class="btn btn-success btn-xs">Tracking</button>
                                </form>
                            </td>
                            @endif 
                            <td>
                                <form action="{{url('ordenes/getorden/'.$data->id_orden)}}" method="GET">
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