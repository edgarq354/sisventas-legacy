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
	{{ __('ingreso.pago_registrado') }}
</div>
@endif
	<div class="row">	
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
		
 
 

         <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
             <font style="font-size: 30px; font-weight: bold;">{{ __('ingreso.crear') }}</font>

              <p></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="{!!URL::to('ingreso/create')!!}" class="small-box-footer">{{ __('ingreso.ver_mas') }} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


         <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <font style="font-size: 30px; font-weight: bold;">{{ __('ingreso.historial') }}</font>

              <p></p>
            </div>
            <div class="icon">
              <i class="fa fa-book fa-3"></i>
            </div>
            <a href="{!!URL::to('ingreso_historial/'.date('Y-m-d').'/'.date('Y-m-d'))!!}" class="small-box-footer">{{ __('ingreso.mas_informacion') }} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
 
		

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box box-body box-primary" >

 

        
	 
		

		

    
<div class="panel-body">
	<div class="table-responsive" style="overflow-x:inherit">	
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir" align="center">
					
					<thead>
						<th><center>{{ __('ingreso.col_id') }}</center></th>  
						<th><center>{{ __('ingreso.col_fecha') }}</center></th>
						<th><center>{{ __('ingreso.col_concepto') }}</center></th>
						<th><center>{{ __('ingreso.col_descripcion') }}</center></th>
						<th><center>{{ __('ingreso.col_tipo') }}</center></th>   
						<th><center>{{ __('ingreso.col_cliente') }}</center></th>   
						<th><center>{{ __('ingreso.col_monto') }}</center></th>   
						<th><center>{{ __('ingreso.col_sucursal') }}</center></th>    
						<th><center>{{ __('ingreso.col_caja') }}</center></th>    
						<th><center>{{ __('ingreso.col_usuario') }}</center></th>  
						<th><center>{{ __('ingreso.col_estado') }}</center></th>  
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
							<span class="badge  btn-success">{{ __('estados.'.$item->estado) }}</span>
							@elseif($item->estado=='Por cobrar')
							<span class="badge  btn-warning">{{ __('estados.'.$item->estado) }}</span> 
							@else
							<span class="badge  btn-danger">{{ __('estados.'.$item->estado) }}</span>
							@endif
						</TD>
						 
						<td>
							<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              {{ __('ingreso.opcion') }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu"> 
                            	<li>
                            		<a target="_blank"  href='ingreso_imprimir/{{$item->id}}' aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="{{ __('ingreso.imprimir') }}"><i class=' fa fa-print'></i> {{ __('ingreso.imprimir') }}</a>
                            	</li>
								
								@if($item->estado=='Procesado' && Auth::user()->privilegio==0)
								<li>
									<a   href='ingreso_cancelar/{{$item->id}}' aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('ingreso.cancelar_ingreso_title') }}"><i class=" fa fa-close"> {{ __('ingreso.cancelar') }}</i></a>								
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

