<head>
 <meta charset="UTF-8">
    <title>{{ __('ingreso.lista_de_ingresos') }}</title>
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
   {{ fecha_hora_impresion() }}
  </div>
<body onload="window.print()">
<div style="width: 100%">
<center><font size="3">{{ __('ingreso.lista_de_ingresos') }}</font></center>
</div>
<br>

<?php $empresa=DB::select("SELECT *from empresa,users where empresa.id=users.id_empresa and empresa.id=".Auth::user()->id_empresa); ?>
<br>
{{ __('egreso.empresa_dp') }}<b> {{$empresa[0]->razon_social}}.</b><br>
{{ __('egreso.usuario_dp') }}<b> {{Auth::user()->nombre}}.</b><br>
{!! __('ingreso.fecha_entre', ['inicio' => $fecha_inicio, 'fin' => $fecha_fin]) !!}<br>
<br>

@if($id_usuario!='' && $id_usuario!='no')
<?php $empresa=DB::select("SELECT usuario from users where id=".$id_usuario); ?>
{!! __('ingreso.reporte_usuario', ['usuario' => $empresa[0]->usuario]) !!}
@else
{{ __('ingreso.reporte_todos_usuarios') }}
@endif
<br>
@if($id_cliente!='' && $id_cliente!='no')
<?php $cliente=DB::select("SELECT nombre,ci_nit from cliente where id=".$id_cliente); ?>
{{ __('ingreso.reporte_cliente') }}<br>
{{ __('ingreso.cliente_nombre_dp') }} <b>{{$cliente[0]->nombre}}.</b><br>
{{ __('ingreso.ci_nit_dp') }} <b>{{$cliente[0]->ci_nit}}.</b><br>
@else
{{ __('ingreso.reporte_todos_clientes') }}
@endif


<br>
    
<?php $monto_total=0; ?>

        <table  >
        <tr>
            <th><center>{{ __('ingreso.col_id') }}</center></th>
            <th><center>{{ __('ingreso.col_fecha') }}</center></th>
            <th><center>{{ __('ingreso.col_usuario') }}</center></th>
            <th><center>{{ __('ingreso.col_observacion') }}</center></th>
            <th><center>{{ __('ingreso.col_monto') }}</center></th>
            <th><center>{{ __('ingreso.col_saldo') }}</center></th>
            <th><center>{{ __('ingreso.col_tipo') }}</center></th>
            <th><center>{{ __('ingreso.col_opcion') }}</center></th>
            <th><center>{{ __('ingreso.col_pagador') }}</center></th>
            <th><center>{{ __('ingreso.col_conductor_cliente_empresa') }}</center></th>
            
          </tr>         
          @foreach($ingreso as $usr)
          <tr>
            <td>{{ $usr->id}}</td>
            <td>{{$usr->fecha}}</td>
            <td>{{$usr->usuario}}</td>
            <td>{{$usr->observacion}}</td>
            <td><b>{{$usr->monto}}</b></td>
            <td>{{$usr->saldo}}</td>
            <td>{{$usr->tipo_ingreso}}</td>
            <td>@if($usr->opcion==1)
              {{ __('ingreso.conductor') }}
              @elseif($usr->opcion==2)
              {{ __('ingreso.corporativo') }}
              @elseif($usr->opcion==0)
              {{ __('ingreso.cliente') }}
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
              }else if($usr->opcion==3)
              {
                $nombre_empresa="";
                $empresa=DB::select("SELECT  nombre as 'razon_social' from lugar where id='".$usr->id_lugar."'");
                foreach ($empresa as $key => $value) {
                  $nombre_empresa=$value->razon_social;
                }
                echo $nombre_empresa;

              }
              ?>
              </b>               
            </td>
          </tr>
          <?php 
          $monto_total+=$usr->monto;
          ?>
          @endforeach 
            
        </table>

  <br><br>

<br>
<table  style="width:250px;">
  <tr style="background-color: #F8B712;">
    <th>{{ __('ingreso.col_detalle') }}</th>
    <th>{{ __('ingreso.col_monto_simple') }}</th>
  </tr>
    
    <tr>
      <td>{{ __('ingreso.total_de_ingresos') }}</td>
      <td>{{$monto_total}} {{ __('ingreso.bs') }}</td>
    </tr>
    
</table >

</body>
</html>
