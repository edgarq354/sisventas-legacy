<?php

use Illuminate\Support\Carbon;

if (!function_exists('fecha_larga')) {
    /**
     * Fecha larga localizada ("Lunes, 13 de Noviembre de 2026" / "Monday, Nov 13, 2026")
     * para reemplazar los bloques legacy que armaban la fecha a mano con strftime().
     */
    function fecha_larga(string $fecha, bool $conHora = false): string
    {
        $carbon = Carbon::parse($fecha)->locale(app()->getLocale());

        $formato = app()->getLocale() === 'en'
            ? ($conHora ? 'l, M j, Y, g:i A' : 'l, M j, Y')
            : ($conHora ? 'l, d \d\e F \d\e Y, H:i' : 'l, d \d\e F \d\e Y');

        return $carbon->translatedFormat($formato);
    }
}

if (!function_exists('fecha_hora_impresion')) {
    /**
     * Fecha/hora "generado el" para pies de ticket, localizada por idioma.
     */
    function fecha_hora_impresion(): string
    {
        $carbon = now()->locale(app()->getLocale());

        $formato = app()->getLocale() === 'en'
            ? 'M j, Y, g:i A'
            : 'j \d\e F \d\e Y, H:i';

        return $carbon->translatedFormat($formato);
    }
}
