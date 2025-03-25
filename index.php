<?php
require_once 'controller/indexController.php';

$weatherData = $_SESSION['weatherData'] ?? null;
//$macronData = $_SESSION['macronData'] ?? null ?? [
//        'base' => '/macronMeteo/media/macronBase.png',
//        'clothing' => '',
//        'accessoires' => '',
//];
$error = $_SESSION['error'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Météo avec Macron</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Météo avec Macron</h1>
    <form method="post" action="controller/indexController.php">
        <label for="city">Put the city</label>
        <input type="text" id="city" name="city" placeholder="City">
        <button type="submit">Узнать погоду</button>
    </form>

    <div class="differentMeteo">
        <article class="meteoCity">
            <div>
                <img src="media/macronBase.png" alt="" class="macron">
            </div>
            <div>
                <h2>Paris</h2>
                <?php
                $url = 'https://api.openweathermap.org/data/2.5/weather?q=Paris&appid=eab3920ab234ca13e37eaf24d33d584f&units=metric';
                $response = file_get_contents($url);

                if(!$response) {
                    $error = "Weather not found in our database";
                } else {
                    // Если перееменная $response не пустая, то достаем данные от туда
                    $weatherData = json_decode($response, true);

                    // Если ёто условие верно, то значит город не был найден
                    if(isset($weatherData['cod']) && $weatherData["cod"] != 200){
                        $error = $weatherData['message'];
                    }
                }
                ?>
                <p>Température : <?php echo htmlspecialchars($weatherData['main']['temp'])?></p>
            </div>
        </article>
        <article class="meteoCity">
            <div>
                <img src="media/macronBase.png" alt="" class="macron">
            </div>
            <div>
                <h2>Metz</h2>
            </div>
        </article>
        <article class="meteoCity">
            <div>
                <img src="media/macronBase.png" alt="" class="macron">
            </div>
            <div>
                <h2>Nice</h2>
            </div>
        </article>
    </div>
</body>
</html>