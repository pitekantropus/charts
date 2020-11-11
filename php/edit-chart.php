<?php
require_once('utils/Session.php');
$session = new Session();
if(!$session->checkPermission('admin')) {
    header("location: /");
}
require_once 'utils/functions.php';
assertPost();

require_once 'utils/DBConnection.php';
require_once 'utils/FileUpload.php';
require_once 'utils/Imager.php';
require_once 'utils/Constants.php';

$chartFile = new FileUpload('chart-file');

$db = new DBConnection();

$id = $db->safeString($_POST['id']);
$title = $db->safeString($_POST['title']);
$urlName = convertTitleToUrlName($title);
$country = $db->safeString($_POST['country']);
$source = $db->safeString($_POST['source']);
$description = $db->safeString($_POST['description']);
$chartType = $db->safeString($_POST['chart-type']);
$startMonth = $db->safeString($_POST['start-month']);
$startYear = $db->safeString($_POST['start-year']);
$endMonth = $db->safeString($_POST['end-month']);
$endYear = $db->safeString($_POST['end-year']);
$base64Image = $_POST['base64-image'];

$categories = '';
if(empty($_POST['categories'])) {
    die('No categories');
}
foreach($_POST['categories'] as $category) {
    $categories = $categories . $db->safeString($category) . ';';
}
$categories = substr($categories, 0, -1);

$fileName = '';
switch($chartType) {
    case Constants::IMAGE_TYPE:
        $fileName = Constants::IMAGE_FILENAME;
        break;
    case Constants::DATA_TYPE:
        $fileName = Constants::DATA_FILENAME;
        break;
}

$valuesMap = array(
    'title' => $title,
    'urlName' => $urlName,
    'categories' => $categories,
    'startMonth' => $startMonth,
    'startYear' => $startYear,
    'endMonth' => $endMonth,
    'endYear' => $endYear,
    'country' => $country,
    'source' => $source,
    'description' => $description,
    'type' => $chartType,
    'modifyTimestamp' => 'now()'
);
$result = $db->updateTable('charts', $valuesMap, "id = '$id'");
if(!$result) {
    die('Failed to update chart.');
}

if($chartFile->isUploaded()) {
    $chartFile->moveDataFile($id, $fileName);
    $imager = new Imager($id);
    if(!empty($base64Image)) {
        $imager->saveBase64Image($base64Image);
    }
    $imager->generateScaledImages();
}

header("location: /charts/$urlName-$id/");
?>