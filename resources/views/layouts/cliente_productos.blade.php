@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        function getimagen(img){
            $('#div_imagen_producto').html("<img src='"+rootpath+"/images/productos/"+img+"' width='100%' height='100%'/>");
            $('#modal_imagen_producto').modal('show');
        }
    </script>
@endpush
<div id="content-wrapper">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Stock en bodega</li>
            </ol>
        </nav>
        @if(isset($getproductos))
        @foreach($getproductos as $data)
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xl font-weight-bold text-primary mb-1">{{ $data->Productos->producto}}</div>
                  <hr>
                  <div class="h7 mb-0"><b>Código:</b> {{ $data->Productos->codigo}}</div>
                  <div class="h7 mb-0"><b>Categoria:</b> {{ $data->Productos->Categorias->nombre}}</div>
                  <div class="h7 mb-0"><b>Descripcion:</b> {{ $data->Productos->descripcion}}</div>
                  <hr>
                  <form action="{{url('clienteproductos/'.$data->id_producto)}}" method="GET">
                      <button type="submit" class="btn btn-success btn-xs">Detalle</button>
                  </form>
                </div>
                <div class="col mr-2">
                    </br>
                    <p onclick="getimagen('{{$data->Productos->imagen}}');"><img src="{{asset('images/productos/'.$data->Productos->imagen)}}" width="100%" height="100%"/></p>
                    </br>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

@endsection
