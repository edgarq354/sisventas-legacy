@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<script type="text/javascript">
  
	function ver_producto(id_producto){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();
	    $.get("../../../get_nota_compra_por_id_producto/"+id_producto+"/"+fechaInicio+"/"+fechaFinal, function (res) {
	     var listaDetalle=res.detalle_compra;


	     $('#body_detalle').empty(); 
	var tabladatos=$("#body_detalle");  
	for (var i = 0; i < listaDetalle.length; i++) {   
		tabladatos.append('<tr> <td>\n\
			 	'+listaDetalle[i].id+'</td> \n\
			 	<td>'+listaDetalle[i].fecha+'</td> \n\
			 	<td>'+listaDetalle[i].proveedor+'</td> \n\
			 	<td>'+listaDetalle[i].comprador+'</td> \n\
			 	<td>'+listaDetalle[i].peso+'</td> \n\
			 	<td>'+listaDetalle[i].sub_total+'</td> \n\
			</tr>'); 
	}
	 

	    
	    });
	} 

function buscarEnlace(){
	var fechaInicio=$("#calendario1").val();
	var fechaFinal=$("#calendario2").val();
	var idProducto=$("#idProducto").val();

	$("#buscar").prop("href", "../../../nota_compra_historial_por_producto/"+fechaInicio+"/"+fechaFinal+"/"+idProducto);
	$("#imprimir").prop("href", "../../../nota_compra_historial_por_producto_imprimir/"+fechaInicio+"/"+fechaFinal+"/"+idProducto);
}

</script>




<?php
$message=Session::get('message');
?>


<input type="hidden" id="listaNotaVenta" value="{{json_encode($nota_compra)}}">

@if($message=='store')
<div class="alert alert-success alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">$times;</span></button>
	Pago registrado con Exito.
</div>
@endif
@include('partials.dashboard_style')

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
    #tabla_sin_imprimir tbody td{ padding:6px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    #tabla_sin_imprimir .badge{ font-size:10px; padding:3px 8px; border-radius:999px; }
    #tabla_sin_imprimir td.num{ text-align:right; font-weight:700; }
    .pp-filtros{ display:flex; flex-wrap:wrap; gap:10px 14px; align-items:flex-end; }
    .pp-filtros .fld{ display:flex; flex-direction:column; gap:3px; }
    .pp-filtros label{ font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d7b6f; margin:0; }
    .pp-filtros input[type=text]{ height:36px; border:1px solid #e2d3c6; border-radius:8px; padding:0 10px; font-size:13px; background:#fff; }
    .pp-filtros .bootstrap-select{ min-width:200px; }
    .pp-filtros .bootstrap-select.open{ z-index:1055; }
    .pp-filtros .bootstrap-select .dropdown-menu{ z-index:1060; }
    .pp-btn{ display:inline-flex; align-items:center; justify-content:center; gap:7px; height:36px; padding:0 16px;
        border-radius:9px; font-weight:700; font-size:12.5px; color:#fff; border:0; text-decoration:none; box-shadow:0 6px 16px -9px rgba(0,0,0,.5); }
    .pp-btn:hover{ filter:brightness(1.07); color:#fff; }
    .pp-btn--buscar{ background:linear-gradient(135deg,#ef6c00,#f9a825); }
    .pp-btn--print{ background:#c62828; }
</style>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-cube"></i></div>
        <div>
            <h3 class="dash-hero__title">Compras por producto</h3>
            <p class="dash-hero__sub">Del {{ $fechaInicio }} al {{ $fechaFinal }} &middot; {{ count($nota_compra) }} productos</p>
        </div>
    </div>

    <div class="dash-card dash-card--overflow">
        <div class="dash-card__body">
            <div class="pp-filtros">
                <div class="fld"><label>Desde</label><input type="text" value="{{ $fechaInicio }}" id="calendario1" onmouseover="buscarEnlace();" autocomplete="off"></div>
                <div class="fld"><label>Hasta</label><input type="text" value="{{ $fechaFinal }}" id="calendario2" onmouseover="buscarEnlace();" autocomplete="off"></div>
                <div class="fld">
                    <label>Producto</label>
                    <select name="id_producto" id="idProducto" class="selectpicker" data-live-search="true" onchange="buscarEnlace();">
                        <option value="0">Todos los productos</option>
                        @foreach($producto as $mov)
                            <option value="{{ $mov->id }}">{{ $mov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fld"><label>&nbsp;</label>
                    <div>
                        <a class="pp-btn pp-btn--buscar" href="../../nota_compra_historial_por_producto/{{ $fechaInicio }}/{{ $fechaFinal }}/0" id="buscar" onmouseover="buscarEnlace();"><i class="fa fa-search"></i> Buscar</a>
                        <a class="pp-btn pp-btn--print" href="../../nota_compra_historial_por_producto_imprimir/{{ $fechaInicio }}/{{ $fechaFinal }}/0" id="imprimir" onmouseover="buscarEnlace();"><i class="fa fa-print"></i> Imprimir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-list"></i> Productos comprados</div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th style="width:55px;"><center>ID</center></th>
                        <th>Tipo</th>
                        <th>Producto</th>
                        <th style="text-align:right;">Precio</th>
                        <th style="text-align:right;">Stock</th>
                        <th style="text-align:right;">Comprado</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:center;">...</th>
                    </thead>
                    <tbody id="body_video">
                        @forelse ($nota_compra as $usr)
                            <tr>
                                <td><center>{{ $usr->id }}</center></td>
                                <td>{{ $usr->nombre_tipo_producto }}</td>
                                <td><b>{{ $usr->nombre }}</b>@if($usr->descripcion)<br><span style="color:#8d7b6f;font-size:11px;">{{ $usr->descripcion }}</span>@endif</td>
                                <td class="num">{{ number_format((float)$usr->precio, 2) }}</td>
                                <td class="num">
                                    @if ($usr->peso > $usr->peso_minimo){{ $usr->peso }}
                                    @else<span class="badge btn-danger">{{ $usr->peso }}</span>@endif
                                </td>
                                <td class="num">{{ $usr->peso_compra }}</td>
                                <td class="num">{{ number_format((float)$usr->sub_total, 2) }}</td>
                                <td style="text-align:center;">
                                    <a class='btn btn-warning btn-xs' data-toggle="modal" data-target="#ModalVenta" onclick="ver_producto({{ $usr->id }});"><i class="fa fa-shopping-cart"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="dash-empty">Sin compras de producto en el período</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<!-- Modal NOTA VENTA-->
<div id="ModalVenta" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: #d4463e; color: white">
		  <h3 class="modal-title">NOTAS DE COMPRAS : <label id="idNotaVenta"></label></h3>
		</div>   
		
  
		<div class="modal-body">
   
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
				<thead> 
					<th><center>ID COMPRA</center></th> 
					<th><center>FECHA</center></th>  
					<th><center>PROVEEDOR</center></th> 
					<th><center>COMPRADOR</center></th>  
					<th><center>CANTIDAD</center></th> 
					<th><center>TOTAL</center></th> 
				</thead>
				<tbody align="center" id="body_detalle">					
				
				</tbody>
			</table>
		</div>
		</div>

		
  
  
		<div class="modal-footer"> 
			 
		</div>
	</div>
</div>
</div>
 
 <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
@endsection

