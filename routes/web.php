<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaVentaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AjusteController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CopiaDeSeguridadController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CobranzasController;
use App\Http\Controllers\DetalleCobranzaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\GastoSueldoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Tipo_ingreso_egresoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Tipo_productoController;
use App\Http\Controllers\Tipo_gastoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\Nota_compraController;
use App\Http\Controllers\Producto_tipoController;
use App\Http\Controllers\CuisController;


//Route::get('/', function () { return view('log.index'); });
Route::get('/', [LoginController::class, 'index'])->name('inicio_todo');

Auth::routes();

// Redireccionar siempre /login a / (y darle el nombre 'login' que espera el
// middleware 'auth' al redirigir invitados: si no, lanza "Route [login] not defined").
Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::get('/home', [App\Http\Controllers\AjusteController::class, 'index'])->middleware('auth')->name('home');
//Route::get('/ajuste', [AjusteController::class, 'index'])->middleware('auth');


// ==================== RUTAS DE AUTENTICACIÓN ====================
Route::controller(LoginController::class)->group(function() {
    Route::post('login', 'store')->name('login.store');
    Route::get('logout', 'logout')->name('logout');
});



Route::get('salir', [AdminsController::class, 'opcion_salir'])->name('salir');

// COPIA DE SEGURIDAD
Route::resource('copiadeseguridad', CopiaDeSeguridadController::class);

// ADMINISTRADORES
Route::resource('administrador', AdminsController::class);
Route::post('actualizar_administrador', [AdminsController::class, 'actualizar_administrador']);
Route::get('ubicacion_empresa', [EmpresaController::class, 'ubicacion_empresa']);
Route::post('Actualizar_Empresa_Cliente', [EmpresaController::class, 'Actualizar_Empresa_Cliente']);

// Datos de empresas para página web
Route::get('get_datos_de_empresa_pagina/{id_empresa}', [EmpresaController::class, 'get_datos_de_empresa_pagina']);

// ADMINISTRATIVOS
Route::get('administrativos', [AdminsController::class, 'index_3']);
Route::get('administrativos/create', [AdminsController::class, 'create_3']);
Route::post('actualizar_administrativo', [AdminsController::class, 'actualizar_administrativo']);

// USUARIOS
Route::prefix('usuarios')->group(function () {
    Route::get('/', [AdminsController::class, 'index_2']);
    Route::get('usuario_imprimir', [AdminsController::class, 'usuario_imprimir']);
    Route::get('empresa', [AdminsController::class, 'index_empresa']);
    Route::get('crear_usuario', [AdminsController::class, 'create_usuario']);
    Route::get('create', [AdminsController::class, 'create_2']);
    Route::get('usuario_actualizar/{id_admins}', [AdminsController::class, 'edit_2']);
    Route::get('actualizar_usuarios_empresa/{id_admins}', [AdminsController::class, 'edit_usuario_empresa']);
    Route::post('usuario_update', [AdminsController::class, 'usuario_update']);
    Route::post('usuario_crear', [AdminsController::class, 'store_2']);

    Route::get('cargar_admins_usuarios/{id_admins}', [AdminsController::class, 'cargar_admins_usuarios']);
});
 Route::post('usuario_update_empresa', [AdminsController::class, 'usuario_update_empresa']);

Route::get('cargar_admins_usuarios/{id_admins}', [AdminsController::class, 'cargar_admins']);
Route::get('cargar_historial_inicio_sesion/{id_admins}', [AdminsController::class, 'cargar_historial_inicio_sesion']);

// EMPRESA
Route::resource('empresa', EmpresaController::class);
Route::post('empresa/{id}/subir_logo_empresa', [EmpresaController::class, 'subir_logo_empresa']);
Route::get('empresa_asociacion/{id_empresa}', [EmpresaController::class, 'empresa_asociacion']);
Route::get('cargar_empresa/{id}', [EmpresaController::class, 'cargar_empresa']);
Route::get('empresas/create_', [EmpresaController::class, 'create_2']);
Route::get('verificar_ci_representante/{ci}', [EmpresaController::class, 'verificar_ci_representante']);
Route::get('verificar_ci_representante_legal/{ci}', [EmpresaController::class, 'verificar_ci_representante_legal']);
Route::post('Cambiar_Password', [EmpresaController::class, 'Cambiar_Password']);
Route::post('Cambiar_Password_empresa', [EmpresaController::class, 'Cambiar_Password_empresa']);
Route::post('Cambiar_Administrador', [EmpresaController::class, 'Cambiar_Administrador']);
Route::post('crear_empresa', [EmpresaController::class, 'store_2']);
Route::get('verificar_nit/{nit}', [EmpresaController::class, 'verificar_nit']);
Route::get('Telefono_Empresa/{id}', [EmpresaController::class, 'Telefono_Empresa']);

