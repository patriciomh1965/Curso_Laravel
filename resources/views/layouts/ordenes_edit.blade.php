@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#fecha_estimada').datetimepicker({lang:'es',timepicker:false,formatDate:'Y-m-d',closeOnDateSelect:true,minDate:0});
            $('#btnrespajax').click(function(e) {
                location.reload(true);
            });
            $('#sucursales').change(function(e) {
                var direccion=$('#'+$('#sucursales').val()+'_sucursal_direccion').text();
                $('#lbl_direccion').html(direccion);    
            });
            $('#categoria').change(function(e) {
                if($('#categoria').val() == 0) { return; }
                $.ajax({
                    url: rootpath+'/ordenes/productos/'+$('#categoria').val(),
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
                if($('#categoria').val() == 0) { $('#palert').html('favor seleccionar una categoria');  $('#modal_alert').modal('show');  return; }
                if($('#productos').val() == 0) { $('#palert').html('favor seleccionar un producto');  $('#modal_alert').modal('show');  return;  }
                if($('#cantidad').val() == 0 || isNaN($('#cantidad').val())) { $('#palert').html('la cantidad debe ser numerica');  $('#modal_alert').modal('show');  return;  }
                if ($("#tr_"+$('#productos').val()).val() != undefined || $("#tr_"+$('#productos').val()).val() != null) {
                    $('#palert').html('El producto ya fue ingresado');  $('#modal_alert').modal('show');  return;
                }
                $.ajax({
                    url: rootpath+'/ordenes/getproducto/'+$('#productos').val(),
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
            $('#btn_orden').click(function(e) {   
                $("#btn_presupuesto").attr("disabled", true);             
                if($('#clientes').val() == 0) { $('#palert').html('favor seleccionar un cliente');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false);return; }
                if($('#sucursales').val() == 0) { $('#palert').html('favor seleccionar una sucursal');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false);return;  }  
                if($('#fecha_estimada').val() == 0) { $('#palert').html('favor seleccionar una fecha');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false);return;  }
                if($('#requerimiento').val() == 0) { $('#palert').html('favor seleccionar requerimiento');$('#modal_alert').modal('show');$("#btn_presupuesto").attr("disabled", false);return;  }
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
                    "_method":$('#_method').val(),
                    "id_orden"    : $('#id_orden').val(),
                    "id_cliente"    : $('#clientes').val(),
                    "id_sucursal"  : $('#sucursales').val(),
                    "id_user"  : $('#asignado').val(),
                    "fecha_estimada"  : $('#fecha_estimada').val(),
                    'observacion': $('#observacion').val(),
                    "requerimiento":$('#requerimiento').val(),
                    "productos"  : productos
                }); 
                $.ajax({
                    url: rootpath+'/ordenes/update_orden/'+$('#id_orden').val(),
                    type: "POST",
                    data:{datos},
                    dataType: 'json', 
                    beforeSend: function() {
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                        $("#btn_orden").attr("disabled", false);  
                        $('#palert').html(thrownError); 
                        $('#modal_alert').modal('show');
                    },
                    complete : function(){
                        $("#btn_orden").attr("disabled", false);  
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
                        <li class="breadcrumb-item"><a href="#">Ordenes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>

        <form method="POST" action="{{url('sucursales')}}">
        <input type="hidden" name="id_orden" id="id_orden" value="{{$ordenes->id_orden}}"/>
         @method('PUT')
         @csrf
            <div class="row">
                <div class="col-lg-8">
                  <div class="card mb-3">
                    <div class="card-header">Orden N°{{$ordenes->id_orden}} </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Cliente') }}:</label>
                            <label class="col-md-4 col-form-label text-md-right"><b>{{$ordenes->Clientes->cliente}}</b></label>
                        </div>
                        <div class="form-group row">
                            <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('sucursales') ? ' is-invalid' : '' }}" data-live-search="true" name="sucursales" id="sucursales" autocomplete="select" >          
                                    @if(isset($sucursales)) 
                                        @php($direccion='')
                                        @foreach($sucursales as $data)
                                            <option value='{{$data->id_sucursal}}' @if($ordenes->id_sucursal==$data->id_sucursal) selected=true @php($direccion=$data->direccion) @endif >{{$data->codigo}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if(isset($sucursales)) 
                                    @foreach($sucursales as $data)
                                        <span id="{{$data->id_sucursal}}_sucursal_direccion" name="{{$data->id_sucursal}}_sucursal_direccion" style="display: none">{{$data->direccion}}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Dirección:</label>
                            <label id='lbl_direccion' name='lbl_direccion' class="col-md-4 col-form-label text-md-right">{{$direccion}}</label>
                        </div>
                        <div class="form-group row">
                            <label for="requerimiento" class="col-md-4 col-form-label text-md-right">{{ __('Requerimiento') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('requerimiento') ? ' is-invalid' : '' }}" data-live-search="true" name="requerimiento" id="requerimiento" autocomplete="select" >
                                    <option value="0">seleccione</option>
                                    @if(isset($requerimientos)) 
                                        @foreach($requerimientos as $data)
                                            <option value='{{$data->id_tipo_requerimiento}}' @if($ordenes->id_tipo_requerimiento==$data->id_tipo_requerimiento) selected=true @endif >{{$data->requerimiento}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="asignado" class="col-md-4 col-form-label text-md-right">{{ __('Asignar a:') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('asignado') ? ' is-invalid' : '' }}" data-live-search="true" name="asignado" id="asignado" autocomplete="select" >
                                    @if(isset($usarioscliente)) 
                                        @foreach($usarioscliente as $data)
                                            <option value='{{$data->id_user}}' @if($ordenes->id_user_asignado==$data->id_user) selected=true @endif>{{$data->name}} {{$data->lastname}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-right">{{ __('Observacion:') }}</label>
                            <div class="col-md-6">
                                <input id="observacion" type="text" class="form-control{{ $errors->has('observacion') ? ' is-invalid' : '' }}" name="observacion" value="{{ $ordenes->observacion }}" maxlength="255" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_estimada" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Solicitud:') }}</label>
                            <div class="col-md-6">
                                <input id="fecha_estimada" type="text" class="form-control{{ $errors->has('fecha_estimada') ? ' is-invalid' : '' }}" name="fecha_estimada" value="{{ substr($ordenes->fecha_estimada,0,10)}}" maxlength="10" required readonly="true">
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
                                    @if(isset($ordenesdetalle)) 
                                        @foreach($ordenesdetalle as $data)
                                        <tr id="tr_{{$data->id_producto}}">
                                            <td>{{$data->Productos->codigo}}</td>
                                            <td>{{$data->Productos->Categorias->nombre}}</td>
                                            <td>{{$data->Productos->producto}}</td>
                                            <td><small>{{$data->Productos->descripcion}}</small></td>
                                            <td>{{$data->cantidad}}</td>
                                            <td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarFila({{$data->id_producto}});">Eliminar</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                    </div>
                    <div class="card-footer small text-muted"> 
                        <div class="col-md-6 offset-md-4">                               
                            <button type="button" class="btn btn-success" name="btn_orden" id="btn_orden">
                                {{ __('Actualizar Orden') }}
                            </button>
                            <a class="ajax-link" href="{{url('ordenes/list')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver a Ordenes</button></a>
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
