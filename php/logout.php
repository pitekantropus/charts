<?php
require_once('utils/Session.php');

$session = new Session(false);
$session->logout();

header('location: /');
die();
?>