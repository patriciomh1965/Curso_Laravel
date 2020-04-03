@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            var getsucursales;
            $('#fecha_solicitud').datetimepicker({lang:'es',timepicker:false,formatDate:'Y-m-d',closeOnDateSelect:true,minDate:0});
            $('#btnrespajax').click(function(e) {
                location.reload(true);
            });
            $('#clientes').change(function(e) {
                if($('#clientes').val() == 0) { 
                    $('#sucursales').empty();
                    $('#asignado').empty();
                    return; 
                }
                $.ajax({
                    url: rootpath+'/clientepresupuesto/sucursales/'+$('#clientes').val(),
                    type: "GET",
                    async:false,
                    dataType: 'json', 
                    beforeSend: function() {
                        $('#sucursales').empty();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                    },
                    complete : function(){
                    },success : function(response){
                        getsucursales=response;
                        $('#sucursales').append('<option value="0">Seleccione</option>');
                        $.each(response, function(i, item) {
                            var casamatriz='';
                            if(item.casa_matriz){ casamatriz='(Casa Matriz)';}  
                            $('#sucursales').append('<option value="'+item.id_sucursal+'">'+item.codigo+'</option>');
                        });
                    }
                });
            });
            $('#sucursales').change(function(e) {
                $.each(getsucursales, function(i, item) {
                    if($('#sucursales').val()==item.id_sucursal)
                    {   
                        $('#lbl_direccion').html(item.direccion);
                        return;
                    }
                });
            });
            $('#categoria').change(function(e) {
                if($('#categoria').val() == 0) { return; }
                $.ajax({
                    url: rootpath+'/clientepresupuesto/productos/'+$('#categoria').val(),
                    type: "GET",
                    async:false,
                    dataType: 'json',  
                    beforeSend: function() {
                        $('#productos').empty();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                    },
                    complete : function(){
                    },success : function(response){
                        $('#productos').append('<option value="0">Seleccione</option>');
                        $.each(response, function(i, item) {
                             $('#productos').append('<option value="'+item.id_producto+'">'+item.producto+'</option>');
                        });
                    }
                });
            });
            $('#btn_agrega').click(function(e) {
                if($('#categoria').val() == 0) { $('#palert').html('favor selecciona una categoria');  $('#modal_alert').modal('show');  return; }
                if($('#productos').val() == 0) { $('#palert').html('favor selecciona un producto');  $('#modal_alert').modal('show');  return;  }
                if($('#cantidad').val() == 0 || isNaN($('#cantidad').val())) { $('#palert').html('la cantidad debe ser numerica');  $('#modal_alert').modal('show');  return;  }
                if ($("#tr_"+$('#productos').val()).val() != undefined || $("#tr_"+$('#productos').val()).val() != null) {
                    $('#palert').html('El producto ya fue ingresado');  $('#modal_alert').modal('show');  return;
                }
                $.ajax({
                    url: rootpath+'/clientepresupuesto/getproducto/'+$('#productos').val(),
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
                            $('#tlb_detalle').append("<tr id='tr_"+item.id_producto+"'><td>"+item.codigo+"</td><td>"+item.categoria+"</td><td>"+item.producto+"</td><td><small>"+item.descripcion+"</small></td><td>"+$('#cantidad').val()+"</td><td><button type='button' class='btn btn-danger btn-xs' onclick='eliminarFila("+item.id_producto+");''>Eliminar</button></td><tr>");
                        });
                    }
                });
            });        
            $('#btn_presupuesto').click(function(e) {                
                $("#btn_presupuesto").attr("disabled", true); 
                if($('#clientes').val() == 0) { $('#palert').html('favor selecciona un cliente');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false);return; }
                if($('#sucursales').val() == 0) { $('#palert').html('favor selecciona una sucursal');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return;  }  
                if($('#fecha_solicitud').val() == 0)  { $('#palert').html('favor selecciona una fecha');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return; }  
                if($('#solicitante').val() == 0)  { $('#palert').html('favor ingresar solicitante');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return; } 
                if($('#solicitante').val() == 0)  { $('#palert').html('favor ingresar solicitante');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return; }  
                if($('#requerimiento').val() == 0)  { $('#palert').html('favor ingresar tipo requerimiento');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return; }  
                if($('#npresupuesto').val() == 0)  { $('#palert').html('favor ingresar n° presupuesto');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false); return; }  
                var productos  = [];
                var datos  = [];
                var checkproductos=0;
                $("#tlb_detalle  tr").each(function (index) {
                    var getid=String($(this).attr("id"));
                    getid=getid.replace("tr_","");
                    var cantidad=$(this).find("td").eq(4).html();
                    if(getid !== 'undefined' && !isNaN(getid) && cantidad !== 'undefined' && cantidad.length > 0 )
                    {   
                        checkproductos++;
                        productos.push({ 
                            "cantidad"  : cantidad,
                            "id"    :   getid  
                        });
                    }
                });
                if(checkproductos == 0) { $('#palert').html('favor seleccionar al menos un producto');  $('#modal_alert').modal('show');  return;  }    
                datos.push({ 
                    "id_cliente"    : $('#clientes').val(),
                    "id_sucursal"  : $('#sucursales').val(),
                    "observacion": $('#observacion').val(),
                    "solicitante":$('#solicitante').val(),
                    "fecha_solicitud":$('#fecha_solicitud').val(),
                    "requerimiento":$('#requerimiento').val(),
                    "npresupuesto":$('#npresupuesto').val(),
                    "productos"  : productos
                }); 
                $.ajax({
                    url: rootpath+'/clientepresupuesto',
                    type: "POST",
                    data:{datos},
                    dataType: 'json', 
                    beforeSend: function() {
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                        $("#btn_presupuesto").attr("disabled", false);  
                        $('#palert').html(thrownError); 
                        $('#modal_alert').modal('show');
                    },
                    complete : function(){
                        $("#btn_presupuesto").attr("disabled", false);  
                    },success : function(response){
                        $('#p_alert_ajax').html(response.message); 
                        $('#modal_resp_ajax').modal('show');
                    }   
                });

            });
        });
        function eliminarFila(index) {
            $("#tr_" + index).remove();
        }
    </script>
