<?php
require_once('../../../php/utils/functions.php');
require_once('../../../php/utils/DBConnection.php');
assertPost();

if(!isset($_POST['chartNumbers'])) {
    echo "No chartNumbers<br>";
    die();
}

$db = new DBConnection();
$chartNumbers = explode(';', $_POST['chartNumbers']);

foreach($chartNumbers as $chartId) {
    $db->removeFromTableById('charts', $chartId);
    $dirName = "../../../data/$chartId";
    array_map('unlink', glob("$dirName/*"));
    rmdir($dirName);
}

echo "OK";

?>