// Subida de imágenes para empresa
Route::prefix('empresa/{id}')->group(function () {
    Route::post('subir_imagen_constitucion', [EmpresaController::class, 'subir_imagen_constitucion']);
    Route::post('subir_imagen_representante', [EmpresaController::class, 'subir_imagen_representante']);
    Route::post('subir_imagen_fundaempresa', [EmpresaController::class, 'subir_imagen_fundaempresa']);
    Route::post('subir_imagen_ci_representante', [EmpresaController::class, 'subir_imagen_ci_representante']);
    Route::post('subir_imagen_licencia_gmlp', [EmpresaController::class, 'subir_imagen_licencia_gmlp']);
    Route::post('subir_imagen_nit', [EmpresaController::class, 'subir_imagen_nit']);
    Route::post('subir_imagen_att', [EmpresaController::class, 'subir_imagen_att']);
    Route::post('subir_imagen_factura_luz', [EmpresaController::class, 'subir_imagen_factura_luz']);
    Route::post('subir_imagen_senapi', [EmpresaController::class, 'subir_imagen_senapi']);
    Route::post('subir_imagen_corporativa', [EmpresaController::class, 'subir_imagen_corporativa']);
});

Route::get('usuarios_empresa/{id}', [EmpresaController::class, 'usuarios_empresa_por_id']);

// INICIO
Route::resource('inicio', InicioController::class);

// AJUSTE
Route::resource('ajuste', AjusteController::class);

// ASISTENCIA
Route::resource('asistencia', AsistenciaController::class);
Route::get('asistencia/registro/{tipo}', [AsistenciaController::class, 'registro']);
Route::post('asistencia/finalizar', [AsistenciaController::class, 'finalizar']);
Route::get('reporte_asistencia_pdf/{id_asistencia}', [AsistenciaController::class, 'reporte_asistencia_pdf']);
Route::get('asistencia_historial/{fecha_inicio}/{fecha_final}/{id_empleado}', [AsistenciaController::class, 'asistencia_historial']);
Route::get('asistencia_historial_imprimir/{fecha_inicio}/{fecha_final}/{id_empleado}', [AsistenciaController::class, 'asistencia_historial_imprimir']);

// INGRESOS
Route::resource('ingreso', IngresoController::class);
Route::get('get_ingreso_semana', [IngresoController::class, 'get_ingreso_semana']);
Route::get('ingreso_historial/{fecha_inicio}/{fecha_fin}', [IngresoController::class, 'historial']);
Route::get('ingreso_historial_imprimir/{fecha_inicio}/{fecha_fin}', [IngresoController::class, 'historial_imprimir']);
Route::get('ingreso_imprimir/{id}', [IngresoController::class, 'imprimir']);
Route::get('ingreso_cancelar/{id_gasto}', [IngresoController::class, 'cancelar']);

// EGRESOS
Route::resource('egreso', EgresoController::class);
Route::get('egreso/comprobante_egreso_pdf/{id_egreso}', [EgresoController::class, 'comprobante_egreso_pdf']);
Route::get('pdf_egreso/{id_empresa}/{id_usuario}/{id_cliente}/{fecha_inicio}/{fecha_fin}', [EgresoController::class, 'pdf_egreso']);
Route::get('get_egreso_semana', [EgresoController::class, 'get_egreso_semana']);
Route::get('recibo_sueldo', [EgresoController::class, 'recibo_sueldo']);

// CAJA
Route::resource('caja', CajaController::class);
Route::get('caja_imprimir', [CajaController::class, 'caja_imprimir']);
Route::get('caja_usuario_imprimir/{id_caja}', [CajaController::class, 'caja_usuario_imprimir']);
Route::get('caja_usuario_imprimir_boletin/{id_caja}', [CajaController::class, 'caja_usuario_imprimir_boletin']);
Route::get('caja_usuario_imprimir_por_producto_boletin/{id_caja}', [CajaController::class, 'caja_usuario_imprimir_por_producto_boletin']);

// COBRANZAS
Route::resource('cobranzas', CobranzasController::class);
Route::get('cobranzas_imprimir', [CobranzasController::class, 'cobranzas_imprimir']);
Route::get('cobranza_detalle_imprimir_pequenio/{id_cobranza}', [CobranzasController::class, 'cobranza_detalle_imprimir_pequenio']);

