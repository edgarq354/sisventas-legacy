<!--//////////////////////////////////-->
<!--MODAL DETALLE DE LAS CARRERAR-->
<!--//////////////////////////////////-->


<div class="modal fade" id="ModalPuntoPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
          <h3 class="modal-title"><b>PUNTO DE PEDIDO</b></h3>
      </div>

      <div class="modal-body">
        <table class="table table-striped table-bordered table-condensed table-hover">
          <tbody align="center" id="body_punto_pedido">
          </tbody>
        </table>
      </div>

  <div class="modal-footer">
      <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
  </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalDetalleCarrera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
          <h3 class="modal-title"><b>HISTORIAL DE CARRERA</b></h3>
      </div>

      <div class="modal-body">
        <table class="table table-striped table-bordered table-condensed table-hover">
          <tbody align="center" id="body_historial_detalle">
          </tbody>
        </table>
      </div>

  <div class="modal-footer">
      <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
  </div>
    </div>
  </div>
</div>







<!--MODAL PEDIDO CANCELADO-->

<div class="modal fade" id="Modal_pedido_cancelado_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">DETALLE DEL PEDIDO CANCELADO POR EL USUARIO</h3>
            </div>

            <div class="modal-body">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-success">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Indicacion: 
                  <label id="indicacion" ></label> 
                  </div>

                  <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <div class="form-group">
                  Hora de pedido:
                  <label id="fecha_inicio"></label>
                  </div> 

                   <div class="form-group">
                  Hora de proceso:
                  <label id="fecha_proceso"></label>
                  </div> 

                  <div class="form-group">
                  Hora de la cancelación:
                  <label id="fecha_cancelado"></label>
                  </div>
                  </div>

                  <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                  Detalle de la cancelación:
                  <label id="detalle_cancelacion"></label>
                  </div> 

                   
                  </div>

              </div>
             
        </div>
      <div class="modal-footer">
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>
</div>

<!--MODAL CONDUCTOR CANCELADO-->

<div class="modal fade" id="Modal_pedido_cancelado_conductor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">DETALLE DEL PEDIDO CANCELADO POR EL CONDUCTOR</h3>
            </div>

            <div class="modal-body">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-success">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Indicacion: 
                  <label id="indicacion_c"  ></label> 
                  </div>

                  <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 
                  <div class="form-group">
                  Hora de pedido:
                  <label id="fecha_inicio_c"></label>
                  </div> 

                   <div class="form-group">
                  Hora de proceso:
                  <label id="fecha_proceso_c"></label>
                  </div> 


                  <div class="form-group">
                  Hora de la cancelación:
                  <label id="fecha_cancelado_c"></label>
                  </div>
                  </div>

                  <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                  Detalle de la cancelación:
                  <label id="detalle_cancelacion_c"></label>
                  </div> 

                   
                  </div>

              </div>
             
        </div>
      <div class="modal-footer">
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>
</div>