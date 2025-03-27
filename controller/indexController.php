<?php
session_start();
require_once __DIR__ . '/../models/weatherModel.php';

$apiKey = "eab3920ab234ca13e37eaf24d33d584f";
$weatherData = null;
$error = null;

if (!isset($_SESSION['cities'])) {
    $_SESSION['cities'] = ['Paris'];
}

// Проверка отправляется ли форма
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $city = $_POST["city"] ?? '';
    if(!empty($city)){
        $weatherData = getWeatherData($city, $apiKey);
        // Если это условие верно, то значит город не был найден
        if($weatherData && isset($weatherData['cod']) && $weatherData["cod"] != 200){
            $error = $weatherData['message'];
        } else {
            $_SESSION['weatherData'] = $weatherData;
        }
    } else {
        $error = "Please enter a city";
    }
} else {
    $weatherData = getWeatherData('Paris', $apiKey);
    if($weatherData && isset($weatherData['cod']) && $weatherData["cod"] != 200){
        $error = "Погода для Парижа не найдена";
    } else {
        $_SESSION['weatherData'] = $weatherData;
    }
}

include "../views/weatherView.php";