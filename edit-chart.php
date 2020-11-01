<?php
require_once('php/utils/Session.php');
$session = new Session();
if(!$session->checkPermission('admin')) {
    header("location: /");
}
require_once('php/utils/Chart.php');
if(!isset($_GET['id'])) {
    die('No id provided!');
}
$id = $_GET['id'];

function printMonthsOptions() {
    echo "<option value=''>Miesiąc (opcjonalnie)</option>";
    echo "<option value='0'>Styczeń</option>";
    echo "<option value='1'>Luty</option>";
    echo "<option value='2'>Marzec</option>";
    echo "<option value='3'>Kwiecień</option>";
    echo "<option value='4'>Maj</option>";
    echo "<option value='5'>Czerwiec</option>";
    echo "<option value='6'>Lipiec</option>";
    echo "<option value='7'>Sierpień</option>";
    echo "<option value='8'>Wrzesień</option>";
    echo "<option value='9'>Październik</option>";
    echo "<option value='10'>Listopad</option>";
    echo "<option value='11'>Grudzień</option>";
}

$chart = new Chart($id);

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edytuj wykres</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/add-chart.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <form id="edit-chart-form" method="POST" enctype="multipart/form-data" action="/admin/php/edit-chart.php">
            <h1>Edytuj wykres</h1>
            <h3>Opis wykresu</h3>
            <label class="input-label"><span class="label-header">Nazwa</span>
                <input name="title" type="text" placeholder="Tytuł wykresu" value="<?= $chart->title ?>">
            </label>
            <p class="field-header">Kategorie</p>
            <label class="category-label">
                <input type="checkbox" name="categories[]" value="health">
                <div class="custom-checkbox"></div>Zdrowie i życie
            </label>
            <label class="category-label">
                <input type="checkbox" name="categories[]" value="economy">
                <div class="custom-checkbox"></div>Ekonomia
            </label>
            <label class="category-label">
                <input type="checkbox" name="categories[]" value="demography">
                <div class="custom-checkbox"></div>Demografia
            </label>
            <label class="category-label">
                <input type="checkbox" name="categories[]" value="geology">
                <div class="custom-checkbox"></div>Geologia
            </label>
            <label class="category-label">
                <input type="checkbox" name="categories[]" value="interesting">
                <div class="custom-checkbox"></div>Ciekawostki
            </label>
            <p class="field-header">Zakres lat</p>
            <div class="horizontal-container timespan-container">
                <div class="vertical-container timespan-single-container">
                    <p class="field-small-header">Od</p>
                    <div class="horizontal-container">
                        <select class="month-selector" name="start-month">
                            <?php printMonthsOptions(); ?>
                        </select>
                        <input class="year-selector" type="number" name="start-year" placeholder="Rok">
                    </div>
                </div>
                <div class="vertical-container timespan-single-container">
                    <p class="field-small-header">Do</p>
                    <div class="horizontal-container">
                        <select class="month-selector" name="end-month">
                            <?php printMonthsOptions(); ?>
                        </select>
                        <input class="year-selector" type="number" name="end-year" placeholder="Rok">
                    </div>
                </div>
            </div>
            <label class="input-label"><span class="label-header">Tagi</span>
                <input name="tags" type="text" placeholder="Słowa kluczowe, podkategorie wykresu">
            </label>
            <label class="input-label"><span class="label-header">Kraj</span>
                <input name="country" type="text" placeholder="Państwo, którego dotyczy wykres">
            </label>
            <label class="input-label"><span class="label-header">Źródło</span>
                <input name="source" type="text" placeholder="Link do artykułu, badań, surowych danych">
            </label>
            <label class="input-label"><span class="label-header">Dodatkowe informacje o wykresie</span>
                <textarea name="description"></textarea>
            </label>
            <h3>Dodaj wykres</h3>
            <div id="add-chart-area">
                <div id="chart-data-area">
                    <p class="field-header">Typ wykresu</p>
                    <label class="radio-label">
                        <input name="chart-type" type="radio" value="IMAGE" checked>
                        Obrazek
                    </label>
                    <label class="radio-label">
                        <input name="chart-type" type="radio" value="DATA">
                        Dane w pliku csv
                    </label>
                    <label for="chart-file-button" id="chart-file-label">Dodaj gotowy wykres</label>
                    <input id="chart-file-button" name="chart-file" accept="image/*" type="file">
                    <input id="submit-button" name="submit" type="submit" value="Prześlij wykres">
                </div>
                <div id="chart-preview-area">
                </div>
            </div>

        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="/libs/papaparse/papaparse.js"></script>
        <script type="module" src="/js/edit-chart.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
