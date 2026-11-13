@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')



<?php
$message=Session::get('message');
?>

<style type="text/css">
	.panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"V";
    float: right;
    color: grey;
}
.panel-heading a.collapsed:after {
    content:">";
}
</style>
@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Ajuste registrado con Exito.
</div>
@endif

    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
  
 
    
{!!Html::script('js/estadistica_principal.js')!!}





	<div class="row">	
		

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
             <h3>{{$monto}} Bs.</h3>

              <p>Libro diario</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="{!!URL::to('libro_diario')!!}" class="small-box-footer">Mas informacion<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
@if(Auth::user()->privilegio==1)
<!--ADMINISTRADOR DE TODO-->
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
              	  <?php $veh=DB::select("SELECT  count(*) as 'cantidad' from vehiculo c "); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <p>Vehículos</p>
            </div>
            <div class="icon">
              <i class="fa fa-car"></i>
            </div>
            <a href="{!!URL::to('vehiculo')!!}" class="small-box-footer">Mas informacion<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

    	<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from conductor c"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <p>Conductores registrados</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{!!URL::to('conductor')!!}" class="small-box-footer">Mas informacion<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from asignacion c"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <p>Conductores asignados</p>
            </div>
            <div class="icon">
              <i class="fa fa-chain"></i>
            </div>
            <a href="{!!URL::to('asignacion')!!}" class="small-box-footer">Mas informacion<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
@elseif(Auth::user()->privilegio==10)
<!--FEDERACION-->
      <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
              	  <?php $veh=DB::select("SELECT  count(*) as 'cantidad' from vehiculo c, empresa e,empresa a where c.id_empresa =e.id and e.id_asociacion=a.id and a.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <h4>Vehículos</h4>
            </div>
            <div class="icon">
              <i class="fa fa-car"></i>
            </div>
            <a href="{!!URL::to('vehiculo')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

    	<div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from conductor c, empresa e,empresa a where c.id_empresa =e.id and e.id_asociacion=a.id and a.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <h4>Conductores</h4>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{!!URL::to('conductor')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from empresa a where a.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>
              <h4>Asociaciones</h4>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="{!!URL::to('empresa')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



@elseif(Auth::user()->privilegio==11)
<!--ASOCIACION-->
      <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
              	  <?php $veh=DB::select("SELECT  count(*) as 'cantidad' from vehiculo c, empresa e where c.id_empresa =e.id and e.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <h4>Vehículos</h4>
            </div>
            <div class="icon">
              <i class="fa fa-car"></i>
            </div>
            <a href="{!!URL::to('vehiculo')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

    	<div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from conductor c, empresa e where c.id_empresa =e.id and e.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <h4>Conductores</h4>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{!!URL::to('conductor')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
              	<?php $veh=DB::select("SELECT  count(*) as 'cantidad' from empresa e where e.id_asociacion='".Auth::user()->id_empresa."'"); ?>
                {{$veh[0]->cantidad}}

              </h3>

              <h4>EMPRESAS</h4>
            </div>
            <div class="icon">
              <i class="fa fa-chain"></i>
            </div>
            <a href="{!!URL::to('empresa')!!}" class="small-box-footer">Mas información<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
@endif       

          
        </div>
       </div>




<!-- DATOS DEL LA EMPRESA ADMINISTRADORA -->
 <div class="panel panel-default" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseFor" 
           href="#collapseFor" class="collapsed">
          Informe de pedido
        </a>
      </h4>
        </div>
        <div id="collapseFor" class="panel-collapse collapse">
            <div id="estadistica_pedido" style="height: 300px;"></div>
        </div>
    </div>
    <br>

    <div class="panel panel-default" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseOne" 
           href="#collapseOne" class="collapsed">
          Informe de conbros de frecuencia
        </a>
      </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div id="frecuencia" style="height: 200px;"></div>
        </div>
    </div>

<br>

    <div class="panel panel-default" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseTwo" 
           href="#collapseTwo" class="collapsed">
          Informe de egreso
        </a>
      </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div id="egreso" style="height: 200px;"></div>
        </div>
    </div>

<br>
    <div class="panel panel-default" id="panel2">
        <div class="panel-heading">
             <h4 class="panel-title">
        <a data-toggle="collapse" data-target="#collapseTree" 
           href="#collapseTree" class="collapsed">
          Informe de ingreso
        </a>
      </h4>
        </div>
        <div id="collapseTree" class="panel-collapse collapse">
            <div id="ingreso" style="height: 200px;"></div>
        </div>
    </div>


<br>
<hr>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

	<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('cliente')!!}">
						 <img src="images/19.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Clientes</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('ajuste/create')!!}">
						 <img src="images/2.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Configuración</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('gestionar_permiso')!!}">
						 <img src="images/33.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Perminsos</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('notificacion')!!}">
						 <img src="images/ic_notificacion.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Notificación</h4>
					</li>
				</ul>
			</div>
		</div>

		

	</div>





	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('empleado')!!}">
						 <img src="images/ic_empleados.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Empleado</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('ingreso')!!}">
						 <img src="images/15.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Ingresos</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('pago_empresa')!!}">
						 <img src="images/47.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Ajustar pago de Empresas</h4>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('pedido')!!}">
						 <img src="images/ic_pedidos.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Solicitud de Taxi</h4>
					</li>
				</ul>
			</div>
		</div>

		

		
	</div>	




	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('contrato')!!}">
						 <img src="images/ic_convenio.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Contrato</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('egreso')!!}">
						 <img src="images/1.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Egresos</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						 <a >
						 <img src="images/36.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Pagar Cuota</h4>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						 <a href="{!!URL::to('arqueo_caja')!!}">
						 <img src="images/arqueo.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Libro mayor</h4>
					</li>
				</ul>
			</div>
		</div>

		


		


	</div>	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('horario')!!}">
						 <img src="images/ic_horario.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Horario</h4>
					</li>
				</ul>
			</div>
		</div>

		

		<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						 <a href="{!!URL::to('tipo_ingreso_egreso')!!}">
						 <img src="images/40.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Tipo de permiso y egreso</h4>
					</li>
				</ul>
			</div>
		</div>
		

	<div class="panel rounded shadow">
			<div class="panel-bodys">
				<ul class="inner-all list-unstyled">
					<li class="text-center">
						<a href="{!!URL::to('agenda')!!}">
						 <img src="images/ic_calendario.png"  style="max-width: 100px; max-height: 100px;" >
						 </a>
					</li>
					<li class="text-center"> 
						<h4 class="text-capitalize">Agenda</h4>
					</li>
				</ul>
			</div>
		</div>

	</div>	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


	    
	    

	    

	</div>	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">


</div>

 
@endsection

