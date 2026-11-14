@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('alerts.nota_venta')
@include('partials.dashboard_style')

<style type="text/css">
    /* ===== nota_venta/create — POS táctil, compacto ===== */
    .nv-create{ --nv-red:#c62828; --nv-line:#e6d8cc; --nv-ink:#3a2c24; --nv-muted:#8d7b6f; color:var(--nv-ink); }
    .nv-create *{ box-sizing:border-box; }

    .nv-top{ display:flex; align-items:center; gap:10px; padding:8px 12px; margin-bottom:8px;
        background:linear-gradient(120deg,#c62828,#ef6c00); color:#fff; border-radius:10px; }

    /* Aviso flotante grande: sin caja abierta */
    #nv-nocaja{ position:fixed; inset:0; z-index:99998; background:rgba(58,44,36,.6);
        display:flex; align-items:center; justify-content:center; padding:20px; animation:nvFade .2s ease; }
    #nv-nocaja .nv-nocaja__box{ position:relative; background:#fff; border-radius:18px; padding:34px 40px 32px;
        max-width:460px; width:100%; text-align:center; box-shadow:0 40px 90px -25px rgba(0,0,0,.6); }
    #nv-nocaja .nv-nocaja__ico{ width:74px; height:74px; margin:0 auto 14px; border-radius:50%;
        background:rgba(198,40,40,.12); color:#c62828; display:flex; align-items:center; justify-content:center; font-size:34px; }
    #nv-nocaja h3{ font-size:21px; font-weight:800; color:#3a2c24; margin:0 0 6px; }
    #nv-nocaja p{ color:#8d7b6f; font-size:14px; margin:0 0 22px; }
    #nv-nocaja .nv-nocaja__btn{ display:inline-flex; align-items:center; gap:9px; text-decoration:none;
        background:linear-gradient(135deg,#2e7d32,#66bb6a); color:#fff; font-weight:800; font-size:16px;
        padding:14px 34px; border-radius:12px; box-shadow:0 12px 26px -10px rgba(46,125,50,.75); }
    #nv-nocaja .nv-nocaja__btn:hover{ filter:brightness(1.06); color:#fff; }
    #nv-nocaja .nv-nocaja__x{ position:absolute; top:12px; right:16px; border:0; background:transparent;
        font-size:26px; line-height:1; color:#b8a99b; cursor:pointer; }
    @keyframes nvFade{ from{ opacity:0; } to{ opacity:1; } }
    .nv-top i{ font-size:16px; }
    .nv-top b{ font-size:14px; letter-spacing:.3px; }
    .nv-top .nv-caja{ margin-left:auto; font-size:11px; font-weight:700; background:rgba(255,255,255,.2); padding:3px 10px; border-radius:999px; }

    .nv-grid{ display:grid; grid-template-columns:1fr 400px; gap:8px; align-items:start; }
    @media (max-width:1100px){ .nv-grid{ grid-template-columns:1fr; } }

    .nv-box{ border:1px solid var(--nv-line); border-radius:10px; background:#fff; overflow:visible; }
    .nv-box__h{ display:flex; align-items:center; gap:7px; padding:6px 10px; font-size:11px; font-weight:800;
        text-transform:uppercase; letter-spacing:.5px; color:var(--nv-red); background:#fdf0e7; border-bottom:2px solid var(--nv-line); border-radius:9px 9px 0 0; }
    .nv-box__b{ padding:8px; }

    .nv-search{ display:flex; gap:6px; flex-wrap:wrap; position:relative; z-index:20; }
    .nv-search .bootstrap-select{ flex:1 1 150px; min-width:130px; }
    .nv-search .bootstrap-select.open{ z-index:1055; }
    .nv-search .bootstrap-select .dropdown-menu{ z-index:1060; }
    .nv-form .bootstrap-select.open{ z-index:1055; }
    .nv-form .bootstrap-select .dropdown-menu{ z-index:1060; }
    .nv-search #txtBuscar{ flex:2 1 180px; height:40px; border:1px solid var(--nv-line); border-radius:8px; padding:0 12px; font-size:14px; }
    .nv-search .nv-buscar{ height:40px; min-width:52px; border:0; border-radius:8px; background:var(--nv-red); color:#fff; font-weight:700; font-size:15px; }

    #listaProductos{ margin-top:8px; }
    #listaProductos > div{ display:flex; flex-wrap:wrap; gap:6px; }
    #listaProductos [class*="col-lg-12"]{ width:100%; padding:0 !important; display:contents; }
    #listaProductos .panel{ width:calc(25% - 5px) !important; float:none !important; margin:0 !important; padding:0 !important;
        border:1px solid var(--nv-line) !important; border-radius:9px; overflow:hidden; cursor:pointer;
        box-shadow:0 2px 8px -6px rgba(58,44,36,.5); transition:transform .08s; }
    #listaProductos .panel-heading{ padding:0 !important; }
    #listaProductos img{ display:block; }
    #listaProductos .panel:active{ transform:scale(.96); }
    #listaProductos .panel:hover{ border-color:#ef6c00 !important; }
    #listaProductos .panel-heading{ padding:0 !important; background:#fff !important; border:0 !important; }
    #listaProductos .panel-heading img{ width:100% !important; height:80px; object-fit:contain; background:#faf6f2; }
    #listaProductos .panel-heading > div{ height:auto !important; min-height:0 !important; padding:4px 6px; font-size:11.5px; font-weight:700; line-height:1.15; }
    #listaProductos .panel-body{ padding:4px 6px !important; font-size:11px; font-weight:800; color:#fff !important; background:var(--nv-red); text-align:center; }
    #listaProductos .panel-body label{ color:#fff !important; margin:0; font-weight:800; }
    /* >1500px = 5 columnas ; por defecto 4 ; luego 3 y 2 */
    @media (min-width:1500px){ #listaProductos .panel{ width:calc(20% - 5px) !important; } }
    @media (max-width:1024px){ #listaProductos .panel{ width:calc(33.333% - 4px) !important; } }
    @media (max-width:520px){  #listaProductos .panel{ width:calc(50% - 3px) !important; } }

    .nv-form label{ font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.4px; color:var(--nv-muted); margin:0 0 2px; display:block; }
    .nv-form .form-control{ height:40px; border-radius:8px; border:1px solid var(--nv-line); font-size:14px; }
    .nv-form select[name=tipo], .nv-form select[name=estado]{ height:40px; width:100%; border-radius:8px; border:1px solid var(--nv-line); padding:0 8px; font-size:14px; }
    .nv-field{ margin-bottom:6px; }
    .nv-row2{ display:grid; grid-template-columns:1fr 1fr; gap:6px; }
    .nv-create #ciNit{ border:2px solid #f39c12 !important; font-weight:700; }
    .nv-create #monto_total{ font-weight:800; font-size:20px !important; height:48px; border:2px solid #f39c12 !important; text-align:right; }
    .nv-create #efectivoCambio{ font-weight:800; font-size:20px !important; height:48px; text-align:right; background:#f4ece5; }

    #sugerenciasCliente{ position:absolute; z-index:9999; width:100%; max-height:200px; overflow:auto; }

    .nv-cart table{ width:100%; margin:0; font-size:12px; }
    .nv-cart thead th{ background:#fdf0e7; color:var(--nv-red); font-size:9px; text-transform:uppercase; padding:4px 5px; text-align:left; }
    .nv-cart tbody td{ padding:4px 5px; border-bottom:1px solid #f2e9e1; }
    .nv-cart .nv-empty{ text-align:center; color:var(--nv-muted); padding:12px; font-size:12px; }

    #btn_guardar_venta, #btn_generar_qrfie{ width:100%; height:52px; border:0 !important; border-radius:10px; margin-top:8px;
        font-weight:900; font-size:16px; letter-spacing:.5px; color:#fff !important; }
    #btn_guardar_venta{ background:linear-gradient(135deg,#2e7d32,#66bb6a) !important; box-shadow:0 8px 18px -9px rgba(46,125,50,.7); }
    #btn_guardar_venta[disabled]{ background:#cdbfb2 !important; box-shadow:none; }
    #btn_generar_qrfie{ background:linear-gradient(135deg,#c62828,#ef6c00) !important; }
</style>

<style>
	.panel-default > .panel-heading {
    color: #333;
    background-color: white;
    border-color: #ddd;

	.col-cuadro-3{
		width: 24%;
	}
}
	</style>

<script type="text/javascript">
/* document.addEventListener('DOMContentLoaded', function() {
  applyInputMask('total', '0.00');
}); */





//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function Cargar_accesorios_por_id_tipo(id) {
  var tabladatos=$("#body_accesorios");

    route = "buscar_accesorios_por_id/"+id; //BUSCAR TODAS LAS EMPRESAS



  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS



      for (var i = 0; i < res.length; i++) {

                tabladatos.append('<tr > <td> '+res[i].id+' </td> <td>'+res[i].nombre+'</td> \n\
                <td>'+res[i].precio+'</td><td>'+res[i].peso+'</td> </tr>');
                cont++;


            }


      });
  }



//MUESTRA LAS EMPRESAS DEPENDE LO Q SELECCIONO EN EL BUSADOR
function Cargar_accesorios_en_lista(id) {
  var tabladatos=$("#body_accesorios");

    route = "buscar_accesorios_por_id/"+id; //BUSCAR TODAS LAS EMPRESAS



  $.get(route, function (res) { //CONSULTA DE TODOS LOS MOTISTAS ACTIVOS



      for (var i = 0; i < res.length; i++) {

                tabladatos.append('<tr id="fila'+cont+'"> <td> <input name="id_empresa[]" id="id_empresa'+cont+'" value='+res[i].id+' type=hidden size=2>\n\
                '+res[i].nit+'</td><td>'+res[i].razon_social+'</td><td>'+res[i].direccion+'</td></tr>');
                cont++;


            }


      });
  }

function eliminar_lista(id)
{

}
function calcularTotal(){
	var precio=document.getElementById("precio").value;
	var cantidad=document.getElementById("cantidad").value;
	var total=parseFloat(precio*cantidad);
	document.getElementById("total").value=total;
	console.log(precio+' '+cantidad+' '+total);
}

function buscarCuis(){
 // console.log('llega');
   // Esta es la variable que vamos a pasar
              var miVariableJS=$("#ciNit").val();
              console.log(miVariableJS);
               // Enviamos la variable de javascript a archivo.php
              $.post("../../resources/services/cuis.php",{"texto":miVariableJS,"texto1":"3"},function(respuesta){
                        if(respuesta=="Error"){
                          alert("Debe enviar todos los datos");
                        }else{
            //alert(respuesta);
            var data = JSON.parse(respuesta);
            var msg="";
            switch(data.RespuestaCuis.mensajesList.codigo){
            case 918:
              msg=data.RespuestaCuis.mensajesList.descripcion;
            break;
            case 980:
              msg=data.RespuestaCuis.mensajesList.descripcion
            break;
            default:
              msg="codigo nuevo"+data.RespuestaCuis.mensajesList.codigo;
            break;
            }
            //console.log(msg);
            Swal.fire({
            title: 'Mensaje',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
            }).then((result) => {
            if (result.isConfirmed) {
              console.log("nit inválido");
            }else{
              console.log("cancel");
            }
            });
                        }
  });
}
function cargarCarrito(){
	$('#body_carrito').empty();
	var tabladatos=$("#body_carrito");
	console.log("Lista de carrito:");
	console.log(this.carrito);
	var monto_total=0;
  var monto_total_descuento=0;
	for (var i = 0; i < this.carrito.length ; i++) {
		monto_total=parseFloat(monto_total)+parseFloat(this.carrito[i].total);
    monto_total_descuento=parseFloat(monto_total_descuento)+parseFloat(this.carrito[i].monto_descuento);
		tabladatos.append('<tr> <td>\n\
       <input name="idCarrito[]" value='+this.carrito[i].id+' type="text" hidden  />\n\
			 <input name="producto[]" value='+this.carrito[i].id+' type="text" hidden   />\n\
			 <input name="precio[]" value='+this.carrito[i].precio+' type="text" hidden  />\n\
			 <input name="precioCompra[]" value='+this.carrito[i].precio_compra+' type="text" hidden />\n\
			 <input name="precioVenta[]" value='+this.carrito[i].precio_venta+' type="text" hidden />\n\
			 <input name="cantidad[]" value="'+this.carrito[i].cantidad+'" type="text" hidden />\n\
       <input name="actividadEconomica[]" value="'+this.carrito[i].actividad_economica+'" type="text" hidden />\n\
       <input name="descripcion[]" value="'+this.carrito[i].nombre+'" type="text" hidden />\n\
       <input name="unidadMedida[]" value='+this.carrito[i].unidad_medida+' type="text" hidden   />\n\
       <input name="montoDescuento[]" value='+this.carrito[i].monto_descuento+' type="text" hidden   />\n\
       <input name="subTotal[]" value='+this.carrito[i].total+' type="text" hidden   />\n\
       <input name="peso[]" value='+this.carrito[i].peso+' type="text" hidden   />\n\
			'+this.carrito[i].nombre+' </td>\n\
      <td>'+this.carrito[i].precio_venta+'</td>\n\
      <td>'+this.carrito[i].peso+'</td>\n\
      <td>'+this.carrito[i].total+'</td> \n\
			<td><div class="input-group"><button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#ModalActualizar" onclick="verProducto('+i+');"><i class="fa fa-edit" aria-hidden="true"></i></button>\n\
				<button class="btn btn-danger btn-xs" type="button" onclick="eliminarProducto('+i+');"><i class="fa fa-close" aria-hidden="true"></i></button></div></td></tr>');
	}

	$("#monto_total").val(parseFloat(monto_total).toFixed(2));

  $("#monto_total_descuento").val(monto_total_descuento);
  calcularCambio();
  if (typeof nvGuardarCarrito === 'function') nvGuardarCarrito();
  if (typeof window.refrescarBotonesVenta === 'function') window.refrescarBotonesVenta();
}
function verProducto(index){
  $("#id_presa").val("");
	// Obtiene los datos para mostrar en la ventana Flotante
	 var vProducto=this.carrito[index];
	 console.log(vProducto);
	 $("#precio_compra").val(vProducto.precio_compra);
	 $("#precio_venta").val(vProducto.precio_venta);
	 $("#precio").val(vProducto.precio);
	 $("#cantidad").val(vProducto.cantidad);
	 $("#nombre").val(vProducto.nombre);
	 $("#monto_descuento").val(vProducto.monto_descuento);
   $("#total").val(vProducto.total);
	 $("#indexCarrito").val(index);
   $("#peso").val(vProducto.peso);
}


 function imprimir_ticket(){
	var pUrl=$("#url_imprimir").val();
	const ticket_base64 = $("#ticket_base64").val();
	const ticket_cocina_base64 = $("#ticket_cocina_base64").val();
	const nota_venta_base64 = $("#nota_venta_base64").val();

	console.log(pUrl);
	if (pUrl != undefined) {
		$.ajax({
			url: pUrl,
			method: "POST",
			data: {
				ticket: ticket_base64,
				ticket_cocina: ticket_cocina_base64,
				nota_venta_rollo: nota_venta_base64
			},
			success: function(data) {
			// La respuesta del servicio se encuentra en la variable `data`
			console.log(data);
			alertify.success('Impreso Correctamente');
			//alertify.alert("Imprimir Ticket","Impreso correctamente", function(){alertify.success('OK');});
			$("#bt_imprimir").hide();
			},
			error: function(error) {
			// Se ha producido un error al consumir el servicio
			console.log(error);
			alertify.error('Error al Imprimir');
			//alertify.alert("Imprimir Ticket","Error al Imprimir", function(){alertify.error('OK');});
			}
		});
		}
}






var listaProducto=[];
var carrito = [];

// ── Persistencia del carrito: si el registro falla, los items NO se pierden ──
var NV_KEY = 'nv_carrito_{{ Auth::user()->id_empresa }}_{{ Auth::user()->id }}';
@if(Session::has('ticket_base64') || Session::has('nota_venta_id'))
    try { localStorage.removeItem(NV_KEY); } catch(e){}
@else
    try {
        var _nvSaved = JSON.parse(localStorage.getItem(NV_KEY) || '[]');
        if (Array.isArray(_nvSaved) && _nvSaved.length) { carrito = _nvSaved; }
    } catch(e){}
@endif
function nvGuardarCarrito(){ try { localStorage.setItem(NV_KEY, JSON.stringify(carrito)); } catch(e){} }
function nvLimpiarCarrito(){ try { localStorage.removeItem(NV_KEY); } catch(e){} carrito = []; if (typeof cargarCarrito === 'function') cargarCarrito(); }

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
    $("#numero_label").text("Nº: "+res.numero);
    $("#numero_pago").val(res.numero);
    });

}

function cargarProducto(index){
	this.listaProducto=JSON.parse($("#listaProductoSeleccionado").val());
	console.log(this.listaProducto);
	var vProducto=this.listaProducto[index];
	vProducto.cantidad=1;
	vProducto.peso=1;
	vProducto.total=vProducto.precio;
	vProducto.precio_venta=vProducto.precio;
	vProducto.precio=vProducto.precio;
	vProducto.monto_descuento=0;

	if(this.carrito.filter(dato=>dato.id==vProducto.id).length>0){
		for (var i = 0; i < this.carrito.length ; i++) {
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

function eliminarProducto(index){
	// Elimina el producto de la lista de carrito
	console.log("eliminar carrito:"+index);
	this.carrito.splice(index, 1);
	cargarCarrito();
}


function guardarProducto(){
	// Editar el array CARRITO actualizando la lista de ventas
	var index=$("#indexCarrito").val();
	this.carrito[index].precio_compra=$("#precio_compra").val();
	this.carrito[index].precio_venta=$("#precio_venta").val();
	this.carrito[index].precio=$("#precio").val();
	this.carrito[index].cantidad=$("#cantidad").val();
	this.carrito[index].peso=$("#peso").val();
	this.carrito[index].nombre=$("#nombre").val();
	this.carrito[index].monto_descuento=$("#monto_descuento").val();
	this.carrito[index].total=parseFloat(parseFloat($("#precio").val())*parseFloat($("#peso").val())).toFixed(2);
	cargarCarrito();
}


function getListaProductos() {

  //Consume los servicios para obtener la lista de productos
  route = "../get_lista_producto/6";

  $.get(route, function (res) {
		this.listaProducto=res;
		$("#listaProducto").val(JSON.stringify(this.listaProducto));
		$("#listaProductoTipo").val(JSON.stringify(this.listaProducto));
		$("#listaProductoSeleccionado").val(JSON.stringify(this.listaProducto));
		var tipo_empresa=$("#tipo_empresa").val();
		var vProductos="<div id='listaProductos'>";
		for (var i = 0; i < res.length ; i++) {
			var iProducto= '';
			iProducto+= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >';
			for (var j = 0; i < res.length && j<4; j++) {
			iProducto+= '<div class="panel panel-default  col-lg-3 col-md-3 col-sm-3 col-xs-6" style="text-align: center; margin: 0px;   " onclick="cargarProducto('+i+')">\n\
								<div class="panel-heading" style="padding-bottom: 0px; padding-top: 5px;"> \n\
									<img src="../'+res[i].imagen1+'"  style="width: 100%;" cache="no-cache" >\n\
									<div    > \n\
										 \n\
										'+res[i].nombre+'\n\
									</div>\n\
								</div>\n\
								<div class="panel-body" style="padding: 0px;"> <label>'+res[i].precio+' bs';

				if(tipo_empresa!="RESTAURANTE"){
					iProducto+=	' - '+res[i].peso;
				}
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

function buscarProducto(){
	//Buscardor de productos en base a al Nombre
	var texto=($("#txtBuscar").val()||"").toUpperCase();
	var tipo_empresa=$("#tipo_empresa").val();
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
		for (var i = 0; i < this.listaProducto.length ; i++) {
			var iProducto= '';
			iProducto+= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >';
			for (var j = 0; i < this.listaProducto.length && j<4; j++) {
			iProducto+= '<div class="panel panel-default  col-lg-3 col-md-3 col-sm-3 col-xs-6" style="text-align: center; margin: 0px;   " onclick="cargarProducto('+i+')">\n\
								<div class="panel-heading" style="padding-bottom: 0px; padding-top: 5px;"> \n\
									<img src="../'+this.listaProducto[i].imagen1+'"  style="width: 100%;" cache="no-cache" >\n\
									<div    > \n\
										 \n\
										'+this.listaProducto[i].nombre+'\n\
									</div>\n\
								</div>\n\
								<div class="panel-body" style="padding: 0px;"> <label>'+this.listaProducto[i].precio+' bs';

				if(tipo_empresa!="RESTAURANTE"){
					iProducto+=	' - '+this.listaProducto[i].peso;
				}
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


function seleccionarPresa(){

	var idPresa=$("#id_presa").val();
	var nombre=$("#nombre").val();
	console.log("Presa:"+idPresa);
	var cantidad=nombre.indexOf(",C");
	if(cantidad>0){
		nombre = nombre.slice(0, cantidad)+" ";

	}

	nombre =nombre+" "+idPresa;
	nombre=nombre.replace("  ", "");
	$("#nombre").val(nombre);


}



  window.onload = function () {
	getListaProductos();
	imprimir_ticket();
	$("#ciNit").val("0");
	buscarNit();
	if (Array.isArray(carrito) && carrito.length) { cargarCarrito(); }
}

function calcularCambio(){
	var efectivoPago= parseFloat($("#efectivoPago").val()).toFixed(2);
	var montoTotal= parseFloat($("#monto_total").val()).toFixed(2);
	$("#efectivoCambio").val(parseFloat(efectivoPago-montoTotal).toFixed(2));
}


function buscarNit(){

	var texto=$("#ciNit").val();

	var listaCliente=[];
	listaCliente=JSON.parse($("#listaCliente").val());
	 listaCliente=listaCliente.filter(dato=>dato.ci_nit==texto && dato.id>0);
	 console.log("Buscar Nit");
	console.log( listaCliente);

		for (var i = 0; i <  listaCliente.length && i<1; i++) {
			 listaCliente[i].cantidad;
			 $("#nombreCliente").val(listaCliente[i].nombre+' '+listaCliente[i].paterno+' '+listaCliente[i].materno);
		}


}
</script>


<script>
	//Auto completado de nombre del cliente
$(document).ready(function() {
	 const listaCliente = JSON.parse($("#listaCliente").val());
    $('#nombreCliente').on('keyup', function() {
		let query = $(this).val().toLowerCase().trim();

        if (query.length < 2) {
            $('#sugerenciasCliente').fadeOut();
            return;
        }

		let coincidencias = listaCliente.filter(cliente => {
            let nombreCompleto = `${cliente.nombre} ${cliente.paterno} ${cliente.materno}`.toLowerCase();
            return nombreCompleto.includes(query);
        }).slice(0, 10);

        let html = '';
        if (coincidencias.length > 0) {
            coincidencias.forEach(cliente => {
                let nombreCompleto = `${cliente.nombre} ${cliente.paterno} ${cliente.materno}`;
                html += `<a href="#" class="list-group-item list-group-item-action" data-nombre="${nombreCompleto}"  ><b>${nombreCompleto}</b></a>`;
            });
        } else {
            html = '<div class="list-group-item disabled">' + @json(__('nota_venta.no_resultados')) + '</div>';
        }

        $('#sugerenciasCliente').html(html).fadeIn();

    });

    $(document).on('click', '#sugerenciasCliente a', function(e) {
        e.preventDefault();
        const nombre = $(this).data('nombre');
        $('#nombreCliente').val(nombre);
        $('#sugerenciasCliente').fadeOut();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#nombreCliente, #sugerenciasCliente').length) {
            $('#sugerenciasCliente').fadeOut();
        }
    });
});
</script>


<style type="text/css">
	.searchable-container{margin:1px 0 0 0}
	.searchable-container label.btn-default.active{background-color:green; color:#FFF}
	.searchable-container label.btn-default{width:100%;border:1px solid #efefef ;margin:1px; box-shadow:1px 1px 1px 0 #ccc;}
	.searchable-container label .bizcontent{width:100%;}
	.searchable-container .btn-group{width:100%}

</style>

<div class="row nv-create">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="nv-top">
        <i class="fa fa-shopping-cart"></i> <b>{{ __('nota_venta.registrar_nota_venta') }}</b>
        @if(!empty($caja_abierta))
            <span class="nv-caja"><i class="fa fa-inbox"></i> {{ __('nota_venta.caja_badge', ['nombre' => $caja_abierta->caja]) }}</span>
        @else
            <span class="nv-caja" style="background:#ffd7d3;color:#a12b21;">{{ __('nota_venta.sin_caja_abierta_corta') }}</span>
        @endif
    </div>

    @if(empty($caja_abierta))
        <div id="nv-nocaja">
            <div class="nv-nocaja__box">
                <div class="nv-nocaja__ico"><i class="fa fa-inbox"></i></div>
                <h3>{{ __('nota_venta.no_hay_caja_abierta') }}</h3>
                <p>{{ __('nota_venta.debes_abrir_caja') }}</p>
                <a href="{!! URL::to('caja') !!}" class="nv-nocaja__btn"><i class="fa fa-unlock-alt"></i> {{ __('nota_venta.abrir_caja') }}</a>
                <button type="button" class="nv-nocaja__x" onclick="document.getElementById('nv-nocaja').remove();" title="{{ __('nota_venta.cerrar_titulo') }}">&times;</button>
            </div>
        </div>
    @endif

    <input type="hidden" id="listaProducto">
    <input type="hidden" id="listaProductoTipo">
    <input type="hidden" id="listaProductoSeleccionado">
    <input type="hidden" id="listaCliente" value="{{ json_encode($cliente) }}">
    <input type="hidden" name="id_empresa" id="id_empresa" value="{{ Auth::user()->id_empresa }}">
    <input type="hidden" name="tipo_empresa" id="tipo_empresa" value="{{ Auth::user()->tipo_empresa }}">

    <div class="nv-grid">

        {{-- ── Productos ── --}}
        <div class="nv-box">
            <div class="nv-box__h"><i class="fa fa-search"></i> {{ __('nota_venta.buscar_productos') }}</div>
            <div class="nv-box__b">
                <div class="nv-search">
                    <select name="id_tipo_producto" id="id_tipo_producto" class="selectpicker" data-live-search="true" onchange="seleccionarTipo();">
                        <option value="">{{ __('nota_venta.todos_mayus') }}</option>
                        @foreach($tipo_producto as $mov)
                            <option value="{{ $mov->id }}">{{ $mov->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="{{ __('nota_venta.buscar_producto_placeholder') }}" id="txtBuscar">
                    <button type="button" class="nv-buscar" onclick="buscarProducto();"><i class="fa fa-search"></i></button>
                </div>
                <div id="listaProductos"></div>
            </div>
        </div>

        {{-- ── Datos de la venta ── --}}
        <div class="nv-box nv-form">
            <div class="nv-box__h"><i class="fa fa-file-text-o"></i> {{ __('nota_venta.datos_de_la_venta') }}</div>
            <div class="nv-box__b">
                <form id="form_nota_venta" action="{{ route('nota_venta.store') }}" method="POST" enctype="multipart/form-data"
                      onkeypress="if(event.keyCode == 13) event.returnValue = false;" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id_caja" value="{{ $id_caja }}">
                    <input type="hidden" name="id_transaccion_qr" id="id_transaccion_qr" value="">
                    <div class="form-group" hidden>
                        <select name="tipo_documento" id="tipo_documento">
                            @foreach ($tipo_documento as $item)<option value="{{ $item->id }}">{{ $item->nombre }}</option>@endforeach
                        </select>
                    </div>

                    <div class="nv-row2">
                        <div class="nv-field">
                            <label>{{ __('nota_venta.nit_ci_cex') }}</label>
                            <input id="ciNit" name="numero_documento" value="" type="number" class="form-control" onchange="buscarNit();">
                        </div>
                        <div class="nv-field" style="position:relative;">
                            <label>{{ __('nota_venta.cliente_razon_social') }}</label>
                            <input id="nombreCliente" name="razon_social" value="" class="form-control" autocomplete="off">
                            <div id="sugerenciasCliente" class="list-group"></div>
                        </div>
                    </div>

                    <div class="nv-row2">
                        <div class="nv-field">
                            <label>{{ __('nota_venta.efectivo_pago') }}</label>
                            <input id="efectivoPago" name="efectivo_pago" value="0" type="number" class="form-control" onchange="calcularCambio();" min="0">
                        </div>
                        <div class="nv-field">
                            <label>{{ __('nota_venta.cambio_bs') }}</label>
                            <input id="efectivoCambio" value="0" type="number" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="nv-field">
                        <label>{{ __('nota_venta.monto_total_bs') }}</label>
                        <input type="text" name="monto_total" value="0" class="form-control" placeholder="0.00" maxlength="10" id="monto_total" onchange="calcularCambio();">
                        <input type="text" value="0" id="monto_total_descuento" name="monto_total_descuento" hidden>
                    </div>

                    <div class="nv-row2">
                        <div class="nv-field">
                            <label>{{ __('nota_venta.modalidad_field') }}</label>
                            <select name="tipo">
                                <option value="LLEVAR" selected>{{ __('nota_venta.llevar') }}</option>
                                <option value="AUTO">{{ __('nota_venta.auto') }}</option>
                                @for($m=1;$m<=30;$m++)<option value="MESA {{ $m }}">{{ __('nota_venta.mesa') }} {{ $m }}</option>@endfor
                            </select>
                        </div>
                        <div class="nv-field">
                            <label>{{ __('nota_venta.estado_field') }}</label>
                            <select name="estado" id="estado_venta" onchange="toggleQrFie();">
                                <option value="Procesado" selected>{{ __('nota_venta.opt_procesado') }}</option>
                                <option value="Qr">Qr</option>
                                @if(!empty($bancofie_habilitado))<option value="QrFie">{{ __('nota_venta.qr_b_fie') }}</option>@endif
                                <option value="Por cobrar">{{ __('nota_venta.opt_por_cobrar') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="nv-cart" style="border:1px solid var(--nv-line);border-radius:8px;overflow:hidden;margin-top:4px;">
                        <table class="table">
                            <thead><tr><th>{{ __('nota_venta.col_descripcion') }}</th><th style="text-align:right;">{{ __('nota_venta.col_pu') }}</th><th style="text-align:center;">{{ __('nota_venta.col_cant') }}</th><th style="text-align:right;">{{ __('nota_venta.col_total_corta') }}</th><th></th></tr></thead>
                            <tbody id="body_carrito"><tr><td colspan="5" class="nv-empty">{{ __('nota_venta.toque_productos') }}</td></tr></tbody>
                        </table>
                    </div>

                    <button type="submit" id="btn_guardar_venta" disabled><i class="fa fa-save"></i> {{ __('nota_venta.guardar_venta') }}</button>
                    @if(!empty($bancofie_habilitado))
                        <button type="button" id="btn_generar_qrfie" style="display:none;" disabled><i class="fa fa-qrcode"></i> {{ __('nota_venta.generar_qr_fie') }}</button>
                    @endif
                </form>

                @if(Session::has('ticket_base64'))
                    <botton id="bt_imprimir" onclick="imprimir_ticket()" class="btn btn-primary form-control" style="margin-top:8px;border-radius:10px;font-weight:700;"><i class="fa fa-print"></i> {{ __('nota_venta.imprimir_ticket_n', ['id' => Session::get('nota_venta_id')]) }}</botton>
                    <input type="hidden" id="url_imprimir" value="http://localhost:80/pdf-imprimir/index.php?servidor1={{Session::get('servidor1')}}&servidor2={{Session::get('servidor2')}}&impresora1={{Session::get('impresora1')}}&impresora2={{Session::get('impresora2')}}&impresora_nota_venta={{Session::get('impresora_nota_venta')}}&impresora_factura={{Session::get('impresora_factura')}}&id_venta={{Session::get('nota_venta_id')}}"/>
                    <input type="hidden" id="ticket_base64" value="{{ Session::get('ticket_base64') }}"/>
                    <input type="hidden" id="ticket_cocina_base64" value="{{ Session::get('ticket_cocina_base64') }}"/>
                    <input type="hidden" id="nota_venta_base64" value="{{ Session::get('nota_venta_base64') }}"/>
                @endif
            </div>
        </div>

    </div>

   <script src="{{ asset('js/nota_venta.js') }}"></script>
</div>
</div>





<!-- Modal ACTUALIZAR PRODUCTO-->
<div id="ModalActualizar" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">

		<div class="modal-header" style="background: #d4463e; color: white">
		  <h3 class="modal-title">{{ __('nota_venta.editar_producto_titulo') }}</h3>
		</div>


		<div class="modal-body">


   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			   <div style="margin: 15px;"  @if(Auth::user()->tipo_empresa=="RESTAURANTE") hidden="" @endif>
					{{ __('nota_venta.codigo_producto_dp') }}<br>
					<input type="text"  id="codigo"  class="form-control" readonly="readonly" />
	  			</div>



				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<input type="hidden" id='indexCarrito'  />

					<div class="form-group">
						<label>{{ __('nota_venta.descripcion_dp') }}</label><br>
						<input type="text"  id="nombre"  class="form-control" />
					  </div>

					<div class="form-group" hidden>
					{{ __('nota_venta.cantidad_dp') }}<br>
					<input type="number"  readonly="readonly" class="form-control" id="cantidad" onchange="calcularTotal()"   required>
					</div>
					<div class="form-group">
					{{ __('nota_venta.precio_compra_dp') }}<br>
					<input type="decimal"  class="form-control" id="precio_compra"  required readonly="readonly" />
					</div>
					<div class="form-group">
						{{ __('nota_venta.descuento_dp') }}<br>
						<input type="decimal"  class="form-control" id="monto_descuento"  required readonly="readonly"/>
					</div>

				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group" @if(Auth::user()->tipo_empresa!="RESTAURANTE")
						hidden=""
					@endif>
					<label>{{ __('nota_venta.presa_dp') }}</label><br>
					<select name="id_presa" id="id_presa" class="form-control"  onchange="seleccionarPresa();" >
						<option value="." selected> {{ __('nota_venta.opt_ninguno') }}</option>
						<option value=",C/PIERNA"> {{ __('nota_venta.opt_pierna') }}</option>
						<option value=",C/PECHO"> {{ __('nota_venta.opt_pecho') }}</option>
						<option value=",C/ALA"> {{ __('nota_venta.opt_ala') }}</option>
						<option value=",C/ENTREPIERNA"> {{ __('nota_venta.opt_entrepierna') }}</option>
					   </select>
					</div>

					<div class="form-group">
					{{ __('nota_venta.precio_venta_dp') }}<br>
					<input type="decimal"   class="form-control" id="precio_venta"   required readonly="readonly">
					</div>

					<div class="form-group">
						{{ __('nota_venta.precio_unitario_dp') }}<br>
						<input type="decimal"  class="form-control" id="precio"  required/>
					</div>
				</div>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group"  >
						{{ __('nota_venta.cantidad_dp') }}<br>
						<input type="decimal"  class="form-control" id="peso" style="border: 3px solid #f39c12;" required/>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group">
						{{ __('nota_venta.total_dp') }}<br>
						<input type="decimal"  class="form-control" id="total"  required/>
					</div>
				</div>
  			 </div>
		</div>


		<div class="modal-footer">
			<button data-dismiss="modal"  class="btn btn-warning form-control" onclick="guardarProducto();">
				<i class="fa fa-save" aria-hidden="true"></i> {{ __('nota_venta.guardar_btn') }}</button>
		</div>
	</div>
</div>




<script>
	$('#txtBuscar').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        buscarProducto();
		var lista=JSON.parse($("#listaProductoSeleccionado").val());
		if(lista.length==1){
			cargarProducto(0);
			$('#txtBuscar').val("");
		}
    }
});
	</script>


<!-- Modal COBRO QR BANCO FIE -->
<div class="modal fade" id="modalQrFie" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background:#c62828;color:#fff;">
				<h4 class="modal-title" style="color:#fff;"><i class="fa fa-qrcode"></i> {!! __('nota_venta.cobro_qr_fie_titulo') !!}</h4>
			</div>
			<div class="modal-body" style="text-align:center;">
				<div id="qrfie_monto" style="font-size:24px;font-weight:700;color:#1b5e20;margin-bottom:10px;"></div>
				<div style="min-height:280px;display:flex;align-items:center;justify-content:center;background:#fafafa;border:1px solid #eee;border-radius:6px;position:relative;">
					<div id="qrfie_cargando" style="text-align:center;color:#c62828;">
						<i class="fa fa-spinner fa-spin fa-3x"></i>
						<div style="margin-top:10px;font-size:14px;font-weight:600;">{{ __('nota_venta.generando_qr') }}</div>
					</div>
					<img id="qrfie_img" src="" alt="Código QR" style="display:none;max-width:100%;width:280px;height:auto;">
				</div>
				<div id="qrfie_link" style="margin-top:8px;"></div>
				<table style="width:100%;margin-top:10px;font-size:12px;color:#555;">
					<tr><td style="text-align:left;font-weight:600;width:40%;">{{ __('nota_venta.alias_dp') }}</td><td id="qrfie_alias" style="text-align:right;word-break:break-all;">—</td></tr>
					<tr><td style="text-align:left;font-weight:600;">{{ __('nota_venta.id_transaccion_dp') }}</td><td id="qrfie_idtx" style="text-align:right;">—</td></tr>
				</table>
				<div id="qrfie_estado" style="margin-top:10px;font-size:13px;color:#777;">{{ __('nota_venta.generando_qr') }}</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_verificar_qrfie" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i> {{ __('nota_venta.ya_pague_verificar') }}</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('nota_venta.cancelar_mayus') }}</button>
			</div>
		</div>
	</div>
</div>

<script>
// ───────── Cobro con QR de Banco FIE (estado = QrFie) ─────────
// - GUARDAR VENTA: habilitado solo si hay productos en el carrito Y el estado
//   NO es QrFie.
// - QrFie: se usa el botón "GENERAR QR B. FIE"; la venta se registra sola
//   (submit del form por JS) recién cuando Banco FIE confirma el pago.
//   NotaVentaController@store re-verifica el pago server-side.
(function () {
	var pollTimer = null, idTx = null, pagoConfirmado = false;

	function esQrFie() { return $('#estado_venta').val() === 'QrFie'; }
	function carritoConItems() {
		if (typeof carrito !== 'undefined' && Array.isArray(carrito)) return carrito.length > 0;
		return $('#body_carrito input[name="idCarrito[]"]').length > 0;
	}

	// Estado de los botones según carrito + método de pago
	window.refrescarBotonesVenta = function () {
		var hayItems = carritoConItems();
		var fie = esQrFie();
		$('#btn_guardar_venta').prop('disabled', fie || !hayItems);
		$('#btn_generar_qrfie').toggle(fie).prop('disabled', !hayItems || pagoConfirmado);
	};
	// El <select> llama onchange="toggleQrFie()"
	window.toggleQrFie = window.refrescarBotonesVenta;

	// El carrito se re-dibuja dentro de #body_carrito -> observamos cambios
	var cont = document.getElementById('body_carrito');
	if (cont && window.MutationObserver) {
		new MutationObserver(window.refrescarBotonesVenta).observe(cont, { childList: true });
	}
	$(window.refrescarBotonesVenta);

	// Guarda de seguridad: nunca enviar una venta QrFie sin pago confirmado
	$('#form_nota_venta').on('submit', function (e) {
		if (esQrFie() && !pagoConfirmado) { e.preventDefault(); }
	});

	$('#btn_generar_qrfie').on('click', generarQrFie);

	// AdminLTE mete el contenido dentro de .content-wrapper y ahí los modales de
	// Bootstrap quedan tapados / fuera de vista. Lo movemos a <body> y forzamos
	// z-index por encima del backdrop.
	$('#modalQrFie').appendTo('body');
	$('#modalQrFie').on('shown.bs.modal', function () {
		$(this).css('z-index', 100050);
		$('.modal-backdrop').last().css('z-index', 100040);
	});

	function abrirModalQrFie() {
		$('#modalQrFie').modal('show');
		// respaldo por si el plugin no pintó: mostrar a mano
		setTimeout(function () {
			var $m = $('#modalQrFie');
			if (!$m.hasClass('in')) {
				$m.addClass('in').css({ display: 'block', 'z-index': 100050 });
				if (!$('.modal-backdrop').length) {
					$('<div class="modal-backdrop fade in"></div>').css('z-index', 100040).appendTo('body');
				}
				$('body').addClass('modal-open');
			}
		}, 250);
	}

	function generarQrFie() {
		var monto = parseFloat($('#monto_total').val() || '0');
		if (!(monto > 0)) { alertify.error('El monto total debe ser mayor a 0.'); return; }
		if (!carritoConItems()) { alertify.error('Agregue productos al carrito.'); return; }

		pagoConfirmado = false;
		idTx = null;
		$('#id_transaccion_qr').val('');
		$('#qrfie_img').removeAttr('src').hide();
		$('#qrfie_cargando').show();
		$('#qrfie_link').empty();
		$('#qrfie_monto').text('');
		$('#qrfie_alias').text('—');
		$('#qrfie_idtx').text('—');
		$('#qrfie_estado').text('Generando QR…');
		abrirModalQrFie();

		$.ajax({
			url: '{{ url("nota_venta/bancofie/generar") }}',
			method: 'POST',
			dataType: 'json',
			data: {
				_token: '{{ csrf_token() }}',
				monto: monto,
				alias: ($('#nombreCliente').val() || 'Venta'),
				glosa: 'Venta'
			},
			success: function (res) {
				if (typeof res === 'string') { try { res = JSON.parse(res); } catch (e) { res = null; } }
				if (!res || String(res.suceso) !== '1') {
					var msg = (res && res.mensaje) || 'No se pudo generar el QR.';
					$('#qrfie_cargando').html('<div style="color:#c62828;"><i class="fa fa-exclamation-triangle"></i><br>' + msg + '</div>');
					$('#qrfie_estado').text(msg);
					return;
				}
				idTx = res.idTransaccion;
				$('#qrfie_monto').text('Bs ' + parseFloat(res.monto).toFixed(2));
				$('#qrfie_alias').text(res.alias || '—');
				$('#qrfie_idtx').text(res.idTransaccion || '—');

				var b64 = String(res.imagenQr || '').replace(/\s+/g, '');
				var uri = b64.indexOf('data:') === 0 ? b64 : ('data:image/png;base64,' + b64);
				if (b64.length < 100) {
					$('#qrfie_cargando').html('<div style="color:#c62828;">El QR se generó pero no llegó la imagen.<br>Use "Ya pagué / Verificar".</div>');
					$('#qrfie_estado').text('El QR se generó pero no llegó la imagen.');
				} else {
					$('#qrfie_img')
						.off('load error')
						.on('load', function () { $('#qrfie_cargando').hide(); $('#qrfie_img').show(); })
						.on('error', function () {
							$('#qrfie_cargando').html('<div style="color:#c62828;">No se pudo mostrar la imagen.<br>Ábrala en pestaña nueva ↓</div>');
							$('#qrfie_estado').text('No se pudo mostrar la imagen del QR.');
						})
						.attr('src', uri);
					$('#qrfie_link').html('<a href="' + uri + '" target="_blank" rel="noopener">Abrir QR en pestaña nueva</a>');
					$('#qrfie_estado').text('Escanee y pague. Esperando confirmación…');
				}
				iniciarPolling();
			},
			error: function (xhr) {
				var msg = 'No se pudo contactar el servicio de QR (' + (xhr && xhr.status ? xhr.status : 'sin conexión') + ').';
				$('#qrfie_cargando').html('<div style="color:#c62828;"><i class="fa fa-exclamation-triangle"></i><br>' + msg + '</div>');
				$('#qrfie_estado').text(msg);
			}
		});
	}

	function verificar(manual) {
		if (!idTx) return;
		$.ajax({
			url: '{{ url("nota_venta/bancofie/estado") }}',
			method: 'POST',
			data: { _token: '{{ csrf_token() }}', idTransaccion: idTx },
			success: function (res) {
				if (res && res.suceso === '1' && res.pagado) {
					detenerPolling();
					pagoConfirmado = true;
					$('#id_transaccion_qr').val(idTx);
					$('#qrfie_estado').text('¡Pago confirmado! Registrando la venta…');
					setTimeout(function () { $('#form_nota_venta')[0].submit(); }, 700);
				} else if (manual) {
					$('#qrfie_estado').text('Aún no se detecta el pago. Intente de nuevo en unos segundos.');
				}
			}
		});
	}

	function iniciarPolling() { detenerPolling(); pollTimer = setInterval(function () { verificar(false); }, 4000); }
	function detenerPolling() { if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

	function cerrarModalQrFie() {
		detenerPolling();
		idTx = null;
		try { $('#modalQrFie').modal('hide'); } catch (e) {}
		$('#modalQrFie').removeClass('in').css('display', 'none');
		$('.modal-backdrop').remove();
		$('body').removeClass('modal-open');
	}

	$('#modalQrFie').on('hidden.bs.modal', function () {
		if (!pagoConfirmado) { detenerPolling(); idTx = null; }
	});
	// Cerrar (botón Cancelar y la X si hubiera)
	$('#modalQrFie').on('click', '[data-dismiss="modal"]', function () { cerrarModalQrFie(); });
	$('#btn_verificar_qrfie').on('click', function () { verificar(true); });
})();
</script>

<style type="text/css">
	#nv-toast{ position:fixed; top:14px; left:50%; transform:translateX(-50%); z-index:99999; width:auto; max-width:94vw; pointer-events:none; }
	#nv-toast .alert{ pointer-events:auto; box-shadow:0 14px 34px -8px rgba(0,0,0,.45); border-radius:12px; border:0; margin:0 0 8px; text-align:center; animation:nvToastIn .25s ease; }
	#nv-toast .alert .btn{ border-radius:8px; }
	@keyframes nvToastIn{ from{ opacity:0; transform:translateY(-14px); } to{ opacity:1; transform:none; } }
</style>
<script type="text/javascript">
// Solo en esta pantalla: los avisos de sesión ("SE REGISTRO CORRECTAMENTE")
// se muestran como toast flotante arriba (no empujan el diseño) y se cierran
// automáticamente a los 10 segundos.
$(function () {
	var $cont = $('#nv-toast');
	if (!$cont.length) { $cont = $('<div id="nv-toast"></div>').appendTo('body'); }
	$('.alert-success').each(function () {
		var $a = $(this);
		$cont.append($a);
		setTimeout(function () { $a.fadeOut(400, function () { $(this).remove(); }); }, 10000);
	});
	// El aviso "sin caja abierta" se ancla a <body> para que quede realmente flotante
	$('#nv-nocaja').appendTo('body');
});
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





