<head>
 <meta charset="UTF-8">
    <title>{{ __('egreso.lista_de_egresos') }}</title>
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
<body>
<div style="width: 100%">
<center><font size="3">{{ __('egreso.lista_de_egresos') }}</font></center>
</div>
<br>

<?php $empresa=DB::select("SELECT *from empresa,users where empresa.id=users.id_empresa and empresa.id=".Auth::user()->id_empresa); ?>
<br>
{{ __('egreso.empresa_dp') }}<b> {{$empresa[0]->razon_social}}.</b><br>
{{ __('egreso.usuario_dp') }}<b> {{Auth::user()->nombre}}.</b><br>
{!! __('egreso.fecha_entre', ['inicio' => $fecha_inicio, 'fin' => $fecha_fin]) !!}<br>
<br>

@if($id_usuario!='' && $id_usuario!='no')
<?php $empresa=DB::select("SELECT usuario from users where id=".$id_usuario); ?>
{!! __('egreso.reporte_usuario', ['usuario' => $empresa[0]->usuario]) !!}
@else
{{ __('egreso.reporte_todos_usuarios') }}
@endif
<br>
@if($id_cliente!='' && $id_cliente!='no')
<?php $cliente=DB::select("SELECT nombre,ci_nit from cliente where id=".$id_cliente); ?>
{{ __('egreso.reporte_cliente') }}<br>
{{ __('egreso.cliente_nombre_dp') }} <b>{{$cliente[0]->nombre}}.</b><br>
{{ __('egreso.ci_nit_dp') }} <b>{{$cliente[0]->ci_nit}}.</b><br>
@else
{{ __('egreso.reporte_todos_clientes') }}
@endif


<br>
    
<?php $monto_total=0; ?>

        <table  >
          <tr>
            <th><center>{{ __('egreso.col_id') }}</center></th>
            <th><center>{{ __('egreso.col_fecha') }}</center></th>
            <th><center>{{ __('egreso.col_usuario') }}</center></th>
            <th><center>{{ __('egreso.col_observaciones') }}</center></th>
            <th><center>{{ __('egreso.col_monto') }}</center></th>
            <th><center>{{ __('egreso.col_debe') }}</center></th>
            <th><center>{{ __('egreso.col_tipo_egreso') }}</center></th>
            <th><center>{{ __('egreso.col_opcion') }}</center></th>
            <th><center>{{ __('egreso.col_conductor_cliente') }}</center></th> 
           </tr>

                
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
    <th>{{ __('egreso.col_detalle') }}</th>
    <th>{{ __('egreso.col_monto_simple') }}</th>
  </tr>
    
    <tr>
      <td>{{ __('egreso.total_de_egresos') }}</td>
      <td>{{$monto_total}} {{ __('egreso.bs') }}</td>
    </tr>
    
</table >

</body>
</html>
