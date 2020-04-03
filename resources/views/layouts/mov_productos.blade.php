@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#fecha_ingreso').datetimepicker({lang:'es',timepicker:false,formatDate:'Y-m-d',closeOnDateSelect:true,minDate:0});
            $('#btnrespajax').click(function(e) {
                location.reload(true);
            })
            $('#categoria').change(function(e) {
                if($('#categoria').val() == 0) { return; }
                $.ajax({
                    url: rootpath+'/movproductos/productos/'+$('#categoria').val(),
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
                if($('#fecha_ingreso').val() == 0) { $('#palert').html('favor ingresar fecha');  $('#modal_alert').modal('show');  return;  }
                if($('#codigo').val() == 0) { $('#palert').html('favor ingresar el codigo de ingreso');  $('#modal_alert').modal('show');  return;  }
                if ($("#tr_"+$('#productos').val()).val() != undefined || $("#tr_"+$('#productos').val()).val() != null) {
                    $('#palert').html('El producto ya fue ingresado');  $('#modal_alert').modal('show');  return;
                }
                $.ajax({
                    url: rootpath+'/movproductos/getproducto/'+$('#productos').val(),
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
                            $('#tlb_detalle').append("<tr id='tr_"+item.id_producto+"'><td>"+$('#codigo').val()+"</td><td>"+$('#fecha_ingreso').val()+"</td><td>"+item.categoria+"</td><td>"+item.producto+"</td><td>"+item.descripcion+"</td><td>"+$('#cantidad').val()+"</td><td>$"+item.precio+"</td><td><button type='button' class='btn btn-danger btn-xs' onclick='eliminarFila("+item.id_producto+");''>Eliminar</button></td><tr>");
                        });
                    }
                });
            });
            
            $('#btn_ingreso').click(function(e) {   
                $("#btn_ingreso").attr("disabled", true);                    
                var productos  = [];
                var datos  = [];
                var checkproductos=0;
                $("#tlb_detalle  tr").each(function (index) {
                    var getid=String($(this).attr("id"));
                    getid=getid.replace("tr_","");
                    var codigo=$(this).find("td").eq(0).html();
                    var fecha=$(this).find("td").eq(1).html();
                    var cantidad=$(this).find("td").eq(5).html();
                    if(getid !== 'undefined' && !isNaN(getid) && cantidad !== 'undefined' && cantidad.length > 0 )
                    {                           
                        checkproductos++;
                        productos.push({ 
                            "id"    :   getid,
                            "codigo_ingreso": codigo,
                            "cantidad"  : cantidad,
                            "fecha":fecha,
                        });
                    }
                });
                if(checkproductos == 0) { $('#palert').html('favor seleccionar al menos un producto');  $('#modal_alert').modal('show');  $("#btn_ingreso").attr("disabled", false); return;   }    
                datos.push({ 
                    "productos"  : productos
                }); 
                $.ajax({
                    url: rootpath+'/movproductos',
                    type: "POST",
                    data:{datos},
                    dataType: 'json', 
                    beforeSend: function() {
                        $('#palert').html(''); 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                        $('#palert').html(thrownError); 
                        $('#modal_alert').modal('show');
                        $("#btn_ingreso").attr("disabled", false); 
                    },
                    complete : function(){
                        $("#btn_ingreso").attr("disabled", false); 
                    },success : function(response){
                        $('#p_alert_ajax').html(response.message); 
                        $('#modal_resp_ajax').modal('show');
                    }
                });
            });
        
        $('#btn_limpiar').click(function(e) {
            $("#tlb_detalle  tr").each(function (index) {
                var getid=String($(this).attr("id"));
                getid=getid.replace("tr_","");
                eliminarFila(getid);
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
                        <li class="breadcrumb-item active" aria-current="page">Ingreso productos</li>
                    </ol>
            </nav>


            <div class="row">
                <div class="col-lg-4">
                  <div class="card mb-3">
                    <div class="card-header">Ingreso Productos
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Codigo Ingreso') }}</label>
                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{ old('codigo') }}" maxlength="5" required>
                            </div>
                        </div>

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

                        <div class="form-group row">
                            <label for="fecha_ingreso" class="col-md-4 col-form-label text-md-right">{{ __('Fecha Ingreso:') }}</label>
                            <div class="col-md-6">
                                <input id="fecha_ingreso" type="text" class="form-control{{ $errors->has('fecha_ingreso') ? ' is-invalid' : '' }}" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" maxlength="10" required readonly="true">
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
                    <div class="card-footer small text-muted"><strong>Ingreso Productos</strong></div>
                  </div>
                </div>
               <div class="col-lg-8">
                  <div class="card mb-3">
                    <div class="card-header">Nuevo Ingreso</div>
                    <div class="card-body">
                        <table id="tlb_cabezera" name="tlb_cabezera" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Código Ingreso</th>
                              <th>Fecha Ingreso</th>
                              <th>Categoria</th>
                              <th>Producto</th>
                              <th>Descripcion</th>
                              <th>Cantidad</th>
                              <th>Precio Unitario</th>
                              <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody id="tlb_detalle">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer small text-muted">   
                        <button type="button" class="btn btn-success" name="btn_ingreso" id="btn_ingreso">
                            {{ __('Generar Ingreso Productos') }}
                        </button>
                        <button type="button" class="btn btn-success" name="btn_limpiar" id="btn_limpiar">
                            {{ __('Limpiar Tabla') }}
                        </button>
                    </div>
                  </div>
                </div>
              </div> 
    </div>
</div>
@endsection
