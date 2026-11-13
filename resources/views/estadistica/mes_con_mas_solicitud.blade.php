
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')




<?php
$message=Session::get('message');
?>

<style type="text/css">
	.panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"V";
    float: right;
    color: grey;
}
.panel-heading a.collapsed:after {
    content:">";
}
</style>
@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Ajuste registrado con Exito.
</div>
@endif

    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
  
 
    
{!!Html::script('js/pedido_estadistica_mes.js')!!}


   
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 font-family">
                  {!!Form::label('','Anio:')!!}
                  <select name="anio" class="form-control selectpicker" id="anio"  onchange="buscar_por_mes();"  >
                   @foreach($fechas as $mov)
                   <option value="{{$mov->anio}}">{{$mov->anio}}  </option>
                  @endforeach
                </select>

                  {!!Form::label('','Mes:')!!}
                  <select name="mes" class="form-control selectpicker" id="mes"  onchange="buscar_por_mes();"   >
                   <option value="1">Enero  </option>
                   <option value="2">Febrero  </option>
                   <option value="3">Marzo  </option>
                   <option value="4">Abril  </option>
                   <option value="5">Mayo  </option>
                   <option value="6">Junio  </option>
                   <option value="7">Julio  </option>
                   <option value="8">Agosto  </option>
                   <option value="9">Septiembre  </option>
                   <option value="10">Octubre  </option>
                   <option value="11">Noviembre  </option>
                   <option value="12">Diciembre  </option>
                </select>
              </div>     


 <div class="row">	
	<div class="container"> 
	<!-- DATOS DEL LA EMPRESA ADMINISTRADORA -->
	 <div class="panel panel-default" id="panel2">
	        <div class="panel-heading">
	             <h4 class="panel-title">
	        <a data-toggle="collapse" data-target="#collapseFor"  
	           href="#collapseFor" class="collapsed" aria-expanded="true">
	          Informe de pedido
	        </a>
	      </h4>
	        </div>
	        <div id="collapseFor" class="panel-collapse collapse in" aria-expanded="true">
	            <div id="estadistica_pedido_mes" style="height: 600px;"></div>
	        </div>
	    </div> 

 	</div>		   

</div>



		

	
	





 
@endsection

