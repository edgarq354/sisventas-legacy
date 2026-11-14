<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Systems Elisoft</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Scripts -->
<script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/numerosmasdecimal.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/alertify.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/jquery-dataTables.js') }}"></script>
<script src="{{ asset('js/jquery-button-print-dataTables.js') }}"></script>
<script src="{{ asset('js/jquery-dataTables.buttons.min.js') }}"></script>

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
<link rel="stylesheet" href="{{ asset('css/_all-skins.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/alertify.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-dataTables.css') }}">


    <script type="text/javascript">
        $(document).ready(function() {


            $('#calendario1').datetimepicker({
                viewMode: 'days',
                format: 'YYYY-MM-DD',
                locale: 'es'
            });
            $('#calendario2').datetimepicker({
                viewMode: 'days',
                format: 'YYYY-MM-DD',
                locale: 'es'
            });
            $('#calendario3').datetimepicker({
                viewMode: 'days',
                format: 'YYYY-MM-DD',
                locale: 'es'
            });



            $('#myTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                select: true,
                "dom": '<"top"flB>rt<"bottom"ip><"clear">',

                buttons: [{
                        extend: 'print',
                        text: 'Imprimir'
                    },

                ],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "initComplete": function () {
                    $(this.api().table().container()).find('.dataTables_filter input')
                        .attr({ autocomplete: 'off', autocorrect: 'off', autocapitalize: 'off', spellcheck: 'false', name: 'dt_s_' + Math.random().toString(36).slice(2) });
                }

            });

        });


        $(document).ready(function() {
            $('#tabla_sin_imprimir').DataTable({
                "order": [
                    [0, "desc"]
                ],
                select: true,
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',

                buttons: [{
                        extend: 'print',
                        text: 'Imprimir'
                    },

                ],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "initComplete": function () {
                    $(this.api().table().container()).find('.dataTables_filter input')
                        .attr({ autocomplete: 'off', autocorrect: 'off', autocapitalize: 'off', spellcheck: 'false', name: 'dt_s_' + Math.random().toString(36).slice(2) });
                }

            });

        });


        $(document).ready(function() {
            $('#tabla_sin_imprimir_medio').DataTable({
                "pageLength" : 5,
                "lengthMenu" : [[5, 10,], [5, 10]],
                "order": [
                    [1, "asc"]
                ],
                select: true,
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',

                buttons: [{
                        extend: 'print',
                        text: 'Imprimir'
                    },

                ],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }

            });

        });

        $(document).ready(function() {
            $('#tabla_sin_imprimir_medio_2').DataTable({
                "pageLength" : 5,
                "lengthMenu" : [[5, 10,], [5, 10]],
                "order": [
                    [2, "desc"]
                ],
                select: true,
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',

                buttons: [{
                        extend: 'print',
                        text: 'Imprimir'
                    },

                ],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }

            });

        });

        function verificarAcceso(){
            if($("#contraseniaEmpresa").val()=="elisoft"){
                $("#nbEmpresa").show();
                $("#contraseniaEmpresa").val()="";
            }else{
                $("#nbEmpresa").hide();
            }
        }



            $(document).ready(verificarAcceso);
    </script>
    <!--FIN DE LOS DATOS DE TABLE Y SUS CONFIGURACIONES-->

    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="apple-touch-icon" href="{{ asset('images/icono.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/icono.png') }}">


