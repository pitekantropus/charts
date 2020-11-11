<?php
require_once('php/utils/Session.php');
require_once('php/utils/include-functions.php');
$session = new Session();
$logged = $session->isLogged();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wykresy</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/index.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
<?php
includeTopBar($logged);
?>
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
        <section id="this-week" class="category-section">
            <div class="section-header">
                <h2>W tym tygodniu</h2>
                <div class="top-new-toggle" data-category="this-week">
                    <label class="toggle-label top-label">
                        <input name="this-week" type="radio" class="top-new-radio" value="top" checked>
                        <span>Popularne</span>
                    </label>
                    <label class="toggle-label new-label">
                        <input name="this-week" type="radio" class="top-new-radio" value="new">
                        <span>Najnowsze</span>
                    </label>
                </div>
            </div>
            <div class="section-charts" id="this-week-charts">
            </div>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/index.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
