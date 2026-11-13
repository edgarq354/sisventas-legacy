@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.errors')









<!--//////////////////////////////////-->
<!--DAR DE BAJA AL VEHICULO CON LA DESCRIPCION DE LA BAJA-->
<!--//////////////////////////////////-->
<div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color: white">
        <h3 id="titulogalpon" class="modal-title"><b>ACTUALIZAR USUARIO</b></h3>
      </div>

      <div class="modal-body">
    {{Form::open(array('url' => 'actualizar_usuario_contrasenia'))}}
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" name="token_not" id="token_not">
              <input type="hidden" name="id_administrador" id="id_administrador" value="{{$usuario[0]->id}}">

              <div class="form-group" >
               {!!Form::label('','Usuario:')!!}
              <div class='input-group'  >
                <input type='text' class="form-control" id="codigo" name="codigo" value="{{$usuario[0]->codigo}}" style="font-size:20px;text-align:left" />
                <span class="input-group-addon ">
                   <span class="fa fa-user" aria-hidden="true"></span>
                </span>
              </div>
            </div>

              <div class="form-group">
                  {!!Form::label('detalle','Contraseña:')!!}
                  {!!Form::text('contrasenia',$usuario[0]->contrasenia,['id'=>'detalle','class'=>'form-control'])!!}
              </div>


      </div>



  </div>

  <div class="modal-footer">
      {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_notificacion','onclick'=>'btn_esconder()'])!!}
      </form>
          <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
      <button data-dismiss="modal"  class="btn btn-danger">CANCELAR</button>
  </div>
    </div>
  </div>
</div>




<div class="row">



@foreach($usuario as $con)

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


     <a>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner fa fa-link fa-2x">
            </div>

           <label>{{base_convert("1999".$con->id, 10,16)}}</label>

          <p class="small-box-footer">Codigo de Usuario</p>
          </div>
        </div>
        </a>

          <div class="col-lg-2 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner fa fa-money fa-2x">
            </div>
            {{$con->billetera}}
             <a  class="small-box-footer">Mi Billetera </a>
          </div>
        </div>

 <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner fa fa-list fa-2x">
            </div>
              Bloqueos
             <a  class="small-box-footer" target="_blank"  href='../../historial_bloqueo_pasajero/{{$con->id}}'>
              Ver
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
  </div>

   <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner fa fa-print fa-2x">
            </div>
              Carreras
             <a  class="small-box-footer" target="_blank"  href='../../historial_pedidos/{{$con->id}}'>
              Ver
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
   </div>

    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner fa fa-key fa-2x">
            </div>
              Usuario
             <a  class="small-box-footer" href="" target="_blank"   data-toggle="modal" data-target="#ModalUsuario"   data-toggle="tooltip" data-placement="top" title="Actualizar usuario">
              Actualizar
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>


   </div>

</div>








<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      @include('alerts.request')



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <h2 align="left" style="color:black;">DATOS DEL PASAJERO</h2> </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

   <div class="form-group">
    {!!Form::label('direccion_imagen','Foto De Perfil :')!!}
    <br>
      <input type="text" hidden="" name="perfil" id="perfil" style="cursor: pointer;"  />
        <a href="../../../../taxivalle2/{{$con->direccion_imagen}}"  target="_blank"><img  src="../../../../taxivalle2/{{$con->direccion_imagen}}" name="foto_conductor"  style="width: 100px; height: 100px;" alt="FOTO" title="PERFIL" class="img-thumbnail"></a>
  </div>

  <div class="form-group" >
    {!!Form::label('nombre','Nombre:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('nombre',$con->nombre,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el nombre del conductor'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('','Apellidos:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('apellido',$con->apellido,['class'=>'form-control text-capitalize','placeholder'=>'Ingrese el apellido '])!!}
  </div>


   <div class="form-group"  >
    {!!Form::label('celular','Celular:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('celular',$con->celular,['class'=>'form-control','placeholder'=>'Ingrese el celular','maxlength'=>'8'])!!}
  </div>







</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


  <div class="form-group"  >
    {!!Form::label('imei','Imei:')!!}

    <div class="input-group">
      <input type="text" class="form-control" name="imei" value="{{$con->imei}}" enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-secondary " data-toggle="modal" data-target="#historial_imei"    type="button"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div>

  <div class="form-group"  >
    {!!Form::label('correo','Correo:')!!}
    {!!Form::text('correo',$con->correo,['class'=>'form-control','placeholder'=>'Ingrese el correo'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('usuario','Usuario:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('codigo',$con->codigo,['class'=>'form-control','placeholder'=>'Ingrese el usuario','maxlength'=>'15'])!!}
  </div>

  <div class="form-group"  >
    {!!Form::label('contrasenia','Contraseña:')!!}<span ><font color="black" size="5px">*</font></span>
    {!!Form::text('contrasenia',$con->contrasenia,['class'=>'form-control','placeholder'=>'Ingrese ls contraseña','maxlength'=>'15'])!!}
  </div>

   <div class="form-group" >
      {!!Form::label('','Estado:')!!}
            {!!Form::select('estado', array('0'=>'BLOQUEADO','1' => 'ACTIVO'),$con->estado,array('id'=>'estado','class'=>'form-control'))!!}
  </div>

</div>


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">







  <div class="form-group"  >
    {!!Form::label('','Id Usuario Registro:')!!}
    <div class="input-group">
      <input type="text" class="form-control" name="id_usuario_registro" value="{{$con->id_usuario_registro}}" enabled="">
      <span class="input-group-btn">
        <a><button class="btn btn-secondary "><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      </span>
    </div>
  </div>

 <div class="form-group">
            {!!Form::label('','Fecha de registro:')!!}

            {!!Form::text('',$con->fecha_registro,['class'=>'form-control','maxlength'=>'20'])!!}
    </div>

<div class="form-group">
            {!!Form::label('','Aplicación:')!!}

            {!!Form::text('',$con->aplicacion,['class'=>'form-control','maxlength'=>'20'])!!}
    </div>











</div>



<input type="hidden" name="token" id="token" value="{{$con->token}}">

@endforeach


</div>



</div>



@endsection