</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="verificarAcceso();">

    <?php
    $privilegio = Auth::user()->privilegio;
    $permiso = Auth::user()->permiso;
    $binario = decbin($permiso);

    ?>
    <div class="wrapper" id="body_principal">

        <header class="main-header">

            <!-- Logo -->
            <a href="http://www.facebook.com/" target="_blanck" class="logo" id="cabecera_titulo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">SE</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg" style="color:white;">TIENDA</span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Navegación</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        {{-- Estado de caja del usuario autenticado --}}
                        <li>
                            <a href="{!! URL::to('caja') !!}" style="padding-top:12px;padding-bottom:12px;">
                                @if(!empty($caja_abierta))
                                    <span style="display:inline-flex;align-items:center;gap:6px;background:#2e7d32;color:#fff;font-weight:700;font-size:12px;padding:5px 12px;border-radius:999px;">
                                        <i class="fa fa-circle" style="font-size:8px;"></i> Caja {{ $caja_abierta->caja }} abierta
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:6px;background:#c62828;color:#fff;font-weight:700;font-size:12px;padding:5px 12px;border-radius:999px;">
                                        <i class="fa fa-circle" style="font-size:8px;"></i> Sin caja abierta
                                    </span>
                                @endif
                            </a>
                        </li>

                        <li class="dropdown user user-menu ">
                            <a data-toggle="modal" data-target="#ModalEmpresa" ><i
                                    class="fa fa-tachometer"></i></a>
                        </li>
                        <li class="dropdown user user-menu " id="nbEmpresa"  hidden="">
                            <a href="{!! URL::to('empresa') !!}"   ><i
                                    class="fa fa-users"></i></a>
                        </li>



                        <li class="dropdown user user-menu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Mi Empresa">
                                <!--small class="bg-yellow">Admin:</small-->
                                @if (Auth::user()->privilegio == 0 || Auth::user()->privilegio == 10 || Auth::user()->privilegio == 11)
                                    <?php $empresa = DB::select('SELECT *from empresa,users where empresa.id=users.id_empresa and empresa.id=' . Auth::user()->id_empresa); ?>


                                    <span style="text-transform: uppercase;"><?php echo $empresa[0]->razon_social; ?></span>
                                @else
                                    <span style="text-transform: uppercase;"><b>{{ Auth::user()->nombre }}</b></span>
                                @endif
                            </a>
                            <?php /*<ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>
                      www.desofttechs.com Desarrollando Software
                      <small>Administador</small>
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">

                    <div class="pull-right">

                      <a href="#" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>*/
                            ?>
                        </li>


                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu" style="cursor: pointer;" data-toggle="tooltip"
                            data-placement="bottom" title="Cerrar sesión">
                            <a href="{!!URL::to('logout')!!}" ><i class="fa fa-power-off"></i> SALIR</a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header form-group" style="color:#fff; size: 15px;">
                        <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i><br>
                        <span>{{ Auth::user()->nombre }}</span><br>
                        <span hidden=""><?php echo $permiso . ' bin:' . $binario; ?></span>
                    </li>



                    @if (Auth::user()->privilegio == 0)
                        <li class="treeview">
                            <a href="{!! URL::to('ajuste') !!}">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span>{{ __('menu.inicio') }}</span>
                            </a>
                        </li>



                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <span>{{ __('menu.compras') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">


                                <li>
                                    <a href="{!! URL::to('nota_compra/create') !!}">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i><span>{{ __('menu.nueva_compra') }}</span>
                                    </a>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! URL::to('nota_compra') !!}">
                                        <i class="fa fa-reorder" aria-hidden="true"></i><span>{{ __('menu.lista_de_compras') }}</span>
                                    </a>
                                </li>
                                <li>


                            </ul>
                        </li>


                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-line-chart"></i>
                                <span>{{ __('menu.ventas') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">
                                <li>
                                    <a href="{!! URL::to('nota_venta/create') !!}">
                                        <i class="fa fa-money" aria-hidden="true"></i><span>{{ __('menu.nueva_venta') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! URL::to('nota_venta') !!}">
                                        <i class="fa fa-reorder" aria-hidden="true"></i><span>{{ __('menu.lista_de_ventas') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('nota_venta_rendimiento')!!}">
                                        <i class="fa fa-line-chart" aria-hidden="true"></i><span>{{ __('menu.rendimiento') }}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>



                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-cubes" aria-hidden="true"></i>
                                <span>{{ __('menu.almacen') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">
                                <li>
                                    <a href="{!! URL::to('inventario') !!}">
                                        <i class="fa fa-list" aria-hidden="true"></i><span>{{ __('menu.inventario') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! URL::to('producto') !!}">
                                        <i class="fa fa-cube" aria-hidden="true"></i><span>{{ __('menu.producto') }}</span> </a>
                                    </a>
                                </li>

                                <li>
                                    <a href="{!! URL::to('tipo_producto') !!}">
                                        <i class="fa fa-th-large" aria-hidden="true"></i><span>{{ __('menu.categoria') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

			<li class="treeview">
                            <a href="{!! URL::to('cobranzas') !!}">
                                <i class="fa fa-money" aria-hidden="true"></i><span>{{ __('menu.cobranzas') }}</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                                <span>{{ __('menu.caja') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">

                                <li>
                                    <a href="{!! URL::to('caja') !!}">
                                        <i class="fa fa-cube" aria-hidden="true"></i><span>{{ __('menu.caja') }}</span> </a>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! URL::to('gasto') !!}">
                                        <i class="fa fa-list" aria-hidden="true"></i><span>{{ __('menu.gastos') }}</span>
                                    </a>
                                </li>
                                <li class="treeview">
                                    <a href="{!! URL::to('ingreso') !!}">
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i><span>{{ __('menu.ingreso') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="treeview">
                            <a href="{!! URL::to('cliente') !!}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>{{ __('menu.clientes') }}</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span>{{ __('menu.usuarios') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">

                                <li>
                                    <a href="{!! URL::to('usuarios/empresa') !!}">
                                        <i class="fa fa-user" aria-hidden="true"></i><span>{{ __('menu.rol_de_usuario') }}</span> </a>
                                    </a>
                                </li>
                                <li hidden>
                                    <a href="{!! URL::to('asistencia') !!}">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i><span>{{ __('menu.asistencia') }}</span>
                                    </a>
                                </li>
                                <li>
                            </ul>
                        </li>


                        <?php $id_emp = 'empresa/' . Auth::user()->id_empresa . '/edit'; ?>



                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span>{{ __('menu.ajuste') }}</span>
                            </a>
                            <ul class="treeview-menu menu-open">

                                <li>
                                    <a href="{!! URL::to('empresa/' . Auth::user()->id_empresa . '/edit') !!}">
                                        <i class="fa fa-building" aria-hidden="true"></i><span>{{ __('menu.perfil_de_empresa') }}</span> </a>
                                </li>
                                <li>
                                    <a href="{!! URL::to('sucursal') !!}">
                                        <i class="fa fa-home" aria-hidden="true"></i><span>{{ __('menu.sucursales') }}</span> </a>
                                </li>
                        </li>
                        <li class="treeview">
                            <a href="{!! URL::to('copiadeseguridad') !!}">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <span>{{ __('menu.copia_de_seguridad') }}</span>
                            </a>

                        </li>


                </ul>


                </li>

                @endif

                @if (Auth::user()->privilegio == -1)
                <li class="treeview">
                            <a href="{!! URL::to('empresa') !!}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>{{ __('menu.empresa') }}</span>
                            </a>
                        </li>
                @endif


                @if (Auth::user()->privilegio == 3)
                    <?php
                    $acceso = DB::select(
                        "SELECT acceso.* FROM `permiso`
                    inner join acceso
                    on(acceso.id=permiso.id_acceso)
                    where permiso.id_login=" .
                            Auth::user()->id);
                    ?>



                    @foreach ($acceso as $ac)
                        @if ($ac->modulo == 'INICIO_NORMAL')
                            <li class="treeview">
                                <a href="{!! URL::to('inicio') !!}">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>{{ __('menu.inicio') }}</span>
                                </a>
                            </li>
                        @endif

                        @if ($ac->modulo == 'INICIO_PRINCIPAL')
                            <li class="treeview">
                                <a href="{!! URL::to('ajuste') !!}">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>{{ __('menu.inicio') }}</span>
                                </a>
                            </li>
                        @endif



                        @if ($ac->modulo == 'COMPRAS')
                            <li class="treeview">
                                <a href="">
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    <span>{{ __('menu.compras') }}</span>
                                </a>
                                <ul class="treeview-menu menu-open">


                                    <li>
                                        <a href="{!! URL::to('nota_compra/create') !!}">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i><span>{{ __('menu.nueva_compra') }}</span> </a>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::to('nota_compra') !!}">
                                            <i class="fa fa-reorder" aria-hidden="true"></i><span>{{ __('menu.lista_de_compras') }}</span>
                                        </a>
                                    </li>
                                    <li>


                                </ul>
                            </li>
                        @endif
                        @if ($ac->modulo == 'VENTAS')
                            <li class="treeview">
                                <a href="">
                                    <i class="fa fa-line-chart"></i>
                                    <span>{{ __('menu.ventas') }}</span>
                                </a>
                                <ul class="treeview-menu menu-open">
                                    <li>
                                        <a href="{!! URL::to('nota_venta/create') !!}">
                                            <i class="fa fa-money" aria-hidden="true"></i><span>{{ __('menu.nueva_venta') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::to('nota_venta') !!}">
                                            <i class="fa fa-reorder" aria-hidden="true"></i><span>{{ __('menu.lista_de_ventas') }}</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @if ($ac->modulo == 'PRODUCTOS')
                            <li class="treeview">
                                <a href="">
                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                    <span>{{ __('menu.almacen') }}</span>
                                </a>
                                <ul class="treeview-menu menu-open">

                                    <li>
                                        <a href="{!! URL::to('inventario') !!}">
                                            <i class="fa fa-cube" aria-hidden="true"></i><span>{{ __('menu.inventario') }}</span> </a>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::to('producto') !!}">
                                            <i class="fa fa-list" aria-hidden="true"></i><span>{{ __('menu.productos') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::to('tipo_producto') !!}">
                                            <i class="fa fa-th-large" aria-hidden="true"></i><span>{{ __('menu.categoria') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if ($ac->modulo == 'COBRANZAS')
                        <li class="treeview">
                            <a href="{!! URL::to('cobranzas') !!}">
                                <i class="fa fa-money" aria-hidden="true"></i><span>{{ __('menu.cobranzas') }}</span>
                            </a>
                        </li>
                        @endif
                        @if ($ac->modulo == 'CAJA')
                            <li>
                                    <a href="{!! URL::to('caja') !!}">
                                        <i class="fa fa-cube" aria-hidden="true"></i><span>{{ __('menu.caja') }}</span> </a>
                                    </a>
                                </li>
                        @endif
                        @if ($ac->modulo == 'GASTOS')
                                <li>
                                    <a href="{!! URL::to('gasto') !!}">
                                        <i class="fa fa-list" aria-hidden="true"></i><span>{{ __('menu.gastos') }}</span>
                                    </a>
                                </li>
                        @endif
                        @if ($ac->modulo == 'INGRESO')
                                <li class="treeview">
                                    <a href="{!! URL::to('ingreso') !!}">
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i><span>{{ __('menu.ingreso') }}</span>
                                    </a>
                                </li>
                        @endif
                        @if ($ac->modulo == 'CLIENTES')
                            <li class="treeview">
                                <a href="{!! URL::to('cliente') !!}">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>{{ __('menu.clientes') }}</span>
                                </a>
                            </li>
                        @endif
                         @if ($ac->modulo == 'ASISTENCIA')
                        <li>
                                        <a href="{!! URL::to('asistencia') !!}">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i><span>{{ __('menu.asistencia') }}</span>
                                        </a>
                                    </li>
                          @endif
                        @if ($ac->modulo == 'USUARIOS')
                            <li class="treeview">
                                <a href="">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <span>{{ __('menu.usuarios') }}</span>
                                </a>
                                <ul class="treeview-menu menu-open">

                                    <li>
                                        <a href="{!! URL::to('usuarios/empresa') !!}">
                                            <i class="fa fa-user" aria-hidden="true"></i><span>{{ __('menu.usuario') }}</span> </a>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::to('asistencia') !!}">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i><span>{{ __('menu.asistencia') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                </ul>
                            </li>
                        @endif
                        @if ($ac->modulo == 'AJUSTES')
                            <?php $id_emp = 'empresa/' . Auth::user()->id_empresa . '/edit'; ?>
                            <li class="treeview">
                                <a href="">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    <span>{{ __('menu.ajuste') }}</span>
                                </a>
                                <ul class="treeview-menu menu-open">

                                    <li>
                                        <a href="{!! URL::to('empresa/' . Auth::user()->id_empresa . '/edit') !!}">
                                            <i class="fa fa-building" aria-hidden="true"></i><span>{{ __('menu.perfil_de_empresa') }}</span> </a>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif

                <!--li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li-->

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>





        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-md-12">
                        <div class="box   ">
                            <!--div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div-->
                            <!-- /.box-header -->
                            <div class="box-body  ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--Contenido-->
                                        @yield('contenido')

                                        <!--Fin Contenido-->
                                    </div>

                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->







      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Systems</b>EliSoft
        </div>
        <strong>Copyright &copy; <a href="https://www.facebook.com/edgarelio/" target="_blanck" style="color: #303F9F">Systems EliSoft</a>.</strong> All rights reserved.
      </footer>
  </div>




    <!-- Modal ACTUALIZAR PRODUCTO-->
    <div id="ModalEmpresa" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #3c8dbc; color: white">
                    <h3 class="modal-title">PERMISOS PARA INGRESAR A EMPRESAS</h3>
                </div>


                <div class="modal-body">


                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            Acceso a la lista de empresa:<br>
                            <input type="password" id="contraseniaEmpresa" placeholder="password"
                                class="form-control" value="">
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-success" onclick="verificarAcceso();">OK</button>
                        <button data-dismiss="modal" class="btn btn-danger">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('js/alertify.js') }}"></script>

<!-- AdminLTE App -->



</body>

</html>
