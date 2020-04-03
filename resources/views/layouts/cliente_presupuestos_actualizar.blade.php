@extends('layouts.app')
@section('content')
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Actualizar Presupuesto') }}</div>
                <div class="card-body">
                        <form method="POST" action="{{url('clientepresupuesto/actualizar')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_presupuesto" id="id_presupuesto" value="{{$presupuesto->id_presupuesto}}">
                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}:</label>
                            <div class="col-md-6">
                                <select class="custom-select" data-live-search="true" name="estado" id="estado" autocomplete="select" >
                                   @if(isset($estados))
                                   	@foreach($estados as $data)
                                        <option value='{{$data->id_estado}}' @if($presupuesto->id_estado == $data->id_estado)      selected=true   @endif>{{$data->estado}}</option>
                                   	@endforeach
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
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">{{ __('Valor') }}:</label>
                            <div class="col-md-6">
                                <input id="valor" type="text" class="form-control{{ $errors->has('valor') ? ' is-invalid' : '' }}" name="valor" maxlength="10" value="{{ $presupuesto->totalvalor}}">
                                @if ($errors->has('valor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="archivo" class="col-md-4 col-form-label text-md-right">{{ __('Archivo') }}:</label>
                            <div class="col-md-6">
                                <input id="archivos[]" type="file" class="form-control{{ $errors->has('archivo') ? ' is-invalid' : '' }}" name="archivos[]" value="{{ old('archivo') }}" multiple />
                                @if ($errors->has('archivo'))
                                    <span class="invalid-feedback" role="alert">  
                                        <strong>{{ $errors->first('archivo') }}</strong> 
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('clientepresupuesto')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
