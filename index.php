<?php
require "controller/indexController.php";

/*
<div class="weather-card">';
    <div id='macron'>
        <img src="../media/macronBase.png" alt="Макрон" class="macron-img">
    </div>
    <div class="weather-content">';
        <h2>' . htmlspecialchars(strtoupper($city[0]) . substr(strtolower($city), 1)) . '</h2>';
        <div class="weather-info">';
            <article class='section-article-temp'>
                <p>Temperature: ' . htmlspecialchars($weatherData['main']['temp']) . '°C</p>';
                <img src=''>
            </article>
            <article class='section-article-weather'>
                <p>Weather: ' . htmlspecialchars($weatherData['weather'][0]['description']) . '</p>';
            </article>
            <article class='section-article-humidity'>
                <p>Humidity: ' . htmlspecialchars($weatherData['main']['humidity']) . '%</p>';
            </article>
            <article class='section-article-windspeed'>
                <p>Wind:</p>
            </article>
            <article class='weather-for-allday'>
                <span>Just hello world)</span>
            </article>
            <article class='weather-for-week'>
                <span>Just hello world)</span>
            </article>
        </div>
    </div>';
</div>';


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
                for ($i = 0; $i < 7; $i++) {
                    $day = date('D', strtotime("+$i days"));
                    echo '<div class="forecast-day">';
                    echo '<span>' . $day . '</span>';
                    echo '<span>Min: --°C / Max: --°C</span>';
                    echo '</div>';
                }
echo '</div>';
echo '</div>';
} else {
    echo '<div class="weather-card"><p>Не удалось загрузить данные для ' . htmlspecialchars($city) . '</p></div>';
}
}
?>