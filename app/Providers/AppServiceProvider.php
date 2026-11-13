<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compartir con TODAS las vistas la caja abierta del usuario autenticado.
        // Las vistas usan $caja_abierta (objeto con id, caja) o null si no hay ninguna.
        // Se resuelve una sola vez por request (memo en el contenedor).
        View::composer('*', function ($view) {
            if (!app()->bound('caja_abierta_memo')) {
                $cajaAbierta = null;
                if (Auth::check()) {
                    $rows = DB::select(
                        "SELECT id, caja FROM caja
                         WHERE estado = 'Abierta' AND id_usuario = ? AND id_empresa = ?
                         ORDER BY id DESC LIMIT 1",
                        [Auth::user()->id, Auth::user()->id_empresa]
                    );
                    $cajaAbierta = $rows[0] ?? null;
                }
                // se envuelve para que el valor guardado nunca sea null (bound() usa isset)
                app()->instance('caja_abierta_memo', (object) ['caja' => $cajaAbierta]);
            }
            $view->with('caja_abierta', app('caja_abierta_memo')->caja);
        });
    }
}
