@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('alerts.detalle_cobranza')


<script>
window.onload = function () {
	$("#ciNit").val("0");
    buscarNit();
}
function calcularCambio(){
	var efectivoPago= parseFloat($("#efectivoPago").val()).toFixed(2);
	var montoTotal= parseFloat($("#monto_total").val()).toFixed(2);
	$("#efectivoCambio").val(parseFloat(efectivoPago-montoTotal).toFixed(2));
}
    function buscarNit(){

	var texto=$("#ciNit").val();
console.log(texto);
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

    <div class="row">
        <input type="hidden" id="listaCliente" value="{{json_encode($cliente)}}">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading"> <label> DETALLE PAGOS:    </label>
                    <a class='btn btn-primary' href="{!!URL::to('cobranza_detalle_imprimir_pequenio',[ 'id_cobranza' => $cobranzas[0]->id])!!}" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                <div class="panel-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            CI/NIT: <label>{{$cobranzas[0]->ci_nit}}</label>  <br>
                            Nombre: <label>{{$cobranzas[0]->razon_social}}</label>
                    </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                Monto Total: <label>{{$cobranzas[0]->monto_total}}</label>  <br>
                                Monto Pagado: <label>{{$cobranzas[0]->monto_pagado}}</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                Fecha: <label>{{$cobranzas[0]->fecha_registro}}</label> <br>
                                Tipo: <label>{{$cobranzas[0]->tipo}}</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            @if($cobranzas[0]->id_nota_compra!=null)
                            {{$cobranzas[0]->tipo}}: <label>{{$cobranzas[0]->id_nota_compra}} </label>
                            <a class='btn btn-primary' href="{!!URL::to('nota_compra_imprimir',[ 'id' => $cobranzas[0]->id_nota_compra])!!}" target="_blank">
                                <i class="fa fa-link"></i> </a>
                                @if($cobranzas[0]->monto_pagado>=$cobranzas[0]->monto_total)
                                    <span class="badge  btn-success">Pagado</span>
                                    @else
                                    <span class="badge  btn-warning">Pendiente</span>
                                    @endif
                            @endif
                            @if($cobranzas[0]->id_nota_venta!=null)
                            {{$cobranzas[0]->tipo}}: <label>{{$cobranzas[0]->id_nota_venta}} </label>
                            <a class='btn btn-primary' href="{!!URL::to('nota_venta_imprimir_pequenio',[ 'id' => $cobranzas[0]->id_nota_venta])!!}" target="_blank">
                                <i class="fa fa-link"></i> </a>

                                @if($cobranzas[0]->monto_pagado >= $cobranzas[0]->monto_total)
                                    <span class="badge  btn-success">PAGADO</span>
                                    @else
                                    <span class="badge  btn-warning">PENDIENTE</span>
                                    @endif
                            @endif

                    </div>
                    </div>
                </div>
              </div>




                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="right">

                </div>


                <div class="table-responsive" style="overflow-x:inherit">

                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_sin_imprimir"
                    style="background: white">
                    <thead>
                        <th>
                            <center>ID</center>
                        </th>
                        <th>
                            <center>USUARIO</center>
                        </th>
                        <th>
                            <center>DETALLE</center>
                        </th>
                        <th>
                            <center>MONTO</center>
                        </th>
                        <th>
                            <center>FORMA DE PAGO</center>
                        </th>
                        <th>
                            <center>CLIENTE</center>
                        </th>
                        <th>
                            <center>CAJA</center>
                        </th>
                        <th>
                            <center>FECHA</center>
                        </th>

                        <th>
                            <center>...</center>
                        </th>

                    </thead>

                    <tbody align="center" id="body_conductor">
                        @foreach ($detalle_cobranza as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario }}</td>
                                <td>{{ $item->detalle }}</td>
                                <td>{{ $item->monto }}</td>
                                <td>{{ $item->forma_pago }}</td>
                                <td>{{ $item->razon_social }}</td>
                                <td>#{{ $item->id_caja }}/{{ $item->caja }}</td>
                                <td>{{ $item->fecha_registro }}</td>
                                <td>
                                    <a   target="_blank" href='../../detalle_cobranza_imprimir_pequenio/{{ $item->id }}/{{ $item->id_cobranza }}'
                                        class="btn btn-primary"
                                        title="Ver"><i class='fa fa-print' aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                </div>


        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 " @if($cobranzas[0]->monto_pagado >= $cobranzas[0]->monto_total) hidden="" @endif>
            <form action="{{ route('detalle_cobranza.store') }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.key === 'Enter') event.preventDefault();">
                @csrf
            <input type="hidden" name="id_caja" value="{{$id_caja}}">
            <input type="hidden" name="id_cobranza" value="{{$cobranzas[0]->id}}">

           <div class=" panel panel-primary">
                 <div class="panel-heading">
                    <label>Registrar Detalle Pago:</label><br>
                 </div>

                 <div class="panel-body">

            <div class="form-group col-lg-12 col-md-12 col-sm4 col-xs-12">
                 <input hidden name="estado_cobranza" value="{{$cobranzas[0]->estado}}"/>

                   <div class="form-group">
                    <label for="ciNit">NIT/CI/CEX:</label><br>
                    <input id="ciNit" name="numero_documento" style="border: 3px solid #f39c12;" value="" type="number" class="form-control" onchange="buscarNit();" />

                    <label for="nombreCliente" style="margin-top: 10px; display: block;">Razon Social / Nombre del Cliente :</label><br>
                    <input id="nombreCliente" name="razon_social" value="" class="form-control" />
                   </div>


                <table class="form-group" style="width: 100%;">
                    <tr hidden>
                        <td>
                        <label for="efectivoPago">Efectivo Pago (Bs):</label> <br>
                        <input id="efectivoPago" name="efectivo_pago" value="0" type="number" class="form-control" onchange="calcularCambio();" min="0" step="0.01" />
                        </td>
                        <td style="padding-left: 8px;">
                        <label for="efectivoCambio">Efectivo Cambio (Bs):</label> <br>
                        <input id="efectivoCambio" value="0" type="number" class="form-control" readonly style="font-size: 25px" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="monto_total">Monto (Bs):</label> <br>
                        <input
                            id="monto_total"
                            name="monto"
                            type="number"
                            value="0"
                            class="form-control"
                            placeholder="Monto Total"
                            maxlength="10"
                            style="font-weight:bold;font-size: 25px;"
                            onchange="calcularCambio();"
                            step="0.01"
                            min="0"
                        />
                        </td>
                        <td style="padding-left: 10px;">
                        <label for="estado">Estado :</label> <br>
                        <select name="estado" id="estado" style="width: 100%; padding: 5px;">
                            <option value="Procesado" selected>Procesado</option>
                            <option value="Qr">Qr</option>
                            <option value="POS/Tarjeta">POS/Tarjeta</option>
                        </select>
                        </td>
                    </tr>
                    </table>

                    <div class="form-group">
                    <label for="detalle">Detalle:</label>
                    <textarea
                        id="detalle"
                        name="detalle"
                        class="form-control"
                        placeholder="Ingrese el detalle"
                        style="height:100px;"
                    ></textarea>
                    </div>




            </div>




                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <button type="submit" class="btn btn-success form-control"    >
                        <i class="fa fa-money" aria-hidden="true"></i> GUARDAR PAGO
                    </button>
                 </form>

                </div>
        </div>
        </div>
        </div>

    </div>



@endsection
