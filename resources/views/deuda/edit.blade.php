
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')




	<div class="row">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <h4 align="left" style="color: red">ACTUALIZAR DEUDA</h4>
</div>      

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
 



{!!Form::open(['route'=>['deuda.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 
<input type="hidden" name="id_conductor" value="{{$deuda[0]->id_conductor}}"> 
<input type="hidden" name="id_deuda" value="{{$deuda[0]->id}}"> 
      
    <div class="input-group">
      Fecha:<br>
      <label>{{$deuda[0]->fecha_registro}}</label>
    </div>
    <div class="input-group">
      Conductor:<br>
      <label>{{$deuda[0]->conductor}}</label>
    </div>

Tipo de deuda:
 <div class="input-group">
       <select name="id_tipo_deuda" class="form-control selectpicker" id="id_tipo_deuda" data-live-search="true" >
         <option value="{{$deuda[0]->id_tipo_deuda}}">  BUSCAR TIPO DE DEUDA...                                </option>
            @foreach($tipo as $mov)
            <option value="{{$mov->id}}" @if($mov->id==$deuda[0]->id_tipo_deuda) selected="selected" @endif  >{{$mov->nombre}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('tipo_ingreso_egreso/create')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>
 
<div class="form-group" >
    {!!Form::label('','Estado:')!!} 
  {!!Form::select('estado', array( '0' => 'CON DEUDA', '1' => 'SIN DEUDA'),$deuda[0]->estado,array('class'=>'custom-select form-control dropdown-toggle','data-toggle' => 'dropdown'))!!}
  </div>  
	


 
  
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <div class="form-group">
    Monto Total:<br>
    <input type="number"  name="monto" placeholder="Ingrese el Monto" class="form-control" id="monto" value="{{$deuda[0]->monto}}" >
  </div>
    <div class="form-group">
    Monto a pagar:<br>
    <input type="number"  name="monto_pagar" placeholder="Ingrese el Monto a pagar" class="form-control" id="monto_pagar" value="{{$deuda[0]->monto_pagar}}" >
  </div>
	<div class="form-group">
		Por conceptp de:<br>
		{!!Form::textarea('descripcion',$deuda[0]->descripcion,['class'=>'form-control','placeholder'=>'Ingrese las descripcion','style'=>'height:100px' ])!!}
	</div>

		<div align="left">

			{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('deuda')!!}" class="btn btn-danger">CANCELAR</a>

  </div>

		</form>
		
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <br>
     <br>
    <h3>DETALLES DE PAGOS REALIZADOS</h3>
   
    <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
          <thead>
            <th><center>Id</center></th>
            <th><center>Fecha</center></th>
            <th><center>Observacion</center></th>
            <th><center>Usuario</center></th>
            <th><center>Monto pagado</center></th>
            <th><center>Saldo</center></th>
            
          </thead>

          <tbody id="body_cliente">         
          @foreach($detalle_ingreso as $usr)
          <tr>
            <td><center>{{$usr->id}}</center></td>
            <td><center>{{$usr->fecha}}</center></td>
            <td><center>{{$usr->observacion}}</center></td>
            <td><center>{{$usr->usuario}}</center></td>
            <td><center>{{$usr->monto}}</center></td>
            <td><center>{{$usr->saldo}}</center></td>
          </tr>
          @endforeach
          </tbody>
         
        </table>

  </div>
 

 
  </div>
   {!!Html::script('js/crear_empresa.js')!!}

@endsection

