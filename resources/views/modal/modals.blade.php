<div id="modal_resp" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">RESPUESTA</h5>
                </div>
                <div class="modal-body">
                    @if(isset($code))
                        @if($code =='200')
                            <div class='alert alert-success'>{{ $message }}</div>
                        @else
                            <div class='alert alert-danger'>{{  $message }}</div>
                        @endif
                        <script>
                            $(function() 
                            {   
                                $('#modal_resp').modal('show');
                            });
                        </script>
                    @endif 
                </div>
                <div class="modal-footer text-center">
                    <div style="aling:center" class="text-center">
                        <a class="ajax-link" href="/"><button type="button" data-dismiss="modal" class="btn btn-success">VOLVER</button></a>
                    </div>
                </div>
            </div>  
        </div>
</div>

<div id="modal_alert" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">RESPUESTA</h5>
                </div>
                <div class="modal-body">
                    <div class='alert alert-info'><p id='palert'></p></div>
                </div>
                <div class="modal-footer text-center">
                    <div style="aling:center" class="text-center">
                        <a class="ajax-link" href="/"><button type="button" data-dismiss="modal" class="btn btn-success">VOLVER</button></a>
                </div>
            </div>
        </div>  
     </div>
</div>
<div id="modal_resp_ajax" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">RESPUESTA</h5>
                </div>
                <div class="modal-body">
                    <div class='alert alert-info'><p id='p_alert_ajax'></p></div>
                </div>
                <div class="modal-footer text-center">
                     <button type="button" data-dismiss="modal" class="btn btn-success" id="btnrespajax" name="btnrespajax">ACEPTAR</button>
                </div>
            </div>
        </div>  
     </div>
</div>
<div id="modal_detalle_orden" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">DETALLE ORDEN</h5>
                </div>
                <div class="modal-body" id="div_modal_orden">
                    <table id="tlb_orden_detalle" name="tlb_orden_detalle" class="table table-bordered">
                        <thead>
                            <tr>
                               <th>PRODUCTO</th>
                               <th>CATEGORIA</th>
                               <th>CANTIDAD</th>
                            </tr>
                            </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer text-center">
                    <a class="ajax-link" href="/"><button type="button" data-dismiss="modal" class="btn btn-success">VOLVER</button></a>
               </div>
            </div>
        </div>  
     </div>
</div>
 
<div id="modal_imagen_producto" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IMAGEN</h5>
                </div>
                <div class="modal-body" id="div_imagen_producto">
                   
                </div>
                <div class="modal-footer text-center">
                    <a class="ajax-link" href="/"><button type="button" data-dismiss="modal" class="btn btn-success">VOLVER</button></a>
               </div>
            </div>
        </div>  
     </div>
</div>

<div class="modal fade" id="modal_presupuesto_confirmar" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           El presupuesto fue autorizado por nosotros pero falta tu confirmación, favor confirmar para generar la orden de compra.
      </div>
      <div class="modal-footer">
        <form name="form_presupuesto_confirmar" id="form_presupuesto_confirmar">
            <input type="hidden" id="id_presupuesto_autorizar" name='id_presupuesto_autorizar' required="true">
            <button type="button" class="btn btn-success" data-dismiss="modal" name="btn_presupuesto_autorizar" id="btn_presupuesto_autorizar">Autorizar</button>
        </form>
        <button type="button" class="btn btn-success" data-dismiss="modal">Volver</button>
      </div>
    </div>
  </div>
</div> 



<div class="modal fade" id="modal_presupuesto_campana" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            Puede generar un presupuesto de tipo campaña, lo que significa que cotizara en una o mas sucursales
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Si</button>
      </div>
    </div>
  </div>
</div> 