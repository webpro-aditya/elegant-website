<?php

use Illuminate\Support\Facades\Crypt;

if (!function_exists('encrypt')) {
    function encrypt($string)
    {
        return Crypt::encryptString($string);
    }
}

if (!function_exists('decrypt')) {
    function decrypt($string)
    {
        return Crypt::decryptString($string);
    }
}
