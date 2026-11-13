
<div class="modal fade" id="Modal_nuevo_pasajero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      

  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">

            <div class="modal-header" style="background: #3c8dbc; color: white">
              <h3 id="titulogalpon" class="modal-title">Registrar un nuevo pasajero</h3>
            </div>

            <div class="modal-body">

             

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
    <div class="form-group" >
    {!!Form::label('','Celular:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('celular',null,['class'=>'form-control text-capitalize','placeholder'=>'Telefono'])!!}
    </div> 
     <div class="form-group" >
    {!!Form::label('nombre','Nombre del Conductor:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('nombre',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
    </div> 
     <div class="form-group"  >
    {!!Form::label('','Apellidos:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('apellidos',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido'])!!}
  </div>
  </div>
 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
  <div class="form-group"  >
    {!!Form::label('','Direccion:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('direccion',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese la dirección'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('','Indicación:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::text('indicacion',null,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese alguna indicacion'])!!}
  </div>  
  <div class="form-group"  >  
    {!!Form::label('correo','Correo:')!!}
    {!!Form::text('correo',null,['class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
   </div>  
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{!!Form::label('domicilio','Ubicacion de su Domicilio :')!!}<span ><font color="red" size="5px">*</font></span>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" class="form-control">
    <div id="mapa2" style=" height: 550px;"></div>
</div>  
   
 {!!Form::hidden('latitud',null,['class'=>'form-control','placeholder'=>'Ingrese la latitud','maxlength'=>'30'])!!}
{!!Form::hidden('longitud',null,['class'=>'form-control','placeholder'=>'Ingrese la longitud','maxlength'=>'30'])!!}
 
              
        </div>

      </div>

      <div class="modal-footer">

           
            <button data-dismiss="modal"  class="btn btn-danger">SALIR</button>
        </div>
    </div> 
  </div>


</div>



