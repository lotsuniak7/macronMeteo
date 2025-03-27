<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Météo avec Macron</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h1>Météo avec Macron</h1>
    <form method="post" action="../controller/indexController.php">
        <label for="city">Введите город</label>
        <input type="text" id="city" name="city" placeholder="Город">
        <button type="submit">Узнать погоду</button>
    </form>
    <form method="post" action="../controller/indexController.php">
        <button type="submit">Clear</button>
        <input type="hidden" name="action" value="clear">
    </form>
<?php if (isset($error) && $error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

    <div class="weather-sections">
        <?php
        foreach ($_SESSION['cities'] as $city) {
            $weatherData = getWeatherData($city, $apiKey);
            if ($weatherData && $weatherData['cod'] == 200) {
                echo '<div class="weather-card">';
                echo '<div class="weather-content">';
                echo '<div><img src="../media/macronBase.png" alt="Макрон" class="macron-img"></div>';
                echo '<div class="weather-info">';
                echo '<h2>' . htmlspecialchars($city) . '</h2>';
                echo '<p>Температура: ' . htmlspecialchars($weatherData['main']['temp']) . '°C</p>';
                echo '<p>Погода: ' . htmlspecialchars($weatherData['weather'][0]['description']) . '</p>';
                echo '<p>Влажность: ' . htmlspecialchars($weatherData['main']['humidity']) . '%</p>';
                echo '</div></div>';

                // Прогноз на 7 дней (заглушка)
                echo '<div class="forecast">';
                /*for ($i = 0; $i < 7; $i++) {
                    $day = date('D', strtotime("+$i days"));
                    echo '<div class="forecast-day">';
                    echo '<span>' . $day . '</span>';
                    echo '<span>Min: --°C / Max: --°C</span>';
                    echo '</div>';
                }*/
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="weather-card"><p>Не удалось загрузить данные для ' . htmlspecialchars($city) . '</p></div>';
            }
        }
        ?>
    </div>
</body>
</html>