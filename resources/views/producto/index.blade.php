@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')







    <style>
        /* Always set the map height explicitly to define the size of the div
           * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
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

    <script type="text/javascript">
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>


    <script type="text/javascript">
        var loadFile_actualizar = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_actualizar');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>


    </script>


@include('partials.dashboard_style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style type="text/css">
    #tabla_sin_imprimir{ font-size:12.5px; }
    #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:10.5px; text-transform:uppercase; letter-spacing:.3px;
        background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; white-space:nowrap; }
    #tabla_sin_imprimir tbody td{ padding:6px 10px !important; vertical-align:middle; }
    #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
    #tabla_sin_imprimir .badge{ font-size:10px; padding:3px 8px; border-radius:999px; }
    #tabla_sin_imprimir td.num{ text-align:right; font-weight:700; white-space:nowrap; }
    .pr-actions{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:16px; }
    .pr-actions .pr-btn{ display:inline-flex; align-items:center; justify-content:center; gap:7px; min-width:150px; height:42px;
        padding:0 16px; border-radius:10px; font-weight:700; font-size:12.5px; color:#fff; border:0; text-decoration:none; cursor:pointer;
        box-shadow:0 6px 16px -9px rgba(0,0,0,.5); }
    .pr-actions .pr-btn:hover{ filter:brightness(1.07); color:#fff; }
    .pr-btn--add{ background:linear-gradient(135deg,#2e7d32,#66bb6a); }
    .pr-btn--print{ background:#c62828; }
    .pr-btn--print2{ background:#5c4033; }
</style>

<div class="dash">

    <div class="dash-hero" style="margin-bottom:14px;">
        <div class="dash-hero__icon"><i class="fa fa-cubes"></i></div>
        <div>
            <h3 class="dash-hero__title">{{ __('producto.titulo_productos') }}</h3>
            <p class="dash-hero__sub">{{ __('producto.registrados', ['count' => count($producto)]) }}</p>
        </div>
    </div>

    <div class="pr-actions">
        <a class="pr-btn pr-btn--add" data-toggle="modal" data-target="#ModalCrearNuevo"><i class="fa fa-plus"></i> {{ __('producto.agregar_producto') }}</a>
        <a class="pr-btn pr-btn--print" href="producto_imprimir" target="_blank"><i class="fa fa-print"></i> {{ __('producto.imprimir') }}</a>
        <a class="pr-btn pr-btn--print2" href="producto_utilidad_imprimir" target="_blank"><i class="fa fa-print"></i> {{ __('producto.con_inversion') }}</a>
    </div>

    <div class="dash-card">
        <div class="dash-card__head"><i class="fa fa-list"></i> {{ __('producto.lista_productos') }}</div>
        <div class="dash-card__body dash-card__body--flush">
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-striped table-hover" id="tabla_sin_imprimir" style="background:white;margin:0;">
                    <thead>
                        <th style="width:50px;"><center>{{ __('producto.col_id') }}</center></th>
                        <th>{{ __('producto.col_serie') }}</th>
                        <th>{{ __('producto.col_nombre') }}</th>
                        <th style="text-align:right;">{{ __('producto.col_p_venta') }}</th>
                        @if (Auth::user()->tipo_empresa!="RESTAURANTE")
                        <th style="text-align:right;">{{ __('producto.col_p_venta_2') }}</th>
                        <th style="text-align:right;">{{ __('producto.col_p_mayorista') }}</th>
                        <th style="text-align:right;">{{ __('producto.col_p_compra') }}</th>
                        @endif
                        <th style="text-align:right;">{{ __('producto.col_cantidad') }}</th>
                        <th>{{ __('producto.col_tipo') }}</th>
                        <th style="text-align:center;">...</th>
                    </thead>
                    <tbody id="body_video">
                        @foreach ($producto as $usr)
                            <tr>
                                <td><center>{{ $usr->id }}</center></td>
                                <td>{{ $usr->numero_serie }}</td>
                                <td><b>{{ $usr->nombre }}</b>@if($usr->descripcion)<br><span style="color:#8d7b6f;font-size:11px;">{{ $usr->descripcion }}</span>@endif</td>
                                <td class="num">{{ number_format((float)$usr->precio, 2) }}</td>
                                @if (Auth::user()->tipo_empresa!="RESTAURANTE")
                                <td class="num">{{ number_format((float)$usr->precio_venta_2, 2) }}</td>
                                <td class="num">{{ number_format((float)$usr->precio_mayorista, 2) }}</td>
                                <td class="num">{{ number_format((float)$usr->precio_compra, 2) }}</td>
                                @endif
                                <td class="num">
                                    @if ($usr->peso > $usr->peso_minimo){{ $usr->peso }}
                                    @else<span class="badge btn-danger">{{ $usr->peso }}</span>@endif
                                </td>
                                <td>{{ $usr->nombre_tipo_producto }}</td>
                                <td style="text-align:center;white-space:nowrap;">
                                    <a class='btn btn-warning btn-sm' data-toggle="modal" data-target="#ModalActualizar" onclick="ver_producto({{ $usr->id }});"><i class="fa fa-pencil"></i></a>
                                    @if (Auth::user()->privilegio==0)
                                    <a class='btn btn-danger btn-sm' href='eliminar_producto/{{ $usr->id }}'><i class="fa fa-close"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


    <!-- Modal CREAR NUEVO PRODUCTO -->
    <div id="ModalCrearNuevo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #3c8dbc; color: white">
                    <h3 class="modal-title">{{ __('producto.modal_crear_titulo') }}</h3>
                </div>


                <div class="modal-body">

                    <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div @if (Auth::user()->tipo_empresa=="RESTAURANTE") class="col-lg-6 col-md-8 col-sm-10 col-xs-12 " @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>
                            <input type="hidden" name='id_empresa' value="{{ Auth::user()->id_empresa }}" />
                            <input type="hidden" name='id_lugar' value="{{ $id_empresa }}" />

                            <div class="form-group">
                                {{ __('producto.nombre_label') }}<br>
                                <input type="text" name="nombre" placeholder="{{ __('producto.placeholder_nombre') }}" class="form-control"
                                    id="nombre" value="">
                            </div>


                            <div class="form-group has-feedback">
                                <label for="numero_serie">{{ __('producto.numero_serie_label') }}</label>
                                <input
                                    type="text"
                                    name="numero_serie"
                                    id="numero_serie"
                                    class="form-control"
                                    placeholder="{{ __('producto.placeholder_numero_serie') }}"
                                    value="{{ old('numero_serie', '') }}"
                                    />

                                <i class="fa fa-barcode form-control-feedback"></i>
                            </div>

                            {{ __('producto.buscar_categoria') }}
                            <div class="form-group">
                                <select name="id_tipo_producto" id="id_categoria" class="form-control selectpicker"
                                    data-live-search="true">
                                    <option value=""> {{ __('producto.opt_buscar_categoria') }} </option>
                                    @foreach ($tipo_producto as $mov)
                                        <option value="{{ $mov->id }}"
                                            @if ('' == $mov->id) selected="" @endif>{{ $mov->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>


                            <div class="form-group">
                                {{ __('producto.descripcion_label') }}<br>
                                <textarea
                                    name="descripcion"
                                    class="form-control"
                                    placeholder=" "
                                    style="height:40px"
                                >{{ old('descripcion', '') }}</textarea>

                            </div>


                            <div hidden="">
                                <div>
                                    {{ __('producto.realiza_pedidos') }}
                                    <div class="material-switch pull-right">
                                        <input id="estado_pedido_producto" name="estado_pedido_producto" type="checkbox" />
                                        <label for="estado_pedido_producto" class="label-success"></label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label>{{ __('producto.precio_compra_label') }}</label><br>
                                <input type="decimal"  name="precio_compra" placeholder=" "
                                    class="form-control" id="precio_compra" value="0">
                            </div>


                            <div class="form-group">
                                <label>{{ __('producto.precio_venta_label') }}</label><br>
                                <input type="decimal"  name="precio" placeholder=" " class="form-control"
                                    value="0">
                            </div>
                            <div class="form-group" hidden>
                                {{ __('producto.cantidad_label') }}<br>
                                <input type="number"  name="cantidad" placeholder="Cant."
                                    class="form-control" id="cantidad" value="0">
                            </div>



                        </div>


                        <div @if (Auth::user()->tipo_empresa=="RESTAURANTE")  hidden="" @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>


                            <div class="form-group" >
                                {{ __('producto.modelo_label') }}<br>
                                <input type="text"  name="modelo" placeholder="" class="form-control"
                                    id="modelo" value="">
                            </div>
                            <div class="form-group" >
                                {{ __('producto.marca_label') }}<br>
                                <input type="text"  name="marca" placeholder="" class="form-control"
                                    id="marca" value="">
                            </div>
                            <div class="form-group">
                                <label>{{ __('producto.precio_compra_sus_label') }}</label><br>
                                <input type="decimal"  name="precio_compra_sus" placeholder=" " class="form-control"
                                     value="0">
                            </div>
                            <div class="form-group">
                                <label>{{ __('producto.precio_venta_2_label') }}</label><br>
                                <input type="decimal"  name="precio_venta_2" placeholder=" " class="form-control"
                                      value="0">
                            </div>
                            <div class="form-group">
                                <label>{{ __('producto.precio_mayorista_label') }}</label><br>
                                <input type="decimal"  name="precio_mayorista" placeholder=" " class="form-control"
                                    id="precio_mayorista" value="0">
                            </div>


                        </div>


                            <div @if (Auth::user()->tipo_empresa=="RESTAURANTE") class="col-lg-6 col-md-8 col-sm-10 col-xs-12 " @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>

                            <div class="form-group"  >
                                <img id="output" style="max-width: 150px;" cache="no-cache"/>
                            </div>

                            <div class="form-group"  >
                                <div class="btn-group">
                                    <label class="btn btn-warning">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        {{ __('producto.buscar_imagen') }}<input type="file" name="imagen1_producto" id="imagen1_producto"
                                            onchange="loadFile(event)" accept="image/*" style="display: none;">
                                    </label>
                                </div>
                            </div>
			    <div class="form-group" hidden="" >
                                {{ __('producto.codigo_producto_label') }}<br>
                                <input type="text" min="0" name="codigo_producto" placeholder="" class="form-control"
                                    id="codigo_producto" value="">
                            </div>

                            <div class="form-group" hidden>
                                {{ __('producto.cantidad_minima_label') }}<br>
                                <input type="number"   name="cantidad_minima" placeholder=" "
                                    class="form-control" id="cantidad_minima" value="0">
                            </div>
                            <div class="form-group" >
                                {{ __('producto.cantidad_label') }}<br>
                                <input type="number"  name="peso" placeholder=" "
                                    class="form-control" id="peso" value="0">
                            </div>
                            <div class="form-group">
                                {{ __('producto.cantidad_minima_label') }}<br>
                                <input type="number"   name="peso_minimo" placeholder=" "
                                    class="form-control" id="peso_minimo" value="0">
                            </div>

                            <div class="form-group" hidden>
                                {{ __('producto.fecha_vencimiento_label') }}<br>
                                <input type="date" name="fecha_vencimiento" placeholder=" " class="form-control"
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="form-group" hidden>
                                {{ __('producto.dias_antes_vencerse_label') }}<br>
                                <input type="number"   name="dia_minimo_vencimiento" placeholder=" "
                                    class="form-control" id="dia_minimo_vencimiento" value="10">
                            </div>



                        </div>
                    </div>
                </div>



                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        >
                        {{ __('producto.registrar') }}
                        </button>

                    </form>

                    <button data-dismiss="modal" class="btn btn-danger">{{ __('producto.cancelar') }}</button>
                </div>
            </div>
        </div>
    </div>







    <!-- Modal ACTUALIZAR PRODUCTO-->
    <div id="ModalActualizar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #3c8dbc; color: white">
                    <h3 class="modal-title">{{ __('producto.modal_actualizar_titulo') }}</h3>
                </div>

                <div class="modal-body">

                    <form action="{{ url('actualizar_producto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div @if (Auth::user()->tipo_empresa=="RESTAURANTE") class="col-lg-6 col-md-8 col-sm-10 col-xs-12 " @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>
                            <input type="hidden" name='id_producto' id="id_producto_actualizar" value="" />
                            <input type="hidden" name='id_lugar' value="{{ $id_empresa }}" />

                            <div class="form-group">
                                {{ __('producto.nombre_label') }}<br>
                                <input type="text" name="nombre" placeholder="{{ __('producto.placeholder_nombre') }}"
                                    class="form-control" id="nombre_actualizar" value="">
                            </div>

                            <div class="form-group has-feedback">
                                <label for="numero_serie">{{ __('producto.numero_serie_label') }}</label>
                                <input
                                    type="text"
                                    name="numero_serie"
                                    id="numero_serie_actualizar"
                                    class="form-control"
                                    placeholder="{{ __('producto.placeholder_numero_serie') }}"
                                    value="{{ old('numero_serie', $numero_serie ?? '') }}"
                                    />

                                <i class="fa fa-barcode form-control-feedback"></i>
                            </div>

                            {{ __('producto.buscar_categoria') }}
                            <div class="form-group">
                                <select name="id_tipo_producto" class="form-control" id="id_tipo_producto_actualizar"
                                    data-live-search="true">
                                    <option value=""> {{ __('producto.opt_buscar') }} </option>
                                    @foreach ($tipo_producto as $mov)
                                        <option value="{{ $mov->id }}">{{ $mov->nombre }} </option>
                                    @endforeach
                                </select>

                            </div>


                            <div class="form-group">
                                {{ __('producto.descripcion_label') }}<br>
                                <textarea
                                    name="descripcion"
                                    id="descripcion_actualizar"
                                    class="form-control"
                                    style="height:40px"
                                    placeholder=" ">{{ old('descripcion', '') }}</textarea>
                            </div>


                            <div hidden="">
                                <div>
                                    {{ __('producto.realiza_pedidos') }}
                                    <div class="material-switch pull-right">
                                        <input id="estado_pedido_actualizar" name="estado_pedido" type="checkbox" />
                                        <label for="estado_pedido_actualizar" class="label-success"></label>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group">
                               <label> {{ __('producto.precio_compra_label') }}</label><br>
                                <input type="decimal" name="precio_compra" placeholder=" " class="form-control"
                                    id="precio_compra_actualizar" value="">
                            </div>
                            <div class="form-group">
                                <label>{{ __('producto.precio_venta_label') }}</label><br>
                                <input type="decimal" name="precio" placeholder=" " class="form-control"
                                    id="precio_actualizar" value="">
                            </div>

                            <div class="form-group" hidden>
                                {{ __('producto.cantidad_label') }}<br>
                                <input type="number" name="cantidad" placeholder=" " class="form-control"
                                    id="cantidad_actualizar" value="0">
                            </div>


                        </div>


                        <div   @if (Auth::user()->tipo_empresa=="RESTAURANTE")  hidden="" @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>


                            <div class="form-group" >
                                {{ __('producto.modelo_label') }}<br>
                                <input type="text" name="modelo" placeholder=" " class="form-control"
                                    id="modelo_actualizar" value="">
                            </div>
                            <div class="form-group"  >
                                {{ __('producto.marca_label') }}<br>
                                <input type="text" name="marca" placeholder=" " class="form-control"
                                    id="marca_actualizar" value="">
                            </div>
                            <div class="form-group"  >
                                <label>{{ __('producto.precio_compra_sus_label') }}</label><br>
                                <input type="decimal" name="precio_compra_sus" placeholder=" " class="form-control"
                                    id="precio_compra_sus_actualizar" value="">
                            </div>
                            <div class="form-group"  >
                                <label>{{ __('producto.precio_venta_2_label') }}</label><br>
                                <input type="decimal" name="precio_venta_2" placeholder=" " class="form-control"
                                    id="precio_venta_2_actualizar" value="">
                            </div>
                            <div class="form-group"  >
                                <label>{{ __('producto.precio_mayorista_label') }}</label><br>
                                <input type="decimal" name="precio_mayorista" placeholder=" " class="form-control"
                                    id="precio_mayorista_actualizar" value="">
                            </div>
                        </div>


                        <div @if (Auth::user()->tipo_empresa=="RESTAURANTE") class="col-lg-6 col-md-8 col-sm-10 col-xs-12 " @else class="col-lg-4 col-md-8 col-sm-10 col-xs-12 "  @endif>

                            <div class="form-group" >
                                <img id="output_actualizar" style="max-width: 150px;" cache="no-cache" />
                            </div>

                            <div class="form-group" >
                                <div class="btn-group">
                                    <label class="btn btn-warning">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        {{ __('producto.buscar_imagen') }}<input type="file" name="imagen1_producto"
                                            id="imagen1_producto_actualizar" onchange="loadFile_actualizar(event)"
                                            accept="image/*" style="display: none;">
                                    </label>
                                </div>
                            </div>





                           <div class="form-group" hidden="">
                                {{ __('producto.codigo_producto_label') }}<br>
                                <input type="text" name="codigo_producto" placeholder=" " class="form-control"
                                    id="codigo_producto_actualizar" value="">
                            </div>
                            <div class="form-group" hidden>
                                {{ __('producto.cantidad_minima_label') }}<br>
                                <input type="decimal" name="cantidad_minima" placeholder=" " class="form-control"
                                    id="cantidad_minima_actualizar" value="">
                            </div>
                            <div class="form-group">
                                {{ __('producto.cantidad_label') }}<br>
                                <input type="number"  name="peso" placeholder=" "
                                    class="form-control" id="peso_actualizar" value="0">
                            </div>
                            <div class="form-group">
                                {{ __('producto.cantidad_minima_label') }}<br>
                                <input type="number"  name="peso_minimo" placeholder=" "
                                    class="form-control" id="peso_minimo_actualizar" value="10">
                            </div>


                            <div class="form-group" hidden>
                                {{ __('producto.fecha_vencimiento_label') }}<br>
                                <input type="date" name="fecha_vencimiento" placeholder=" " class="form-control"
                                    id="fecha_vencimiento_actualizar">
                            </div>

                            <div class="form-group" hidden>
                                {{ __('producto.dias_antes_vencerse_label') }}<br>
                                <input type="number"  name="dia_minimo_vencimiento" placeholder=" "
                                    class="form-control" id="dia_minimo_vencimiento_actualizar" value="10">
                            </div>


                        </div>


                    </div>



                    <div class="modal-footer">

                        <button
                            type="submit"
                            class="btn btn-primary"  >
                            {{ __('producto.actualizar') }}
                        </button>

                        </form>

                        <button data-dismiss="modal" class="btn btn-danger">{{ __('producto.cancelar') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#ModalCrearNuevo form").addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                //event.preventDefault(); // Evita que se envíe el formulario
            }
        });
        document.querySelector("#ModalActualizar form").addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Evita que se envíe el formulario
            }
        });
    });
</script>

@endsection

<script src="{{ asset('js/producto_actualizar.js') }}"></script>
