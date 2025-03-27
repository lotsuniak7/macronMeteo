<?php

function getWeatherData($city, $apiKey)
{
    $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . "&appid={$apiKey}&units=metric";
    $response = file_get_contents($url);

    if ($response) {
        // Если переменная $response не пустая, то достаем данные оттуда
        return json_decode($response, true);
    }
    return null; // Возвращаем null, если запрос не удался
}
