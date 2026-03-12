<?php

if (!function_exists('route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function route($name, $parameters = [], $absolute = true)
    {
        $except = ['web_home', 'web_locale'];

        if ((substr($name, 0, strlen('web_')) === 'web_') && !in_array($name, $except)) {
            $parameters = ['locale' => app()->getLocale()] + $parameters;
        }
        return app('url')->route($name, $parameters, $absolute);
    }
}

