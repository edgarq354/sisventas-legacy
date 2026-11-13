
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>
<script type="text/javascript">
  
function comprobante_egreso_pdf(){  
  var id_egreso=$('#id_egreso').val();
  if(id_egreso!="")
  {
    window.open('egreso/comprobante_egreso_pdf/'+id_egreso,'_blank');
  }
}

window.onload=comprobante_egreso_pdf;




</script>
	<div class="row">

	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  <div class=" well">

  <input type="hidden" name="id_egreso" id="id_egreso" value="{{$id_egreso}}">


{!!Form::open(['route'=>'egreso.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

  <h4 align="left" style="color: red">REGISTRAR EGRESOS</h4>
 
      
    He pagado a:
    <div class="input-group">

      <select name="id_cliente" class="form-control selectpicker" id="id_cliente" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($buscar_cliente as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} - {{$mov->telefono}} - {{$mov->ci_nit}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('cliente/create')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>

Tipo de egreso:
 <div class="input-group">
       <select name="id_tipo" class="form-control selectpicker" id="id_tipo" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($buscar_tipo as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('tipo_ingreso_egreso/create')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>
       
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="form-group">
		Monto Total:<br>
		<input type="number"  name="monto" placeholder="Ingrese el Monto" class="form-control" id="monto" value="0" >
	</div>

  <div class="form-group">
    Debe:<br>
    <input type="number"  name="saldo" placeholder="Saldo" value="0" class="form-control" id="saldo" >
  </div>
  </div>

  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  <div class="form-group">
    Cheque Nº:<br>
    <input type="number"  name="numero_cheque" placeholder="Ingrese el Numero de Cheque" class="form-control" id="numero_cheque" value="0" >
  </div>

  <div class="form-group">
    Banco:<br>
    <input type="text"  name="banco" placeholder="Banco" value="ninguno" class="form-control" id="banco" >
  </div>
  </div>

	<div class="form-group">
		Por conceptp de:<br>
		{!!Form::textarea('observaciones',null,['class'=>'form-control','placeholder'=>'Ingrese las observaciones','style'=>'height:100px' ])!!}
	</div>

		<div align="left">

			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('egreso')!!}" class="btn btn-danger">CANCELAR</a>

</div>

		</form>
		
  </div>
  </div>






<!--Registrar pago de empleados-->
  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" hidden="">
  <div class=" well">
{!!Form::open(['route'=>'egreso.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

  <h4 align="left" style="color: red">Registrar pago de Sueldo</h4>
  Nombre del empleado:
    <div class="input-group">
      <select name="id_cliente" class="form-control selectpicker" id="id_cliente" data-live-search="true" >
         <option value="">  Buscar el empleado ...</option>
            @foreach($buscar_empleado as $mov)
            <option value="{{$mov->ci}}">{{$mov->nombre}} - {{$mov->celular}}</option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('empleado')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>

Tipo de egreso:
 <div class="input-group">
       <select name="id_tipo" class="form-control selectpicker" id="id_tipo" data-live-search="true" >
         <option value="">  BUSCAR...                                </option>
            @foreach($buscar_tipo as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('tipo_ingreso_egreso/create')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>
       

  <div class="form-group">
    Monto Total:<br>
    <input type="number"  name="monto" placeholder="Ingrese el Monto" class="form-control" id="monto" value="0" >
  </div>

  <div class="form-group">
    Debe:<br>
    <input type="number"  name="saldo" placeholder="Saldo" value="0" class="form-control" id="saldo" >
  </div>

  <div class="form-group">
    Observaciones:<br>
    {!!Form::textarea('observaciones',null,['class'=>'form-control','placeholder'=>'Ingrese las observaciones' ])!!}
  </div>

    <div align="left">

      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
      <a href="{!!URL::to('egreso')!!}" class="btn btn-danger">CANCELAR</a>

</div>

    </form>
    
  </div>
  </div>
  </div>
   {!!Html::script('js/crear_empresa.js')!!}

@endsection

