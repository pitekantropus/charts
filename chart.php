<?php
require_once('php/utils/Session.php');
require_once('php/utils/Chart.php');
require_once('php/utils/include-functions.php');
$session = new Session();
$logged = $session->isLogged();
if(!isset($_GET['url'])) {
    die('No urlName provided!');
}
$url = $_GET['url'];
$dashPos = strrpos($url, '-');
if($dashPos == false) {
    die('No dash in urlName');
}
$urlName = substr($url, 0, $dashPos);
$id = substr($url, $dashPos+1, strlen($url) - $dashPos - 1);
$chart = new Chart($id, $urlName);
if($chart->error) {
    echo "error: $chart->error";
    die("No such chart: urlName = $urlName");
}

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
<?php
includeTopBar($logged);
?>
        <div id="chart-section">
<?php
$chart->printChartSection();
?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="/libs/papaparse/papaparse.js"></script>
        <script type="module" src="/js/draw-chart.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
