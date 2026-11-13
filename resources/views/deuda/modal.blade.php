 


<!--//////////////////////////////////-->
<!--MODAL PAGO DE MOTISTA-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalPagarConductor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
          <h3 class="modal-title"><b>PAGO DE DEUDAS</b></h3>
      </div>

      <div class="modal-body">
      {{Form::open(array('url' => 'pagar_deuda_conductor'))}}  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <div class="form-group"   >
    <LABEL id="tipo_deuda"></LABEL>
     <span > 
      
    </div>
  </div>

  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" align="left">
          <label>NRO DE DEUDA:</label>
        <label id="codigo_fac"></label> <br><br>
        <label>CONDUCTOR:</label><br>
        <label id="nombre_fac"></label> <br>
         <input type="hidden" name="id_deuda" id="id_deuda">

 </div>
 
<input type="hidden" name="id_admin" id="id_admin" value="{{Auth::user()->id}}">
        
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">
        <label>MONTO TOTAL:</label><br>
        <font size="6" id="monto_total"></font> <font size="4"> Bs.</font> <br>
        <label>MONTO A PAGAR:</label><br>
        <font size="6" id="monto_pagar"></font> <font size="4"> Bs.</font> <br>
        <input type="hidden" name="monto_aux" id="monto_aux">         
  </div>

  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            {!!Form::label('monto','MONTO:')!!} 
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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
      {!!Form::submit('ACEPTAR',['class'=>'btn btn-primary','id'=>'btn_pagar','onclick'=>'ocultar()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button></div>
  </div>
    </div>
  </div>
</div>


 