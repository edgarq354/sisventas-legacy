@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')


<div class="row">
	<?php
	$existe=0;

	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  @if($existe==1) hidden="" @endif>
 <div class=" panel panel-success">
      	<div class="panel-heading"><H3>NUEVO CODIGO </H3> </div>
      	<div class="panel-body">

 <div class="table-responsive" style="overflow-x:inherit">	
	 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	    @include('alerts.request')
	

{!!Form::open(['route'=>'codigo.store', 'method'=>'POST'])!!}	

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  

		<div class="form-group" >
		
		{!!Form::label('','Monto:')!!}
		{!!Form::number('monto','1',['class'=>'form-control','maxlength'=>'5'])!!}
	</div>	
		<div class="form-group">
			{!!Form::label('','Usuario:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('usuario', array( '0' => 'Todos', '1' => 'Pasajero', '2' => 'Conductor'),null,array('id'=>'usuario','class'=>'form-control'))!!}
	</div>	

</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
	<div class="form-group"  >
		{!!Form::label('','Fecha inicial:')!!}
		<div class='input-group date' id='datetimepicker11'>
		  {!!Form::text('fecha_inicio',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
	</div>
	<div class="form-group">
			{!!Form::label('','Tipo:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('unico', array( '0' => 'Multiples', '1' => 'Unico' ),null,array('id'=>'unico','class'=>'form-control'))!!}
	</div>	
</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
	 <div class="form-group"  >
		{!!Form::label('','Fecha final:')!!}
	
	<div class='input-group date' id='datetimepicker10'>

		  {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  
          </span>
    </div>
      </div>

      <div class="form-group" >
   {!!Form::label('','Cantidad a generar:')!!}<span ><font color="red" size="5px">*</font></span>
    {!!Form::number('cantidad','1',['class'=>'disabled form-control','maxlength'=>'5','min'=>'1', 'max'=>30])!!}
  </div> 

      
</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
	<div class="form-group"  >
	{!!Form::submit('AGREGAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()','style'=>'padding: 17px;'])!!}
		 </div>


	

	</div>
</div>
 	</form>	




</div>
</div>
</div>
</div>	


</div>
</div>
   
   
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
 
			
	<div class=" panel panel-primary">
      	<div class="panel-heading"><H3>CODIGOS PROMOCINALES</H3> </div>
      	<div class="panel-body">
		<div class="table-responsive" style="overflow-x:inherit">	

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white; "  id="myTable">
					
					<thead>
						<th><center>Id</center></th>
						<th><center>Codigo</center></th>
						<th><center>Monto</center></th>
						<th><center>Cantidad</center></th>
						<th><center>Fecha de Inicio</center></th>
						<th><center>Fecha final</center></th>
						<th><center>Usuario</center></th>
						<th><center>Tipo</center></th>
						<th><center>. . .</center></th>
					</thead>
					
					<tbody>
						@foreach($codigo as $mot)
					<tr align="center">
						<td>{{ $mot->id}}</td>
						<td>{{ base_convert("1999".$mot->id,10,16)}}</td>
						<td>{{ $mot->monto}}</td>
						<td>{{ $mot->cantidad}}</td>
						<td>{{ $mot->fecha_inicio}}</td>
						<td>{{ $mot->fecha_fin}} </td>
						<td>@if($mot->usuario==0)
							Todos
							@elseif($mot->usuario==1)
							Pasajero
							@elseif($mot->usuario==2)
							Conductor
							@endif
						 </td>
						<td>@if($mot->unico==0)
							Multiples
							@elseif($mot->unico==1)
							Unico
							@endif
						 </td>
						<td>
						<a href="codigo/{{$mot->id}}/edit"><i class="fa fa-pencil-square-o btn btn-link" aria-hidden="true"></i></a>
					
						</td>
					</tr>
					@endforeach
					</tbody>
						
				</table>

	
			</div>
	</div>
	</div>
	</div>
 
 
 
	@endsection