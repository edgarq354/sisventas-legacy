
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
  {!!Html::script('js/estadistica_principal_anio.js')!!}
 
 

   
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 font-family">
                  {!!Form::label('','Anio:')!!}
                  <select name="anio" class="form-control selectpicker" id="anio" onchange="buscar_por_anio();"   >
                   @foreach($fechas as $mov)
                   <option value="{{$mov->anio}}" >{{$mov->anio}}  </option>
                  @endforeach
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
	            <div id="estadistica_pedido_anio" style="height: 600px;"></div>
	        </div>
	    </div> 

 	</div>		   

</div>



		

	
	





 
@endsection

