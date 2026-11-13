
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
  {!!Html::script('js/pedido_estadistica_entre_fecha.js')!!}
 
 
<div class="row">
   
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 font-family">
                   <div class="form-group" >
                     {!!Form::label('fecha','Fecha de Inicio:')!!}              
                    <div class='input-group date' id='datetimepicker10'>
                      <input type='text' class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{date('Y-m-j')}}" style="font-size:20px;text-align:left" />
                      <span class="input-group-addon ">
                         <span class="fa fa-calendar" aria-hidden="true"></span> 
                      </span>
                    </div>
                  </div>  
              </div>    
              <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 font-family">
                   <div class="form-group" >
                     {!!Form::label('fecha','Fecha final:')!!}              
                    <div class='input-group date' id='datetimepicker11'>
                      <input type='text' class="form-control" id="fecha_fin" name="fecha_fin" value="{{date('Y-m-j')}}" style="font-size:20px;text-align:left" />
                      <span class="input-group-addon ">
                         <span class="fa fa-calendar" aria-hidden="true"></span> 
                      </span>
                    </div>
                  </div>  

              </div>  
              <div class="form-group" >
                     {!!Form::label('fecha','.')!!} <br>   
                <button class="btn btn-primary fa fa-search  " onclick="buscar_entre_fecha();">  </button>                         
              </div>
                  

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
 	
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
	            <div id="estadistica_pedido_entre_fecha" style="height: 600px;"></div>
	        </div>
	    </div> 
 	</div>		   

</div>
 


 
@endsection

