@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 

 



<?php
$message=Session::get('message');
$fechaInicial=date('Y-m-d');
$fechaFinal=date('Y-m-d');
?>


<input type="hidden" id="listaTraspaso" value="{{json_encode($ingreso)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif
	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
		
 
 

         <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
             <font style="font-size: 30px; font-weight: bold;">Crear</font>

              <p></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="{!!URL::to('ingreso/create')!!}" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


         <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <font style="font-size: 30px; font-weight: bold;">Historial</font>

              <p></p>
            </div>
            <div class="icon">
              <i class="fa fa-book fa-3"></i>
            </div>
            <a href="{!!URL::to('ingreso_historial/'.date('Y-m-d').'/'.date('Y-m-d'))!!}" class="small-box-footer">Mas información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
 
		

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary" >

 

        
	 
		

		

    
<div class="panel-body">
	<div class="table-responsive" style="overflow-x:inherit">	
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir" align="center">
					
					<thead>
						<th><center>Id</center></th>  
						<th><center>Fecha</center></th>
						<th><center>Concepto</center></th>
						<th><center>Descripción</center></th>
						<th><center>Tipo</center></th>   
						<th><center>Cliente</center></th>   
						<th><center>Monto</center></th>   
						<th><center>Sucursal</center></th>    
						<th><center>Caja</center></th>    
						<th><center>Usuario</center></th>  
						<th><center>Estado</center></th>  
						<th><center>. . .</center></th>
					</thead>
					
						<tbody>
						@foreach($ingreso as $item)
					 
					<tr>
						<td>{{ $item->id}}</td>  
						<td>{{ $item->fecha}}</td>   
						<td>{{ $item->concepto}}  </td>
						<td>{{ $item->descripcion}}  </td>
						<td>{{ $item->tipo_gasto}}  </td> 
						<td>{{ $item->nombre_cliente}}  </td> 
						<td>{{ $item->monto}}  </td> 
						<td>{{ $item->sucursal}}  </td> 
						<td>{{ $item->caja}}  </td>  
						<td>{{ $item->usuario}}</td> 
						<TD>@if($item->estado=='Procesado')
							<span class="badge  btn-success">{{$item->estado}}</span>
							@elseif($item->estado=='Por cobrar')
							<span class="badge  btn-warning">{{$item->estado}}</span> 
							@else
							<span class="badge  btn-danger">{{$item->estado}}</span>
							@endif
						</TD>
						 
						<td>
							<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Opción <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu"> 
                            	<li>
                            		<a target="_blank"  href='ingreso_imprimir/{{$item->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Imprimir"><i class=' fa fa-print'></i> Imprimir</a>
                            	</li>
								
								@if($item->estado=='Procesado' && Auth::user()->privilegio==0)
								<li>
									<a   href='ingreso_cancelar/{{$item->id}}' aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Cancelar el Ingreso"><i class=" fa fa-close"> Cancelar</i></a>								
								</li>
								@endif
								
								 
                            </ul>
                          </div>
						 
						</td>
					</tr>
				
					@endforeach
					</tbody>
				
						
				</table>
	</div>
	
			</div>


		</div>
	</div>

</div>



 
 <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
@endsection

