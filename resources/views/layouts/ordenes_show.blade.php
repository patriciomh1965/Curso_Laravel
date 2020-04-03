@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#tlb_productos').DataTable({   
                responsive: true, 
                language: {
                    "url": rootpath+'/js/lang_datatable_esp.js'
                }
            });
            $('#tlb_traking').DataTable({   
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
            <div class="row">
                <div class="col-lg-12 card border-left-primary shadow h-100 py-2"">
                  <div class="card mb-3">
                    <div class="card-header">Servicio N°{{$ordenes->id_orden}} </div>
                    <div class="card-body">
                        <div class="card col-lg-6">
                                </br>
                                <div class="form-group row">
                                    <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Presupuesto') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->id_presupuesto}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('N°Presupuesto') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->npresupuesto}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->Clientes->cliente}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Sala') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b> {{$ordenes->Sucursales->codigo}} </b></label>
                                </div>
                                <div class="form-group row">
                                        <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}:</label>
                                        <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->Sucursales->direccion}}</b></label>
                                    </div>

                                <div class="form-group row">
                                    <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Solicitante') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->solicitante}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Observacion Cliente') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->observacion_cliente}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label for="requerimiento" class="col-md-4 col-form-label text-md-right">{{ __('Requerimiento') }}:</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->TipoRequerimiento->requerimiento}}</b></label>
                                </div>
                                <div class="form-group row">
                                    <label for="asignado" class="col-md-4 col-form-label text-md-right">{{ __('Asignado:') }}</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>
                                    @if(isset($ordenes->id_user_asignado)){{$ordenes->UsuariosAsignados->name}} {{$ordenes->UsuariosAsignados->lastname}} @endif</b></label>
                                </div>

                                <div class="form-group row">
                                    <label for="observacion" class="col-md-4 col-form-label text-md-right">{{ __('Observacion:') }}</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->observacion}}</b></label>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_estimada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Solicitud:') }}</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{substr($ordenes->fecha_estimada,0,10)}}</b></label>
                                </div>

                                 <div class="form-group row">
                                    <label for="fecha_estimada" class="col-md-4 col-form-label text-md-right">{{ __('Estado:') }}</label>
                                    <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->Estados->estado}}</b></label>
                                </div>
                         </div>
                        <br/><hr><br/>
                        <h5>Detalle Productos</h5>
                        <br/><hr><br/>

                        <table id="tlb_productos" name="tlb_productos" class="table table-striped table-hover dataTable no-footer dtr-inline">
                             <thead class="thead-dark">
                             <tr>
                               <th>Código</th>
                               <th>Categoria</th>
                               <th>Producto</th>
                               <th>Descripcion</th>
                               <th>Cantidad</th>
                             </tr>
                             </thead>
                             <tbody id="tlb_detalle">
                                 @if(isset($ordenesdetalle)) 
                                     @foreach($ordenesdetalle as $data)
                                     <tr id="tr_{{$data->id_producto}}">
                                         <td>{{$data->Productos->codigo}}</td>
                                         <td>{{$data->Productos->Categorias->nombre}}</td>
                                         <td>{{$data->Productos->producto}}</td>
                                         <td><small>{{$data->Productos->descripcion}}</small></td>
                                         <td>{{$data->cantidad}}</td>
                                     </tr>
                                     @endforeach
                                 @endif
                             </tbody>
                         </table>
                        <br/><hr><br/>
                        <h5>Tracking Orden</h5>
                        <br/><hr><br/>
                        <table id="tlb_traking" name="tlb_traking" class="table table-striped table-hover dataTable no-footer dtr-inline">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Comentarios</th>
                                    <th>Archivos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($bitacoras))
                                    @foreach($bitacoras as $data)
                                    <tr>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->Usuarios->name}}</td>
                                        <td>{{$data->Estados->estado}}</td>
                                        <td>@if($data->id_comentario==10) {{$data->observacion}} @else {{$data->Comentarios->comentario}} @endif</td>
                                        <td>
                                            @if(strlen($data->archivo)>5)
                                                <form action="{{url('ordenes/archivo/'.$data->id_bitacora)}}" method="GET">
                                                    <button type="submit" class="btn btn-success btn-xs">Descargar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer small text-muted"> 
                        <div class="col-md-6 offset-md-4">                               
                            <a class="ajax-link" href="{{url('ordenes/list')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver a Ordenes</button></a>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
    </div>
</div>

@endsection
