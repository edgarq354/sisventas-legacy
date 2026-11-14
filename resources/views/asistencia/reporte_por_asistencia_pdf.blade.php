     
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>{{ __('asistencia.titulo_respaldo') }}</title>
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
  border:1px solid #ddd!important;
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

<div style="width: 100%;height: 0%;">
<center><font size="3">{{ __('asistencia.titulo_respaldo') }}</font></center>
</div>

<table style=" border-collapse:none;">
<tr>
  <td colspan="3" align="left" style="border: 0px solid #000;"><h2>.</h2></td>
  
</tr>
<tr>
  <td style="border: 0px solid #000;">
    @foreach($usuario as $usu)
             
            @endforeach
    #{{$usu->id}} <br>
    {{ __('asistencia.nombre_dp') }} {{$usu->usuario}} 
  </td>
  </tr>   
  <TR><td style="border: 0px solid #000;">{{ __('asistencia.hora_ingreso_dp') }} {{$usu->fecha_ingreso}}
</td>
</TR>
<TR>
  <td style="border: 0px solid #000;">{{ __('asistencia.hora_salida_dp') }} {{$usu->fecha_salida}}</td>
</tr>
<tr>
 <TD style="border: 0px solid #000;"> {{ __('asistencia.empresa_dp') }}{{$usu->razon_social}}
</TD>
</tr>
</table>
<br>





 


{{ __('asistencia.observaciones_dp2') }}
@foreach($usuario as $usu)
             {{$usu->observaciones}} 
            @endforeach


</body>
</html>




  
  

