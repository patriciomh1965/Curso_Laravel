@extends('layouts.app')
@section('content')
@push('js')
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            $('#tlb_tracking').DataTable({   
                responsive: true, 
                language: {
                     "url": rootpath+'/js/lang_datatable_esp.js'
                }
            });
        });
    </script>
@endpush
 <div id="content-wrapper">
        <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tracking Orden N° </div>
                <div class="card-body">
                    <div>
                        <table id="tlb_tracking" name="tlb_tracking" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                           <thead class="thead-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Comentarios</th>
                                    <th>Archivos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($bitacoras))
                                    @foreach($bitacoras as $data)
                                    <tr>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->Usuarios->name}}</td>
                                        <td>{{$data->Estados->estado}}</td>
                                        <td>@if($data->id_comentario==10) {{$data->observacion}} @else {{$data->Comentarios->comentario}} @endif</td>
                                        <td>
                                            @if(strlen($data->archivo)>5)
                                                <form action="{{url('ordenes/archivo/'.$data->id_bitacora)}}" method="GET">
                                                    <button type="submit" class="btn btn-success btn-xs">Descargar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
