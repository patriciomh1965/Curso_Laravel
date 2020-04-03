@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#region').change(function(e) {
                if($('#region').val() == 0) { return; }
                $.ajax({
                    url: rootpath+'/ciudades/'+$('#region').val(),
                    type: "GET",
                    async:false,
                    dataType: 'json', 
                    beforeSend: function() {
                        $('#ciudad').empty();
                        $('#comuna').empty();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                    },
                    complete : function(){
                    },success : function(response){
                        $('#ciudad').append('<option value="0">Seleccione</option>');
                        $.each(response, function(i, item) {
                             $('#ciudad').append('<option value="'+item.id_ciudad+'">'+item.ciudad+'</option>');
                        });
                    }
                });
            });
            $('#ciudad').change(function(e) {
                if($('#ciudad').val() == 0) { return; }
                $.ajax({
                    url: rootpath+'/comunas/'+$('#ciudad').val(),
                    type: "GET",
                    async:false,
                    dataType: 'json', 
                    beforeSend: function() {
                        $('#comuna').empty();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {   
                    },
                    complete : function(){
                    },success : function(response){
                        $('#comuna').append('<option value="0">Seleccione</option>');
                        $.each(response, function(i, item) {
                             $('#comuna').append('<option value="'+item.id_comuna+'">'+item.comuna+'</option>');
                        });
                    }
                });
            });

        });
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">

                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Sala</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                        </ol>
                    </nav>


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sala') }}</div>
                <div class="card-body" id='div_sucursal_save'>
                    @if(!isset($sucursal))
                        <form method="POST" action="{{url('sucursales')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" maxlength="255" required autofocus>
                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{ old('direccion') }}" maxlength="255" required>

                                @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="casa_matriz" class="col-md-4 col-form-label text-md-right">{{ __('Casa Matriz') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('casa_matriz') ? ' is-invalid' : '' }}" data-live-search="true" name="casa_matriz" id="casa_matriz" autocomplete="select" >
                                    <option value="0">NO</option><option value="1">SI</option>    
                                </select>
                                @if ($errors->has('casa_matriz'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('casa_matriz') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>
                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" maxlength="50" value="{{ old('codigo') }}" required>

                                @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">{{ __('Region') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('region') ? ' is-invalid' : '' }}" data-live-search="true" name="region" id="region" autocomplete="select" >
                                    <option value='0'>Seleccionar</option>
                                    @if(isset($regiones)) 
                                        @foreach($regiones as $data)
                                            <option value='{{$data->id_region}}'>{{$data->shortname}} - {{$data->region}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('region'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ciudad" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('ciudad') ? ' is-invalid' : '' }}" data-live-search="true" name="ciudad" id="ciudad" autocomplete="select" >
                                </select>
                                @if ($errors->has('ciudad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ciudad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comuna" class="col-md-4 col-form-label text-md-right">{{ __('Comuna') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('comuna') ? ' is-invalid' : '' }}" data-live-search="true" name="comuna" id="comuna" autocomplete="select" >
                                </select>
                                @if ($errors->has('comuna'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comuna') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="latitud" class="col-md-4 col-form-label text-md-right">{{ __('Latitud') }}</label>
                            <div class="col-md-6">
                                <input id="latitud" type="text" class="form-control{{ $errors->has('latitud') ? ' is-invalid' : '' }}" name="latitud" value="{{ old('latitud') }}" maxlength="50" required>

                                @if ($errors->has('latitud'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('latitud') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="longitud" class="col-md-4 col-form-label text-md-right">{{ __('Longitud') }}</label>

                            <div class="col-md-6">
                                <input id="longitud" type="text" class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}" name="longitud" maxlength="50"  value="{{ old('longitud') }}" required>

                                @if ($errors->has('longitud'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('longitud') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-right">{{ __('Clientes') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('clientes') ? ' is-invalid' : '' }}" data-live-search="true" name="clientes" id="clientes" autocomplete="select" >
                                    @if(isset($clientes)) 
                                        @foreach($clientes as $data)
                                            <option value='{{$data->id_cliente}}'>{{$data->cliente}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('clientes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('clientes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('sucursales')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{url('sucursales')}}/{{$sucursal->id_sucursal}}">
                        @csrf
                        @method('PUT')
                        <input id="id_sucursal" type="hidden" name="id_sucursal" value="{{$sucursal->id_sucursal}}"/>
                        
                         <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ $sucursal->nombre }}" maxlength="255" required autofocus>
                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{ $sucursal->direccion }}" maxlength="255" required>

                                @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="casa_matriz" class="col-md-4 col-form-label text-md-right">{{ __('Casa Matriz') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('casa_matriz') ? ' is-invalid' : '' }}" data-live-search="true" name="casa_matriz" id="casa_matriz" autocomplete="select" >
                                    <option value="0" @if(!$sucursal->casa_matriz) selected @endif> NO</option><option value="1" @if($sucursal->casa_matriz) selected @endif>SI</option>    
                                </select>
                                @if ($errors->has('casa_matriz'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('casa_matriz') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" maxlength="50" value="{{$sucursal->codigo}}" required>

                                @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">{{ __('Region') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('region') ? ' is-invalid' : '' }}" data-live-search="true" name="region" id="region" autocomplete="select" >
                                    <option value='0'>Seleccionar</option>
                                    @if(isset($regiones)) 
                                        @foreach($regiones as $data)
                                            <option value='{{$data->id_region}}' @if($sucursal->Comunas->Ciudades->id_region==$data->id_region) selected @endif >{{$data->shortname}} - {{$data->region}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('region'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ciudad" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('ciudad') ? ' is-invalid' : '' }}" data-live-search="true" name="ciudad" id="ciudad" autocomplete="select" >
                                    <option value='0'>Seleccionar</option>
                                    @if(isset($ciudades)) 
                                        @foreach($ciudades as $data)
                                            <option value='{{$data->id_ciudad}}' @if($sucursal->Comunas->id_ciudad==$data->id_ciudad) selected @endif  >{{$data->ciudad}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('ciudad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ciudad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comuna" class="col-md-4 col-form-label text-md-right">{{ __('Comuna') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('comuna') ? ' is-invalid' : '' }}" data-live-search="true" name="comuna" id="comuna" autocomplete="select" >
                                    @if(isset($comunas)) 
                                        @foreach($comunas as $data)
                                            <option value='{{$data->id_comuna}}' @if($sucursal->id_comuna==$data->id_comuna) selected @endif >{{$data->comuna}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('comuna'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comuna') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="latitud" class="col-md-4 col-form-label text-md-right">{{ __('Latitud') }}</label>
                            <div class="col-md-6">
                                <input id="latitud" type="text" class="form-control{{ $errors->has('latitud') ? ' is-invalid' : '' }}" name="latitud" value="{{ $sucursal->latitud }}" maxlength="50" required>

                                @if ($errors->has('latitud'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('latitud') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="longitud" class="col-md-4 col-form-label text-md-right">{{ __('Longitud') }}</label>

                            <div class="col-md-6">
                                <input id="longitud" type="text" class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}" name="longitud" maxlength="50" value="{{ $sucursal->longitud}}" required>

                                @if ($errors->has('longitud'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('longitud') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select" data-live-search="true" name="estado" id="estado" autocomplete="select" >
                                    @if($sucursal->estado)
                                        <option value='1' selected>ACTIVO</option>
                                        <option value='0'>INACTIVO</option>
                                    @else
                                        <option value='0' selected>INACTIVO</option>
                                        <option value='1'> ACTIVO</option>
                                    @endif
                                </select>
                                @if ($errors->has('estado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clientes" class="col-md-4 col-form-label text-md-right">{{ __('Clientes') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('clientes') ? ' is-invalid' : '' }}" data-live-search="true" name="clientes" id="clientes" autocomplete="select" >
                                    @if(isset($clientes)) 
                                        @foreach($clientes as $data)
                                            <option value='{{$data->id_cliente}}' @if($data->id_cliente == $sucursal->id_cliente) selected="true" @endif>{{$data->cliente}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('clientes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('clientes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('sucursales')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
