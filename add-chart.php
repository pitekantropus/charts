<?php
require_once('php/utils/Session.php');
$session = new Session();
if(!$session->checkPermission('add-chart')) {
    header("location: /");
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dodaj wykres</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/add-chart.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <form id="add-chart-form" method="POST" enctype="multipart/form-data" action="php/add-chart.php">
            <h1>Dodaj wykres</h1>
            <h3>Opis wykresu</h3>
            <label class="input-label">Nazwa
                <input name="title" type="text" placeholder="Tytuł wykresu">
            </label>
            <label class="input-label">Podtytuł
                <input name="subtitle" type="text" placeholder="Szczegółowy tytuł">
            </label>
            <label class="input-label">Tagi
                <input name="tags" type="text" placeholder="Słowa kluczowe, podkategorie wykresu">
            </label>
            <label class="input-label">Kraj
                <input name="country" type="text" placeholder="Państwo, którego dotyczy wykres">
            </label>
            <label class="input-label">Źródło
                <input name="source" type="text" placeholder="Link do artykułu, badań, surowych danych">
            </label>
            <label class="input-label">Dodatkowe informacje o wykresie
                <textarea name="description"></textarea>
            </label>
            <h3>Dodaj wykres</h3>
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
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/add-chart.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
