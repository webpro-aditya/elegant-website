<?php

if (!function_exists('formatAmount')) {
    function formatAmount($amount, $roundOff = 2)
    {
        // $amount = round((float) $amount, $roundOff);
        $amount = number_format((float) $amount, 2);

        return config('app.currency.symbol') . $amount;
    }
}

if (!function_exists('formatAmountToNumber')) {
    function formatAmountToNumber($amount, $roundOff = 2)
    {
        // $amount = round((float) $amount, $roundOff);
        $amount = number_format((float) $amount, 2, ',', '');

        return config('app.currency.symbol') . $amount;
    }
}

if (!function_exists('formatStock')) {
    function formatStock($stock)
    {
        $stock = number_format((float) $stock, 2);

        return $stock;
    }
}
