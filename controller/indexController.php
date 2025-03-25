<?php
session_start();

$apiKey = "eab3920ab234ca13e37eaf24d33d584f";
$weatherData = null;
$error = null;

// Проверка отправляется ли форма
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $city = $_POST["city"] ?? '';
    if(!empty($city)){
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . "&appid={$apiKey}&units=metric";
        $response = file_get_contents($url);

        if(!$response) {
            $error = "Weather not found in our database";
        } else {
            // Если перееменная $response не пустая то достаем данные от туда
            $weatherData = json_decode($response, true);

            // Если ёто условие верно то значит город не был найден
            if(isset($weatherData['cod']) && $weatherData["cod"] != 200){
                $error = $weatherData['message'];
            }
        }
    } else {
        $error = "Please enter a city";
    }
}

// Аутфит Макрона
//$macronOutfit = [
//    'base' => '/macronMeteo/media/macronBase.png',
//    'clothing' => '',
//    'accessories' => '',
//];

/*if(!empty($weatherData)){
    $temperature = $weatherData["main"]["temp"];
    $climate = $weatherData["weather"][0]["main"];

    if($temperature > 30) {
        $macronOutfit['accessories'] .= '';
        $macronOutfit['clothing'] .= '';

        echo 'Ouuula il fait chaud';
    } elseif ($temperature < 30 && $temperature >  20) {
        $macronOutfit['accessories'] .= '';
        $macronOutfit['clothing'] .= '';

        echo 'Il fait bon là';
    } elseif ($temperature < 20 && $temperature > 10) {
        $macronOutfit['accessories'] .= '';
        $macronOutfit['clothing'] .= '';

        echo 'Il fait pas bon';
    } elseif ($temperature < 10 && $temperature > 0) {
        $macronOutfit['accessories'] .= '';
        $macronOutfit['clothing'] .= '';

        echo 'Il fait froid';
    } elseif ($temperature < 0) {
        $macronOutfit['accessories'] .= '';
        $macronOutfit['clothing'] .= '';

        echo 'Il fait super froid';
    }
}
*/

$_SESSION['weatherData'] = $weatherData;
// $_SESSION['macronOutfit'] = $macronOutfit;
$_SESSION['error'] = $error;


