@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')


@if(Session::has('nota_venta_id'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  SE REGISTRO CORRECTAMENTE

  <a class="btn btn-primary form-control" target="_blank"  href="{!!URL::to('nota_venta_imprimir_pequenio',Session::get('nota_venta_id'))!!}" aria-hidden="true" style="text-decoration: none;" >
	<i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR NOTA DE VENTA</a>

</div>
@endif

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
	var cantidad_total=0;
	for (var i = 0; i < this.carrito.length ; i++) {
		//Contar cantidad productos
		cantidad_total+=this.carrito[i].cantidad;

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
	if (!isNaN(monto_total)) {
    	$("#monto_total_label").text(parseFloat(monto_total).toFixed(2));
	} else {
		$("#monto_total_label").text("0.00");  // O algún valor predeterminado
	}
	$("#item_carrito").text(cantidad_total);
  	$("#monto_total_descuento").val(monto_total_descuento);
  calcularCambio();
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
	//const ticket_base64 = $("#ticket_base64").val();
	const id_nota_venta = $("#id_nota_venta").val();
	const nota_venta_base64 = $("#nota_venta_base64").val();

	if(id_nota_venta>0){
		const link = document.createElement('a');
		link.href = 'data:application/pdf;base64,' + nota_venta_base64;
		link.download = id_nota_venta+"_nota_venta.pdf";
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}

}






var listaProducto=[];
var carrito = [];

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
									<img src="../'+res[i].imagen1+'"  style="width:100px; height:100px;" cache="no-cache" >\n\
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
	var texto=$("#txtBuscar").val();
	var tipo_empresa=$("#tipo_empresa").val();
	console.log('buscar producto'+texto);
	this.listaProducto=JSON.parse($("#listaProductoTipo").val());
	this.listaProducto=this.listaProducto.filter(dato=>dato.nombre.toUpperCase().indexOf(texto.toUpperCase())>=0||dato.numero_serie.toUpperCase().indexOf(texto.toUpperCase())>=0);

	$("#listaProductoSeleccionado").val(JSON.stringify(this.listaProducto));

	console.log(this.listaProducto);
	var vProductos="<div id='listaProductos'>";
		for (var i = 0; i < this.listaProducto.length ; i++) {
			var iProducto= '';
			iProducto+= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >';
			for (var j = 0; i < this.listaProducto.length && j<4; j++) {
			iProducto+= '<div class="panel panel-default  col-lg-3 col-md-3 col-sm-3 col-xs-6" style="text-align: center; margin: 0px;   " onclick="cargarProducto('+i+')">\n\
								<div class="panel-heading" style="padding-bottom: 0px; padding-top: 5px;"> \n\
									<img src="../'+this.listaProducto[i].imagen1+'"  style="width:100px; height:100px;"  cache="no-cache" >\n\
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
	this.listaProducto=JSON.parse($("#listaProducto").val());
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
	$("#cabecera_titulo").hide();
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
	 listaCliente=listaCliente.filter(dato=>dato.ci_nit==texto);
	 console.log("Buscar Nit");
	console.log( listaCliente);

		for (var i = 0; i <  listaCliente.length && i<1; i++) {
			 listaCliente[i].cantidad;
			 $("#nombreCliente").val(listaCliente[i].nombre+' '+listaCliente[i].paterno+' '+listaCliente[i].materno);
		}


}




</script>

<style type="text/css">
	.searchable-container{margin:1px 0 0 0}
	.searchable-container label.btn-default.active{background-color:green; color:#FFF}
	.searchable-container label.btn-default{width:100%;border:1px solid #efefef ;margin:1px; box-shadow:1px 1px 1px 0 #ccc;}
	.searchable-container label .bizcontent{width:100%;}
	.searchable-container .btn-group{width:100%}



/* Estilos del botón flotante */
.floating-btn {
    position: fixed; /* Esto lo hace flotante */
    bottom: 0px; /* Distancia desde el fondo */
    right: 0px;  /* Distancia desde el lado derecho */
	width: 100%;
    padding: 10px 20px;
	z-index: 1;
	background: #fff;
}

</style>

<div class="floating-btn">
	<center><button class=" btn btn-success form-control" data-toggle="modal" data-target="#ModalNotaVenta" >
	<label id="item_carrito"> 0</label> ITEM CARRITO = <label id="monto_total_label"> 0</label> <i class="fa fa-chevron-right" style="margin-left: auto;"></i> </button></center>
</div>
<div class="row">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">



			<div class="table-responsive" style="overflow-x:inherit">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label>REGISTRAR NOTA DE VENTA</label>

			</div>



<input type="hidden" id="listaProducto" >
<input type="hidden" id="listaProductoTipo" >
<input type="hidden" id="listaProductoSeleccionado" >
<input type="hidden" id="listaCliente" value="{{json_encode($cliente)}}">
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">
<input type="hidden" name="tipo_empresa" id="tipo_empresa" value="{{Auth::user()->tipo_empresa}}">




    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  " style="padding: 0px;">

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class=" panel panel-danger  ">
				<div class="panel-heading">
						<div class="form-group" style="margin-bottom:0px;" >
							TIPO DE PRODUCTO:
						<select name="id_tipo_producto" id="id_tipo_producto" class=" selectpicker"  data-live-search="true" onchange="seleccionarTipo();" >
							<option value=""> TODOS                              </option>
								@foreach($tipo_producto as $mov)
								<option value="{{$mov->id}}"> {{$mov->nombre}} </option>
								@endforeach
							</select>
						<input type="text" placeholder="Buscar ..." id="txtBuscar"  style=" padding: 4px; color:black;"/>

						<a class='btn btn-warning' onclick="buscarProducto();">
							<i class="fa fa-search"></i>
						Buscar</a>
						</div>
			  	</div>
			</div>


			<div id="listaProductos"></div>

		</div>







</div>




</div>
</div>


</form>
   <script src="{{ asset('js/nota_venta.js') }}"></script>
</div>



<div   id="ModalNotaVenta" class="modal fade" role="dialog">
	<form action="{{ route('nota_venta.store') }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
	<input type="hidden" name="id_caja" value="{{$id_caja}}">
    @csrf
   <div class=" panel panel-danger">
		 <div class="panel-heading">
		 	<i class="fa fa-close btn" data-dismiss="modal" aria-hidden="true"></i>
			<label>Nota de Venta:</label>
		 </div>

		 <div class="panel-body">

			<div class="form-group col-lg-12 col-md-12 col-sm4 col-xs-12">

				<div class="form-group "  hidden>
					<label>TIPO DOCUMENTO:</label> <br>
				<select name="tipo_documento" id='tipo_documento' style="width: 100%; padding: 5px;" >
				@foreach ($tipo_documento as $item)
					<option value="{{$item->id}}">{{$item->nombre}}</option>
					@endforeach
				</select>
				</div>
				<div class="form-group " >
				<label>NIT/CI/CEX:</label> <br>
					<input id="ciNit" name="numero_documento" style="border: 3px solid #f39c12;" value=""  type="number"  class="form-control" onchange="buscarNit();"   />
					<label>Razon Social / Nombre del Cliente :</label> <br>
					<input id="nombreCliente" name="razon_social" value=""   class="form-control" />
			</div>


			<table class="form-group " style="width: 100%;">
				<tr>
					<td>
						<label>Efectivo Pago (Bs):</label> <br>
						<input id="efectivoPago" name="efectivo_pago" value="0"  type="decimal"  class="form-control" onchange="calcularCambio();"   min="0" />
					</td>
					<td style="padding-left: 8px;"><label>Efetivo Cambio (Bs):</label> <br>
						<input id="efectivoCambio" value="0" type="number"  class="form-control" readonly="readonly" style="font-size: 25px"   />
					</td>
				</tr>
				<tr>
					<td >
						<label>Monto Total (Bs):</label> <br>
					<input
							type="text"
							name="monto_total"
							value="0"
							class="form-control"
							placeholder="Monto Total"
							maxlength="10"
							id="monto_total"
							style="font-weight:bold;font-size:25px;"
							onchange="calcularCambio();"
						/>

					<input type="text" value="0" id="monto_total_descuento" name="monto_total_descuento" hidden />
					</td>
					<td style="padding-left: 8px;" >
						<label>Modalidad :</label> <br>
						<select name="tipo" style="width: 100%; padding: 5px;" >
							<option value="LLEVAR" selected="">LLEVAR</option>
							<option value="AUTO"> AUTO</option>
							<option value="MESA 1"> MESA 1</option>
							<option value="MESA 2"> MESA 2</option>
							<option value="MESA 3"> MESA 3</option>
							<option value="MESA 4"> MESA 4</option>
							<option value="MESA 5"> MESA 5</option>
							<option value="MESA 6"> MESA 6</option>
							<option value="MESA 7"> MESA 7</option>
							<option value="MESA 8"> MESA 8</option>
							<option value="MESA 9"> MESA 9</option>
							<option value="MESA 10"> MESA 10</option>
							<option value="MESA 11"> MESA 11</option>
							<option value="MESA 12"> MESA 12</option>
							<option value="MESA 13"> MESA 13</option>
							<option value="MESA 14"> MESA 14</option>
							<option value="MESA 15"> MESA 15</option>
							<option value="MESA 16"> MESA 16</option>
							<option value="MESA 17"> MESA 17</option>
							<option value="MESA 18"> MESA 18</option>
							<option value="MESA 19"> MESA 19</option>
							<option value="MESA 20"> MESA 20</option>
							<option value="MESA 21"> MESA 21</option>
							<option value="MESA 22"> MESA 22</option>
							<option value="MESA 23"> MESA 23</option>
							<option value="MESA 24"> MESA 24</option>
							<option value="MESA 25"> MESA 25</option>
							<option value="MESA 26"> MESA 26</option>
							<option value="MESA 27"> MESA 27</option>
							<option value="MESA 28"> MESA 28</option>
							<option value="MESA 29"> MESA 29</option>
							<option value="MESA 30"> MESA 30</option>

							</select>
					</td>
					<td style="padding-left: 8px;">
						<label>Estado :</label> <br>
						<select name="estado" style="width: 100%; padding: 5px;" >
							<option value="Procesado" selected=""> Procesado</option>
							<option value="Qr"> Qr</option>
							<option value="Por cobrar"> Por cobrar</option>
							</select>
					</td>
				</tr>
			</table>

		</div>


 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			 <label>PRODUCTOS:</label>
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
				<thead>

					<th><center>Descripción</center></th>
					<th><center>Precio Unitario</center></th>
					<th><center>Cantidad</center></th>
					<th><center>Total</center></th>
					<th><center>...</center></th>
				</thead>
				<tbody align="center" id="body_carrito">

				</tbody>
			</table>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<button type="submit" class="btn btn-warning form-control"    >
				<i class="fa fa-save" aria-hidden="true"></i> GUARDAR VENTA
			</button>
		 </form>

		 @if(Session::has('ticket_base64'))
		 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		  	<botton id="bt_imprimir" onclick="imprimir_ticket()" class="btn btn-primary form-control" data-dismiss="alert" aria-label="Close"   > <i class="fa fa-print" aria-hidden="true" ></i> Ticket #{{Session::get('nota_venta_id')}}</botton>
			<input type="hidden" id="url_imprimir" value="http://localhost:80/pdf-imprimir/index.php?servidor1={{Session::get('servidor1')}}&servidor2={{Session::get('servidor2')}}&impresora1={{Session::get('impresora1')}}&impresora2={{Session::get('impresora2')}}&id_venta={{Session::get('nota_venta_id')}}"/>
			<input type="hidden" id="id_nota_venta" value="{{Session::get('nota_venta_id')}}"/>
			<input type="hidden" id="ticket_base64" value="{{Session::get('ticket_base64')}}"/>
			<input type="hidden" id="ticket_cocina_base64" value="{{Session::get('ticket_cocina_base64')}}"/>
			<input type="hidden" id="nota_venta_base64" value="{{Session::get('nota_venta_base64')}}"/>
		 </div>
		 @endif
		</div>
	</div>
</div>


<!-- Modal ACTUALIZAR PRODUCTO-->
<div id="ModalActualizar" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">

		<div class="modal-header" style="background: #d4463e; color: white">
			<i class="fa fa-close btn" data-dismiss="modal" aria-hidden="true"></i>
		  	<label class="modal-title">EDITAR PRODUCTO</label>
		</div>


		<div class="modal-body">


   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			   <div style="margin: 15px;"  @if(Auth::user()->tipo_empresa=="RESTAURANTE") hidden="" @endif>
					Código Producto:<br>
					<input type="text"  id="codigo"  class="form-control" readonly="readonly" />
	  			</div>



				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<input type="hidden" id='indexCarrito'  />

					<div class="form-group">
						<label>Descripción:</label><br>
						<input type="text"  id="nombre"  class="form-control" />
					  </div>

					<div class="form-group" hidden>
					Cantidad:<br>
					<input type="number"  readonly="readonly" class="form-control" id="cantidad" onchange="calcularTotal()"   required>
					</div>
					<div class="form-group">
					Precio de compra:<br>
					<input type="decimal"  class="form-control" id="precio_compra"  required readonly="readonly" />
					</div>
					<div class="form-group">
						Descuento:<br>
						<input type="decimal"  class="form-control" id="monto_descuento"  required readonly="readonly"/>
					</div>

				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group" @if(Auth::user()->tipo_empresa!="RESTAURANTE")
						hidden=""
					@endif>
					<label>Presa:</label><br>
					<select name="id_presa" id="id_presa" class="form-control"  onchange="seleccionarPresa();" >
						<option value="." selected> NINGUNO</option>
						<option value=",C/PIERNA"> PIERNA</option>
						<option value=",C/PECHO"> PECHO</option>
						<option value=",C/ALA"> ALA</option>
						<option value=",C/ENTREPIERNA"> ENTREPIERNA</option>
					   </select>
					</div>

					<div class="form-group">
					Precio de venta:<br>
					<input type="decimal"   class="form-control" id="precio_venta"   required readonly="readonly">
					</div>

					<div class="form-group">
						Precio unitario:<br>
						<input type="decimal"  class="form-control" id="precio"  required/>
					</div>
				</div>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group"  >
						Cantidad:<br>
						<input type="decimal"  class="form-control" id="peso" style="border: 3px solid #f39c12;" required/>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
					<div class="form-group">
						Total:<br>
						<input type="decimal"  class="form-control" id="total"  required/>
					</div>
				</div>
  			 </div>
		</div>


		<div class="modal-footer">
			<button data-dismiss="modal"  class="btn btn-warning form-control" onclick="guardarProducto();">
				<i class="fa fa-save" aria-hidden="true"></i> GUARDAR</button>
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





