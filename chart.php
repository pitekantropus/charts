<?php
require_once('php/utils/Session.php');
$session = new Session();
require_once('php/utils/Chart.php');
if(!isset($_GET['id'])) {
    die('No id provided!');
}
$id = $_GET['id'];
$chart = new Chart($id);

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wykres</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/chart.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body data-id="<?= $id ?>">
        <div id="chart-section">
<?php
$chart->printChartSection();
?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="/libs/papaparse/papaparse.js"></script>
        <script src="/js/draw-chart.js"></script>
    </body>
</html>
