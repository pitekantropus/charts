<?php
require_once 'utils/DBConnection.php';
require_once 'utils/FileUpload.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location: ../index.php");
    die();
}

$chartFile = new FileUpload('chart-file');
if(!$chartFile->isUploaded()) {
    die('No file present');
}

$db = new DBConnection();

$title = $db->safeString($_POST['title']);
$subtitle = $db->safeString($_POST['subtitle']);
$tags = $db->safeString($_POST['tags']);
$country = $db->safeString($_POST['country']);
$source = $db->safeString($_POST['source']);
$description = $db->safeString($_POST['description']);
$chartType = $db->safeString($_POST['chart-type']);
$fileName = strtolower($chartType) . '.jpg';

$result = $db->query("INSERT INTO charts (title, subtitle, tags, country, source, description,
                                type, createTimestamp, modifyTimestamp)
                                VALUES ('$title', '$subtitle', '$tags', '$country', '$source',
                                '$description', '$chartType', now(), now())");
if(!$result) {
    die('Failed to insert chart.');
}

$lastId = $db->lastId();

$chartFile->moveDataFile($lastId, $fileName);
print('File uploaded');
?>