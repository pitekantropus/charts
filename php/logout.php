<?php
require_once 'LoginUtils.php';
session_start();
$_SESSION = array();
session_destroy();
destroyCookie('remember_id');
destroyCookie('remember_hash');

header('location: ../index.php');
exit;
?>