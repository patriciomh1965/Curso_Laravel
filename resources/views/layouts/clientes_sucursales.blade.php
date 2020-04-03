@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Asignación Sucursales</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <label for="name" class="col-md-3 col-form-label text-md-left">Cliente: <b> {{$cliente->cliente}} </b></label>
                    </div> 
                    <hr>
                    @if(isset($sucursales))
                    <form method="POST" action="{{url('clientes/sucursales')}}">
                        @csrf
                        <input type="hidden" name="id_cliente" id="id_cliente" value="{{$cliente->id_cliente}}"/>
                        <div class="row">     
                        @foreach($sucursales as $data)
                            <div class=" form-group col-md-3">
                                <label for="sucursales" class="col-md-4 col-form-label text-md-right">{{$data->nombre}}</br><small>({{$data->direccion}})</small></label>
                                <input type="checkbox" name="sucursales[{{$data->id_sucursal}}]" value="{{$data->id_sucursal}}"
                                @foreach($clientessucursales as $data2)
                                    @if($data2->id_sucursal == $data->id_sucursal) 
                                        checked="true"
                                    @endif
                                 @endforeach
                                 >
                            </div>
                        @endforeach
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
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
