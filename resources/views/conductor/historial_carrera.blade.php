@extends('layouts.inicio')
@section('contenido')
@include('usuario.modal_carrera')
 
    
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="pull-left"> <font size="6">HISTORIAL DE SERVICIOS </font> </div>
    </div>

       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @foreach($conductor as $con)
        <div class="pull-left"> 
            <?php if ($con->direccion_imagen != ""): ?>
                <img id="logo" src=<?php echo "".asset(''.$con->direccion_imagen);?> width="100px" height="100px"  class="img-thumbnail">                 
            <?php endif ?>
        </div>    
        <div class="pull-left">
        <b>Número de Movil: </b> {{$con->numero_movil}}  <br>
        <b>Conductor: </b> {{$con->nombre}} {{$con->paterno}} {{$con->materno}} <br><br>
         
        @endforeach     
        </div>
          
                   
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      {{Form::open(array('url' => 'conductor_pedido','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'))}} 
    
           
          <input type="hidden" name="id_conductor" value="{{$conductor[0]->ci}}">
         
        @foreach($fechas as $fecha)
            <b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
            <b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
        @endforeach
  

            
            <b>Opción:</b>
            {!!Form::select('estado_opcion', array( '1' => 'TODOS', '2' => 'COMPLETADO', '3' => 'CANCELADO'),$estado,array('id'=>'estado_opcion','class'=>' selectpicker','data-toggle' => 'dropdown'))!!}

            <button class=" form-group btn-sm btn-primary" ><i class="fa fa-search"></i></button>         
        
             
          </form>     
            
         
          </div>
    </div>

  

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover" id="myTable">
                <thead>
                    <th><center>ID</center></th>    
                    <th><center># MOVIL</center></th>    
                    <th><center>PLACA</center></th>    
                    <th><center>CONDUCTOR</center></th>                 
                    <th><center>PASAJERO</center></th>                   
                    <th><center>FECHA</center></th>
                    <th><center>ESTADO</center></th>
                    <th><center>CARACTERISTICA</center></th>
                    <th><center>REFERENCIA</center></th>
                    <th><center>MONTO</center></th>
                    <th><center>MONTO EMPRESA</center></th>
                    <th><center>MONTO CONDUCTOR</center></th>
                    <th><center>EMPRESA</center></th>
                    <th><center>. . .</center></th>
                </thead>
                <tbody align="center">
                    @foreach($pedidos as $value)
                    <tr align=center >
                        <td>{{$value->id}}</td>
                        <td><label>{{$value->codigo_empresa}}</label></td>
                        <td> <a href="vehiculo/{{$value->placa}}/edit"; ><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_vehiculo}} - {{$value->placa}}</a></td>
                        <td><i class="fa fa-star" aria-hidden="true"></i>{{$value->calificacion_conductor}} - {{$value->conductor}}</td>
                         <td>{{$value->usuario}}</td>
                        <td>{{$value->fecha_pedido}}</td>
                          <td>
                            <hidden><label style="visibility: collapse;">{{$value->estado}}</label></hidden>
                        

                        @if($value->estado==0)
                         
                        <a class="fa fa-street-view btn btn-primary" target="_BLANK" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="En camino a la ubicación del pasajero"  href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}"></a>
                        @elseif($value->estado==1)
                        <a class="fa fa-location-arrow btn btn-link" target="_BLANK"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Con pasajero abordo" href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}"></a>
                        @elseif($value->estado==2)
                         <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" target="_BLANK" class="fa fa-check btn btn-link" aria-hidden="true"  title="Pedido finalizado" />
                         
                        @elseif($value->estado==4)
                         

                        <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" target="_BLANK" class="fa fa-user-times btn btn-link" aria-hidden="true"  title="Pedido cancelado por el pasajero"   style="color:red;"/>
                        @elseif($value->estado==5)
                     

                        <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" target="_BLANK" class="fa fa-id-card-o btn btn-link" aria-hidden="true"  title="Pedido cancelado por el conductor"  style="color:red;" />
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
                                @if($value->tipo_pedido_empresa==1)
                                <?php
                                $empresa=DB::select("SELECT razon_social, id from empresa where id=".$value->id_empresa_cliente);
                                foreach ($empresa as $key => $emp) {
                                   
                                    echo "<label><a href='../empresa/".$emp->id."/edit'; >".$emp->razon_social."</a></label>";
                                }
                                ?>
                                @else
                                -
                                @endif

                            </td>

                    <td>
                          @if($value->estado==2) 
                        
                         <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" class="fa fa-print btn btn-link" aria-hidden="true"  title="Pedido finalizado" />
                        @elseif($value->estado>=4)
                         <a href="{!!URL::to('ver_detalle_pedido_por_id',$value->id)!!}" class="fa fa-male btn btn-link" aria-hidden="true"  title="Pedido CANCELADO" />

                          
                        
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
{!!Html::script('js/usuario.js')!!}
@endsection