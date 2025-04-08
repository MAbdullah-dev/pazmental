<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = env('DEFAULT_LANGUAGE', 'en');
        }

        App::setLocale($locale);
        session()->put('locale', $locale);

        $langcode =  Session::get('langcode')?? env('DEFAULT_LANGUAGE', 'en');
        Carbon::setLocale($langcode);

        view()->share("lang", get_system_language()->code ?? env('DEFAULT_LANGUAGE'));


        return $next($request);
    }
}
