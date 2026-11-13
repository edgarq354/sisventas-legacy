@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('alerts.nota_compra')
@include('partials.dashboard_style')

<style type="text/css">
    /* ===== nota_compra/create — POS táctil, compacto ===== */
    .nc-create{ --nc-red:#c62828; --nc-line:#e6d8cc; --nc-ink:#3a2c24; --nc-muted:#8d7b6f; color:var(--nc-ink); }
    .nc-create *{ box-sizing:border-box; }

    .nc-top{
        display:flex; align-items:center; gap:10px; padding:8px 12px; margin-bottom:8px;
        background:linear-gradient(120deg,#c62828,#ef6c00); color:#fff; border-radius:10px;
    }
    .nc-top i{ font-size:16px; }
    .nc-top b{ font-size:14px; letter-spacing:.3px; }
    .nc-top .nc-caja{ margin-left:auto; font-size:11px; font-weight:700; background:rgba(255,255,255,.2); padding:3px 10px; border-radius:999px; }

    .nc-grid{ display:grid; grid-template-columns:1fr 380px; gap:8px; align-items:start; }
    @media (max-width:1100px){ .nc-grid{ grid-template-columns:1fr; } }

    .nc-box{ border:1px solid var(--nc-line); border-radius:10px; background:#fff; overflow:visible; }
    .nc-box__h{
        display:flex; align-items:center; gap:7px; padding:6px 10px; font-size:11px; font-weight:800;
        text-transform:uppercase; letter-spacing:.5px; color:var(--nc-red); background:#fdf0e7; border-bottom:2px solid var(--nc-line);
        border-radius:9px 9px 0 0;
    }
    .nc-box__b{ padding:8px; }

    /* Barra de búsqueda */
    .nc-search{ display:flex; gap:6px; flex-wrap:wrap; position:relative; z-index:20; }
    .nc-search .bootstrap-select{ flex:1 1 160px; min-width:140px; }
    .nc-search .bootstrap-select.open{ z-index:1055; }
    .nc-search .bootstrap-select .dropdown-menu{ z-index:1060; }
    .nc-form .bootstrap-select.open{ z-index:1055; }
    .nc-form .bootstrap-select .dropdown-menu{ z-index:1060; }
    .nc-search #txtBuscar{ flex:2 1 180px; height:40px; border:1px solid var(--nc-line); border-radius:8px; padding:0 12px; font-size:14px; }
    .nc-search .nc-buscar{ height:40px; min-width:52px; border:0; border-radius:8px; background:var(--nc-red); color:#fff; font-weight:700; font-size:15px; }

    /* Grilla de productos — 4 columnas, targets grandes para dedo */
    #listaProductos{ margin-top:8px; }
    #listaProductos > div{ display:flex; flex-wrap:wrap; gap:6px; }
    #listaProductos [class*="col-lg-12"]{ width:100%; padding:0 !important; }
    #listaProductos .panel{
        width:calc(25% - 5px) !important; float:none !important; margin:0 !important; padding:0 !important;
        border:1px solid var(--nc-line) !important; border-radius:9px; overflow:hidden; cursor:pointer;
        box-shadow:0 2px 8px -6px rgba(58,44,36,.5); transition:transform .08s;
    }
    #listaProductos img{ display:block; }
    #listaProductos .panel:active{ transform:scale(.96); }
    #listaProductos .panel:hover{ border-color:#ef6c00 !important; }
    #listaProductos .panel-heading{ padding:0 !important; background:#fff !important; border:0 !important; }
    #listaProductos .panel-heading img{ width:100% !important; height:80px; object-fit:contain; background:#faf6f2; }
    #listaProductos .panel-heading > div{ height:auto !important; min-height:0 !important; padding:4px 6px; font-size:11.5px; font-weight:700; line-height:1.15; }
    #listaProductos .panel-heading > div br{ display:none; }
    #listaProductos .panel-body{ padding:4px 6px !important; font-size:11px; font-weight:800; color:#fff; background:var(--nc-red); text-align:center; }
    @media (max-width:1400px){ #listaProductos .panel{ width:calc(25% - 5px) !important; } }
    @media (max-width:1100px){ #listaProductos .panel{ width:calc(20% - 5px) !important; } }
    @media (max-width:768px){ #listaProductos .panel{ width:calc(33.333% - 4px) !important; } }
    @media (max-width:480px){ #listaProductos .panel{ width:calc(50% - 3px) !important; } }

    /* Panel de datos de la compra */
    .nc-form label{ font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.4px; color:var(--nc-muted); margin:0 0 2px; display:block; }
    .nc-form .form-control, .nc-form select[name=estado]{ height:40px; border-radius:8px; border:1px solid var(--nc-line); font-size:14px; }
    .nc-form .bootstrap-select > .dropdown-toggle{ height:40px; border-radius:8px; border:1px solid var(--nc-line); }
    .nc-field{ margin-bottom:6px; }
    .nc-row2{ display:grid; grid-template-columns:1fr 1fr; gap:6px; }
    #monto_total{ font-weight:800; font-size:18px !important; border:2px solid #f39c12 !important; text-align:right; }

    /* Carrito */
    .nc-cart table{ width:100%; margin:0; font-size:12.5px; }
    .nc-cart thead th{ background:#fdf0e7; color:var(--nc-red); font-size:9.5px; text-transform:uppercase; padding:5px 6px; text-align:left; }
    .nc-cart tbody td{ padding:5px 6px; border-bottom:1px solid #f2e9e1; }
    .nc-cart tbody tr:last-child td{ border-bottom:0; }
    .nc-cart .nc-empty{ text-align:center; color:var(--nc-muted); padding:14px; font-size:12px; }

    #btn_guardar_compra{
        width:100%; height:52px; border:0; border-radius:10px; margin-top:8px;
        font-weight:900; font-size:16px; letter-spacing:.5px; color:#fff;
        background:linear-gradient(135deg,#2e7d32,#66bb6a); box-shadow:0 8px 18px -9px rgba(46,125,50,.7);
    }
    #btn_guardar_compra[disabled]{ background:#cdbfb2; box-shadow:none; }
</style>

<style>
	.panel-default > .panel-heading {
    color: #333;
    background-color: white;
    border-color: #ddd;
}
	</style>

<script type="text/javascript">


 

var listaProducto=[];
var carrito = [];

// ── Persistencia del carrito: si el registro falla (validación o error) los
//    items NO se pierden. Se guarda en localStorage y se limpia al guardar OK.
var NC_KEY = 'nc_carrito_{{ Auth::user()->id_empresa }}_{{ Auth::user()->id }}';
@if(Session::has('nota_compra_id'))
    try { localStorage.removeItem(NC_KEY); } catch(e){}
@else
    try {
        var _ncSaved = JSON.parse(localStorage.getItem(NC_KEY) || '[]');
        if (Array.isArray(_ncSaved) && _ncSaved.length) { carrito = _ncSaved; }
    } catch(e){}
@endif
function ncGuardarCarrito(){ try { localStorage.setItem(NC_KEY, JSON.stringify(carrito)); } catch(e){} }
function ncLimpiarCarrito(){ try { localStorage.removeItem(NC_KEY); } catch(e){} carrito = []; if (typeof cargarCarrito === 'function') cargarCarrito(); }

console.log("Vaciar");
	
 
function con_permiso()
{
	$("#permiso").val(1);
}
function sin_permiso(){
	$("#permiso").val(0);
}

 


function obtener_ultimo_numero(){

    $.get("../get_ultimo_numero_recibo", function (res) {
    $("#numero_label").text(@json(__('nota_compra.numero_label', ['numero' => '']))+res.numero);
    $("#numero_pago").val(res.numero);
    });

}

function cargarProducto(index){
	this.listaProducto=JSON.parse($("#listaProductoSeleccionado").val());
	console.log(this.listaProducto);  
	var vProducto=this.listaProducto[index]; 
	vProducto.cantidad=1;
	vProducto.peso=1;
	vProducto.total=vProducto.precio_compra;
	vProducto.precio_venta=vProducto.precio;
	vProducto.precio=vProducto.precio_compra;
	 
	if(this.carrito.filter(dato=>dato.id==vProducto.id).length>0){  
		for (var i = 0; i < this.carrito.length; i++) {  
			if(this.carrito[i].id==vProducto.id){ 
				this.carrito[i].cantidad++;
				this.carrito[i].peso++;
				this.carrito[i].total=parseFloat(parseFloat(this.carrito[i].total)+parseFloat(vProducto.precio)).toFixed(2);
			}
		}
	}else{ 
		this.carrito.push(vProducto);
	}
	cargarCarrito();
}

function cargarCarrito(){
	$('#body_carrito').empty(); 
	var tabladatos=$("#body_carrito");
	console.log("Lista de carrito:");
	console.log(this.carrito);
	var monto_total=0;
	for (var i = 0; i < this.carrito.length; i++) {  
		monto_total=parseFloat(monto_total)+parseFloat(this.carrito[i].total);
		tabladatos.append('<tr> <td>\n\
			 <input name="idCarrito[]" value='+this.carrito[i].id+' type="hidden"   />\n\ '
			 +'<input name="precio[]" value='+this.carrito[i].precio+' type="hidden"  />\n\ '
			 +'<input name="precioCompra[]" value='+this.carrito[i].precio_compra+' type="hidden"  />\n\ '
			 +'<input name="precioVenta[]" value='+this.carrito[i].precio_venta+' type="hidden"  />\n\ '
			 +'<input name="cantidad[]" value='+this.carrito[i].cantidad+' type="hidden"  />\n\ '
			 +'<input name="peso[]" value='+this.carrito[i].peso+' type="hidden"  />\n\ '
			  +'<input name="subtotal[]" value='+this.carrito[i].total+' type="hidden"  />\n\ '
			+this.carrito[i].nombre+'</td><td>'+this.carrito[i].peso+'</td><td>'+this.carrito[i].total+'</td> \n\
			<td><div class="input-group"><button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#ModalActualizar" onclick="verProducto('+i+');"><i class="fa fa-edit" aria-hidden="true"></i></button>\n\
				<button class="btn btn-danger btn-xs" type="button" onclick="eliminarProducto('+i+');"><i class="fa fa-close" aria-hidden="true"></i></button></div></td></tr>'); 
	}

	$("#monto_total").val(parseFloat(monto_total).toFixed(2));
	ncGuardarCarrito();
	if (typeof refrescarBtnCompra === 'function') refrescarBtnCompra();
}
function eliminarProducto(index){
	console.log("eliminar carrito:"+index);
	this.carrito.splice(index, 1);
	cargarCarrito();
}
function verProducto(index){
	 var vProducto=this.carrito[index];
	 console.log(vProducto);
	 $("#precio_compra").val(vProducto.precio_compra);
	 $("#precio_venta").val(vProducto.precio_venta);
	 $("#precio").val(vProducto.precio);
	 $("#cantidad").val(vProducto.cantidad);
	 $("#peso").val(vProducto.peso);
	 $("#nombre").val(vProducto.nombre);
	 $("#indexCarrito").val(index);
}

function guardarProducto(){
	var index=$("#indexCarrito").val();
	this.carrito[index].precio_compra=$("#precio_compra").val();
	this.carrito[index].precio_venta=$("#precio_venta").val();
	this.carrito[index].precio=$("#precio").val();
	this.carrito[index].peso=$("#peso").val();
	this.carrito[index].cantidad=$("#cantidad").val(); 
	this.carrito[index].nombre=$("#nombre").val();  
	this.carrito[index].total=parseFloat(parseFloat($("#precio").val())*parseFloat($("#peso").val())).toFixed(2);
	cargarCarrito();
}

//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function getListaProductos() {

  
  route = "../get_lista_producto/6"; //BUSCAR TODAS LAS EMPRESAS    

  $.get(route, function (res) {  
		this.listaProducto=res; 
		$("#listaProducto").val(JSON.stringify(this.listaProducto));
		$("#listaProductoTipo").val(JSON.stringify(this.listaProducto));
		$("#listaProductoSeleccionado").val(JSON.stringify(this.listaProducto));
		var vProductos="<div id='listaProductos'>";
		for (var i = 0; i < res.length && i<20; i++) {  
			//
			var iProducto= ''; 
			iProducto+= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >';
			for (var j = 0; i < res.length && j<4; j++) {  
			iProducto+= '<div class="panel panel-default  col-lg-3 col-md-3 col-sm-3 col-xs-6" style="text-align: center; margin: 0px;   " onclick="cargarProducto('+i+')">\n\
								<div class="panel-heading" > \n\
									<img src="../'+res[i].imagen1+'"  style="width: 100%;"  cache="no-cache">\n\
									<div  style="height: 50px;" > \n\
										<br>\n\
										'+res[i].nombre+'\n\
									</div>\n\
								</div>\n\
								<div class="panel-body"> <label>'+res[i].precio_compra+' bs - '+res[i].peso+' ';
				iProducto+=	'  </label></div>\n\
							</div>';
				i++;
			}
			i--;
			iProducto+= '</div>';

			vProductos+=iProducto;														
		} 
 
		
		document.getElementById("listaProductos").innerHTML +=vProductos+ "</div>";

		 
      }); 
  }

 function seleccionarTipo(){
	
	var idTipo=$("#id_tipo_producto").val();
	console.log("Tipo:"+idTipo);
	this.listaProducto=JSON.parse($("#listaProducto").val() || "[]");
	if(idTipo>0)
	this.listaProducto=this.listaProducto.filter(dato=>dato.id_tipo_producto==idTipo);

	$("#listaProductoTipo").val(JSON.stringify(this.listaProducto));
	console.log("Seleccionado por Categoria:"); 
	console.log(this.listaProducto);

	buscarProducto();
}

function buscarProducto(){
	
	var texto=($("#txtBuscar").val()||"").toUpperCase();
	console.log('buscar producto'+texto);
	this.listaProducto=JSON.parse($("#listaProductoTipo").val() || "[]");
	this.listaProducto=this.listaProducto.filter(function(dato){
		var n=(dato.nombre||"").toString().toUpperCase();
		var s=(dato.numero_serie||"").toString().toUpperCase();
		return n.indexOf(texto)>=0 || s.indexOf(texto)>=0;
	});

	$("#listaProductoSeleccionado").val(JSON.stringify(this.listaProducto));
	console.log(this.listaProducto);
	var vProductos="<div id='listaProductos'>";
		for (var i = 0; i < this.listaProducto.length && i<20; i++) {  
			//
			var iProducto= ''; 
			iProducto+= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >';
			for (var j = 0; i < this.listaProducto.length && j<4; j++) {  
			iProducto+= '<div class="panel panel-default  col-lg-3 col-md-3 col-sm-3 col-xs-6" style="text-align: center; margin: 0px;   " onclick="cargarProducto('+i+')">\n\
								<div class="panel-heading" > \n\
									<img src="../'+this.listaProducto[i].imagen1+'"  style="width: 100%;" cache="no-cache">\n\
									<div  style="height: 50px;" > \n\
										<br>\n\
										'+this.listaProducto[i].nombre+'\n\
									</div>\n\
								</div>\n\
								<div class="panel-body"> <label>'+this.listaProducto[i].precio_compra+' bs - '+this.listaProducto[i].peso; 
				iProducto+=	'  </label></div>\n\
							</div>';
				i++;
			}
			i--;
			iProducto+= '</div>';

			vProductos+=iProducto;	
		} 
 
		
		document.getElementById("listaProductos").innerHTML =vProductos+ "</div>";
}

  window.onload = function () {
	getListaProductos();
	// Restaurar carrito guardado (si el registro anterior falló)
	if (Array.isArray(carrito) && carrito.length) {
		cargarCarrito();
	}
}




</script>

<style type="text/css">
	.searchable-container{margin:1px 0 0 0}
	.searchable-container label.btn-default.active{background-color:green; color:#FFF}
	.searchable-container label.btn-default{width:100%;border:1px solid #efefef ;margin:1px; box-shadow:1px 1px 1px 0 #ccc;}
	.searchable-container label .bizcontent{width:100%;}
	.searchable-container .btn-group{width:100%}
	
</style>

<div class="row nc-create">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="nc-top">
        <i class="fa fa-truck"></i> <b>{{ __('nota_compra.registrar_nota_compra') }}</b>
        @if(!empty($caja_abierta))
            <span class="nc-caja"><i class="fa fa-inbox"></i> {{ __('nota_compra.caja_badge', ['nombre' => $caja_abierta->caja]) }}</span>
        @else
            <span class="nc-caja" style="background:#ffd7d3;color:#a12b21;">{{ __('nota_compra.sin_caja_abierta_corta') }}</span>
        @endif
    </div>

    @if(empty($caja_abierta))
        <div style="display:flex;align-items:center;gap:10px;background:#fdecea;border:1px solid #f5c6c2;color:#a12b21;border-radius:9px;padding:8px 12px;margin-bottom:8px;font-size:12.5px;font-weight:700;">
            <i class="fa fa-exclamation-triangle"></i> {{ __('nota_compra.abra_caja_compra') }}
            <a href="{!! URL::to('caja') !!}" class="btn btn-danger btn-xs" style="margin-left:auto;border-radius:7px;font-weight:700;">{{ __('nota_compra.ir_a_caja') }}</a>
        </div>
    @endif

    <input type="hidden" id="listaProducto">
    <input type="hidden" id="listaProductoTipo">
    <input type="hidden" id="listaProductoSeleccionado">
    <input type="hidden" name="id_empresa" id="id_empresa" value="{{ Auth::user()->id_empresa }}">

    <div class="nc-grid">

        {{-- ── Productos ── --}}
        <div class="nc-box">
            <div class="nc-box__h"><i class="fa fa-search"></i> {{ __('nota_compra.buscar_productos') }}</div>
            <div class="nc-box__b">
                <div class="nc-search">
                    <select name="id_tipo_producto" id="id_tipo_producto" class="selectpicker" data-live-search="true" onchange="seleccionarTipo();">
                        <option value="">{{ __('nota_compra.todos_mayus') }}</option>
                        @foreach($tipo_producto as $mov)
                            <option value="{{ $mov->id }}">{{ $mov->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="{{ __('nota_compra.buscar_producto_placeholder') }}" id="txtBuscar">
                    <button type="button" class="nc-buscar" onclick="buscarProducto();"><i class="fa fa-search"></i></button>
                </div>
                <div id="listaProductos"></div>
            </div>
        </div>

        {{-- ── Datos de la compra ── --}}
        <div class="nc-box nc-form">
            <div class="nc-box__h"><i class="fa fa-file-text-o"></i> {{ __('nota_compra.datos_de_la_compra') }}</div>
            <div class="nc-box__b">
                <form action="{{ route('nota_compra.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off"
                      onkeypress="if(event.keyCode == 13) event.returnValue = false;">
                    @csrf
                    <input type="hidden" name="id_caja" value="{{ $id_caja }}">
                    <input type="hidden" name="id_empresa" value="{{ Auth::user()->id_empresa }}">

                    <div class="nc-field">
                        <label>{{ __('nota_compra.comprador_field') }}</label>
                        <select name="id_comprador" id="id_comprador" class="form-control selectpicker text-uppercase" data-live-search="true">
                            <option value="">{{ __('nota_compra.buscar_comprador_placeholder') }}</option>
                            @foreach($empleado as $mov)
                                <option value="{{ $mov->id }}" {{ (string) old('id_comprador', $comprador_default ?? '') === (string) $mov->id ? 'selected' : '' }}>{{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="nc-field">
                        <label>{{ __('nota_compra.proveedor_field') }}</label>
                        <select name="id_proveedor" id="id_proveedor" class="form-control selectpicker text-uppercase" data-live-search="true">
                            <option value="">{{ __('nota_compra.buscar_proveedor_placeholder') }}</option>
                            @foreach($proveedor as $mov)
                                <option value="{{ $mov->id }}" {{ (string) old('id_proveedor') === (string) $mov->id ? 'selected' : '' }}>{{ $mov->nombre }} {{ $mov->paterno }} {{ $mov->materno }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="nc-row2">
                        <div class="nc-field">
                            <label>{{ __('nota_compra.total_bs') }}</label>
                            <input type="text" name="monto_total" id="monto_total" value="{{ old('monto_total', 0) }}" class="form-control" maxlength="10">
                        </div>
                        <div class="nc-field">
                            <label>{{ __('nota_compra.estado_field') }}</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="Procesado" {{ old('estado') === 'Procesado' || !old('estado') ? 'selected' : '' }}>{{ __('nota_compra.opt_procesado') }}</option>
                                <option value="Por pagar" {{ old('estado') === 'Por pagar' ? 'selected' : '' }}>{{ __('estados.Por pagar') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="nc-cart" style="border:1px solid var(--nc-line);border-radius:8px;overflow:hidden;margin-top:4px;">
                        <table class="table">
                            <thead><tr><th>{{ __('nota_compra.col_producto_corta') }}</th><th style="text-align:center;">{{ __('nota_compra.col_cant_corta') }}</th><th style="text-align:right;">{{ __('nota_compra.col_total_corta') }}</th><th></th></tr></thead>
                            <tbody id="body_carrito"><tr><td colspan="4" class="nc-empty">{{ __('nota_compra.toque_productos') }}</td></tr></tbody>
                        </table>
                    </div>

                    <button type="submit" id="btn_guardar_compra" disabled><i class="fa fa-save"></i> {{ __('nota_compra.guardar_compra') }}</button>
                </form>
            </div>
        </div>

    </div>

   <script src="{{ asset('js/nota_compra.js') }}"></script>
</div>
</div>
 




<!-- Modal ACTUALIZAR PRODUCTO-->
<div id="ModalActualizar" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: red; color: white">
		  <h3 class="modal-title">{{ __('nota_compra.actualizar_producto_titulo') }}</h3>
		</div>   
		
  
		<div class="modal-body">
   
   
   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
				<div style="margin: 15px;">
					{{ __('nota_compra.nombre_dp') }}<br>
					<input type="text"  id="nombre"  class="form-control" readonly="readonly" />
	  			</div>
	 

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
					<input type="hidden" id='indexCarrito'  /> 
	 
    
					<div class="form-group">
					{{ __('nota_compra.precio_compra_dp') }}<br>
					<input type="decimal"  class="form-control" id="precio_compra"  required readonly="readonly" />
					</div>
	
					<div class="form-group">
						{{ __('nota_compra.precio_dp') }}<br>
						<input type="decimal"  class="form-control" id="precio"  required/>
					</div>
				</div>
	  
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 	  
					<div class="form-group">
					{{ __('nota_compra.precio_venta_dp') }}<br>
					<input type="decimal"   class="form-control" id="precio_venta"   required readonly="readonly">
					</div>

					<div class="form-group" hidden>
					{{ __('nota_compra.cantidad_dp') }}<br>
					<input type="number"   class="form-control" id="cantidad"   required>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 	  
					<div class="form-group">
					{{ __('nota_compra.cantidad_dp2') }}<br>
					<input type="decimal" style="border: 3px solid #f39c12;"  class="form-control" id="peso"   required>
					</div>

					 
				</div>
  			 </div>
		</div>
  
  
		<div class="modal-footer"> 
			<button data-dismiss="modal"  class="btn btn-danger form-control" onclick="guardarProducto();">
				<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_compra.guardar_btn') }}</button>
		</div>
	</div>
</div>
 


<script>
	$('#txtBuscar').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        buscarProducto();
		var lista=JSON.parse($("#listaProductoSeleccionado").val());
		if(lista.length>0){
			cargarProducto(0);
			$('#txtBuscar').val("");
		}
    }
});
	</script>

<script type="text/javascript">
	// GUARDAR COMPRA habilitado solo si el carrito tiene items
	(function () {
		function refrescarBtnCompra() {
			var hay = (typeof carrito !== 'undefined' && Array.isArray(carrito))
				? carrito.length > 0
				: $('#body_carrito input[name="idCarrito[]"]').length > 0;
			$('#btn_guardar_compra').prop('disabled', !hay);
		}
		var cont = document.getElementById('body_carrito');
		if (cont && window.MutationObserver) {
			new MutationObserver(refrescarBtnCompra).observe(cont, { childList: true });
		}
		$(refrescarBtnCompra);
		// Comprador por defecto = empleado del usuario autenticado
		$(function () { $('#id_comprador').selectpicker('refresh'); });
	})();
</script>

	@endsection




	<?php
	function obtener_dia($fecha){
		$dia="";
		$numero=date('N',strtotime($fecha));
		switch ($numero) {
			case 1:
				$dia="Lunes";
				break;
			case 2:
				$dia="Martes";
				break;
			case 3:
				$dia="Miercoles";
				break;
			case 4:
				$dia="Jueves";
				break;
			case 5:
				$dia="Viernes";
				break;
			case 6:
				$dia="Sabado";
				break;	
			case 7:
				$dia="Domingo";
				break;					
		}
		return $dia;
	}
	?>





