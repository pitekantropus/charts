<?php
die('not working');
if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location: /");
    die();
}

require_once 'utils/DBConnection.php';

$db = new DBConnection();

$email = $db->safeString($_POST['email']);
$nick = $db->safeString($_POST['nick']);
$password = $db->safeString($_POST['password']);
$password2 = $db->safeString($_POST['password2']);

if($password != $password2) {
    die("Different passwords");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$hash = md5(date("YmdHis"));

$result = $db->query("INSERT INTO users (email, password, nick, power, createTimestamp,
                                modifyTimestamp, hash)
                                VALUES ('$email', '$hashedPassword', '$nick', 1, now(), now(),
                                '$hash')");
if(!$result) {
    die('Failed to create account.');
}
echo "Account created.";
?>
