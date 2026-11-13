@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>


<div class="row">	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
			   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <TABLE>
      <TR>
        <TD>
          @foreach($fechas as $fecha)
            <b>Fecha Inicio:</b> <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{$fecha->fecha_inicio}}">
            <b>Fecha Fin:</b> <input type="date" name="fecha_fin"  id="fecha_fin" value="{{$fecha->fecha_fin}}"> 
         @endforeach 
        </TD>
        <td>
          <label> Opción:</label>
        </td>
        <TD>
           <select class="form-control" id="opcion" name="opcion"  >
                  <option value="0" selected=""> TODOS</option>
                  <option value="1">CANCELADOS</option>
                  <option value="2">PEDIDOS COMPLETOS</option>
                  <option value="3">SIN ACEPTAR</option>
                </select>
        </TD>
         
      </TR>
    </TABLE>
        
               
          
          

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div id="mapa" style="width: 100%; height: 800px;"></div>
    <br>
    <table>
      <tr>
        <td><img src="images/pedido_finalizado.png"> COMPLETOS ...........</td>
        <td><img src="images/cancelado.png"> CANCELADO.............</td>
        <td><img src="images/sin_aceptar.png"> SIN ACEPTAR..........</td>
      </tr>
    </table>
	</div>

	


	






</div>

<input type="hidden" name="privilegio" id="privilegio" value="{{Auth::user()->privilegio}}">


{!!Html::script('js/puntos_pedido.js')!!}

 <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz02-44rmUM4TCcICttE6_qLCh6RmzjJw">
</script>

@endsection
