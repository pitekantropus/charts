<?php
file_put_contents("../../abc.txt", "abcd");
require_once('../utils/functions.php');
assertPost();

if(!isset($_POST['data']) || !isset($_POST['path'])) {
    die('No data or path');
}

$data = $_POST['data'];
$path = '../../' . $_POST['path'];
if(!is_dir($path)) {
    mkdir($path);
}

$pngData = base64_decode(explode(',', $data)[1]);
if($pngData === false) {
    die('Decoding failed');
}

file_put_contents($path, $pngData);
echo $path;
?>
