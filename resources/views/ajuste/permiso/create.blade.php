@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">REGISTRAR PERMISO</font>
			</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<?php $ci=""; 
foreach($conductor as $id){
	$ci=$id->ci; 
	echo "
	<font size='4'> <b>C.I:</b>".$ci." </font><BR>   
	<font size='4'> <b> Nombre:</b>".$id->nombre." ".$id->paterno." </font>
	";

	?>
	<a class='btn btn-success fa fa-history ' href="{!!URL::to('pago_frecuencia/historial',$ci)!!} " target="_blanck"> HISTORIAL</a>
	<?php
} ?>
		</div>


<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
   
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

<hr>
{!!Form::open(['route'=>'gestionar_permiso.create', 'method'=>'GET'])!!}	
		
 

	<div class="input-group">
      <select name="ci" class="form-control selectpicker " id="ci" data-live-search="true" onchange="this.form.submit();" >
		     <option value="">  BUSCAR CONDUCTOR. . .                               </option>
		        @foreach($buscar_conductor as $mov)
		        <option name="ci" value="{{$mov->ci}}">{{$mov->nombre}} {{$mov->paterno}} - {{$mov->ci}} - {{$mov->codigo}}</option>
		        @endforeach
		    </select>
      <span class="input-group-btn ">
        <button class="btn btn-success"  >Buscar</button>
      </span>
    </div>

</form>
<?php if($ci!="")
{
	?>
	
<?php
} 
?>

<hr>
</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">




{!!Form::open(['route'=>'gestionar_permiso.store', 'method'=>'POST'])!!}	
			
		<div class="form-group" hidden="" >
		{!!Form::label('monto_frecuencia_1','Monto Frecuencia:')!!}
		{!!Form::text('monto_frecuencia',0,['class'=>'form-control','placeholder'=>'Monto Frecuencia','maxlength'=>'10','id'=>'monto_frecuencia','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()','monto_total_frecuencia()'])!!}
	</div>	
	@foreach($ajuste as $ajuste)
	<div class="form-group" hidden="">
		{!!Form::label('monto_retraso','Monto Retraso:')!!}
		{!!Form::text('monto_retraso',$ajuste->retraso_dia,['class'=>'form-control','placeholder'=>'Monto Retraso','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" hidden="">
		{!!Form::label('pro_navidad','Pro Navidad:')!!}
		{!!Form::text('pro_navidad',$ajuste->pro_navidad,['class'=>'form-control','placeholder'=>'Pro Navidad','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>
	<div class="form-group" hidden="" >
		{!!Form::label('pro_accidente','Pro Accidente:')!!}
		{!!Form::text('pro_accidente',$ajuste->pro_accidente,['class'=>'form-control','placeholder'=>'Pro Accidente','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group" hidden="">
		{!!Form::label('ahorro','Ahorro:')!!}
		{!!Form::text('ahorro',$ajuste->ahorro,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
    @endforeach
    <div class="form-group"  >
		{!!Form::label('obsercaciones','Observaciones:')!!}
		{!!Form::textarea('observaciones','',['class'=>'form-control','placeholder'=>'Observaciones'])!!}
	</div>
	<div class="form-group" hidden="">
        {!!Form::select('permiso', array('1' => 'CON PERMISO'),null,array('id'=>'permiso','class'=>'form-control'))!!}	
	</div>
	<div class="form-group"   >
		{!!Form::label('monto_total','Monto Total:')!!}
		{!!Form::text('monto_total',0,['class'=>'form-control','placeholder'=>'Monto Total','maxlength'=>'10'])!!}
	</div>	
	
	<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
	<input type="hidden" name="ci" id="ci" value="<?php echo $ci;?>">  


		<div class="form-group">
			{!!Form::submit('REGISTRAR PERMISO',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
			<a href="{!!URL::to('gestionar_permiso')!!}" class="btn btn-danger">CANCELAR</a>
			<?php //{!!Form::reset('CANCELAR',['class'=>'btn btn-danger'])!!} ?>
		</div>


</div>	


		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<font size="4"><label>Deuda de Pago Por Frecuencia:</label></font><br>

		
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>FECHA</center></th>
						<th><center>DIA</center></th>
						<th><center>MONTO</center></th>
						<th><center>SELECCIONAR</center></th>
					</thead>
					<tbody align="center" id="body_moto">					
					@foreach($frecuencia as $deuda)
					<tr>
						<td>{{ $deuda->fecha_inicio}}</td>
						<td>{{ obtener_dia($deuda->fecha_inicio)}}</td>
						<td>{{ $deuda->monto}}</td>
						<td align="center">
						  <div class="material-switch pull-center">
		       				 <input id="{{$deuda->id}}" name="{{$deuda->id}}"  type="checkbox"   value="0"  />
		      			     <label for="{{$deuda->id}}" class="label-success" onclick="cambiar_value_id({{$deuda->id}});" ></label>
		    			 </div>
		

						</td>
					</tr>
					@endforeach
					</tbody>
			</table>

		</div>
	






	</div>
    <?php
	function obtener_dia($fecha){
		$dia="";
		$numero=date('N',strtotime($fecha));
		switch ($numero) {
			case 1:
				$dia="Lunes";
				break;
			case 2:
				$dia="Martes";
				break;
			case 3:
				$dia="Miercoles";
				break;
			case 4:
				$dia="Jueves";
				break;
			case 5:
				$dia="Viernes";
				break;
			case 6:
				$dia="Sabado";
				break;	
			case 7:
				$dia="Domingo";
				break;					
		}
		return $dia;
	}
	?>

	</form>
	
   {!!Html::script('js/pago_frecuencia_crear.js')!!}	
</div>
 
	@endsection