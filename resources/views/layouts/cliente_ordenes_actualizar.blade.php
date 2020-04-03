@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#comentario').change(function(e) {
                if($('#comentario').val() == 10) { 
                    $("#observacion").attr("disabled", false);
                }else{
                    $("#observacion").val(""); 
                    $("#observacion").attr("disabled", true); 
                }
            });
        });
   </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Actualizar Orden') }} N° {{$orden->id_orden}} </div>
                <div class="card-body">
                        <form method="POST" action="{{url('ordenes/actualizar')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_orden" id="id_orden" value="{{$orden->id_orden}}">
                        
                        <div class="form-group row">
                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}:</label>
                            <div class="col-md-6">
                                <select class="custom-select" data-live-search="true" name="estado" id="estado" autocomplete="select" >
                                   @if(isset($estados))
                                    @foreach($estados as $data)
                                        <option value='{{$data->id_estado}}' @if($orden->id_estado == $data->id_estado)      selected=true   @endif >{{$data->estado}}</option>
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
                            <label for="comentario" class="col-md-4 col-form-label text-md-right">{{ __('Comentario') }}:</label>
                            <div class="col-md-6">
                                <select class="custom-select" data-live-search="true" name="comentario" id="comentario" autocomplete="select" >
                                   @if(isset($comentarios))
                                   	@foreach($comentarios as $data)
                                        <option value='{{$data->id_comentario}}'>{{$data->comentario}}</option>
                                   	@endforeach
                                   @endif
                                </select>
                                @if ($errors->has('comentario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comentario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" class="col-md-4 col-form-label text-md-right">{{ __('Observación') }}:</label>
                            <div class="col-md-6">
                                <input id="observacion" type="text" class="form-control{{ $errors->has('observacion') ? ' is-invalid' : '' }}" name="observacion" maxlength="255" value="" disabled="true" >
                                @if ($errors->has('observacion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observacion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="archivos" class="col-md-4 col-form-label text-md-right">{{ __('Archivos') }}:</label>
                            <div class="col-md-6">
                                <input id="archivos[]" type="file" class="form-control{{ $errors->has('archivos') ? ' is-invalid' : '' }}" name="archivos[]" value="{{ old('archivos') }}" multiple />
                                @if ($errors->has('archivos'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('archivos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                 <a class="ajax-link" href="{{url('ordenes/list')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
