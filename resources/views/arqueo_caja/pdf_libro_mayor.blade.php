<HTML>
<head>
 <meta charset="UTF-8">
    <title>LIBRO MAYOR</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

<style type="text/css">
         
      
table { 
  width: 730px;
  border-collapse: collapse;
}
td {
overflow: hidden;
max-width: 400px;
word-wrap: break-word;
}
body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
th{
  height: 30px;
  border:1px solid #000 !important;
        color: black;
        padding-left: 5px;
        padding-right: 5px; 
}

td{
      border: 1px solid #ddd;
}  
tr{
  display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}    

       
     </style>

</head>
<div align="right" style="height: 10px;">
   {{date("j - F - Y, g:i a")}}
  </div>
<body>
<div style="width: 100%">
<center><font size="3">LIBRO MAYOR</font></center>
</div>
<?php $empresa=DB::select("SELECT *from empresa,users where empresa.id=users.id_empresa and empresa.id=".Auth::user()->id_empresa); ?>
<br>
Empresa:<b> {{$empresa[0]->razon_social}}.</b><br>
Usuario:<b> {{Auth::user()->nombre}}.</b><br>
Fecha: <b> {{$fecha_inicio}}.</b> entre <b> {{$fecha_fin}}.</b><br>
@if($id_usuario!='' && $id_usuario!='no')
<?php $empresa=DB::select("SELECT usuario from users where id=".$id_usuario); ?>
Reporte del usuario {{$empresa[0]->usuario}}.
@else
Reporte de todos los usuarios.
@endif



<br>

<?php $monto_total_frecuencia=0; ?>

<h3  >Cobro de pagos de frecuencia</h3>
<table >
  <tr>
    <th><center>Nº</center></th>
    <th><center>Fecha</center></th>
    <th><center># Movil</center></th>
    <th><center>CI</center></th>
    <th><center>Conductor</center></th>
    <th><center>Monto Total</center></th>
    <th><center>Candidad</center></th>
    <th><center>Frecuencias</center></th>
    <th><center>Usuario</center></th>
  </tr>
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
</table>
<h3> Total de los cobros por frecuencia: <b>{{$monto_total_frecuencia}} Bs</b></h3>

<BR>

<?php $monto_ingreso=0; ?>
<h3>Ingresos</h3>
<table  >
  <tr>
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
  </tr>
 
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
           

</table>
<h3> <span  >Total de ingresos: <b>{{$monto_ingreso}} Bs</b></span></h3>


<br>
<?php $monto_egreso=0; ?>
<h3>Egresos</h3>
<table   > 
  <tr>
     <th><center>ID</center></th>
            <th><center>FECHA</center></th>
            <th><center>USUARIO</center></th>
            <th><center>OBSERVACIONES</center></th>
            <th><center>MONTO</center></th>
            <th><center>DEBE</center></th>
            <th><center>TIPO EGRESO</center></th>
            <th><center>OPCION</center></th>
            <th><center>Conductor/Cliente</center></th>
  </tr>  
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
</table>
<h3> <span  >Total de egreso: <b>{{$monto_egreso}} Bs</b></span></h3>

<br>
 
<?php
 $monto_total_ingreso=$monto_ingreso+$monto_total_frecuencia;
 $monto_total_egreso=$monto_egreso ;

?>

<br>
<table  style="width:250px;">
	<tr style="background-color: #F8B712;">
		<th>Detalle</th>
		<th>Monto</th>
	</tr>
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
</table >

      <br>

</body>
</html>
