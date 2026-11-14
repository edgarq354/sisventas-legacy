@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')


    <script type="text/javascript">
        function ver_sucursal(id_sucursal) {
            $.get('get_sucursal_por_id/' + id_sucursal, function(response) {
                if (response[0] == 0) {

                } else {
                    $("#id_sucursal_actualizar").val(response[0].id);
                    $("#codigo_actualizar").val(response[0].codigo);
                    $("#nombre_actualizar").val(response[0].nombre);
                    $("#municipio_actualizar").val(response[0].municipio);
                    $("#direccion_actualizar").val(response[0].direccion);
                    $("#telefono_actualizar").val(response[0].telefono);
                    $("#cuis_actualizar").val(response[0].cuis);
                    $("#codigo_punto_venta_actualizar").val(response[0].codigo_punto_venta);
                }
            });
        }
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


    <div class="row">




        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">



            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <font size="6">{{ __('sucursal.titulo_sucursales') }}</font>
            </div>


            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <a class='btn btn-primary form-control' href='sucursal_imprimir'><i class="fa fa-print"></i> {{ __('sucursal.imprimir') }}</a>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="pull-right">
                    <a class='btn btn-success' data-toggle="modal" data-target="#ModalCrearNuevo"> <i
                            class="fa fa-plus"></i> {{ __('sucursal.agregar') }}</a>
                </div>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <hr style="height: 2px; background-color: black;">

                <table class="table table-striped table-bordered table-condensed table-hover" style="background: white"
                    id="tabla_sin_imprimir">
                    <thead>
                        <th>
                            <center>{{ __('sucursal.col_codigo') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_nombre') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_municipio') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_direccion') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_telefono') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_cuis') }}</center>
                        </th>
                        <th>
                            <center>{{ __('sucursal.col_cp_venta') }}</center>
                        </th>
                        <th>
                            <center>...</center>
                        </th>

                    </thead>

                    <tbody align="center" id="body_video">
                        @foreach ($sucursal as $usr)
                            <tr>
                                <td>{{ $usr->codigo }}</td>
                                <td>{{ $usr->nombre }}</td>
                                <td>{{ $usr->municipio }}</td>
                                <td>{{ $usr->direccion }}</td>
                                <td>{{ $usr->telefono }}</td>
                                <td>{{ $usr->cuis }}</td>
                                <td>{{ $usr->codigo_punto_venta }}</td>
                                <td>
                                    <a class='btn btn-warning' data-toggle="modal" data-target="#ModalActualizar"
                                        onclick="ver_sucursal({{ $usr->id }});"> <i class="fa fa-edit"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>







    <!-- Modal CREAR NUEVO PRODUCTO -->
    <div id="ModalCrearNuevo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #3c8dbc; color: white">
                    <h3 class="modal-title">{{ __('sucursal.registrar_nuevo_sucursal') }}</h3>
                </div>


                <div class="modal-body">

                    <form action="{{ route('sucursal.store') }}" method="POST" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
                    @csrf
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-7 col-md-8 col-sm-10 col-xs-12">

                            <div class="form-group">
                                {{ __('sucursal.codigo_dp') }}<br>
                                <input type="text" name="codigo" placeholder="{{ __('sucursal.placeholder_codigo') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                {{ __('sucursal.nombre_dp') }}<br>
                                <input type="text" name="nombre" placeholder="{{ __('sucursal.placeholder_nombre') }}" class="form-control">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.municipio_dp') }}<br>
                                <input type="text" name="municipio" placeholder="{{ __('sucursal.placeholder_municipio') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.direccion_dp') }}<br>
                                <input type="text" name="direccion" placeholder="{{ __('sucursal.placeholder_direccion') }}"
                                    class="form-control">
                            </div>

                        </div>




                        <div class="col-lg-5 col-md-8 col-sm-10 col-xs-12 ">

                            <div class="form-group">
                                {{ __('sucursal.telefono_dp') }}<br>
                                <input type="number" name="telefono" placeholder="{{ __('sucursal.placeholder_telefono') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.cuis_dp') }}<br>
                                <input type="text" name="cuis" placeholder="{{ __('sucursal.placeholder_cuis') }}" class="form-control">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.codigo_punto_venta_dp') }}<br>
                                <input type="number" name="codigo_punto_venta" placeholder="{{ __('sucursal.placeholder_codigo_punto_venta') }}"
                                    class="form-control">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary" onclick="btn_esconder()">{{ __('sucursal.registrar') }}</button>

                    </form>

                    <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
                    <button data-dismiss="modal" class="btn btn-danger">{{ __('sucursal.cancelar') }}</button>
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
                    <h3 class="modal-title">{{ __('sucursal.actualizar_sucursal_titulo') }}</h3>
                </div>


                <div class="modal-body">


                   <form action="{{ url('actualizar_sucursal') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="col-lg-7 col-md-8 col-sm-10 col-xs-12 ">
                            <input type="hidden" name='id_sucursal' id="id_sucursal_actualizar" value="" />

                            <div class="form-group">
                                {{ __('sucursal.codigo_dp') }}<br>
                                <input type="text" name="codigo" placeholder="{{ __('sucursal.placeholder_codigo') }}" class="form-control"
                                    id="codigo_actualizar">
                            </div>
                            <div class="form-group">
                                {{ __('sucursal.nombre_dp') }}<br>
                                <input type="text" name="nombre" placeholder="{{ __('sucursal.placeholder_nombre') }}"
                                    class="form-control" id="nombre_actualizar">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.municipio_dp') }}<br>
                                <input type="text" name="municipio" placeholder="{{ __('sucursal.placeholder_municipio') }}"
                                    class="form-control" id="municipio_actualizar">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.direccion_dp') }}<br>
                                <input type="text" name="direccion" placeholder="{{ __('sucursal.placeholder_direccion') }}"
                                    class="form-control" id="direccion_actualizar">
                            </div>
                        </div>



                        <div class="col-lg-5 col-md-8 col-sm-10 col-xs-12 ">

                            <div class="form-group">
                                {{ __('sucursal.telefono_dp') }}<br>
                                <input type="number" name="telefono" placeholder="{{ __('sucursal.placeholder_telefono') }}"
                                    class="form-control" id="telefono_actualizar">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.cuis_dp') }}<br>
                                <input type="text" name="cuis" placeholder="{{ __('sucursal.placeholder_cuis') }}" class="form-control"
                                    id="cuis_actualizar">
                            </div>

                            <div class="form-group">
                                {{ __('sucursal.codigo_punto_venta_dp') }}<br>
                                <input type="number" name="codigo_punto_venta" placeholder="{{ __('sucursal.placeholder_codigo_punto_venta') }}"
                                    class="form-control" id="codigo_punto_venta_actualizar">
                            </div>

                        </div>


                    </div>



                    <div class="modal-footer">

                         <button
                            type="submit"
                            id="btn_registrar"
                            class="btn btn-primary"
                            onclick="btn_esconder(this)">
                            {{ __('sucursal.actualizar') }}
                        </button>
                        </form>

                        <button data-dismiss="modal" class="btn btn-danger">{{ __('sucursal.cancelar') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
