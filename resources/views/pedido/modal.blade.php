
<div class="modal fade" id="Modal_pedido_sin_aceptar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">DETALLE DEL PEDIDO O RESERVA</h3>
            </div>

            <div class="modal-body">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-success">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Descripción:
                     <label id="direccion_pedido_s"></label> 
                  
                  </div>
                  
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Estado:
                     <label id="estado_pedido_s"></label>
                  </div>       

               
              </div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-primary">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  ">
              <h2>Pasajero</h2>
                  <img src=""  id="perfil_pasajero_s" width="150px" height="150px" style="border-radius: 10px;" />

                  <div class="form-group">
                      <label id="pasajero_s"> </label>
                  </div>


                  <div class="form-group">
                  Celular Pasajero:
                     <label id="celular_pasajero_s"></label>
                  </div>
                  <div class="form-group">
                  Correo:
                  <label id="correo_s"></label>
                  </div>
                          
               
              </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 ">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <tbody align="center" id="body_punto_pedido_usuario_sin_aceptar">
                    </tbody>
                  </table>
          </div>    
              
        </div>

      </div>

      <div class="modal-footer">

           
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>
</div>


<!--//////////////////////////////////-->
<!--MODAL perfil-->
<!--//////////////////////////////////-->
<div class="modal fade" id="Modal_pedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">DETALLE DEL PEDIDO</h3>
            </div>

            <div class="modal-body">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-success">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Referencia:
                     <label id="direccion_pedido"></label> <br>
                  Calificación del conductor:<i class="fa fa-star "   aria-hidden="true"></i> <label id="calificacion_conductor"></label><br>
                  Calificación del vehículo: <i class="fa fa-star" aria-hidden="true"></i> <label id="calificacion_vehiculo"></label>
                  
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Monto total:
                  <label id="monto_total"></label>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  Estado:
                     <label id="estado_pedido"></label>
                  </div>       

               
              </div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-primary">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  ">
              <h2>Pasajero</h2>
                  <img src=""  id="perfil_pasajero" width="150px" height="150px" style="border-radius: 10px;" />

                  <div class="form-group">
                      <label id="pasajero"> </label>
                  </div>


                  <div class="form-group">
                  Celular Pasajero:
                     <label id="celular_pasajero"></label>
                  </div>
                  <div class="form-group">
                  Correo:
                  <label id="correo"></label>
                  </div>
                          
               
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  " >
                <h2>Conductor</h2>
                  <img src=""  id="perfil_conductor" width="150px" height="150px" style="border-radius: 10px;"/>
                  <br>
                   <a id="btn_detalle_conductor"  class="btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver datos del conductor">Ver mas detalles</a>
                  <div class="form-group">
                    <label id="conductor"></label>
                  </div>

                  <div class="form-group">
                      Cedula:
                      <label id="cedula"></label>
                  </div>

                  <div class="form-group">
                  Celular conductor:
                      <label id="celular_conductor"></label>
                  </div>
                  <div class="form-group">
                  Categoria de Licencia:
                      <label id="categoria_licencia"></label>
                  </div>
                          
                   <div class="form-group">
                   Dirección:
                      <label id="direccion"></label>
                   </div>

              </div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
               <h2>Vehículo</h2>
                  <img src=""  id="imagen_delantero" width="150px" height="150px" style="border-radius: 10px;" />
                  <br>
                   <a id="btn_detalle_vehiculo" class="btn btn-link" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver datos del Vehículo">Ver mas detalles</a>
                  <div class="form-group">
                      Vehiculo:
                      <label id="marca"></label>
                  </div>

                  <div class="form-group">
                      Placa:
                      <label id="placa"></label>
                  </div>

                  <div class="form-group">
                      Modelo:
                      <label id="modelo"></label>
                  </div>
                  <div class="form-group">
                      Color:
                      <label id="color"></label>
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
                  <label id="indicacion"  ></label> 
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


                   <table class="table table-striped table-bordered table-condensed table-hover">
                    <tbody align="center" id="body_punto_pedido_usuario">
                    </tbody>
                  </table>

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

                   <table class="table table-striped table-bordered table-condensed table-hover">
                    <tbody align="center" id="body_punto_pedido">
                    </tbody>
                  </table>
              </div>
             
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
