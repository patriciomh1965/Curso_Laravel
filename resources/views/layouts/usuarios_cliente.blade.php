@extends('layouts.app')
@section('content')
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Asignación De Roles</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <label for="name" class="col-md-3 col-form-label text-md-left">Usuario: <b> {{$usuario->name}} </b></label>
                        </br>
                        <label for="name" class="col-md-3 col-form-label text-md-left">Email: <b>{{$usuario->email}}</b></label>
                    </div> 
                    <hr>
                    @if(isset($clientes))
                    <form method="POST" action="{{url('usuarios/clientes')}}">
                        @csrf
                        <input type="hidden" name="id_user" id="id_user" value="{{$usuario->id_user}}"/>
                        <div class="row">     
                        @foreach($clientes as $data)
                            <div class=" form-group col-md-4">
                                <label for="clientes" class="col-md-4 col-form-label text-md-right">{{$data->cliente}}</label>
                                <input type="checkbox" name="clientes[{{$data->id_cliente}}]" value="{{$data->id_cliente}}"
                                @foreach($usuarioclientes as $data2)
                                    @if($data2->id_cliente == $data->id_cliente) 
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
                                <a class="ajax-link" href="{{url('usuarios')}}"><button type="button" class="btn btn-success" name="btnback" id="btnback">Volver</button></a>
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
