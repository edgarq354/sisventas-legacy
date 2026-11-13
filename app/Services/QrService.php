<?php

namespace App\Services;

class QrService
{
    protected $qrlibPath;

    public function __construct()
    {
        // Ruta a la librería PHP QR Code
        $this->qrlibPath = base_path('public/Libs/qrlib.php');
    }

    /**
     * Genera un QR en Base64 a partir de un texto
     *
     * @param string $texto
     * @param int $size
     * @param int $margin
     * @return string Base64
     */
    public function generarBase64(string $texto, int $size = 5, int $margin = 1): string
    {
        require_once $this->qrlibPath;

        // Capturar la salida PNG en memoria
        ob_start();
        \QRcode::png($texto, false, QR_ECLEVEL_L, $size, $margin);
        $pngData = ob_get_contents();
        ob_end_clean();

        return  base64_encode($pngData);
    }
}
