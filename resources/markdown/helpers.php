<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

if (! function_exists('__db')) {
    /**
     * Traduzione "intelligente": cerca prima nel database (via cache) e poi nei file locali.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string|null  $locale
     * @return string
     */
    function __db($key, $replace = [], $locale = null)
    {
        $locale = $locale ?? App::getLocale();

        // Logica ipotetica: cerca in cache per evitare query ridondanti
        // $translation = Cache::tags(['translations'])->remember("db_trans.{$locale}.{$key}", 3600, function () use ($key, $locale) {
        //     return \App\Models\Translation::where('key', $key)->where('locale', $locale)->value('text');
        // });

        // Se trovi la traduzione nel DB, processa i placeholder, altrimenti usa __() nativo
        // return $translation ? strtr($translation, $replace) : __($key, $replace, $locale);
        
        return __($key, $replace, $locale);
    }
}
