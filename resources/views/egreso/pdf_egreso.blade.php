<head>
 <meta charset="UTF-8">
    <title>LISTA DE EGRESOS</title>
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
<center><font size="3">LISTA DE EGRESOS</font></center>
</div>
<br>

<?php $empresa=DB::select("SELECT *from empresa,users where empresa.id=users.id_empresa and empresa.id=".Auth::user()->id_empresa); ?>
<br>
Empresa:<b> {{$empresa[0]->razon_social}}.</b><br>
Usuario:<b> {{Auth::user()->nombre}}.</b><br>
Fecha: <b> {{$fecha_inicio}}.</b> entre <b> {{$fecha_fin}}.</b><br>
<br>

@if($id_usuario!='' && $id_usuario!='no')
<?php $empresa=DB::select("SELECT usuario from users where id=".$id_usuario); ?>
Reporte del usuario <b>{{$empresa[0]->usuario}}.</b>
@else
Reporte de todos los usuarios.
@endif
<br>
@if($id_cliente!='' && $id_cliente!='no')
<?php $cliente=DB::select("SELECT nombre,ci_nit from cliente where id=".$id_cliente); ?>
Reporte del cliente:<br>
Nombre: <b>{{$cliente[0]->nombre}}.</b><br>
Ci/Nit: <b>{{$cliente[0]->ci_nit}}.</b><br>
@else
Reporte de todos los clientes.
@endif


<br>
    
<?php $monto_total=0; ?>

        <table  >
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
            <td><b>{{$usr->monto}}</b></td>
            <td>{{$usr->debe}}</td>
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
    <th>Detalle</th>
    <th>Monto</th>
  </tr>
    
    <tr>
      <td>Total de egresos</td>
      <td>{{$monto_total}} Bs</td>
    </tr>
    
</table >

</body>
</html>
