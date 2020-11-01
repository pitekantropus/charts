<?php
require_once 'utils/functions.php';
assertPost();

require_once 'utils/DBConnection.php';
require_once 'utils/FileUpload.php';
require_once 'utils/Constants.php';

$chartFile = new FileUpload('chart-file');
if(!$chartFile->isUploaded()) {
    die('No file present');
}

$db = new DBConnection();

$title = $db->safeString($_POST['title']);
$urlName = convertTitleToUrlName($title);
$country = $db->safeString($_POST['country']);
$source = $db->safeString($_POST['source']);
$description = $db->safeString($_POST['description']);
$chartType = $db->safeString($_POST['chart-type']);

$categories = '';
if(empty($_POST['categories'])) {
    die('No categories');
}
foreach($_POST['categories'] as $category) {
    $categories = $categories . $db->safeString($category) . ';';
}
$categories = substr($categories, 0, -1);

$timespan = '';
if(!empty($_POST['start-month'])) {
    $timespan = $db->safeString($_POST['start-month']) . '.';
}
if(!empty($_POST['start-year'])) {
    $timespan .= $db->safeString($_POST['start-year']);
}
$timespan .= ';';
if(!empty($_POST['end-month'])) {
    $timespan .= $db->safeString($_POST['end-month']) . '.';
}
if(!empty($_POST['end-year'])) {
    $timespan .= $db->safeString($_POST['end-year']);
}

$fileName;
switch($chartType) {
    case Constants::IMAGE_TYPE:
        $fileName = Constants::IMAGE_FILENAME;
        break;
    case Constants::DATA_TYPE:
        $fileName = Constants::DATA_FILENAME;
        break;
}

$result = $db->query("INSERT INTO charts (title, urlName, categories, timespan, country, source, description,
                                type, createTimestamp, modifyTimestamp)
                                VALUES ('$title', '$urlName', '$categories', '$timespan', '$country', '$source',
                                '$description', '$chartType', now(), now())");
if(!$result) {
    die('Failed to insert chart.');
}

$lastId = $db->lastId();
$chartFile->moveDataFile($lastId, $fileName);

header("location: /charts/$lastId/");
?>