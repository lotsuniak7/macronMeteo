<?php
session_start();
require_once __DIR__ . '/../models/weatherModel.php';

$apiKey = "eab3920ab234ca13e37eaf24d33d584f";
$lon = null;
$lat = null;
$weatherData = null;
$forecastData = null;
$error = null;

if (!isset($_SESSION['cities'])) {
    $_SESSION['cities'] = ['Paris'];
}

if (!isset($_SESSION['coords'])) {
    $_SESSION['coords'] = [];
}

// Проверка отправляется ли форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"]) && $_POST["action"] == "clear") {
        $_SESSION['cities'] = ['Paris'];
        $_SESSION['coords'] = [];
    }
    $city = $_POST["city"] ?? '';
    if (!empty($city)) {
        $weatherData = getWeatherData($city, $apiKey);
        if ($weatherData && isset($weatherData['cod']) && $weatherData["cod"] != 200) {
            $error = $weatherData['message'];
        } else {
            $forecastData = getForecastData($weatherData['coord']['lat'], $weatherData['coord']['lon'], $apiKey);
            if ($forecastData && $forecastData["cod"] != "200") {
                $error = $forecastData['message'];
            } else {
                $cityLower = strtolower($city);
                $index = false;

                foreach ($_SESSION['cities'] as $i => $cityExist) {
                    if ($cityLower === strtolower($cityExist)) {
                        $index = $i;
                        break;
                    }
                }

                if ($index !== false) {
                    unset($_SESSION['cities'][$index]);
                    $_SESSION['cities'] = array_values($_SESSION['cities']);
                    unset($_SESSION['coords'][$cityLower]);
                }
                // Добавляем город в начало списка
                array_unshift($_SESSION['cities'], $city);

                // Сохраняем координаты
                $_SESSION['coords'][$cityLower] = [
                    'lat' => $weatherData['coord']['lat'],
                    'lon' => $weatherData['coord']['lon']
                ];
            }
        }
    } else {
        $error = "Please enter a city";
    }
} else {
    $weatherData = getWeatherData('Paris', $apiKey);
    if ($weatherData && isset($weatherData['cod']) && $weatherData["cod"] != 200) {
        $error = "Погода для Парижа не найдена";
    } else {
        $_SESSION['weatherData'] = $weatherData;
        $cityLower = strtolower('Paris');
        $_SESSION['coords'][$cityLower] = [
            'lat' => $weatherData['coord']['lat'],
            'lon' => $weatherData['coord']['lon']
        ];
    }
}

include "../views/weatherView.php";