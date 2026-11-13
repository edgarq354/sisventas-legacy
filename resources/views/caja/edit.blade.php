@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')

    <script type="text/javascript">
        function cargarNotaVenta(index) {
            var listaNotaVenta = JSON.parse($("#listaNotaVenta").val());
            listaNotaVenta = listaNotaVenta.filter(dato => dato.id == index);
            var total = 0;

            for (var i = 0; i < listaNotaVenta.length; i++) {
                $("#idNotaVenta").text(listaNotaVenta[i].id);
                $("#ciNit").val(listaNotaVenta[i].ci_nit);
                $("#razonSocial").val(listaNotaVenta[i].razon_social);
                $("#montoTotal").val(listaNotaVenta[i].monto_total);
                $("#usuario").val(listaNotaVenta[i].usuario);
                $("#fecha").val(listaNotaVenta[i].fecha);
                total = listaNotaVenta[i].monto_total;
            }

            this.obtenerObtenerNotaVenta(index, total);
        }

        function obtenerObtenerNotaVenta(id, total) {

            $.get("../../get_nota_venta_por_id/" + id, function(res) {
                var listaDetalle = res.detalle_venta;


                $('#body_detalle').empty();
                var tabladatos = $("#body_detalle");
                var monto_total = 0;
                for (var i = 0; i < listaDetalle.length; i++) {
                    tabladatos.append('<tr> <td>\n\
    			 	' + listaDetalle[i].nombre + '</td><td>' + listaDetalle[i].peso + '</td><td>' + listaDetalle[i].sub_total + '</td> \n\
    			</tr>');
                }
                tabladatos.append('<tr style="font-weight:bold;"> <td colspan="2">\n\
    			 	TOTAL: </td><td>' + total + '</td> \n\
    			</tr>');


            });
        }

        function cargarNotaVentaCancelar(index) {
            $("#idNotaVentaCancelar").val(index);
        }


        function cargarNotaCompra(index){
		var listaNotaVenta=JSON.parse($("#listaNotaCompra").val()); 
		listaNotaVenta=listaNotaVenta.filter(dato=>dato.id==index);
		var total=0;
		 
			for (var i = 0; i < listaNotaVenta.length; i++) {  
				$("#idNotaCompra").text(listaNotaVenta[i].id);
				$("#ciNitCompra").val(listaNotaVenta[i].ci_nit);
				$("#proveedorCompra").val(listaNotaVenta[i].proveedor);
				$("#compradorCompra").val(listaNotaVenta[i].comprador);
				$("#montoTotalCompra").val(listaNotaVenta[i].monto_total);
				$("#usuarioCompra").val(listaNotaVenta[i].usuario);  
				$("#fechaCompra").val(listaNotaVenta[i].fecha); 
				total=listaNotaVenta[i].monto_total;
			} 

		this.obtenerObtenerNotaCompra(index,total);		
	}

	function obtenerObtenerNotaCompra(id,total){

	    $.get("../../get_nota_compra_por_id/"+id, function (res) {
	     var listaDetalle=res.detalle_compra;


	     $('#body_detalle_compra').empty(); 
	var tabladatos=$("#body_detalle_compra"); 
	var monto_total=0;
	for (var i = 0; i < listaDetalle.length; i++) {   
		tabladatos.append('<tr> <td>\n\
			 	'+listaDetalle[i].nombre+'</td><td>'+listaDetalle[i].peso+'</td><td>'+listaDetalle[i].sub_total+'</td> \n\
			</tr>'); 
	}
	tabladatos.append('<tr style="font-weight:bold;"> <td colspan="2">\n\
			 	TOTAL: </td><td>'+total+'</td> \n\
			</tr>'); 

	    
	    });
	}


        function cancelarNota() {
            //  var miurl="asignar_usuario_pedido/"+id_pedido_c+"/"+ci+"/"+placa; 
            var token = $('input[name="_token"]').val();
            var miurl = "cancelar_nota_venta";
            var divresul = "notificacion_resultado";
            //información del formulario
            var formData = new FormData();
            formData.append('id', $("#idNotaVentaCancelar").val());
            formData.append('_token', token);

            //hacemos la petición ajax   
            $.ajax({
                url: miurl,
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //mientras enviamos el archivo
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargando_asignacion").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success(":" + data);
                    window.location.href = window.location.href;
                    $("#" + divresul + "").html("Asignacion de Taxi completado");
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error:" + data);

                }
            });

        }
    </script>




    <?php
    $message = Session::get('message');
    ?>


    <input type="hidden" id="listaNotaVenta" value="{{ json_encode($nota_venta) }}">
    <input type="hidden" id="listaNotaCompra" value="{{ json_encode($nota_compra) }}">

    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

            <div class=" panel panel-success">
                <div class="panel-heading">
                    <label>Ventas de Caja:</label><br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="overflow-x:inherit">
                        <table class="table table-striped table-bordered table-condensed table-hover"
                            style="background: white"   align="center">

                            <thead>
                                <th>
                                    <center>Id</center>
                                </th> 
                                <th>
                                    <center>usuario</center>
                                </th>
                                <th>
                                    <center>Cliente</center>
                                </th>
                                <th>
                                    <center>estado</center>
                                </th>
                                <th>
                                    <center>Fecha</center>
                                </th>
                                <th>
                                    <center>Monto Total</center>
                                </th>
                                <th>
                                    <center>. . .</center>
                                </th>
                            </thead>

                            <tbody>
                                <?php 
                                $total_procesado=0;
                                $total_por_cobrar=0; 
                                $total_qr=0;
                                ?>
                                @foreach ($nota_venta as $pago)
                                    <tr>
                                        <td>{{ $pago->id }}</td> 
                                        <td>{{ $pago->usuario }}</td>
                                        <td>{{ $pago->razon_social }} </td>
                                        <td>@if($pago->estado=='Procesado')
                                     <span class="badge  btn-success">{{$pago->estado}}</span>
                                     <?php 
                                     $total_procesado+=$pago->monto_total; 
                                     ?>
                                     @elseif($pago->estado=='Por cobrar')
                                     <span class="badge  btn-warning">{{$pago->estado}}</span> 
                                     <?php 
                                     $total_por_cobrar+=$pago->monto_total; 
                                     ?>
                                     @elseif($pago->estado=='Qr')
                                     <span class="badge  btn-dark">{{$pago->estado}}</span>
                                     <?php 
                                     $total_qr+=$pago->monto_total; 
                                     ?>
                                     @else 
                                     <span class="badge  btn-danger">{{$pago->estado}}</span>
                                     @endif</td>
                                     <td>{{ $pago->fecha }}</td>
                                     <td>{{ $pago->monto_total }} </td>

                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Op. <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a class='fa fa-eye' data-toggle="modal" data-target="#ModalVenta"
                                                            onclick="cargarNotaVenta({{ $pago->id }});"> Ver detalle</a>
                                                    </li>
                                                    <li>
                                                        <a class=' fa fa-print'
                                                            href='../../nota_venta_imprimir/{{ $pago->id }}'
                                                            aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                                            title="Ver y editar"> Imprimir</a>
                                                    </li>
                                                   
                                                    
                                                    


                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td> </td> 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td align="right"><B>TOTAL </B> <span class="badge  btn-success">PROCESADO</span> </td>
                                    <td> <b>{{ $total_procesado }}</b></td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td> 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td align="right"><B>TOTAL </B> <span class="badge  btn-warning">POR COBRAR</span> </td>
                                    <td> <b> {{ $total_por_cobrar }}</b></td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td> 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td align="right"><B>TOTAL </B> <span class="badge  btn-dark">QR</span> </td>
                                    <td> <b>{{ $total_qr }}</b></td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class=" panel panel-info">
                <div class="panel-heading">
                    <label>Detalle de Cobranzas:</label><br>
                </div>
                <div class="panel-body">
            <div class="table-responsive" style="overflow-x:inherit">

                <table class="table table-striped table-bordered table-condensed table-hover"  
                    style="background: white">
                    <thead>
                        <th>
                            <center>ID</center>
                        </th>
                        <th>
                            <center>USUARIO</center>
                        </th>
                        <th>
                            <center>CLIENTE</center>
                        </th>
                        <th>
                            <center>DETALLE</center>
                        </th>
                       
                        <th>
                            <center>FORMA DE PAGO</center>
                        </th> 
                        <th>
                            <center>ESTADO</center>
                        </th> 
                        <th>
                            <center>FECHA</center>
                        </th>
                        <th>
                            <center>MONTO</center>
                        </th>
                        <th>
                            <center>...</center>
                        </th>

                    </thead>

                    <tbody align="center" id="body_conductor">
                        <?php 
                        $total_procesado_por_pagar=0; 
                        $total_procesado_por_cobrar=0; 
                        $total_qr_por_pagar=0;
                        $total_qr_por_cobrar=0;
                        ?>
                        @foreach ($detalle_cobranza as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario }}</td>
                                <td>{{ $item->razon_social }}</td>
                                <td>{{ $item->detalle }}</td> 
                                <td>
                                    @if($item->forma_pago=='Procesado')
                                     <span class="badge  btn-success">{{$item->forma_pago}}</span>
                                     <?php 
                                     if($item->estado_cobranza=="Por pagar"){
                                        $total_procesado_por_pagar+=$item->monto; 
                                     }else if($item->estado_cobranza=="Por cobrar"){
                                        $total_procesado_por_cobrar+=$item->monto; 
                                     } 
                                     ?> 
                                     @elseif($item->forma_pago=='Qr')
                                     <span class="badge  btn-dark">{{$item->forma_pago}}</span>
                                     <?php 
                                     if($item->estado_cobranza=="Por pagar"){
                                        $total_qr_por_pagar+=$item->monto; 
                                     }else if($item->estado_cobranza=="Por cobrar"){
                                        $total_qr_por_cobrar+=$item->monto; 
                                     } 
                                     ?> 
                                     @endif</td> 
                                <td>{{ $item->estado_cobranza }}</td>
                                <td>{{ $item->fecha_registro }}</td>
                                <td>{{ $item->monto }}</td>
                                <td>
                                    <a   target="_blank" href='../../detalle_cobranza_imprimir_pequenio/{{ $item->id }}/{{ $item->id_cobranza }}'
                                        class="btn btn-primary"
                                        title="Ver"><i class='fa fa-print' aria-hidden="true"></i> </a>  
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td> </td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td align="right"><B>TOTAL </B> <span class="badge  btn-success">PROCESADO</span> POR PAGAR </td>
                            <td> <b>{{ $total_procesado_por_pagar }}</b></td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td> </td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td align="right"><B>TOTAL </B> <span class="badge  btn-success">PROCESADO</span> POR COBRAR </td>
                            <td> <b>{{ $total_procesado_por_cobrar }}</b></td>
                            <td> </td>
                        </tr>
                        
                        <tr>
                            <td> </td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td align="right"><B>TOTAL </B> <span class="badge  btn-dark">QR</span> POR PAGAR</td>
                            <td> <b>{{ $total_qr_por_pagar }}</b></td>
                            <td> </td>
                        </tr>

                        <tr>
                            <td> </td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td align="right"><B>TOTAL </B> <span class="badge  btn-dark">QR</span> POR COBRAR </td>
                            <td> <b>{{ $total_qr_por_cobrar }}</b></td>
                            <td> </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


 

            <div class=" panel panel-danger">
                <div class="panel-heading">
                    <label>Compras de Caja:</label><br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="overflow-x:inherit">
                        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white"   align="center">
    
                            <thead>
                                <th>
                                    <center>Id</center>
                                </th> 
                                <th>
                                    <center>Usuario</center>
                                </th>
                                <th>
                                    <cente>Proveedor</center>
                                </th>
                                <th>
                                    <cente>Comprador</center>
                                </th>
                                <th>
                                    <center>Fecha</center>
                                </th>
                                <th>
                                    <center>Monto Total</center>
                                </th>
                                <th>
                                    <center>. . .</center>
                                </th>
                            </thead>
    
                            <tbody>
                                <?php 
                                $total_procesado=0;
                                $total_por_pagar=0; 
                                ?>
                                @foreach($nota_compra as $pago)
    
                                <tr>
                                    <td>{{ $pago->id}}</td> 
                                    <td>{{ $pago->usuario}}</td>
                                    <td>{{ $pago->proveedor}} </td>
                                    <td>{{ $pago->comprador}} </td>
                                    <td>{{ $pago->fecha}}</td>
                                    <td>{{ $pago->monto_total}}<br>
                                    @if($pago->estado=='Procesado')
                                     <span class="badge  btn-success">{{$pago->estado}}</span>
                                     <?php  $total_procesado+=$pago->monto_total;
                                     ?>
                                     @elseif($pago->estado=='Por pagar')
                                     <span class="badge  btn-warning">{{$pago->estado}}</span> 
                                     <?php  $total_por_pagar+=$pago->monto_total;
                                     ?>
                                     @else
                                     <span class="badge  btn-danger">{{$pago->estado}}</span>
                                     @endif </td>
                                    
    
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Op. <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a class='fa fa-eye' data-toggle="modal" data-target="#ModalCompra" onclick="cargarNotaCompra({{$pago->id}});"> Ver detalle</a>
                                                </li>
                                                <li>
                                                    <a class=' fa fa-print' href='../../nota_compra_imprimir/{{$pago->id}}' aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Imprimir"> Imprimir</a>
                                                </li> 
                                            </ul>
                                        </div>
    
                                    </td>
                                </tr>
    
                                @endforeach

                                <tr>
                                    <td> </td> 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td align="right"><B>TOTAL </B> <span class="badge  btn-success">PROCESADO</span> </td>
                                    <td> <b>{{ $total_procesado }}</b></td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td> 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td align="right"><B>TOTAL </B> <span class="badge  btn-warning">POR PAGAR</span> </td>
                                    <td> <b> {{ $total_por_pagar }}</b></td>
                                    <td> </td>
                                </tr>
                                 
                            </tbody>
    
    
                        </table>
                    </div>

                </div>

            </div>





			<div class=" panel panel-warning">
                <div class="panel-heading">
                    <label>Gastos de Caja:</label><br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="overflow-x:inherit">
                        <table class="table table-striped table-bordered table-condensed table-hover"   style="background: white">
                            <thead>
                                <th><center>ID</center></th>
                                <th><center>USUARIO</center></th>
                                <th><center>DETALLE</center></th>
                                <th><center>NOTA</center></th> 
                                <th><center>CAJA</center></th>
                                <th><center>FECHA</center></th>  
                                <th><center>PRECIO</center></th> 
                                
                            </thead>
        
                            <tbody align="center" id="body_conductor">		
                                <?php 
                                $total_gasto=0; 
                                ?>			
                            @foreach($gasto as $usr)
                            <tr>
                                <td>{{ $usr->id}}</td>
                                <td>{{ $usr->usuario}}</td>
                                <td>{{ $usr->detalle}}</td>
                                <td>{{ $usr->nota}}</td> 
                                <td>{{ $usr->caja}}</td>
                                <td>{{ $usr->fecha}}</td>
                                <td>{{ $usr->precio_gasto}}</td> 
                                <?php 
                                $total_gasto+=$usr->precio_gasto; 
                                ?>	
                                 
                            </tr>
                            @endforeach
                            <tr>
                                <td> </td> 
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td align="right"><B>TOTAL :</B>   </td>
                                <td> <b>{{ $total_gasto }}</b></td>
                                
                            </tr>
                            </tbody>
                             
                        </table>
                    </div>

                </div>

            </div>





            <div class=" panel panel-success">
                <div class="panel-heading">
                    <label>Ingreso a Caja:</label><br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="overflow-x:inherit">
                        <table class="table table-striped table-bordered table-condensed table-hover"   style="background: white">
                            <thead>
                                <th><center>Id</center></th>  
                                <th><center>Fecha</center></th>
                                <th><center>Concepto</center></th>
                                <th><center>Descripción</center></th>
                                <th><center>Tipo</center></th>   
                                <th><center>Cliente</center></th>   
                                <th><center>Monto</center></th>   
                                <th><center>Sucursal</center></th>    
                                <th><center>Caja</center></th>    
                                <th><center>Usuario</center></th>  
                            </thead>
        
                            <tbody align="center" id="body_conductor">		
                                <?php 
                                $total_ingreso=0; 
                                ?>			
                            @foreach($ingreso as $item)
                            <tr>
                                <td>{{ $item->id}}</td>  
                                <td>{{ $item->fecha}}</td>   
                                <td>{{ $item->concepto}}  </td>
                                <td>{{ $item->descripcion}}  </td>
                                <td>{{ $item->tipo_gasto}}  </td> 
                                <td>{{ $item->nombre_cliente}}  </td> 
                                <td>{{ $item->monto}}  </td> 
                                <td>{{ $item->sucursal}}  </td> 
                                <td>{{ $item->caja}}  </td>  
                                <td>{{ $item->usuario}}</td> 
                                <?php 
                                $total_ingreso+=$item->monto; 
                                ?>	
                                 
                            </tr>
                            @endforeach
                            <tr>
                                <td> </td> 
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td> 
                                <td> </td>
                                <td> </td>
                                <td align="right"><B>TOTAL :</B>   </td>
                                <td> <b>{{ $total_ingreso }}</b></td>
                                
                            </tr>
                            </tbody>
                             
                        </table>
                    </div>

                </div>

            </div>






			
        </div>






        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 ">


            <div class=" panel panel-success">
                <div class="panel-heading">
                    <label>Datos de Caja:</label>
                    @if ($caja[0]->estado != 'Abierta')
                        <a target="_blank" class='btn btn-primary' href='../../caja_usuario_imprimir/{{ $caja[0]->id }}'><i
                                class="fa fa-print"></i> </a>
                        <a target="_blank" class='btn btn-primary' href='../../caja_usuario_imprimir_boletin/{{ $caja[0]->id }}'><i
                                    class="fa fa-print"></i> Boletin</a>
                        <a target="_blank" class='btn btn-primary' href='../../caja_usuario_imprimir_por_producto_boletin/{{ $caja[0]->id }}'><i
                                class="fa fa-print"></i> Por Producto</a>            
                    @endif
                </div>

                <div class="panel-body">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-striped table-bordered table-condensed table-hover"
                            style="background: white">

                            <tbody align="left">
                                <tr>
                                    <td>Fecha y Hora de Apertura</td>
                                    <td>{{ $caja[0]->fecha_abrir }}</td>
                                </tr>
                                <tr>
                                    <td>Fecha y Hora de Cierre</td>
                                    <td>{{ $caja[0]->fecha_cierre }}</td>
                                </tr>
                                <tr>
                                    <td>Caja</td>
                                    <td>{{ $caja[0]->caja }}</td>
                                </tr>
                                <tr>
                                    <td>Nota al Abrir</td>
                                    <td><em>{{ $caja[0]->nota_abrir }}</em></td>
                                </tr>
                                <tr>
                                    <td>Monto de Apertura Efectivo</td>
                                    <td><b>{{ $caja[0]->monto_abrir }}</b>/{{ $caja[0]->monto_abrir_bk }}</td>
                                </tr>
                                <tr>
                                    <td>Monto de Apertura QR</td>
                                    <td>{{ $caja[0]->monto_abrir_qr }}</td>
                                </tr>
                                <tr>
                                    <td>Monto de Cierre Efectivo</td>
                                    <td><b>{{ $caja[0]->monto_cierre }}</b>/{{ $caja[0]->monto_venta }}</td>
                                </tr>
                                <tr>
                                    <td>Monto de Cierre QR</td>
                                    <td><b>{{ $caja[0]->monto_cierre_qr }}</b>/{{ $caja[0]->monto_venta_qr }}</td>
                                </tr>
                                
                                <tr>
                                    <td>Monto de Cierre Total</td>
                                    <td><b>{{ $caja[0]->monto_cierre_total }}</b>/{{ $caja[0]->monto_venta_total }}</td>
                                </tr>
                                 
                                <tr>
                                    <td>Estado</td>
                                    <td>
                                        @if ($caja[0]->estado == 'Abierta')
                                            <span class="badge  btn-success">{{ $caja[0]->estado }}</span>
                                        @else
                                            <span class="badge  btn-danger">{{ $caja[0]->estado }}</span>
                                        @endif

                                    </td>
                                </tr>

                                <tr>
                                    <td>Nota al Cerrar</td>
                                    <td><em>{{ $caja[0]->nota_cierre }}</em></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                    <h3 class="modal-title">Venta : <label id="idNotaVenta"></label></h3>
                </div>


                <div class="modal-body">


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div style="margin: 15px;">
                            <label>Nombre:</label><br>
                            <input type="text" id="razonSocial" class="form-control" readonly="" />
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <input type="hidden" id='indexCarrito' />


                            <div class="form-group">
                                <label>NIT/CI:</label><br>
                                <input type="decimal" class="form-control" id="ciNit" readonly="" />
                            </div>

                            <div class="form-group">
                                <label>Fecha:</label><br>
                                <input type="decimal" class="form-control" id="fecha" readonly="" />
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <label>Monto Total:</label><br>
                                <input type="decimal" class="form-control" id="montoTotal" readonly="">
                            </div>

                            <div class="form-group">
                                <label>Usuario:</label><br>
                                <input type="text" class="form-control" id="usuario" readonly="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
                        <thead>

                            <th>
                                <center>Producto</center>
                            </th>
                            <th>
                                <center>Cantidad</center>
                            </th>
                            <th>
                                <center>Total</center>
                            </th>
                        </thead>
                        <tbody align="center" id="body_detalle">

                        </tbody>
                    </table>
                </div>


                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning form-control">
                        <i class="fa fa-save" aria-hidden="true"></i> CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CANCELAR NOTA VENTA-->
    <div id="ModalCancelarVenta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #d4463e; color: white">
                    <h3 class="modal-title">Cancelar la Venta </h3>
                </div>


                <div class="modal-body">


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="idNotaVentaCancelar">
                        <center>
                            <h3>Al cancelar la venta, se regresaran al inventario los productos comprados.</h3>
                        </center>

                    </div>
                </div>




                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-warning " onclick="cancelarNota();">
                        <i class="fa fa-save" aria-hidden="true"></i> ACEPTAR</button>
                    <button data-dismiss="modal" class="btn btn-danger ">
                        <i class="fa fa-save" aria-hidden="true"></i> CERRAR</button>
                </div>
            </div>
        </div>
    </div>




    