@endpush
<div id="content-wrapper">
    <div class="container-fluid">
            <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Presupuesto</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                    </ol>
                </nav>



        <form method="POST" action="{{url('sucursales')}}">
        @csrf
            <div class="row">
                <div class="col-lg-8">
                  <div class="card mb-3">
                    <div class="card-header">Nuevo Presupuesto</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="npresupuesto" class="col-md-4 col-form-label text-md-right">{{ __('N°Presupuesto:') }}</label>
                            <div class="col-md-6">
                                <input id="npresupuesto" type="text" class="form-control{{ $errors->has('npresupuesto') ? ' is-invalid' : '' }}" name="npresupuesto" value="{{ old('npresupuesto') }}" maxlength="10" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-right">{{ __('Clientes') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('clientes') ? ' is-invalid' : '' }}" data-live-search="true" name="clientes" id="clientes" autocomplete="select" >
                                    <option value="0">seleccione</option>
                                    @if(isset($clientes)) 
                                        @foreach($clientes as $data)
                                            <option value='{{$data->id_cliente}}'>{{$data->cliente}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Sala') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('sucursales') ? ' is-invalid' : '' }}" data-live-search="true" name="sucursales" id="sucursales" autocomplete="select" >
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Dirección:</label>
                            <label id='lbl_direccion' name='lbl_direccion' class="col-md-4 col-form-label text-md-right"></label>
                        </div>
                        <div class="form-group row">
                            <label for="requerimiento" class="col-md-4 col-form-label text-md-right">{{ __('Requerimiento') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('requerimiento') ? ' is-invalid' : '' }}" data-live-search="true" name="requerimiento" id="requerimiento" autocomplete="select" >
                                    <option value="0">seleccione</option>
                                    @if(isset($requerimientos)) 
                                        @foreach($requerimientos as $data)
                                            <option value='{{$data->id_tipo_requerimiento}}'>{{$data->requerimiento}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_presupuesto_campana">
                                    <i class="fas fa-info fa-sm text-white-50"></i> Campaña
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-right">{{ __('Observacion:') }}</label>
                            <div class="col-md-6">
                                <input id="observacion" type="text" class="form-control{{ $errors->has('observacion') ? ' is-invalid' : '' }}" name="observacion" value="{{ old('observacion') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="solicitante" class="col-md-4 col-form-label text-md-right">{{ __('Solicitante:') }}</label>
                            <div class="col-md-6">
                                <input id="solicitante" type="text" class="form-control{{ $errors->has('solicitante') ? ' is-invalid' : '' }}" name="solicitante" value="{{ old('solicitante') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fecha_solicitud" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Solicitud:') }}</label>
                            <div class="col-md-6">
                                <input id="fecha_solicitud" type="text" class="form-control{{ $errors->has('fecha_solicitud') ? ' is-invalid' : '' }}" name="fecha_solicitud" value="{{ old('fecha_solicitud') }}" maxlength="10" required readonly="true">
                            </div>
                        </div>
                        <br/><hr><br/>
                        <table id="tlb_cabezera" name="tlb_cabezera" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                          <thead class="thead-dark">
                            <tr>
                              <th>Código</th>
                              <th>Categoria</th>
                              <th>Producto</th>
                              <th>Descripcion</th>
                              <th>Cantidad</th>
                              <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody id="tlb_detalle">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer small text-muted"> 
                        <div class="col-md-6 offset-md-4">                               
                            <button type="button" class="btn btn-success" name="btn_presupuesto" id="btn_presupuesto">
                                {{ __('Generar Presupuesto') }}
                            </button>
                             <a class="ajax-link" href="{{url('clientepresupuesto')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver a presupuestos</button></a>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="card mb-3">
                    <div class="card-header">Agregar Productos
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" data-live-search="true" name="categoria" id="categoria" autocomplete="select" >
                                    <option value="0">seleccione</option>
                                    @if(isset($categorias)) 
                                        @foreach($categorias as $data)
                                            <option value='{{$data->id_categoria}}'>{{$data->nombre}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="productos" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('productos') ? ' is-invalid' : '' }}" data-live-search="true" name="productos" id="productos" autocomplete="select" >
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cantidad" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>
                            <div class="col-md-6">
                                <input id="cantidad" type="numeric" class="form-control{{ $errors->has('cantidad') ? ' is-invalid' : '' }}" name="cantidad" value="{{ old('cantidad') }}" maxlength="5" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">                              
                                <button type="button" class="btn btn-success" name="btn_agrega" id="btn_agrega">
                                    {{ __('Agregar Producto') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer small text-muted"><strong>Agrega tus productos</strong></div>
                  </div>
                </div>
              </div>
        </form>
    </div>
</div>

@endsection
