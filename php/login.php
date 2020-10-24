<?php
if($_SERVER['REQUEST_METHOD'] != 'POST') {
    die('failed');
}

require_once('utils/Session.php');

$email = $_POST['email'];
$password = $_POST['password'];
$remember = isset($_POST['remember']) && $_POST['remember'] == 'yes';

$session = new Session(false);
$result = $session->login($email, $password, $remember);

if(!$result) {
    die('Failed to log in.');
}

header('location: /');
die();
?>