// DETALLE COBRANZA
Route::resource('detalle_cobranza', DetalleCobranzaController::class);
Route::get('detalle_cobranza_imprimir_pequenio/{id_detalle_cobranza}/{id_cobranza}', [DetalleCobranzaController::class, 'detalle_cobranza_imprimir_pequenio']);

// GASTOS
Route::resource('gasto', GastoController::class);
Route::get('gasto_imprimir/{id_gasto}', [GastoController::class, 'gasto_imprimir']);
Route::get('gasto_historial/{fecha_inicio}/{fecha_final}/{id_tipo_gasto}/{id_empleado}', [GastoController::class, 'gasto_historial']);
Route::get('gasto_historial_imprimir/{fecha_inicio}/{fecha_final}/{id_tipo_gasto}/{id_empleado}', [GastoController::class, 'gasto_historial_imprimir']);
Route::get('gasto_cancelar/{id_gasto}', [GastoController::class, 'cancelar']);

// GASTOS SUELDO
Route::resource('gasto_sueldo', GastoSueldoController::class);
Route::get('get_lista_gastos_para_sueldo/{fecha_inicio}/{fecha_final}/{id_tipo_gasto}/{id_empleado}', [GastoSueldoController::class, 'get_lista_gastos_para_sueldo']);

// CLIENTES
Route::resource('cliente', ClienteController::class);
Route::get('cliente_imprimir', [ClienteController::class, 'cliente_imprimir']);
Route::get('get_cliente_por_id/{id_cliente}', [ClienteController::class, 'get_cliente_por_id']);
Route::get('cliente_id/{id}', [ClienteController::class, 'edit']);
Route::get('verificar_id_cliente/{ci}', [ClienteController::class, 'verificar_id_cliente']);
Route::post('dar_de_baja_personal', [ClienteController::class, 'personal_baja']);
Route::post('dar_de_alta_personal', [ClienteController::class, 'personal_alta']);
Route::get('historial_baja_alta_personal/{id_personal}', [ClienteController::class, 'historial_baja_alta']);

// TIPO INGRESO/EGRESO
Route::resource('tipo_ingreso_egreso', Tipo_ingreso_egresoController::class);

// TIPO PRODUCTO
Route::resource('tipo_producto', Tipo_productoController::class);
Route::get('cargar_tipo_producto/{id_tipo_producto}', [Tipo_productoController::class, 'cargar_tipo_producto']);
Route::post('subir_imagen_tipo', [Tipo_productoController::class, 'subir_imagen_tipo']);
Route::get('categoria_imprimir', [Tipo_productoController::class, 'categoria_imprimir']);

// TIPO GASTO
Route::post('tipo_gasto_rapido', [Tipo_gastoController::class, 'store_rapido']);
Route::resource('tipo_gasto', Tipo_gastoController::class);
Route::get('cargar_tipo_gasto/{id_tipo_producto}', [Tipo_gastoController::class, 'cargar_tipo_gasto']);
Route::get('tipo_gasto_imprimir', [Tipo_gastoController::class, 'tipo_gasto_imprimir']);

// PRODUCTOS
Route::resource('producto', ProductoController::class);
Route::prefix('producto/{id}')->group(function () {
    Route::post('subir_imagen1', [ProductoController::class, 'subir_imagen1']);
    Route::post('subir_imagen2', [ProductoController::class, 'subir_imagen2']);
    Route::post('subir_imagen3', [ProductoController::class, 'subir_imagen3']);
    Route::post('subir_imagen4', [ProductoController::class, 'subir_imagen4']);
    Route::post('subir_imagen5', [ProductoController::class, 'subir_imagen5']);
});
Route::post('actualizar_producto', [ProductoController::class, 'actualizar_producto']);
Route::get('get_producto_por_id/{id_producto}', [ProductoController::class, 'get_producto_por_id']);
Route::get('get_lista_producto/{id_lugar}', [ProductoController::class, 'get_lista_producto']);
Route::get('inventario', [ProductoController::class, 'inventario']);
Route::get('inventario_imprimir', [ProductoController::class, 'inventario_imprimir']);
Route::get('rptMinimos', [ProductoController::class, 'ProductosMinimos']);
Route::get('producto_imprimir', [ProductoController::class, 'producto_imprimir']);
Route::get('producto_utilidad_imprimir', [ProductoController::class, 'producto_utilidad_imprimir']);
Route::get('eliminar_producto/{id}', [ProductoController::class, 'eliminar_producto']);

// SUCURSALES
Route::resource('sucursal', SucursalController::class);
Route::post('actualizar_sucursal', [SucursalController::class, 'actualizar_sucursal']);
Route::get('get_sucursal_por_id/{id_sucursal}', [SucursalController::class, 'get_sucursal_por_id']);
Route::get('sucursal_imprimir', [SucursalController::class, 'sucursal_imprimir']);

