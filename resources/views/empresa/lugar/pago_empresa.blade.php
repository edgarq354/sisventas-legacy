@extends('layouts.inicio')
@section('contenido')
@include('empresa.modal_carrera')
    
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="pull-left"> <font size="6">REGISTRAR PAGOS DE SERVICIOS <b>   "{{$administrador[0]->razon_social}}"  </b></font><br> </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'crear_pago_empresa','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
    
            <input type="hidden" id="id_empresa_cliente" name="id_empresa_cliente" value="{{$administrador[0]->id_empresa_cliente}}"> 
          
         
         
        @foreach($fechas as $fecha)
    		<b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
    		<b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
  

    		
            <b>Opción:</b>
        	{!!Form::select('estado_opcion', array( '4' => 'TODAS LAS DEUDAS', '5' => 'DEUDAS (Solo servicios completados)'),$estado,array('id'=>'estado_opcion','class'=>'custom-select form-group dropdown-toggle','data-toggle' => 'dropdown'))!!}
            <button class="btn-sm btn-primary" onclick="BuscarHistorial({{$administrador[0]->id}})"><i class="fa fa-search"></i></button>         
    	
            <a class='btn btn-success fa fa-print '  href="{!!URL::to('empresa/get_historial_pedidos_excel/'.$fecha->fecha_inicio.'/'.$fecha->fecha_fin.'/'.$estado.'/'.$administrador[0]->id)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Exportar a Excel"> EXCEL</a>  
            
          </form>     
          
         
          </div>
	</div>

 {!!Form::open(['route'=>'pago_empresa_cliente.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary "  data-widget="box-widget">    
       <input type="hidden" id="id_empresa_cliente" name="id_empresa_cliente" value="{{$administrador[0]->id_empresa_cliente}}"> 
   		   
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
                    <th><center>Placa</center></th>                 
                    <th><center>Conductor</center></th>                   
    				<th><center>Pasajero</center></th>    				
                    <th><center>Fecha</center></th>
                    <th><center>Estado</center></th>
                    <th><center>Clase de vehiculo</center></th>
    				<th><center>Referencia</center></th>
                    <th><center>Monto</center></th>
                    <th><center>Monto empresa</center></th>
                    <th><center>Monto conductor</center></th>
                    <th><center>Pagar</center></th>
    				<th><center>. . .</center></th>
    			</thead>
    			<tbody align="center">
    				@foreach($pedidos as $value)
                    <tr align=center >
                       <td>{{$value->id}}</td>
                        <td>{{$value->codigo_empresa}}</td>
                        <td> <a href="../vehiculo/{{$value->placa}}/edit"; ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_vehiculo}} -  {{$value->placa}}</a></td>
                        <td> <a href="{!!URL::to('conductors',$value->ci)!!} "  ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_conductor}} - {{$value->conductor}}</a> </td>
                        <td>{{$value->usuario}}</td>
                        <td>{{$value->fecha_pedido}}</td>
                         <td>
                            @if($value->estado==2)
                                @if($value->estado_pago_empresa==0)
                                Completo. <label>*Deuda*</label>
                                @else
                                Completo. <label>*Sin deuda*</label>
                                @endif

                            @else
                            
                            @if($value->estado==1)
                         
                        @elseif($value->estado==2)
                       Completo
                        @elseif($value->estado==4)
                       Cancelo el pasajero
                        @elseif($value->estado==5)
                       Cancelo e conductor
                        @endif
                            @endif
                        </td>
                        
                        <td>
                            @if($value->clase_vehiculo==1)
                            MOVIL
                            @elseif($value->clase_vehiculo==2)
                            DE LUJO
                            @elseif($value->clase_vehiculo==3)
                            CON AIRE
                            @elseif($value->clase_vehiculo==4)
                            MALETERO LIBRE
                            @elseif($value->clase_vehiculo==5)
                            PEDIDO
                            @elseif($value->clase_vehiculo==6)
                            RESERVA
                            @elseif($value->clase_vehiculo==7)
                            MOTO
                            @endif
                            </td>

                        <td>{{$value->direccion}}</td>
                         @if($value->estado==2)
                            <td>{{$value->monto_total}} Bs</td>
                            <td>{{$value->monto_empresa}} Bs</td>
                            <td>{{$value->monto_conductor}} Bs</td>
                            @else
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            @endif


                   		 <td>
							        
							      <div class="material-switch pull-RIGHT">
							        <input id="{{$value->id}}" name="{{$value->id}}"  type="checkbox" value="0"  />
							        <label for="{{$value->id}}" class="label-success"  onclick="sumar_deudas_emrpesa_cliente('{{$value->id}}','{{$value->monto_empresa}}');" ></label>
							      </div>
							 </td>
							    <td>
                      
                          @if($value->estado==2) 
                       <a class='btn btn-primary fa fa-print' data-toggle='modal' data-target='#ModalDetalleCarrera' onclick="CargarDetalleCarreraEmpresa({{$value->id}},{{$otra}})"></a>
                        @elseif($value->estado>=4)
                         <a class='btn btn-link fa fa-male' data-toggle='modal' data-target='#ModalPuntoPedido' onclick="CargarDetalleSolicitud({{$value->latitud}},{{$value->longitud}})"> </a>
                        
                        @else
                        -
                        @endif
                    </td></tr>
                    @endforeach
    			</tbody>
    		</table>
    	</div>
	</div>	
	{{Form::close()}} 
</div>
   {!!Html::script('js/pago_cliente_empresa.js')!!}
@endsection