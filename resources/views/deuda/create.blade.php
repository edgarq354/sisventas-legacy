
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')




	<div class="row">

       
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
 



{!!Form::open(['route'=>'deuda.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

  <h4 align="left" style="color: red">REGISTRAR DEUDA</h4>
 
      
    Conductor:
    <div class="input-group">

      <select name="id_conductor" class="form-control selectpicker" id="id_conductor" data-live-search="true" >
         <option value="">  BUSCAR EL CONDUCTOR...                                </option>
            @foreach($buscar_conductor as $mov)
            <option value="{{$mov->ci}}">{{$mov->codigo_empresa}} : {{$mov->nombre}} - {{$mov->paterno}} - {{$mov->materno}} </option>
            @endforeach
        </select>

      <span class="input-group-btn ">
        <a href="{!!URL::to('conductor/create')!!}">
        <button class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</button>
        </a>
      </span>
    </div>

Tipo de deuda:
 <div class="input-group">
       <select name="id_tipo_deuda" class="form-control selectpicker" id="id_tipo_deuda" data-live-search="true" >
         <option value="">  BUSCAR TIPO DE DEUDA...                                </option>
            @foreach($buscar_tipo_ingreso_egreso as $mov)
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
		Por conceptp de:<br>
		{!!Form::textarea('descripcion',null,['class'=>'form-control','placeholder'=>'Ingrese las descripcion','style'=>'height:100px' ])!!}
	</div>

		<div align="left">

			{!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('deuda')!!}" class="btn btn-danger">CANCELAR</a>

  </div>

		</form>
		
  </div>
 

 
  </div>
   {!!Html::script('js/crear_empresa.js')!!}

@endsection

