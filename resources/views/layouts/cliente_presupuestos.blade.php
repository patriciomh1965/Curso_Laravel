@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#tlb_cabezera').DataTable({   
                responsive: true, 
                language: {
                     "url": rootpath+'/js/lang_datatable_esp.js'
                }
            });
            $('#btnrespajax').click(function(e) {
                location.reload(true);
            });
            $('#btn_presupuesto_autorizar').click(function(e) {
                $("#btn_presupuesto_autorizar").attr("disabled", true); 
                var data = new FormData($('#form_presupuesto_confirmar')[0]);
                $.ajax({
                    url: rootpath+'/clientepresupuesto/autorizar',
                    type: "POST",
                    data: data, 
                    contentType: false,
                    processData: false,
                    cache : false, 
                    beforeSend: function() {
                       $('#modal_presupuesto_confirmar').modal('hide');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                        $("#btn_presupuesto_autorizar").attr("disabled", false);  
                        $('#palert').html(thrownError); 
                        $('#modal_alert').modal('show');
                    },
                    complete : function(){
                        $("#btn_presupuesto_autorizar").attr("disabled", false);  
                    },success : function(response){
                        $('#p_alert_ajax').html(response.message); 
                        $('#modal_resp_ajax').modal('show');
                    }   
                });
            });
        });
        function actualizar(id){
          $('#id_presupuesto_autorizar').val(id);
          $('#modal_presupuesto_confirmar').modal('show');
        }
    </script>
@endpush
<div id="content-wrapper">
    <div class="container-fluid">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Presupuesto</li>
            </ol>
        </nav>

              <form action="{{url('clientepresupuesto/create')}}" method="GET">
                <button type="submit" class="btn btn-success">Nuevo Presupuesto</button>
              </form>
                <table id="tlb_cabezera" name="tlb_cabezera" class="table table-striped table-hover" id="dataTable" >
                  <thead class="thead-dark">
                    <tr>
                      <th>Código</th>
                      <th>N° Presupuesto</th>
                      <th>Fecha</th> 
                      <th>Cliente</th>
                      <th>Sala</th>
                      <th>Dirección</th>
                      <th>Estado</th>
                      <th>-</th>
                      @if (Auth::user()->id_perfil == env('PERFIL_ADMIN') or Auth::user()->id_perfil == env('PERFIL_ORDEN'))
                        <th>-</th>
                        <th>-</th>
                      @else
                        <th>Autorizar</th>
                      @endif
                    </tr>
                    </thead>
                    <tbody id="tlb_detalle">
                         @if(isset($presupuestos))
                            @foreach($presupuestos as $data)
                            <tr>
                                <td>{{$data->id_presupuesto}}</td>
                                <td>{{$data->npresupuesto}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->Clientes->cliente}}</td>
                                <td>{{$data->Sucursales->codigo}}</td>
                                <td>{{$data->Sucursales->direccion}}</td>
                                <td>{{$data->Estados->estado}}</td>
                                <td>
                                    <form action="{{url('clientepresupuesto/'.$data->id_presupuesto)}}" method="GET">
                                        <button type="submit" class="btn btn-success btn-xs">Ver</button>
                                    </form>
                                </td>
                                @if (Auth::user()->id_perfil == env('PERFIL_ADMIN') or Auth::user()->id_perfil == env('PERFIL_ORDEN'))
                                  
                                  <td>
                                      @if ($data->id_estado == 1 or $data->id_estado == 5 or $data->id_estado == 6)
                                      @else
                                      <form action="{{url('clientepresupuesto/'.$data->id_presupuesto.'/edit')}}" method="GET">
                                          <button type="submit" class="btn btn-success btn-xs">Editar</button>
                                      </form>
                                      @endif
                                  </td>
                                  <td>
                                      @if ($data->id_estado == 1 or $data->id_estado == 5 or $data->id_estado == 6)
                                      @else
                                      <form action="{{url('clientepresupuesto/actualizar/'.$data->id_presupuesto)}}" method="GET">
                                        <button type="submit" class="btn btn-success btn-xs">Estado</button>
                                      </form>
                                      @endif
                                  </td>
                                @else
                                   <td>
                                      @if ($data->id_estado == 1)
                                        <button type="button" class="btn btn-success btn-xs" onclick="actualizar({{$data->id_presupuesto}})">Autorizar</button>
                                      @endif
                                  </td>
                                @endif 
                            </tr>
                          @endforeach
                        @endif
                    </tbody>
                </table>


    </div>
</div>


@endsection
