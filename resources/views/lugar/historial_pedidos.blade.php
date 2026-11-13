@extends('layouts.inicio')
@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="pull-left"> <font size="6">HISTORIAL DE SERVICIOS</font> </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'historial_pedidos_lugar','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
    
           
          
         
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{$administrador[0]->id}}">  
        @foreach($fechas as $fecha)
    		<b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
    		<b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
  

    		
            <b>Opción:</b>
        	{!!Form::select('estado_opcion', array( '1' => 'TODOS', '2' => 'COMPLETADO', '3' => 'CANCELADO','4' => 'DEUDAS', '5' => 'DEUDAS (COMPLETADO)', '6' => 'PAGADOS'),$estado,array('id'=>'estado_opcion','class'=>'custom-select form-group dropdown-toggle','data-toggle' => 'dropdown'))!!}
            <button class="btn-sm btn-primary"  ><i class="fa fa-search"></i></button>         
    	
            <a class='btn btn-success fa fa-print '  href="{!!URL::to('lugar/get_historial_pedidos_excel/'.$fecha->fecha_inicio.'/'.$fecha->fecha_fin.'/'.$estado.'/'.$administrador[0]->id)!!} " target="_blanck" data-toggle="tooltip" data-placement="top" title="Exportar a Excel"> EXCEL</a>  
            
          </form>     
          
         
          </div>
	</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
        <?php $ruta=''.$administrador[0]->id.'/edit' ?>
        <div class="pull-left">
        <b>Empresa: </b><font size="4">{{$administrador[0]->razon_social}}</font> <br>
        <b>Adminstrador: </b><font size="4">{{$administrador[0]->nombre}} {{$administrador[0]->apellido}}</font> <br><br>
  
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<div class="table-responsive">
    		<table class="table table-striped table-bordered table-condensed table-hover" id="myTable">
    			<thead>
                    <th><center>ID</center></th>                   
                    <th><center># Movil</center></th>                   
                    <th><center>Placa</center></th>                   
    				<th><center>Conductor</center></th>   
                    <th><center>Pasajero</center></th>                   
                    <th><center>Fecha</center></th>
    				<th><center>Referencia</center></th>
                    <th><center>Monto de Envio</center></th>
                    <th><center>Monto de Carrito</center></th>
    				<th><center>. . .</center></th>
    			</thead>
    			<tbody align="center">
    				@foreach($pedidos as $value)
                    <tr align=center >
                        <td>{{$value->id}}</td>
                        <td>{{$value->codigo_empresa}}</td>
                        <td> <a href="vehiculo/{{$value->placa}}/edit"; ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_vehiculo}} - {{$value->placa}}</a></td>
                        <td> <a href="{!!URL::to('conductors',$value->ci)!!} "  ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_conductor}} - {{$value->conductor}}</a> </td>
                        <td>{{$value->usuario}}</td>
                        <td>{{$value->fecha_pedido}}</td>
                        
                         
                        <td>{{$value->direccion}}</td>
                         @if($value->estado==2)
                            <td>{{$value->monto_total}} Bs</td>
                            <td>{{$value->monto_pedido}} Bs</td>
                            @else
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            @endif


                    <td>
                      
                       
                          @if($value->estado==2) 
                           <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" class="fa fa-print btn btn-link" aria-hidden="true"  title="Pedido finalizado" />
                       
                        @elseif($value->estado>=4)
                         <button class='btn btn-link fa fa-male' data-toggle='modal' data-target='#ModalPuntoPedido' onclick="CargarDetalleSolicitud({{$value->latitud}},{{$value->longitud}})"> </button>
                        
                        @else
                        -
                        @endif
                    </td></tr>
                    @endforeach
    			</tbody>
    		</table>
    	</div>
	</div>	
</div>
   {!!Html::script('js/historial_empresa.js')!!} 
@endsection