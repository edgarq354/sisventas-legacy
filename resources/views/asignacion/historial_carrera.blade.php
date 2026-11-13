@extends('layouts.inicio')
@section('contenido')
@include('taxi.modal_carrera')
    
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="pull-left"> <font size="6">HISTORIAL DE PEDIDOS</font> </div>
    	<div class="pull-right">
        @foreach($fechas as $fecha)
    		<b>Fecha Inicio:</b> <input type="date" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
    		<b>Fecha Fin:</b> <input type="date" id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
    		<button class="btn-sm btn-primary" onclick="BuscarHistorial({{$taxi->id}})"><i class="fa fa-search"></i></button> 
            <input type="hidden" name="id_motista" id="id_motista" value="{{$taxi->id}}">     		
    	</div>
	</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="pull-left"> <a class="btn btn-danger" href="{!!URL::to('taxi')!!}">VOLVER</a> </div>    
    	<div class="pull-right">
        <b>Taxista: </b><font size="4">{{$taxi->nombre}} {{$taxi->apellido}}</font> <img id="logo" src="{{$taxi->imagen}}" width="100px" height="100px">
    	</div>
	</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="table-responsive">
    		<table class="table table-striped table-bordered table-condensed table-hover">
    			<thead>
                    <th><center>USUARIO</center></th>                   
    				<th><center>DIRECCION</center></th>    				
                    <th><center>FECHA</center></th>
    			</thead>
    			<tbody align="center" id="body_historial">
    				
    			</tbody>
    		</table>
    	</div>
	</div>	
</div>

{!!Html::script('js/historial_taxi.js')!!}
@endsection