// NOTA COMPRA
Route::resource('nota_compra', Nota_compraController::class);
Route::get('nota_compra_imprimir/{id}', [Nota_compraController::class, 'nota_compra_imprimir']);
Route::get('get_nota_compra_por_id/{id}', [Nota_compraController::class, 'get_nota_compra_por_id']);
Route::get('get_nota_compra_por_id_producto/{id}/{fecha_inicio}/{fecha_final}', [Nota_compraController::class, 'get_nota_compra_por_id_producto']);
Route::get('nota_compra_historial/{fecha_inicio}/{fecha_final}', [Nota_compraController::class, 'nota_compra_historial']);
Route::get('nota_compra_historial_por_producto/{fecha_inicio}/{fecha_final}/{id_producto}', [Nota_compraController::class, 'nota_compra_historial_por_producto']);
Route::get('nota_compra_historial_por_producto_imprimir/{fecha_inicio}/{fecha_final}/{id_producto}', [Nota_compraController::class, 'nota_compra_historial_por_producto_imprimir']);
Route::get('nota_compra_historial_imprimir/{fecha_inicio}/{fecha_final}', [Nota_compraController::class, 'nota_compra_historial_imprimir']);
Route::post('actualizar_estado_nota_compra', [Nota_compraController::class, 'actualizar_estado_nota_compra']);

// NOTA VENTA
// Cobro con QR de Banco FIE (antes del resource para que no lo capture nota_venta/{id})
Route::post('nota_venta/bancofie/generar', [App\Http\Controllers\BancoFieQrController::class, 'generar']);
Route::post('nota_venta/bancofie/estado', [App\Http\Controllers\BancoFieQrController::class, 'estado']);
Route::resource('nota_venta', NotaVentaController::class);
Route::get('nota_venta_imprimir/{id}', [NotaVentaController::class, 'nota_venta_imprimir']);
Route::get('nota_venta_imprimir_pequenio/{id}', [NotaVentaController::class, 'nota_venta_imprimir_pequenio']);
Route::get('imprimir_ticket_pdf/{id}', [NotaVentaController::class, 'nota_venta_imprimir_pequenio_ticket_pdf']);
Route::get('get_nota_venta_por_id/{id}', [NotaVentaController::class, 'get_nota_venta_por_id']);
Route::post('cancelar_nota_venta', [NotaVentaController::class, 'cancelar_nota_venta']);
Route::get('nota_venta_rendimiento', [NotaVentaController::class, 'rendimiento']);
Route::get('imprimir_factura/{id}', [NotaVentaController::class, 'imprimir_factura']);
Route::get('est_result_imp/{fecha_inicio}/{fecha_final}', [NotaVentaController::class, 'est_result_imp']);
Route::post('actualizar_estado_nota_venta', [NotaVentaController::class, 'actualizar_estado_nota_venta']);
Route::get('get_nota_venta_por_id_producto/{id}/{fecha_inicio}/{fecha_final}', [NotaVentaController::class, 'get_nota_venta_por_id_producto']);
Route::get('nota_venta_historial_por_producto/{fecha_inicio}/{fecha_final}/{id_producto}', [NotaVentaController::class, 'nota_venta_historial_por_producto']);
Route::get('nota_venta_historial_por_producto_imprimir/{fecha_inicio}/{fecha_final}/{id_producto}', [NotaVentaController::class, 'nota_venta_historial_por_producto_imprimir']);
Route::get('get_venta_estadistica_anio/{anio}', [NotaVentaController::class, 'get_venta_estadistica_anio']);
Route::get('nota_venta_historial/{fecha_inicio}/{fecha_final}', [NotaVentaController::class, 'nota_venta_historial']);
Route::get('nota_venta_historial_imprimir/{fecha_inicio}/{fecha_final}', [NotaVentaController::class, 'nota_venta_historial_imprimir']);
Route::get('nota_venta_historial_por_dia_imprimir/{fecha_inicio}/{fecha_final}', [NotaVentaController::class, 'nota_venta_historial_por_dia_imprimir']);

// PRODUCTO POR TIPO
Route::resource('producto_tipo', Producto_tipoController::class);
Route::post('producto_tipo/{id}/subir_imagen1', [Producto_tipoController::class, 'subir_imagen1']);
Route::post('Actualizar_producto_tipo', [Producto_tipoController::class, 'Actualizar_Producto_tipo']);
Route::post('Actualizar_producto_tipo_menos', [Producto_tipoController::class, 'Actualizar_Producto_tipo_menos']);
