@extends('layouts.app')
@section('content')
 <div id="content-wrapper">
        <div class="container-fluid">


                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Cliente</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mantenedor</li>
                        </ol>
                    </nav>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cliente') }}</div>
                <div class="card-body">
                    @if(!isset($cliente))
                        <form method="POST" action="{{url('clientes')}}" enctype="multipart/form-data">
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
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>
                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ old('descripcion') }}" maxlength="255" required>

                                @if ($errors->has('descripcion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
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
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control{{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen" maxlength="50" value="{{ old('imagen') }}" required>

                                @if ($errors->has('imagen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('imagen') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('clientes')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{url('clientes')}}/{{$cliente->id_cliente}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input id="id_cliente" type="hidden" name="id_cliente" value="{{$cliente->id_cliente}}"/>
                        
                         <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ $cliente->cliente }}" maxlength="255" required autofocus>
                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>
                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ $cliente->descripcion }}" maxlength="255" required>

                                @if ($errors->has('descripcion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" maxlength="50" value="{{$cliente->codigo}}" required>

                                @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control{{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen" maxlength="50" value="{{ old('imagen') }}">

                                @if ($errors->has('imagen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('imagen') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select" data-live-search="true" name="estado" id="estado" autocomplete="select" >
                                    @if($cliente->estado)
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('clientes')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
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
