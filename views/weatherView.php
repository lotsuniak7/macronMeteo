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

<?php if (isset($error) && $error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['weatherData']) && $_SESSION['weatherData']): ?>
    <div class="meteoCity">
        <div>
            <img src="../media/macronBase.png" alt="" class="macron">
        </div>
        <div>
            <h2><?php echo htmlspecialchars($_SESSION['weatherData']['name']); ?></h2>
            <p>Температура: <?php echo htmlspecialchars($_SESSION['weatherData']['main']['temp']); ?>°C</p>
            <p>Условия: <?php echo htmlspecialchars($_SESSION['weatherData']['weather'][0]['main']); ?></p>
            <p>Влажность: <?php echo htmlspecialchars($_SESSION['weatherData']['main']['humidity']); ?>%</p>
        </div>
    </div>
<?php endif; ?>
</body>
</html>