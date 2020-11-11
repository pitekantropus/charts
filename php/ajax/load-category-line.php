<?php
require_once('../utils/functions.php');
assertPost();
require_once('../utils/DBConnection.php');

if(!isset($_POST['category']) || !isset($_POST['count'])) {
    die();
}

$category = $_POST['category'];
$count = $_POST['count'];
$linesCount = isset($_POST['lines']) ? $_POST['lines'] : 2;
$chartsInLine = $count / $linesCount;

$db = new DBConnection();
$rows = $db->fetchFromTable('charts', '*', "categories LIKE '%$category%'", $count);

foreach($rows as $row) {
    $title = $row['title'];
    $id = $row['id'];
    $tilePath = "../../data/$id/thumbnail.jpg";
    $url = '/charts/' . $row['urlName'] . "-$id/";
    echo "<a href='$url'>";
    echo '<div class="single-chart">';
    echo "<img class='chart-tile' src='$tilePath' alt='$title'>";
    echo "<p class='chart-title'>$title</p>";
    echo '</div></a>';
}

$fakeCharts = $chartsInLine - count($rows) % $chartsInLine;
for($i = 0; $i < $fakeCharts; $i++) {
    echo '<div class="fake-chart"></div>';
}

?>
