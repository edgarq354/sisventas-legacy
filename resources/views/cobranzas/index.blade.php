@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')



    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
 
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <font size="6">COBRANZAS</font>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="right">
                    <a class='btn btn-primary' href='cobranzas_imprimir' target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                     
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
                            <center>CLIENTE / PROVEEDOR</center>
                        </th> 
                        <th>
                            <center>MONTO TOTAL</center>
                        </th>
                        <th>
                            <center>MONTO PAGADO</center>
                        </th>
                        <th>
                            <center>ESTADO</center>
                        </th>
                        <th>
                            <center>TIPO</center>
                        </th>
                        <th>
                            <center>ID NOTA DE VENTA</center>
                        </th>
                        <th>
                            <center>ID NOTA DE COMPRA</center>
                        </th>
                        <th>
                            <center>FECHA</center>
                        </th>
                        
                        <th>
                            <center>OPCION</center>
                        </th>

                    </thead>

                    <tbody align="center" id="body_conductor">
                        @foreach ($cobranzas as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario }}</td>
                                <td>{{ $item->razon_social }}</td>
                               
                                <td>{{ $item->monto_total }}</td>
                                <td>{{ $item->monto_pagado }}</td>
                                <td>@if($item->monto_pagado>=$item->monto_total)
                                    <span class="badge  btn-success">PAGADO</span>
                                    @else
                                    <span class="badge  btn-warning">PENDIENTE</span>
                                    @endif
                                </td>
                                <td>{{ $item->tipo }}<br>
                                    {{ $item->estado }}</td>
                                <td>{{ $item->id_nota_venta }}</td>
                                <td>{{ $item->id_nota_compra }}</td>
                                <td>{{ $item->fecha_registro }}</td>
                               
                                <td>


                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            Opción <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a  href='detalle_cobranza/{{ $item->id }}/edit'
                                                    aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                                    title="Ver"><i class='fa fa-eye' aria-hidden="true"></i> Ver</a>
                                            </li>
                                          
                                                <li>
                                                    <a  href="{!!URL::to('cobranza_detalle_imprimir_pequenio',[ 'id_cobranza' => $item->id])!!}" target="_blank"
                                                        > <i class='fa fa-print' aria-hidden="true"></i> Imprimir</a>
                                                </li> 
                                                


                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                </div> 


        </div>
    </div>



@endsection 