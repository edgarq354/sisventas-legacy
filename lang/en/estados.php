<?php

declare(strict_types=1);

// Status values used across modules (sales, purchases, collections, cash registers).
// Keys are the literal Spanish values stored in the database.
return [
    'Procesado' => 'Processed',
    'Por cobrar' => 'Receivable',
    'Por pagar' => 'Payable',
    'Qr' => 'QR',
    'Abierta' => 'Open',
    'Cerrada' => 'Closed',
    'Activo' => 'Active',
    'Inactivo' => 'Inactive',
    'Pendiente' => 'Pending',
    'Cancelado' => 'Cancelled',
    'Entregado' => 'Delivered',
];
