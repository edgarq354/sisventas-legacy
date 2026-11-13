@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')


<script type="text/javascript">
	
function mostar_pdf(){	
	obtener_ultimo_numero();

	var pdf=$('#pdf').val();
	if(pdf==1)
	{var placa=$('#placa').val();
	 var nro=$('#nro_recibo').val();
	 	window.open('pago_frecuencia/pago_pdf/'+nro+'/'+placa,'_blank');
	}
}

function con_permiso()
{
	$("#permiso").val(1);
}
function sin_permiso(){
	$("#permiso").val(0);
}

window.onload=mostar_pdf;


function obtener_ultimo_numero(){

    $.get("../get_ultimo_numero_recibo", function (res) {

    $("#numero_label").text("Nº: "+res.numero);
    $("#numero_pago").val(res.numero);
    });

}



</script>

<style type="text/css">
	.searchable-container{margin:1px 0 0 0}
	.searchable-container label.btn-default.active{background-color:green; color:#FFF}
	.searchable-container label.btn-default{width:100%;border:1px solid #efefef ;margin:1px; box-shadow:1px 1px 1px 0 #ccc;}
	.searchable-container label .bizcontent{width:100%;}
	.searchable-container .btn-group{width:100%}
	
</style>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<a href="{!!URL::to('pago_frecuencia')!!}" class="btn btn-danger fa fa-arrow-circle-left "></a>

			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">REGISTRAR PAGO DE FRECUENCIA</font>
				<input type="hidden" name="pdf" id="pdf" value="{{$pdf}}">
				<input type="hidden" name="placa" id="placa" value="{{$placa}}">
				<input type="hidden" name="nro_recibo" id="nro_recibo" value="{{$nro_recibo}}">
			</div>


<?php 
	$ci="";
	$cantidad_deuda=0;
	$tipo_de_pago="";
 
foreach ($conductor as $key => $value) {
$ci=$value->ci;
$tipo_de_pago=$value->tipo_de_pago;
}
?>

@if($ci!="0" && $ci!="")
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
	 
  <img src="{{asset($conductor[0]->direccion_imagen)}}" style='width: 100px; height: 100px; border-radius: 5px;' alt='img.png'>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
	<font size='4'> <b>C.I:</b> {{$conductor[0]->ci}}</font> <br>  
	<font size='4'> <b> Nombre:</b>{{$conductor[0]->nombre}} {{$conductor[0]->paterno}}</font><br>
	<a class='btn btn-success fa fa-history '  href="{!!URL::to('pago_frecuencia/historial',$conductor[0]->ci)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Histoprial de pagos"> Historial</a>
	<a class='btn btn-primary fa fa-print '  href="{!!URL::to('pago_frecuencia/get_historial_deuda_pdf',$conductor[0]->ci)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Histoprial de deuda"> Imprimir</a>
	<a class='btn btn-primary fa fa-user'  href="{!!URL::to('conductors',$conductor[0]->ci)!!} " data-toggle="tooltip" data-placement="top" title="Ver el perfil"> </a>

</div>
<a href="{!!URL::to('deuda_conductor',$ci)!!} " hidden="">
	<div class="searchable-container col-lg-2 col-md-2 col-sm-2 col-xs-2  "  style="padding: 0px 0px 0px 0px;"   >
	    <label class="btn btn-default bg-yellow" for="monto_caja"   >
	        <div class="bizcontent">
	         <h3>
		       <span class="fa fa-money fa-1x  " style="color:white;"><b> {{$otras_deudas}} Bs</b></span>
		       <h3> Otras deudas </h3>
		     </h3>
	      </div>
	     </label>
	 </div>
 </a> 
	 

			 	 
			 	 	<div  class="">
			 	 		
	                <div class="searchable-container "  style="padding: 0px 0px 0px 0px;" data-toggle="buttons">
	                       
	                         <label class=" bg-red"  > 
	                             
	                                <div class="bizcontent">
	                                	
		                                    
	                                   
	                                </div>
	                          
	                          </label>  
	                      </div>
	                      
	                </div>
     			
@endif

<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
   
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<hr>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
{!!Form::open(['route'=>'pago_frecuencia.create', 'method'=>'GET'])!!}	

<label>Conductor:</label><br>

  <div class="input-group">
	      <select name="ci" class="form-control selectpicker text-uppercase" id="ci" data-live-search="true"   onchange="this.form.submit()">
					     <option value="">  Buscar el conductor . .</option>
					        @foreach($buscar_conductor as $mov)
					        <option name="ci" value="{{$mov->ci}}"  > {{$mov->codigo}} - {{$mov->nombre}} {{$mov->paterno}} </option>
					        @endforeach
					    </select>
	      <span class="input-group-btn">
	        <button class="btn btn-success" onclick="btn_esconder()" type="button">Verificar</button>
	      </span>
   </div>

</form>
<br>
</div>

</div>
{!!Form::open(['route'=>'pago_frecuencia.store', 'method'=>'POST','id'=>'pagar_formulario','name'=>'pagar_formulario'])!!}	
 
 @include('alerts.request')
@if($ci!='0' && isset($_GET['ci']))

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

    	   
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="4"><label>Deuda de Pago Por Frecuencia:</label></font><br>

		
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>Id</center></th>
						<th><center>NRO SEMANA</center></th>
						<th><center>FECHA INICIO</center></th>
						<th><center>FECHA FINAL</center></th>
						<th><center>DIA</center></th>
						<th><center>MONTO FRECUENCIA</center></th>
						<th><center>MONTO MULTA</center></th>
						<th><center>SELECCIONAR</center></th>
					</thead>
					<tbody align="center" id="body_moto">					
					@foreach($frecuencia as $deuda)
					<?php 
	                $cantidad_deuda+=1;
	                ?>
					<tr  @if($deuda->cantidad_dias_multa==0) style="background: yellow;" @endif >
						<td>{{ $cantidad_deuda}}</td>
						<td>{{ $deuda->numero}}</td> 
						<td>{{ $deuda->fecha_inicio}}</td>
						<td>{{ $deuda->fecha_fin}}</td>
						<td>{{ obtener_dia($deuda->fecha_inicio)}}</td>
						<td>{{ $deuda->monto}}</td>
						<td>{{ $deuda->monto_frecuencia_multa}}</td>
						<td align="center">
						  <div class="material-switch pull-center">
		       				 <input id="{{$deuda->id}}" name="frecuencia[]"  type="checkbox"   value="{{$deuda->id}}"  />
		      			     <label for="{{$deuda->id}}" class="label-success" onclick="sumar_frecuencia2({{$deuda->id}},{{$deuda->monto}},{{$deuda->monto_frecuencia_multa}}); monto_total_frecuencia();"  ></label>
		    			 </div>
		

						</td>
					</tr>
					

					@endforeach
					<tr>
						<td colspan="5">Cantidad total de deudas : {{$cantidad_deuda}}</td>
					</tr>
					</tbody>
			</table>

		</div>
	

	</div>
 @endif   
		
 <br>
<br>
<br>




@if($ci!='0' && isset($_GET['ci']))
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	
		
		<div class="form-group " >
		<h2 style="color: red;">{!!Form::label('numero_label','Nº:'.$nro_recibo,['id'=>'numero_label'])!!}</h2>
		<input type="hidden" name="numero_pago" id="numero_pago" value="{{$nro_recibo}}">
		<input type="hidden" name="tipo_de_pago" value={{$tipo_de_pago}} >
		
	</div>

			<div class="form-group" hidden="">
		{!!Form::label('','Monto por frecuencia:')!!}
		{!!Form::text('monto_detalle',0,['class'=>'form-control','placeholder'=>'Monto por frecuencia','maxlength'=>'10','id'=>'monto_detalle','onkeyup'=>'total_monto_frecuencia();monto_total_frecuencia();','onBlur'=>'total_monto_frecuencia();monto_total_frecuencia();'])!!}
	</div>		
	
	@foreach($ajuste as $ajuste)
	<input type="hidden" name="retraso_dia" id="retraso_dia" value="{{$ajuste->retraso_dia}}">
	<input type="hidden" name="cantidad_tolerancia_cobro" id="cantidad_tolerancia_cobro" value="{{$ajuste->cantidad_tolerancia_cobro}}">
	<div class="form-group "  >
		{!!Form::label('monto_retraso','Monto Retraso:')!!}
		{!!Form::text('monto_retraso',0,['class'=>'form-control','placeholder'=>'Monto Retraso','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()','id'=>'monto_retraso'])!!}
	</div>


	<div class="form-group" hidden="">
		{!!Form::label('pro_navidad','Pro Navidad:')!!}
		{!!Form::text('pro_navidad',$ajuste->pro_navidad,['class'=>'form-control','placeholder'=>'Pro Navidad','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>
	 
	<div class="form-group "  hidden="">
		{!!Form::label(' ','Pro Accidente:')!!}
		{!!Form::text('pro_accidente',$ajuste->pro_accidente,['class'=>'form-control','placeholder'=>'Pro Accidente','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
	<div class="form-group " hidden="">
		{!!Form::label('ahorro','Ahorro:')!!}
		{!!Form::text('ahorro',$ajuste->ahorro,['class'=>'form-control','placeholder'=>'Ahorro','maxlength'=>'10','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()'])!!}
	</div>	
    @endforeach
    
    

	</div>

	<input type="text" hidden="" name="cantidad" id="cantidad" value="0">

    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <div class="form-group " >
		{!!Form::label('monto_frecuencia_1','Total de Frecuencia:')!!}
		{!!Form::text('monto_frecuencia',0,['class'=>'form-control','placeholder'=>'Monto Frecuencia','maxlength'=>'10','id'=>'monto_frecuencia','onkeyup'=>'monto_total_frecuencia()','onBlur'=>'monto_total_frecuencia()','monto_total_frecuencia()'])!!}
		</div>

		{!!Form::label('obsercaciones','Observaciones:')!!}
		{!!Form::textarea('observaciones','',['class'=>'form-control','placeholder'=>'Observaciones','style'=>'height:80px;'])!!}

		<div class="form-group " >
	    <h2 style="color: blue;"><label id="monto_total_value" name="monto_total_value"> 0 Bs</label></h2>
		<input name='monto_total' value="0" class='form-control' placeholder='Monto total' maxlength='10' id='monto_total' type="hidden" />
		</div>
	</div>
	
	
	
	<input type="hidden" name="permiso" id="permiso" value="0">
	
	<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
	<input type="hidden" name="ci" id="ci" value="<?php echo $ci; ?>">  



		<button type="button" class="btn btn-success btn-circle btn-xl" onmouseover="sin_permiso();" onClick='document.forms["pagar_formulario"].submit();'>
		<img src="../images/ic_pagar.png"  style="max-width: 80px; max-height: 80px;" >
			<h4 class="text-capitalize">Pagar</h4>
		</button>
 
		<button  hidden  class="btn btn-warning  btn-circle btn-xl" onmouseover="con_permiso();" >
		<img src="../images/ic_permiso.png"  style="max-width: 80px; max-height: 80px;" >
			<h4 class="text-capitalize">Permisos</h4>
		</button>
 

</div>

@endif
				



	</div>
    

	</form>
	
   {!!Html::script('js/pago_frecuencia_crear.js')!!}	
</div>
 
	@endsection




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