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
    if (isset($_POST["action"]) && $_POST["action"] == "clear"){
        $_SESSION['cities'] = ['Paris'];
    }
    $city = $_POST["city"] ?? '';
    if(!empty($city)){
        $weatherData = getWeatherData($city, $apiKey);
        // Если это условие верно, то значит город не был найден
        if($weatherData && isset($weatherData['cod']) && $weatherData["cod"] != 200){
            $error = $weatherData['message'];
        } else {
            if (!in_array($city, $_SESSION['cities'])) {
                // array_unshift если не сможем с помощью флекса поменять напрвеление
                array_push($_SESSION['cities'], $city);
            } elseif (in_array(mb_strtolower($city), $_SESSION['cities'])) {
                //$_SESSION['weatherData'] = $weatherData;
                array_diff($_SESSION['cities'],[mb_strtolower($city)]);
                array_values($_SESSION['cities']);
                array_push($_SESSION['cities'], mb_strtolower($city));
            }
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