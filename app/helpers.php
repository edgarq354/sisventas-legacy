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

if (!function_exists('nombre_mes')) {
    /**
     * Nombre del mes (1-12) localizado según el idioma de la empresa.
     */
    function nombre_mes(int $numero, bool $mayusculas = true): string
    {
        if ($numero < 1 || $numero > 12) {
            return '';
        }

        $nombre = Carbon::create(null, $numero, 1)->locale(app()->getLocale())->translatedFormat('F');

        return $mayusculas ? mb_strtoupper($nombre) : $nombre;
    }
}

if (!function_exists('tipo_venta_label')) {
    /**
     * Traduce la modalidad de venta guardada en BD ("LLEVAR", "AUTO", "PEDIDO",
     * "MESA 5") a su etiqueta localizada, sin tocar el valor almacenado.
     */
    function tipo_venta_label(?string $tipo): string
    {
        if ($tipo === null || $tipo === '') {
            return '';
        }

        if (str_starts_with($tipo, 'MESA ')) {
            return __('nota_venta.mesa') . ' ' . substr($tipo, 5);
        }

        return match ($tipo) {
            'LLEVAR' => __('nota_venta.llevar'),
            'AUTO' => __('nota_venta.auto'),
            'PEDIDO' => __('nota_venta.pedido'),
            default => $tipo,
        };
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
