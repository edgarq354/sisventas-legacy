<?php
require 'qrlib.php'; // Asegúrate que esté en la misma carpeta

$texto = $_GET['texto'] ?? 'HolaMundo';

// Capturar la salida PNG en memoria
ob_start();
QRcode::png($texto, false, QR_ECLEVEL_L, 5, 1); // margin=1
$pngData = ob_get_contents();
ob_end_clean();

// Convertir a Base64
$base64 = base64_encode($pngData);

// Retornar solo Base64 (puedes agregar JSON si quieres)
header('Content-Type: text/plain');
echo $base64;