<!-- Modal NOTA COMPRA-->
<div id="ModalCompra" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
	  <!-- Modal content-->
	  <div class="modal-content">
  
		<div class="modal-header" style="background: #d4463e; color: white">
		  <h3 class="modal-title">COMPRA : <label id="idNotaCompra"></label></h3>
		</div>   
		
  
		<div class="modal-body">
   
   
   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
				<div style="margin: 15px;">
					<label>Proveedor:</label><br>
					<input type="text"  id="proveedorCompra"  class="form-control" readonly="" />
	  			</div>

	  			<div style="margin: 15px;">
					<label>Comprador:</label><br>
					<input type="text"  id="compradorCompra"  class="form-control" readonly="" />
	  			</div>
	 

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 
					<input type="hidden" id='indexCarrito'  /> 
	 
    
					<div class="form-group">
					<label>NIT/CI:</label><br>
					<input type="decimal"  class="form-control" id="ciNitCompra"  readonly="" />
					</div>
	
					<div class="form-group">
						<label>Fecha:</label><br>
						<input type="decimal"  class="form-control" id="fechaCompra" readonly="" />
					</div>
				</div>
	  
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " > 	  
					<div class="form-group">
					<label>Monto Total:</label><br>
					<input type="decimal"   class="form-control" id="montoTotalCompra" readonly=""  >
					</div>

					<div class="form-group">
					<label>Usuario:</label><br>
					<input type="text"   class="form-control" id="usuarioCompra" readonly=""  >
					</div>
				</div>
  			 </div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
			<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
				<thead>
					
					<th><center>Producto</center></th> 
					<th><center>Cantidad</center></th> 
					<th><center>Total</center></th> 
				</thead>
				<tbody align="center" id="body_detalle_compra">					
				
				</tbody>
			</table>
		</div>
  
  
		<div class="modal-footer"> 
			<button data-dismiss="modal"  class="btn btn-warning form-control" >
				<i class="fa fa-close" aria-hidden="true"></i> CERRAR</button>
		</div>
	</div>
</div>
</div>


    <input type="hidden" name="_token" id="_token" value="<?= csrf_token() ?>">
@endsection
