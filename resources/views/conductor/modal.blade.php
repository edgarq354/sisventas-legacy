
<!--//////////////////////////////////-->
<!--MODAL DE VER PERFILDEL MOTISTA-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalTaxi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title"><b>PERFIL DEL MOTISTA</b></h3>
            </div>

            <div class="modal-body">
        {!!Form::open(['route'=>['vehiculo.update','null'],'method'=>'PUT'])!!}   

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  
                  <div class="form-group">
                      {!!Form::label('Nombre','Nombre:')!!}
                      {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>'Ingrese el nombre'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('apellido','Apellido:')!!}
                      {!!Form::text('apellido',null,['id'=>'apellido','class'=>'form-control','placeholder'=>'Ingrese el apellido'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('ci','CI:')!!}
                      {!!Form::text('ci',null,['id'=>'ci','class'=>'form-control','placeholder'=>'Ingrese el CI','maxlength'=>'12'])!!}
                  </div>

                  <div class="form-group">
                      {!!Form::label('celular','Celular:')!!}
                      {!!Form::text('celular',null,['id'=>'celular','class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8'])!!}
                      <input type="hidden" name="celular_aux" id="celular_aux">
                  </div>
                  <div class="form-group">
                      {!!Form::label('contrasenia','Contraseña:')!!}
                      {!!Form::text('contrasenia',null,['id'=>'contrasenia','class'=>'form-control','placeholder'=>'Ingrese la contrasenia','maxlength'=>'4'])!!}
                  </div>            
                  <div class="form-group">
                      {!!Form::label('correo','Correo:')!!}
                      {!!Form::email('correo',null,['id'=>'correo','class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('marca','Marca:')!!}
                      {!!Form::text('marca',null,['id'=>'marca','class'=>'form-control','placeholder'=>'Ingrese la marca'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('modelo','Modelo:')!!}
                      {!!Form::text('modelo',null,['id'=>'modelo','class'=>'form-control','placeholder'=>'Ingrese el modelo','maxlength'=>'4', 'onkeypress'=>'return bloqueo_de_punto(event)'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('placa','Placa:')!!}
                      {!!Form::text('placa',null,['id'=>'placa','class'=>'form-control','placeholder'=>'Ingrese la placa','maxlength'=>'10'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('color','Color:')!!}
                      {!!Form::text('color',null,['id'=>'color','class'=>'form-control','placeholder'=>'Ingrese la color'])!!}
                  </div>    
                  <div class="form-group">
                      {!!Form::label('tipo_taxi','Tipo De Taxi:')!!}
                      {!!Form::text('tipo_taxi',null,['id'=>'tipo_taxi','class'=>'form-control','placeholder'=>'Ingrese el tipo de taxi'])!!}
                  </div>
                  <div class="form-group" hidden="">
                      {!!Form::label('credito','Credito:')!!}
                      {!!Form::text('credito',null,['id'=>'credito','class'=>'form-control','placeholder'=>'Ingrese el credito','maxlength'=>'2',])!!}
                  </div>
                  <div class="form-group" hidden="">
                      {!!Form::label('latitud','Latitud:')!!}
                      {!!Form::text('latitud',null,['id'=>'latitud','class'=>'form-control','placeholder'=>'Ingrese la latitud'])!!}
                  </div>
                  <div class="form-group" hidden="">
                      {!!Form::label('longitud','Longitud:')!!}
                      {!!Form::text('longitud',null,['id'=>'longitud','class'=>'form-control','placeholder'=>'Ingrese la longitud'])!!}
                  </div>    
                    <div class="form-group">
                      {!!Form::label('estado','Estado:')!!}
                      {!!Form::select('estado', array('0' => 'INACTIVO', '1' => 'ACTIVO', '2' => 'BLOQUEADO'),null,array('id'=>'estado','class'=>'form-control'))!!}
                      
                  </div>
                  <div class="form-group">
                      {!!Form::label('login','Login:')!!}
                      {!!Form::select('login', array('0' => 'DESCONECTADO', '1' => 'CONECTADO'),null,array('id'=>'login','class'=>'form-control'))!!}                
                  </div>
                  <div class="form-group" hidden="">
                      {!!Form::label('token','Token:')!!}
                      {!!Form::text('token',null,['id'=>'token','class'=>'form-control','placeholder'=>'Ingrese el token'])!!}
                  </div>
              </div>

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="center">
                  <input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id}}">              
                  <input type="hidden" name="id_taxi" id="id_taxi">
                  <!--img src="" id="foto"-->
                  <label>FOTO DE PERFIL</label><br>
                  <img id="logo" src="" alt="Cargar Imagen" onclick="cargarImagen(this, 1)" class="point img-circle"/><br>
                  <input type="hidden" name="imagen" id="imagen"> <br><br>


                  <label>FOTOS DEL VEHICULO</label><br>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="center">
                    <img id="logo_1" src="" alt="Cargar Imagen" onclick="cargarImagen_1(this, 1)" class="point img-thumbnail"/>
                    <input type="hidden" name="imagen_1" id="imagen_1">    
                    <br><br>
                    <img id="logo_2" src="" alt="Cargar Imagen" onclick="cargarImagen_2(this, 1)" class="point img-thumbnail"/>
                    <input type="hidden" name="imagen_2" id="imagen_2">    
                  </div>
                   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="center">
                  <img id="logo_3" src="" alt="Cargar Imagen" onclick="cargarImagen_3(this, 1)" class="point img-thumbnail"/>
                  <input type="hidden" name="imagen_3" id="imagen_3">     
                  <br><br>
                  <img id="logo_4" src="" alt="Cargar Imagen" onclick="cargarImagen_4(this, 1)" class="point img-thumbnail"/>
                  <input type="hidden" name="imagen_4" id="imagen_4"> 
                  </div>
              </div>
            <div>
          </div>
        </div>
<br><br><br><br><br><br><br><br><br><br>
        <div class="modal-footer">

            {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
            </form>
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>
</div>


<!--//////////////////////////////////-->
<!--MODAL DE ENVIAR NOTIFICACIONES-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalNotificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>ENVIAR NOTIFICAION</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'notificacion_conductor'))}}  
      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
              
              <div class="form-group">
                  {!!Form::label('detalle','Mensaje:')!!}
                  {!!Form::textarea('detalle',null,['id'=>'detalle','class'=>'form-control','rows'=>'5','placeholder'=>'Ingrese el mensaje'])!!}
              </div>  
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <b>Nombre:</b> <font id="nombre_not" size="3"></font> <br>
          <b>CI:</b> <font id="ci_not" size="3"></font> <br>
          
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="center">
            <input type="hidden" name="id_taxi_not" id="id_taxi_not">
            <img id="logo_not" src="" class="point img-circle"/>      
      </div>

  </div>

  <div class="modal-footer">
      {!!Form::submit('ENVIAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>




 
 



<!--//////////////////////////////////-->
<!--MODAL PAGO DE MOTISTA-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalPagarConductor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
          <h3 class="modal-title"><b>PAGO DEL CONDUCTOR</b></h3>
      </div>

      <div class="modal-body">
      {{Form::open(array('url' => 'pagar_empresa_conductor'))}}  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <div class="form-group"   >
    {!!Form::label('','Tipo de egreso (PAGO DE DEUDA SERVICIO CORPORATIVO) :')!!}<span > 
      <select name="id_tipo_ingreso_egreso" class="form-control selectpicker" id="id_tipo_ingreso_egreso" data-live-search="true" >
              @foreach($tipo as $mov)
              <option value="{{$mov->id}}">{{$mov->nombre}}</option>
              @endforeach
      </select>
    </div>
  </div>

  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" align="left">
        <label>CONDUCTOR:</label><br>
        <label id="nombre_fac"></label> <br>
 </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" align="left">
        <label>CODIGO:</label><br>
        <label id="codigo_fac"></label> <br>
          
        <input type="hidden" name="id_conductor_fac" id="id_conductor_fac">
  </div>
<input type="hidden" name="id_admin" id="id_admin" value="{{Auth::user()->id}}">
        
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">
        <label>MONTO A PAGAR:</label><br>
        <font size="6" id="monto_pagar"></font> <font size="4"> Bs.</font> <br>
        <input type="hidden" name="monto_aux" id="monto_aux">         
  </div>

  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
            {!!Form::label('monto','MONTO TOTAL:')!!} 
            {!!Form::text('monto',null,['id'=>'monto','class'=>'form-control','maxlength'=>'6','placeholder'=>'Ingrese el monto total', 'onkeypress'=>'return numerosmasdecimal(event)'])!!}
        </div> 
  </div>
   
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
   <div class="form-group">
       {!!Form::label(' ','Observación:')!!}
       {!!Form::textarea('observacion',null,['class'=>'form-control','rows'=>'5','placeholder'=>'Ingrese alguna observación'])!!}
   </div>  
 </div>
  </div>

  <div class="modal-footer">
      {!!Form::submit('ACEPTAR',['class'=>'btn btn-primary','id'=>'btn_pagar','onclick'=>'ocultar()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>



<!--//////////////////////////////////-->
<!--MODAL DETALLE DE LAS CARRERAR-->
<!--//////////////////////////////////-->
<?php /*
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
            <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE5wxnO359aqjF2EWWIs9qqLenJjg-9vQ">
    </script>
      </div>

  <div class="modal-footer">
      <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
  </div>
    </div>
  </div>
</div>
*/ ?>