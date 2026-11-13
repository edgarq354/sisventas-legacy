@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<?php
$message=Session::get('message');
?>


	<div class="row">	
    
		<div clasrs="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
	
 

		
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 
 <center> <h2>Libro diario </h2></center>

{!!Form::open(['route'=>'libro_diario.index', 'method'=>'GET'])!!}	
		<div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12" >
		<div class='input-group date' id='datetimepicker11'>
		  {!!Form::text('fecha',date('Y-m-j'),['id'=>'fecha','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}		
		  <span class="input-group-addon ">
		     <span class="fa fa-calendar" aria-hidden="true"></span> 
		  </span>
		</div>
		</div>
			

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    <select name="id_usuario" class="form-control selectpicker" id="id_usuario" data-live-search="true" >
		     <option value="">  Buscar por usuario . .</option>
		        @foreach($usuario as $mov)
		        <option value="{{$mov->id}}">{{$mov->nombre}} </option>
		        @endforeach
		    </select>
		</div>

       <table class=" form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <tr>
        <td><button class="btn btn-success" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"><i class="fa fa-search"></i> BUSCAR</button> 
        </td>
        <td>
          <?php echo "<a class='btn btn-warning' target='_blank'  href='../public/pdf_libro_diario/$id_empresa/$id_usuario/$fecha'> <i class='fa fa-print'></i> IMPRIMIR</a>";?>
        </td>
      </tr>
    </table> 
		

		

</form>

		

		</div>
    


	
			</div>


		</div>
	</div>


<?php $monto_total_frecuencia=0; ?>
<div class="well">
<h3  >Cobro de pagos de frecuencia</h3>
<table class="table table-striped table-bordered table-condensed table-hover" >
  <thead>
    <th><center>Nº</center></th>
    <th><center>Fecha</center></th>
    <th><center># Movil</center></th>
    <th><center>CI</center></th>
    <th><center>Conductor</center></th>
    <th><center>Monto Total</center></th>
    <th><center>Candidad</center></th>
    <th><center>Frecuencias</center></th>
    <th><center>Usuario</center></th>
  </thead>
  <tbody>
  @foreach($pago_frecuencia as $pago)
  <tr>
    <td align="center">
     {{$pago->numero}}
    </td>
    <td align="center">
     {{$pago->fecha}}
    </td>
    <td align="center">
     {{$pago->codigo_empresa}}
    </td>
    <td align="center">
     {{$pago->ci}}
    </td>
    <td align="left">
     {{$pago->nombre}} {{$pago->paterno}} {{$pago->materno}}
    </td>
    <td align="center">
     {{$pago->monto_total}} Bs.
    </td>
    <td align="center">
     {{$pago->cantidad}}
    </td>
    <td align="center">
      @foreach($detalle_frecuencia as $frecuencia)
      <?php 
        if($frecuencia->id_pago_frecuencia==$pago->id)
        {
          echo $frecuencia->numero.",";
        }  
      ?>
      @endforeach
    </td>
    <td align="center">
     {{$pago->usuario}}
    </td>
  </tr>

  <?php $monto_total_frecuencia+=$pago->monto_total; ?>
  @endforeach
  </tbody>
</table>
<h3> <span class="label label-danger" >Total de los cobros por frecuencia: <b>{{$monto_total_frecuencia}} Bs</b></span></h3>

</div>

<div class="well">
<?php $monto_ingreso=0; ?>
<h3>Ingresos</h3>

        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" >
          <thead>
            <th><center>Id</center></th>
            <th><center>Fecha</center></th>
            <th><center>Usuario</center></th>
            <th><center>Observacion</center></th>
            <th><center>Monto</center></th>
            <th><center>Saldo</center></th>
            <th><center>Tipo</center></th>
            <th><center>Opcion</center></th>
            <th><center>Pagador</center></th>
            <th><center>Conductor/Cliente/Empresa</center></th>
            
          </thead>

          <tbody align="center" id="body_conductor">          
          @foreach($ingreso as $usr)
          <tr>
            <td>{{ $usr->id}}</td>
            <td>{{$usr->fecha}}</td>
            <td>{{$usr->usuario}}</td>
            <td>{{$usr->observacion}}</td>
            <td><b>{{$usr->monto}} Bs</b></td>
            <td>{{$usr->saldo}} Bs</td>
            <td>{{$usr->tipo_ingreso}}</td>
            <td>@if($usr->opcion==1)
              CONDUCTOR
              @elseif($usr->opcion==2)
              CORPORATIVO
              @elseif($usr->opcion==0)
              CLIENTE
              @endif
            </td>
            <td>{{$usr->nombre_pagador}}</td>
            <td><b>
              <?php
              if($usr->opcion==1)
              {
                $conductor=DB::select("SELECT  nombre, paterno, materno from conductor where ci='".$usr->id_conductor."'");
                $nombre_conductor="";
                foreach ($conductor as $key => $value) {
                  $nombre_conductor=$value->nombre." ".$value->paterno." ".$value->materno;
                }
                echo $nombre_conductor;

              }else if($usr->opcion==2)
              {
                $nombre_empresa="";
                $empresa=DB::select("SELECT  razon_social from empresa where id='".$usr->id_empresa."'");
                foreach ($empresa as $key => $value) {
                  $nombre_empresa=$value->razon_social;
                }
                echo $nombre_empresa;

              }else if($usr->opcion==0)
              {
                $nombre_cliente="";
                 
                $cliente=DB::select("SELECT  nombre,paterno,materno from cliente where id='".$usr->id_cliente."'");
                foreach ($cliente as $key => $value) {
                  $nombre_cliente=$value->nombre." ".$value->paterno." ".$value->materno;
                }
                echo $nombre_cliente;
              }
              ?>
              </b>               
            </td>
          </tr>
          <?php $monto_ingreso+= $usr->monto; ?>
          @endforeach
          </tbody>
        
        </table>




 
<h3> <span class="label label-warning" >Total de ingresos: <b>{{$monto_ingreso}} Bs</b></span></h3>
</div>

<div class="well">
<?php $monto_egreso=0; ?>
<h3>Egresos</h3>

<table class="table table-striped table-bordered table-condensed table-hover" style="background: white"  >
          <thead>
            <th><center>ID</center></th>
            <th><center>FECHA</center></th>
            <th><center>USUARIO</center></th>
            <th><center>OBSERVACIONES</center></th>
            <th><center>MONTO</center></th>
            <th><center>DEBE</center></th>
            <th><center>TIPO EGRESO</center></th>
            <th><center>OPCION</center></th>
            <th><center>Conductor/Cliente</center></th>
            
          </thead>

          <tbody align="center" id="body_egreso">         
          @foreach($egreso as $usr)
          <tr>
              <td>{{ $usr->id}}</td>
            <td>{{$usr->fecha}}</td>
            <td>{{$usr->usuario}}</td>
            <td>{{$usr->observacion}}</td>
            <td><b>{{$usr->monto}} Bs</b></td>
            <td>{{$usr->debe}} Bs</td>
            <td>{{$usr->tipo_egreso}}</td>
            <td> 
              @if($usr->opcion==2)
              CONDUCTOR
              @elseif($usr->opcion==0)
              CLIENTE
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
              <?php $monto_egreso+=$usr->monto; ?>
          </tr> 
          @endforeach
          </tbody>

          <tbody align="center" id="body_conductor_2">
          </tbody>          
        </table>
 
 
<h3> <span class="label label-success" >Total de egreso: <b>{{$monto_egreso}} Bs</b></span></h3>

</div>
 
<div class="well">

<?php
 $monto_total_ingreso=$monto_ingreso+$monto_total_frecuencia;
 $monto_total_egreso=$monto_egreso ;

?>
<table class="table table-striped table-bordered table-condensed table-hover " style="width:250px;">
	<thead style="background-color: #F8B712;">
		<th>Detalle</th>
		<th>Monto</th>
	</thead>
	<tbody>
		<tr >
			<td>Total de ingresos</td>
			<td>{{$monto_total_ingreso}} Bs</td>
		</tr>
		<tr>
			<td>Total de egresos</td>
			<td>{{$monto_total_egreso}} Bs</td>
		</tr>
		<tr>
			<td>Total de efectivo</td>
			<td style="background-color: #F8B712;">{{$monto_total_ingreso-$monto_total_egreso}} Bs</td>
		</tr>
	</tbody>
</table >

      <br>
</div>

 
 
@endsection

