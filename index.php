<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wykresy</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/index.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <div id="top-bar">
                <div id="top-logo">
                    <h3>NOMBRE</h3>
                </div>
                <div id="top-login-buttons">
                    <a href="login.php" id="login-button" class="top-button">Zaloguj się</a>
                    <a href="register.php" id="register-button" class="top-button">Załóż konto</a>
                </div>
            </div>
            <h1>Wykresy z całego Internetu<br>zebrane w jednym miejscu</h1>
            <form id="search-chart">
                <input id="search-phrase" type="search" placeholder="Wyszukiwanie">
                <input id="search-button" type="submit" value="Szukaj">
            </form>
            <div id="categories-bar">
                <a href="medicine.php" class="category-button">Medycyna</a>
                <a href="economy.php" class="category-button">Ekonomia</a>
                <a href="demography.php" class="category-button">Demografia</a>
                <a href="climate.php" class="category-button">Klimat</a>
                <a href="interesting.php" class="category-button">Ciekawostki</a>
            </div>
        </header>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>
</html>
