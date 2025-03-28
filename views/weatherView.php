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
        // Через foreach получаем погоду города
        foreach ($_SESSION['cities'] as $city) {
            $weatherData = getWeatherData($city, $apiKey);
            // Если удалось, то показываем контейнер
            if ($weatherData && $weatherData['cod'] == 200) {
                echo '<div class="weather-card">';
                    echo '<div id="macron">';
                        echo '<img src="../media/macronBase.png" alt="Макрон" class="macron-img">';
                    echo '</div>';
                    echo '<div class="weather-content">';
                        // Name of city
                        echo '<h2>' . htmlspecialchars(strtoupper($city[0]) . substr(strtolower($city), 1)) . '</h2>';
                        echo '<div class="weather-info">';
                            echo '<article class="section-article-temp">';
                                // Показываем температуру плюс тут округление с помощью round()
                                echo '<p>Temperature: ' . htmlspecialchars(round($weatherData['main']['temp'])) . '°C</p>';
                            echo '</article>';
                            echo '<article class="section-article-weather">';
                                // Выбираем картинку для отображение погоды которая сейчас с помощью сравнения
                                // Например если у нас clear sky то показываем картинку солнечно и тд
                                echo '<p>Weather: ' . htmlspecialchars($weatherData['weather'][0]['description']) . '</p>';
                                if ($weatherData['weather'][0]['description'] === 'clear sky')
                                    echo '<img src="../media/sunny.png" alt="Sunny" class="weather-img">';
                                elseif ($weatherData['weather'][0]['description'] === 'broken clouds' || $weatherData['weather'][0]['description'] === 'overcast clouds')
                                    echo '<img src="../media/cloudy.png" alt="Cloudy" class="weather-img">';
                                /*
                                    Для облегчения просто решил сделать проверку если
                                    строка содержит слово: snow, то будем показывать фотку со снегом
                                */
                                elseif (str_contains($weatherData['weather'][0]['description'], 'snow'))
                                    echo '<img src="../media/snowy.png" alt="Snow" class="weather-img">';
                            echo '</article>';
                            echo '<article class="section-article-humidity">';
                                echo '<p>Humidity: ' . htmlspecialchars($weatherData['main']['humidity']) . '%</p>';
                            echo '</article>';
                            echo '<article class="section-article-windspeed">';
                                echo '<p>Wind: ' . htmlspecialchars(number_format($weatherData['wind']['speed'], 1)) . '</p>';
                            echo '</article>';
                            echo '<article class="weather-for-allday">';
                                echo '<span>Just hello world)</span>';
                            echo '</article>';
                            echo '<article class="weather-for-week">';
                                echo '<span>Just hello world)</span>';
                            echo '</article>';
                        echo '</div>';
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