<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>MacronWeather</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1>Weather with Macron</h1>
    <form method="post" action="../controller/indexController.php" class="form-city">
        <label for="city" class="form-label">Put a city</label>
        <br>
        <input type="text" id="city" name="city" class="form-control" placeholder="ex Paris">
        <button type="submit">Check the weather</button>
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
                echo '<h2>' . htmlspecialchars(strtoupper($city[0]) . substr(strtolower($city), 1)) . '</h2>';
                echo '<p>Temperature: ' . htmlspecialchars($weatherData['main']['temp']) . '°C</p>';
                echo '<p>Weather: ' . htmlspecialchars($weatherData['weather'][0]['description']) . '</p>';
                echo '<p>Humidity: ' . htmlspecialchars($weatherData['main']['humidity']) . '%</p>';
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>