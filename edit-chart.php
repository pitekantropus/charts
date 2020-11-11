<?php
require_once('php/utils/Session.php');
$session = new Session();
if(!$session->checkPermission('admin')) {
    header("location: /");
}
if(!isset($_GET['id'])) {
    die('No id provided!');
}
$id = $_GET['id'];

require_once('php/utils/Chart.php');
require_once('php/utils/include-functions.php');

function printMonthsOptions($month) {
    echo "<option value='0'>Miesiąc (opcjonalnie)</option>";
    foreach($GLOBALS['MONTHS_MAP'] as $monthNumber => $fullMonth) {
        if($month == $monthNumber) {
            echo "<option value='$monthNumber' selected>$fullMonth</option>";
        } else {
            echo "<option value='$monthNumber'>$fullMonth</option>";
        }
    }
}

function printCategoriesCheckboxes($categoriesMap) {
    foreach($GLOBALS['CATEGORIES_MAP'] as $category => $fullCategory) {
        $checked = $categoriesMap[$category];
        echo '<label class="category-label">';
        echo "<input type='checkbox' name='categories[]' value='$category'$checked>";
        echo "<div class='custom-checkbox'></div>$fullCategory";
        echo '</label>';
    }
}

$chart = new Chart($id);
$categoriesMap = $chart->categoriesMapWithValues(' checked');
$startYear = $chart->startYear == 0 ? '' : $chart->startYear;
$endYear = $chart->endYear == 0 ? '' : $chart->endYear;

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
    <body data-id="<?= $id?>">
<?php
includeTopBar(true);
?>
        <form id="edit-chart-form" method="POST" enctype="multipart/form-data" action="/php/edit-chart.php">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="base64-image" value="">
            <h1>Edytuj wykres</h1>
            <h3>Opis wykresu</h3>
            <label class="input-label"><span class="label-header">Nazwa</span>
                <input name="title" type="text" placeholder="Tytuł wykresu" value="<?= $chart->title ?>">
            </label>
            <p class="field-header">Kategorie</p>
<?php
printCategoriesCheckboxes($categoriesMap);
?>
            <p class="field-header">Zakres lat</p>
            <div class="horizontal-container timespan-container">
                <div class="vertical-container timespan-single-container">
                    <p class="field-small-header">Od</p>
                    <div class="horizontal-container">
                        <select class="month-selector" name="start-month">
                            <?php printMonthsOptions($chart->startMonth); ?>
                        </select>
                        <input class="year-selector" type="number" name="start-year" placeholder="Rok" value="<?= $startYear?>">
                    </div>
                </div>
                <div class="vertical-container timespan-single-container">
                    <p class="field-small-header">Do</p>
                    <div class="horizontal-container">
                        <select class="month-selector" name="end-month">
                            <?php printMonthsOptions($chart->endMonth); ?>
                        </select>
                        <input class="year-selector" type="number" name="end-year" placeholder="Rok" value="<?= $endYear?>">
                    </div>
                </div>
            </div>
            <label class="input-label"><span class="label-header">Tagi</span>
                <input name="tags" type="text" placeholder="Słowa kluczowe, podkategorie wykresu">
            </label>
            <label class="input-label"><span class="label-header">Kraj</span>
                <input name="country" type="text" placeholder="Państwo, którego dotyczy wykres" value="<?= $chart->country?>">
            </label>
            <label class="input-label"><span class="label-header">Źródło</span>
                <input name="source" type="text" placeholder="Link do artykułu, badań, surowych danych" value="<?= $chart->source?>">
            </label>
            <label class="input-label"><span class="label-header">Dodatkowe informacje o wykresie</span>
                <textarea name="description"><?= $chart->description?></textarea>
            </label>
            <h3>Wykres</h3>
            <div id="edit-chart-area" data-chart-type="<?= $chart->chartType?>">
                <div id="chart-data-area">
                    <p class="field-header">Typ wykresu</p>
                    <label class="radio-label">
                        <input name="chart-type" type="radio" value="IMAGE">
                        Obrazek
                    </label>
                    <label class="radio-label">
                        <input name="chart-type" type="radio" value="DATA">
                        Dane w pliku csv
                    </label>
                    <label for="chart-file-button" id="chart-file-label">Wybierz gotowy wykres</label>
                    <input id="chart-file-button" name="chart-file" accept="image/*" type="file">
                    <input id="submit-button" name="submit" type="submit" value="Zapisz wykres">
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
