@extends('layouts.app')
@section('content')
<div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Formulario') }}</div>
                <div class="card-body">
                    @if(!isset($perfil))
                    <form method="POST" action="{{url('perfiles')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="perfil" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="perfil" type="text" class="form-control{{ $errors->has('perfil') ? ' is-invalid' : '' }}" name="perfil" value="{{ old('perfil') }}" required autofocus>
                                @if ($errors->has('perfil'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('perfil') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success" name="btnsave" id="btnsave">Guardar</button>
                                <a class="ajax-link" href="{{url('perfiles')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{url('perfiles')}}/{{$perfil->id_perfil}}">
                        @csrf
                        @method('PUT')
                        <input id="id_perfil" type="hidden" name="id_perfil" value="{{ $perfil->id_perfil }}"/>
                        <div class="form-group row">
                            <label for="perfil" class="col-md-4 col-form-label text-md-right">Perfil</label>
                            <div class="col-md-6">
                                <input id="perfil" type="text" class="form-control{{ $errors->has('perfil') ? ' is-invalid' : '' }}" name="perfil" value="{{ $perfil->perfil }}" required autofocus>
                                @if ($errors->has('perfil'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('perfil') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">Estado</label>
                            <div class="col-md-6">
                                 <select class="custom-select" data-live-search="true" name="estado" id="estado" autocomplete="select" >
                                    @if($perfil->estado)
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
                                <button type="submit" class="btn btn-success" name="btnsave" id="btnsave">Guardar</button>
                                <a class="ajax-link" href="{{url('perfiles')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
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
