<?php

function curs()
{
    $cache_time_out = 10800; // Время жизни кэша в секундах
    $file_currency_cache = 'currency.txt'; // Файл кэша

    if (!is_file($file_currency_cache) || filemtime($file_currency_cache) < (time() - $cache_time_out)) {
        $url = "https://cdn.cur.su/api/nbu.json";
        $curs = file_get_contents($url);
        $curs = json_decode($curs, true);
        $curs = $curs['rates']['UAH'];
        $curs = mb_strimwidth($curs, 0, 5);
        file_put_contents($file_currency_cache, $curs);
    }

    return (file_get_contents($file_currency_cache));
}
echo curs();





