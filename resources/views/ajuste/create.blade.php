@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

 
<div class="row">
	<?php
	$existe=0;
	foreach ($ajuste as $key => $value) {
		$anio=date('Y');
		if($value->anio==$anio){
			$existe=1;
		}
	}

	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  @if($existe==1) hidden="" @endif>
 <div class=" panel panel-success">
      	<div class="panel-heading"><label>Registrar una nueva configuración del año </label><font size="6" ><b><?php $anio=date('Y'); echo "  ".$anio;?></b></font></div>
      	<div class="panel-body">

 <div class="table-responsive" style="overflow-x:inherit">	
	 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')
	
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
{!!Form::open(['route'=>'ajuste.store', 'method'=>'POST'])!!}	
			
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  

		<div class="form-group" >
		Frecuencia por día:
		{!!Form::text('frecuencia_dia','13',['class'=>'form-control','placeholder'=>'Freccuencia por dia','maxlength'=>'10'])!!}
	</div>	
	<div class="form-group" >
		Frecuencia por semana:
		{!!Form::text('frecuencia_semana',50,['class'=>'form-control','placeholder'=>'Freccuencia por semana','maxlength'=>'10'])!!}
	</div>	


	<div class="form-group" hidden="">
		Frecuencia por mes:
		{!!Form::text('frecuencia_mes',200,['class'=>'form-control','placeholder'=>'Freccuencia por mes','maxlength'=>'10'])!!}
	</div>


	<div class="form-group" >
		Retraso por día:
		{!!Form::text('retraso_dia',0,['class'=>'form-control','placeholder'=>'Retraso por día','maxlength'=>'10'])!!}
	</div>

	</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


	<div class="form-group" hidden="" >
		Pro navidad:
		{!!Form::text('pro_navidad',0,['class'=>'form-control','placeholder'=>'Pro navidad','maxlength'=>'10'])!!}
	</div>	
		<div class="form-group" hidden="">
			Dias de cobro de frecuencia:
			<select class="custom-select form-control dropdown-toggle" 
                           data-toggle = "dropdown" name="dia_cobro" value='1' id="dia_cobro" >
             <option  value="1" selected>Lunes</option>
             <option  value="2" >Martes</option>
             <option  value="3" >Miercoles</option>
             <option  value="4" >Jueves</option>
             <option  value="5" >Viernes</option>
             </select>
		</div>
             	<div class="form-group">
		Cantidad de dia de tolerancia:
			<select class="custom-select form-control dropdown-toggle" 
                           data-toggle = "dropdown" name="cantidad_tolerancia_cobro" value='1' id="cantidad_tolerancia_cobro" >
             <option  value="1" selected>1</option>
             <option  value="2" >2</option>
             <option  value="3" >3</option>
             <option  value="4" >4</option>
             <option  value="5" >5</option>
             <option  value="6" >6</option>
             </select>
        </div>
		
		<div class="form-group" >
				Pro accidente:
				{!!Form::text('pro_accidente',0,['class'=>'form-control','placeholder'=>'Pro accidente','maxlength'=>'10'])!!}
			</div>	

			<div class="form-group">
		Número de recibo (Pagos de frecuencia):
		<table>
        	<tr>
        		<td>
        			
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="inicio_recibo" aria-describedby="start-date" class="form-control" value="100" placeholder="Inicio">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-up"></span></span>
					</div></div>
        		</td>
        		<td>
        			<i class="fa fa-arrows-h form-group"></i>
        		</td>
        		<td>
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="fin_recibo" aria-describedby="start-date" class="form-control" value="3000" placeholder="Fin">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-down"></span></span>
					</div></div>
        		</td>
        	</tr>
        </table>
        </div>

 </div>

		
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

	
	<div class="form-group" hidden="" >
		Ahorro:
		{!!Form::text('ahorro',0,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10'])!!}
	</div>	
	<input type="hidden" name="anio" id="anio" value="<?php echo $anio;?>">  
	

</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">



       <div class="form-group" hidden="">
		Número de Facturacion:
		<table>
        	<tr>
        		<td>
        			
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="inicio_factura" aria-describedby="start-date" class="form-control" value="100" placeholder="Inicio">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-up"></span></span>
					</div></div>
        		</td>
        		<td>
        			<i class="fa fa-arrows-h form-group"></i>
        		</td>
        		<td>
        			<div class="form-group"><div class="input-group">
					   <input type="number" name="fin_factura" aria-describedby="start-date" class="form-control" value="3000" placeholder="Fin">
					    <span class="input-group-addon" id="start-date"><span class="fa fa-arrow-down"></span></span>
					</div></div>
        		</td>
        	</tr>
        </table>
        </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="form-group">
			{!!Form::submit('REGISTRAR',['class'=>'btn btn-success','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}
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
      	<div class="panel-heading"><label>Historial de configuraciones </label> </div>
      	<div class="panel-body">
		<div class="table-responsive" style="overflow-x:inherit">	
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					
					<thead>
						<th><center>AÑO</center></th>
						<th><center>Frecuencia por dia</center></th>
						<th><center>Cantidad de tolerancia</center></th>
						<th><center>Retraso por día</center></th>
						<th><center>Pro accidente</center></th>
						<th><center>Nro recibos(pago frecuencia)</center></th>
						<th><center>. . .</center></th>
					</thead>
					
					<tbody>
						@foreach($ajuste as $mot)
					<tr align="center">
						<td>{{ $mot->anio}}</td>
						<td>{{ $mot->frecuencia_dia}} Bs</td>
						<td>{{ $mot->cantidad_tolerancia_cobro}} días</td>
						<td>{{ $mot->retraso_dia}} Bs</td>
						<td>{{ $mot->pro_accidente}} Bs</td>
						<td>{{ $mot->numero_inicio_recibo}} - {{$mot->numero_fin_recibo}}</td>
						<td>
						<a href="{{$mot->anio}}/edit"><i class="fa fa-pencil-square-o btn btn-link" aria-hidden="true"></i></a>
					
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