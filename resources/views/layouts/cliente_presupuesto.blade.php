@extends('layouts.app')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <form method="POST" action="{{url('sucursales')}}">
        @csrf
            <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="card-header">Presupuestos</div>
                    <div class="card-body">
                        <table id="tlb_cabezera" name="tlb_cabezera" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Código</th>
                              <th>Fecha</th>
                              <th>Cliente</th>
                              <th>Sucursal</th>
                              <th>Total productos</th>
                              <th>Valor</th>
                              <th>Ver Presupuesto</th>
                            </tr>
                            </thead>
                            <tbody id="tlb_detalle">
                                <tr>
                                    <td>1asd324</td>
                                    <td>2019-01-01</td>
                                    <td>Gasco</td>
                                    <td>Providencia</td>
                                    <td>23</td>
                                    <td>$233</td>
                                    <td>
                                        <button type="button" class="btn btn-success" name="btn_agrega" id="btn_agrega">
                                            {{ __('Presupuesto') }}
                                        </button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>1asd324</td>
                                    <td>2019-02-01</td>
                                    <td>Gasco</td>
                                    <td>Vitacura <b>(Casa Matriz)</b></td>
                                    <td>1</td>
                                    <td>$120.233</td>
                                    <td>
                                        <button type="button" class="btn btn-success" name="btn_agrega" id="btn_agrega">
                                            {{ __('Presupuesto') }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                  </div>
                </div>

                </div>
              </div>
        </form>
    </div>
</div>

@endsection
