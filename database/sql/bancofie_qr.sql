-- =====================================================================
--  COBRO CON QR DE BANCO FIE  —  todo en un solo archivo
--  Fecha: 2026-08-28
--
--  Ejecutar UNA sola vez en el servidor:
--      mysql -u USUARIO -p NOMBRE_BD < bancofie_qr.sql
--
--  Si alguna columna/tabla ya existe, MySQL avisa ("Duplicate column name"
--  / "Table already exists") y podés seguir con el resto sin problema.
-- =====================================================================

-- 1) Configuración de Banco FIE por empresa ---------------------------
--    pago_qr_bancofie      : 1 = la empresa cobra con QR Banco FIE, 0 = no
--    bancofie_usuario      : usuario del servicio Banco FIE
--    bancofie_password     : contraseña ENCRIPTADA (Laravel Crypt / AES-256), nunca texto plano
--    bancofie_token        : token temporal (login), se cachea y renueva solo
--    bancofie_token_expira : expiración del token temporal
--    bancofie_id_servicio  : idServicio de la cuenta comercial (panel sip.mc4.com.bo)
--    bancofie_callback     : dominio / callback registrado
ALTER TABLE `empresa`
    ADD COLUMN `pago_qr_bancofie`      TINYINT      NOT NULL DEFAULT 0            AFTER `comentario_recibo`,
    ADD COLUMN `bancofie_usuario`      VARCHAR(191)     NULL DEFAULT NULL         AFTER `pago_qr_bancofie`,
    ADD COLUMN `bancofie_password`     TEXT             NULL DEFAULT NULL         AFTER `bancofie_usuario`,
    ADD COLUMN `bancofie_token`        TEXT             NULL DEFAULT NULL         AFTER `bancofie_password`,
    ADD COLUMN `bancofie_token_expira` DATETIME         NULL DEFAULT NULL         AFTER `bancofie_token`,
    ADD COLUMN `bancofie_id_servicio`  INT              NULL DEFAULT NULL         AFTER `bancofie_token_expira`,
    ADD COLUMN `bancofie_callback`     VARCHAR(191)     NULL DEFAULT NULL         AFTER `bancofie_id_servicio`;

-- 2) Link de la venta con la transacción de Banco FIE ----------------
--    Guarda el idTransaccion (el que devuelve generaQr / verificaTransaccion)
--    directamente en nota_venta.
ALTER TABLE `nota_venta`
    ADD COLUMN `id_transaccion_qr` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `id_empresa`,
    ADD INDEX `idx_nota_venta_id_transaccion_qr` (`id_transaccion_qr`);

-- 3) Detalle de cada transacción QR (la imagen NO se guarda: solo se muestra) --
CREATE TABLE IF NOT EXISTS `transaccion_qr_bancofie` (
    `id_transaccion`      BIGINT UNSIGNED NOT NULL COMMENT 'idTransaccion devuelto por Banco FIE',
    `id_qr`               VARCHAR(60)     DEFAULT NULL,
    `id_empresa`          INT             DEFAULT NULL,
    `id_nota_venta`       INT             DEFAULT NULL COMMENT 'se llena cuando la venta queda registrada',
    `id_usuario_registro` INT             DEFAULT NULL COMMENT 'users.id del cajero',
    `origen`              VARCHAR(20)     DEFAULT 'NOTA_VENTA',
    `alias`               VARCHAR(150)    DEFAULT NULL,
    `detalle_glosa`       VARCHAR(255)    DEFAULT NULL,
    `moneda`              VARCHAR(5)      DEFAULT 'BOB',
    `monto`               DECIMAL(10,2)   DEFAULT NULL,
    `id_servicio`         INT             DEFAULT NULL,
    `banco_destino`       VARCHAR(100)    DEFAULT NULL,
    `cuenta_destino`      VARCHAR(30)     DEFAULT NULL,
    `fecha_vencimiento`   DATE            DEFAULT NULL,
    `estado_pago`         VARCHAR(20)     NOT NULL DEFAULT 'PENDIENTE' COMMENT 'PENDIENTE | PAGADO | ...',
    `cliente_ref`         VARCHAR(30)     DEFAULT NULL,
    `fecha_alta`          DATETIME        DEFAULT CURRENT_TIMESTAMP,
    `fecha_pago`          DATETIME        DEFAULT NULL,
    `fecha_verificacion`  DATETIME        DEFAULT NULL,
    PRIMARY KEY (`id_transaccion`),
    KEY `idx_tqb_empresa` (`id_empresa`),
    KEY `idx_tqb_nota_venta` (`id_nota_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
