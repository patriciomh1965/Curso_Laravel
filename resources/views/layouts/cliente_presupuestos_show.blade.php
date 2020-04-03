@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#tlb_presupuesto_detalle').DataTable({   
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
            <div class="col-lg-12">
              <div class="card mb-3">
                <div class="card-header">Presupuesto</div>
                <div class="card-body">
                    <br/>
                    @if(isset($presupuesto))
                    <div class="card col-lg-6">
                        <br/>
                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-left">{{ __('Código Presupuesto') }}:</label>
                            <label for="clientes" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->id_presupuesto}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-left">{{ __('N° Presupuesto') }}:</label>
                            <label for="clientes" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->npresupuesto}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-left">{{ __('Clientes') }}:</label>
                            <label for="clientes" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->Clientes->cliente}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="sucursales" class="col-md-4 col-form-label text-md-left">{{ __('Sucursal') }}:</label>
                            <label for="sucursales" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->Sucursales->codigo}} {{ $presupuesto->Sucursales->nombre}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="sucursales" class="col-md-4 col-form-label text-md-left">{{ __('Direccion') }}:</label>
                            <label for="sucursales" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->Sucursales->direccion}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-left">{{ __('Observacion') }}:</label>
                            <label for="observacion" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->observacion }}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-left">{{ __('Total Productos') }}:</label>
                            <label for="observacion" class="col-md-4 col-form-label text-md-left"><b>{{ $presupuesto->totalproductos }}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-left">{{ __('Total') }}:</label>
                            <label for="observacion" class="col-md-4 col-form-label text-md-left"><b>${{ $presupuesto->totalvalor }}</b></label>
                        </div>
                    </div>
                    @endif
                    <br/><hr><br/>
                    <h4>Detalle Presupuesto</h4>
                    <br/><hr><br/>
                        <table id="tlb_presupuesto_detalle" name="tlb_presupuesto_detalle" class="table table-striped table-hover dataTable no-footer dtr-inline">
                            <thead class="thead-dark">
                            <tr>
                              <th>Código Producto</th>
                              <th>Categoría</th>
                              <th>Producto</th>
                              <th>Descripción</th>
                              <th>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody id="tlb_detalle">
                                 @if(isset($presupuestodetalle))
                                    @foreach($presupuestodetalle as $data)
                                        <tr>
                                            <td>{{$data->Productos->codigo}}</td>
                                            <td>{{$data->Productos->Categorias->nombre}}</td>
                                            <td>{{$data->Productos->producto}}</td>
                                            <td>{{$data->Productos->descripcion}}</td>
                                            <td>{{$data->cantidad}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    <br/><hr><br/>
                    <h5>Tracking</h5>
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
                                            <form action="{{url('clientepresupuesto/archivo/'.$data->id_bitacora)}}" method="GET">
                                               <button type="submit" class="btn btn-success btn-xs">Descargar</button>
                                            </form>
                                        @endif
                                     </td>
                                 </tr>
                                 @endforeach
                             @endif
                         </tbody>
                        </table>

                     <br/><hr>
                    <a class="ajax-link" href="{{url('clientepresupuesto')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver a presupuestos</button></a>
                </div>
              </div>
        </div>
    </div>
</div>

@endsection
