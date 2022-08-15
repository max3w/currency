<?php

function curs()
    
{
    $cache_time_out = 1; // Время жизни кэша в секундах
    $file_currency_cache = 'currency.txt'; // Файл кэша

    if (!is_file($file_currency_cache) || filemtime($file_currency_cache) < (time() - $cache_time_out)) {
        $url = "https://kurs.com.ua/valyuta/usd";
        $curs = file_get_contents($url);
        preg_match_all('#<script type="application/ld\+json">(.+?)</script>#is', $curs, $arr); // Парсинг выбраного фида
        $arr = $arr[1][0];
        $curs = json_decode($arr, true);
        $curs = $curs['mainEntity']['csvw:tableSchema']['csvw:columns'][3]['csvw:cells'][0]['csvw:value'];

        file_put_contents($file_currency_cache, $curs);
    }

    return (file_get_contents($file_currency_cache));
}
echo curs();
