<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->id_empresa) {
            $idioma = DB::table('empresa')->where('id', Auth::user()->id_empresa)->value('idioma');

            if ($idioma && in_array($idioma, ['es', 'en'], true)) {
                App::setLocale($idioma);
            }
        }

        return $next($request);
    }
}
