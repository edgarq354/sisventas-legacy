@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('usuario.modal')
	
	
	<div class="row">	
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<font size="6">{{ __('egreso.titulo_egreso') }}</font>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">
				<a class="btn btn-link fa fa-plus" href="{!!URL::to('egreso/create')!!}"> {{ __('egreso.agregar_egreso') }}</a> 
			</div>
		</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'egreso.index', 'method'=>'GET'])!!}	
	<table class=" form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <tr>
        <td>
	        <div class="form-group " >
			<div class='input-group date' id='datetimepicker11'>
			  {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
			  <span class="input-group-addon ">
			     <span class="fa fa-calendar" aria-hidden="true"></span> 
			  </span>
			</div>
			</div> 
        </td>
        <td><i class=" fa fa-arrows-h form-group" ></i></td>
        <td>
          <div class="form-group " >
	        <div class='input-group date' id='datetimepicker10'>

			  {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
	          <span class="input-group-addon ">
	             <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
	          </span>
	        </div>
           </div>
        </td>
      </tr>
    </table> 
		
		
    

			

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		    <select name="id_usuario" class="form-control selectpicker" id="id_usuario" data-live-search="true" >
		     <option value="">  {{ __('egreso.buscar_por_usuario') }}</option>
		        @foreach($buscar_usuario as $mov)
		        <option value="{{$mov->id}}">{{$mov->nombre}} </option>
		        @endforeach
		    </select>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" hidden="">
		    <select name="id_cliente" class="form-control selectpicker" id="id_usuario" data-live-search="true" >
		     <option value="">  {{ __('egreso.buscar_por_cliente') }}</option>
		        @foreach($buscar_cliente as $mov)
		        <option value="{{$mov->id}}">{{$mov->nombre}} - {{$mov->ci_nit}}</option>
		        @endforeach
		    </select>
		</div>
			 <table class=" form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <tr>
        <td><button class="btn btn-success" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"><i class="fa fa-search"></i> {{ __('egreso.buscar') }}</button> 
        </td>
        <td class=" form-group"></td>
        <td>
          <?php echo "<a class='btn btn-warning' target='_blank'  href='../public/pdf_egreso/$id_empresa/$id_usuario/$id_cliente/$fecha_inicio/$fecha_fin'> <i class='fa fa-print'></i> ".__('egreso.imprimir')."</a>";?>
        </td>
      </tr>
    </table> 
	</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        
	

		</div>
		

</form>

		

<?php
$monto_total=0; 
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		
		
      

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>{{ __('egreso.col_id') }}</center></th>
						<th><center>{{ __('egreso.col_fecha') }}</center></th>
						<th><center>{{ __('egreso.col_usuario') }}</center></th>
						<th><center>{{ __('egreso.col_observaciones') }}</center></th>
						<th><center>{{ __('egreso.col_monto') }}</center></th>
						<th><center>{{ __('egreso.col_debe') }}</center></th>
						<th><center>{{ __('egreso.col_tipo_egreso') }}</center></th>
						<th><center>{{ __('egreso.col_opcion') }}</center></th>
						<th><center>{{ __('egreso.col_conductor_cliente') }}</center></th>
						<th><center>. . .</center></th>
						
					</thead>

					<tbody align="center" id="body_egreso">					
					@foreach($egreso as $usr)
					<tr>
							<td>{{ $usr->id}}</td>
						<td>{{$usr->fecha}}</td>
						<td>{{$usr->usuario}}</td>
						<td>{{$usr->observacion}}</td>
						<td><b>{{$usr->monto}}</b></td>
						<td>{{$usr->debe}}</td>
						<td>{{$usr->tipo_egreso}}</td>
						<td> 
							@if($usr->opcion==2)
							{{ __('egreso.conductor') }}
							@elseif($usr->opcion==0)
							{{ __('egreso.cliente') }}
							@endif
						</td>
						<td><b>
							<?php
							if($usr->opcion==1)
							{
								 
							}else if($usr->opcion==2)
							{
								 
								$conductor=DB::select("SELECT  nombre, paterno, materno from conductor where ci='".$usr->id_conductor."'");
								$nombre_conductor="";
								foreach ($conductor as $key => $value) {
									$nombre_conductor=$value->nombre." ".$value->paterno." ".$value->materno;
								}
								echo $nombre_conductor;

							}else if($usr->opcion==0)
							{
								 
								$cliente=DB::select("SELECT  nombre,paterno,materno from cliente where id='".$usr->id_cliente."'");
								echo $cliente[0]->nombre." ".$cliente[0]->paterno." ".$cliente[0]->materno;
							}
							?>
							</b>							 
						
						</td>
						<td>
						<a class='btn btn-warning fa fa-print' href="{!!URL::to('egreso/comprobante_egreso_pdf',[$usr->id])!!}" data-toggle="tooltip" data-placement="top" title="{{ __('egreso.imprimir_title') }}" target="_blanck"></a>
						</td>
					</tr>
					<?php 
					$monto_total+=$usr->monto;
					?>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>

	<div class="pull-left btn btn-success">{{ __('egreso.monto_total_egreso') }}<b> {{$monto_total}} {{ __('egreso.bs') }}</b> </div>
			</div>


		</div>
	</div>

   {!!Html::script('js/usuario.js')!!}
@endsection
