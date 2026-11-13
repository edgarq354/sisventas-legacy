@extends('layouts.inicio')
@section('contenido')
@include('empresa.modal_carrera')
<div class="row">



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <font size="5" color="red">{{$empresa->razon_social}}</font>                 
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" align="right">
            <b>Fecha Inicio:</b>         
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            @foreach($fechas as $fecha)
            <div class='input-group date' id='datetimepicker10'>
              <input type='text' value="{{$fecha->fecha_inicio}}" class="form-control" id="fecha_inicio" name="fecha_inicio" style="font-size:15px;text-align:left" />
              <span class="input-group-addon ">
                 <span class="fa fa-calendar" aria-hidden="true"></span> 
              </span>
            </div>
        </div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" align="right">
            <b>Fecha Fin:</b>         
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class='input-group date' id='datetimepicker11'>
              <input type='text' value="{{$fecha->fecha_fin}}" class="form-control" id="fecha_fin" name="fecha_fin" style="font-size:15px;text-align:left" />
              <span class="input-group-addon ">
                 <span class="fa fa-calendar" aria-hidden="true"></span> 
              </span>
            </div>
        </div>

            @endforeach

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" align="left">
                <button class="btn-sm btn-primary" onclick="BuscarHistorial({{$empresa->id}})"><i class="fa fa-search"></i></button> 
            <input type="hidden" name="id_empresa" id="id_empresa" value="{{$empresa->id}}">            
        </div>                                      

    </div>







    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="pull-left"> <br><a class="btn btn-danger" href="{!!URL::to('empresas')!!}">VOLVER</a> <br><br> </div>    
    	<div class="pull-right"><br>
            <select id="estado_opcion" name="estado_opcion" class="form-control">
                <option value="2">PEDIDO COMPLETADO</option>
                <option value="5">CANCELADO CONDUCTOR</option>
                <option value="4">CANCELADO PASAJERO</option>
            </select>
        </div>      
        <div class="pull-right">
            <br> <span> Seleccione Una Opción: </span>
        </div>    
	</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="table-responsive">
    		<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
    			<thead id="head_completado">
                    <th><center>CARNET</center></th>                   
                    <th><center>CONDUCTOR</center></th>                   
    				<th><center>DIRECCION</center></th>    				
                    <th><center>PASAJERO</center></th>
                    <th><center>MONTO</center></th>
                    <th><center>FECHA</center></th>
                    <th><center>OPCION</center></th>
    			</thead>

                <thead id="head_cancelado">
                    <th><center>CARNET</center></th>                   
                    <th><center>CONDUCTOR</center></th>                   
                    <th><center>DIRECCION</center></th>                 
                    <th><center>PASAJERO</center></th>
                    <th><center>DETALLE DE CANCELACION</center></th>                 
                    <th><center>FECHA</center></th>
                </thead>                
    			<tbody align="center" id="body_historial">
    				
    			</tbody>
    		</table>
    	</div>
	</div>	
</div>

{!!Html::script('js/historial_empresa.js')!!}
@endsection