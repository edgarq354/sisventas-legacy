@extends('layouts.inicio')
@section('contenido')
@include('empresa.modal_carrera')
    
<style type="text/css">
    
.material-switch > input[type="checkbox"] {
  display: none;
}

.material-switch > label {
  cursor: pointer;
  height: 0px;
  position: relative;
  top: 2px;
  width: 40px;
}

.material-switch > label::before {
  background: rgb(0, 0, 0);
  box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
  border-radius: 8px;
  content: '';
  height: 16px;
  margin-top: -8px;
  position: absolute;
  opacity: 0.3;
  transition: all 0.4s ease-in-out;
  width: 40px;
}

.material-switch > label::after {
  background: rgb(255, 255, 255);
  border-radius: 16px;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
  content: '';
  height: 24px;
  left: -4px;
  margin-top: -8px;
  position: absolute;
  top: -4px;
  transition: all 0.3s ease-in-out;
  width: 24px;
}

.material-switch > input[type="checkbox"]:checked + label::before {
  background: inherit;
  opacity: 0.5;
}

.material-switch > input[type="checkbox"]:checked + label::after {
  background: inherit;
  left: 20px;
}


</style>   

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }








    </style>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="pull-left"> <font size="6">REGISTRAR PAGOS DE SERVICIOS <b>   "{{$administrador[0]->razon_social}}"  </b></font><br> </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'crear_pago_lugar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
    
            <input type="hidden" id="id_lugar" name="id_lugar" value="{{$administrador[0]->id_lugar}}"> 
          
         
         
        @foreach($fechas as $fecha)
    		<b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
    		<b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
  

    		
            <b>Opción:</b>
        	{!!Form::select('estado_opcion', array( '2' => 'TODOS LOS PEDIDOS', '5' => 'Solo con deudas (Solo servicios completados)'),$estado,array('id'=>'estado_opcion','class'=>'custom-select form-group dropdown-toggle','data-toggle' => 'dropdown'))!!}
            <button class="btn btn-primary" onclick="BuscarHistorial({{$administrador[0]->id}})"><i class="fa fa-search"></i></button>         
    	
            <a class='btn btn-success'  href="{!!URL::to('lugar/get_historial_pedidos_excel/'.$fecha->fecha_inicio.'/'.$fecha->fecha_fin.'/'.$estado.'/'.$administrador[0]->id)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Exportar a Excel"> <i class="fa fa-print"></i> EXCEL</a>  
            
          </form>     
          
         
          </div>
	</div>

 {!!Form::open(['route'=>'pago_lugar.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary "  data-widget="box-widget">    
       <input type="hidden" id="id_lugar" name="id_lugar" value="{{$administrador[0]->id_lugar}}"> 
   		   
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">    
		 <div class="form-group"   >
		{!!Form::label('','Tipo de ingreso (COBRO DE DEUDA DE EMPRESA) :')!!}<span > 
			<select name="id_tipo_ingreso_egreso" class="form-control selectpicker" id="id_tipo_ingreso_egreso" data-live-search="true" >
			        @foreach($tipo as $mov)
			        <option value="{{$mov->id}}">{{$mov->nombre}}</option>
			        @endforeach
			</select>
		</div>
		<div class="form-group " >
		      	<input type="hidden" name="monto_total_auxiliar"  id="monto_total_auxiliar" value="0">
		      	<input type="hidden" name="cantidad" value="0" id="cantidad">
				{!!Form::label(' ','Nombre:')!!}
				{!!Form::text('nombre_pagador','',['class'=>'form-control','placeholder'=>'Nombre del pagador','id'=>'nombre'])!!}
			</div>
			 <div class="form-group " >
				{!!Form::label('monto_total','Monto Total:')!!}
				{!!Form::number('monto_total',0,['class'=>'form-control','placeholder'=>'Monto total','id'=>'monto_total','step'=>'any'])!!}
			</div>
	</div>

         
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">    
		     
			<div class="form-group">
				{!!Form::label(' ','Observacioón:')!!}  
			 	{!!Form::textarea('observacion',null,['class'=>'form-control','placeholder'=>'Ingrese alguna observación.','style'=>'height:100px;'])!!}	
			</div>
			 <button class="btn btn-success ">PAGAR</button> 
		</div>
	 

		 
    </div>
 
   

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="table-responsive">
    		<table class="table table-striped table-bordered table-condensed table-hover"  >
    			<thead>
                    <th><center>ID</center></th>    
                     <th><center># Movil</center></th>                   
                    <th><center>Conductor</center></th>                   
    				<th><center>Pasajero</center></th>    				
                    <th><center>Fecha</center></th>
                    <th><center>Estado</center></th>
    				<th><center>Referencia</center></th>
                    <th><center>Monto pedido</center></th>
                    <th><center>Pagar</center></th>
                    <th><center>%</center></th>
                    <th><center>...</center></th>
    			</thead>
    			<tbody align="center">
    				@foreach($pedidos as $value)
                    <tr align=center         @if($value->estado_deuda_lugar==1)
                                  style="background-color:#FCE8E4;"
                                @endif
                                 >


                       <td>{{$value->id}}</td>
                        <td>{{$value->codigo_empresa}}</td>
                         
                        <td> <a href="{!!URL::to('conductors',$value->ci)!!} "  ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_conductor}} - {{$value->conductor}}</a> </td>
                        <td>{{$value->usuario}}</td>
                        <td>{{$value->fecha_pedido}}</td>
                         <td>
                                @if($value->estado_deuda_lugar==1)
                                  <label>*Deuda*</label>
                                @else
                                 <label>*Sin deuda*</label>
                                @endif

                           
                        </td>
                    

                        <td>{{$value->direccion}}</td>
                            <td>{{$value->monto_pedido}} Bs</td>
                            <td>{{$value->monto_deuda_lugar}} Bs</td>
                            <td>{{$value->porcentaje_pago_lugar}} %</td>




                   		 <td>
                            @if($value->estado_deuda_lugar==1)
							    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
   
							      <div class="material-switch">
							        <input id="{{$value->id}}" name="{{$value->id}}"  type="checkbox" value="0"  />
							        <label for="{{$value->id}}" class="label-success"  onclick="sumar_deudas_emrpesa_cliente('{{$value->id}}','{{$value->monto_deuda_lugar}}');" ></label>
							      </div>
                                </div>
                                @endif

							 </td>
						</tr>
                    @endforeach
    			</tbody>
    		</table>
    	</div>
	</div>	
	{{Form::close()}} 
</div>
   {!!Html::script('js/pago_cliente_empresa.js')!!}
@endsection