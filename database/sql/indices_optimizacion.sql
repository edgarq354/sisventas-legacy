-- =====================================================================
--  Índices de optimización  —  Fecha: 2026-08-30
--
--  Ejecutar en el servidor:
--      mysql -u USUARIO -p NOMBRE_BD < indices_optimizacion.sql
--
--  Solo la tabla `nota_venta` es grande (~170k filas) y necesita ayuda.
--  El resto de tablas (gasto, caja, nota_compra, etc.) tienen pocas filas
--  y no necesitan índices nuevos.
--  Si un índice ya existe, MySQL da error 1061 y podés seguir con el resto.
-- =====================================================================

-- nota_venta: la mayoría de reportes filtran por (id_empresa + rango de fecha):
--   - historial de ventas / compras
--   - estado de resultado
--   - estadística anual del dashboard (ajuste, rendimiento)
-- Con este índice la consulta va directo a las filas de la empresa en el rango,
-- en vez de escanear todas las empresas.
ALTER TABLE `nota_venta` ADD INDEX `idx_nv_empresa_fecha` (`id_empresa`, `fecha`);

-- detalle_venta: para el join + group by del estado de resultado
-- (nota_venta -> detalle_venta -> producto). id_nota_venta ya está indexado,
-- este lo hace "covering" para ese reporte.
ALTER TABLE `detalle_venta` ADD INDEX `idx_dv_nv_prod` (`id_nota_venta`, `id_producto`);
