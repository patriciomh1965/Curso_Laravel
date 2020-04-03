@extends('layouts.app')
@section('content')
 <div id="content-wrapper">
        <div class="container-fluid">

                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Productos</li>
                        </ol>
                </nav>
            
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Producto') }}</div>
                <div class="card-body">
                    @if(!isset($producto))
                        <form method="POST" action="{{url('productos')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="producto" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>
                            <div class="col-md-6">
                                <input id="producto" type="text" class="form-control{{ $errors->has('producto') ? ' is-invalid' : '' }}" name="producto" value="{{ old('producto') }}" maxlength="255" required autofocus>
                                @if ($errors->has('producto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('producto') }}</strong>
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
                            <label for="minstock" class="col-md-4 col-form-label text-md-right">{{ __('Stock Minimo') }}</label>

                            <div class="col-md-6">
                                <input id="minstock" type="text" class="form-control{{ $errors->has('minstock') ? ' is-invalid' : '' }}" name="minstock" maxlength="8" value="{{ old('minstock') }}" required>

                                @if ($errors->has('minstock'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('minstock') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                            <div class="col-md-6">
                                <input id="precio" type="text" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" maxlength="8" value="{{ old('precio') }}" required>

                                @if ($errors->has('precio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('precio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" data-live-search="true" name="categoria" id="categoria" autocomplete="select" >
                                    @if(isset($categorias)) 
                                        @foreach($categorias as $data)
                                            <option value='{{$data->id_categoria}}'>{{$data->nombre}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('categoria'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('categoria') }}</strong>
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
                                 <a class="ajax-link" href="{{url('productos')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{url('productos')}}/{{$producto->id_producto}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input id="id_producto" type="hidden" name="id_producto" value="{{$producto->id_producto}}"/>
                        
                         <div class="form-group row">
                            <label for="producto" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('producto') ? ' is-invalid' : '' }}" name="producto" value="{{ $producto->producto }}" maxlength="255" required autofocus>
                                @if ($errors->has('producto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('producto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>
                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ $producto->descripcion }}" maxlength="255" required>

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
                                <input id="codigo" type="text" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" maxlength="50" value="{{$producto->codigo}}" required>

                                @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="minstock" class="col-md-4 col-form-label text-md-right">{{ __('Stock Mínimo') }}</label>

                            <div class="col-md-6">
                                <input id="minstock" type="text" class="form-control{{ $errors->has('minstock') ? ' is-invalid' : '' }}" name="minstock" maxlength="8" value="{{$producto->min_stock}}" required>

                                @if ($errors->has('minstock'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('minstock') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                            <div class="col-md-6">
                                <input id="precio" type="text" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" maxlength="8" value="{{$producto->precio}}" required>

                                @if ($errors->has('precio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('precio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" data-live-search="true" name="categoria" id="categoria" autocomplete="select" >
                                    @if(isset($categorias)) 
                                        @foreach($categorias as $data)
                                            <option value='{{$data->id_categoria}}' @if($producto->id_categoria == $data->id_categoria) selected @endif>{{$data->nombre}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('categoria'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control{{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen" maxlength="50" value="">

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
                                    @if($producto->estado)
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
                                 <a class="ajax-link" href="{{url('productos')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
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
