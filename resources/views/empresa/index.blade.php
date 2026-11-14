
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('empresa.modal')

 





	<div class="row">	
	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<font size="6">{{ __('empresa.listado_titulo') }}</font>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

		</div>


		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="pull-right">

				@if(Auth::user()->privilegio != 2)
					<a class="btn btn-success" href="{!!URL::to('empresa/create')!!}">{{ __('empresa.registrar_mayus') }}</a>
				@endif
			</div>
		</div>
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>{{ __('empresa.col_id') }}</center></th>
						<th><center>{{ __('empresa.col_logo') }}</center></th>
						<th><center>{{ __('empresa.col_nit') }}</center></th>
						<th><center>{{ __('empresa.col_razon_social') }}</center></th>
						<th><center>{{ __('empresa.col_administrador') }}</center></th>
						<th><center>{{ __('empresa.col_estado') }}</center></th>
						<th><center>{{ __('empresa.col_deuda') }}</center></th>
						<th><center>{{ __('empresa.col_opcion') }}</center></th>
					</thead>
					<tbody align="center" id="body_empresa">					
					@foreach($empresa as $user)
					<tr>
						<td>{{ $user->id}}</td>	
						<td>
							<img src="{{ !empty($user->direccion_logo) ? $user->direccion_logo : asset('images/empresa_default.svg') }}" title="{{ __('empresa.col_logo') }}" width="90px" height="90px" class="img-thumbnail" onerror="this.onerror=null;this.src='{{ asset('images/empresa_default.svg') }}';">

						</td>
								
						<td>{{ $user->nit}}</td>					
						<td>{{ $user->razon_social}}</td>
						<td>{{ $user->nombre}} {{$user->paterno}} {{$user->materno}}</td>
						<td>
							@if($user->estado==1)
							<i class="fa fa-circle  fa-red" style="color:green;" aria-hidden="true"></i>
							@else
							<i class="fa fa-circle  " style="color:red;" aria-hidden="true"></i>
							@endif
						</td>
						<td>{{ $user->deuda}}</td>
						<td>
						{!!link_to_route('empresa.edit', $title = '', $parameters = $user->id, $attributes = ['class'=>'btn btn-primary fa fa-eye'])!!}	
						<a class='btn btn-warning fa fa-money' href="{{url('crear_pago_empresa', ['idguest' => $user->id])}}" aria-hidden="true"  target="_blanck"></a>
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_empresa_2">
					</tbody>					
				</table>
				</div>

			</div>
		</div>
	</div>
   {!!Html::script('js/empresas.js')!!}

@endsection





