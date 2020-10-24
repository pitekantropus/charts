<?php
require_once('php/utils/Session.php');
$session = new Session();
if($session->isLogged()) {
    header("location: /");
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Zaloguj się</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/login.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <form id="login-form" method="POST" enctype="multipart/form-data" action="/php/login.php">
            <h1>Logowanie</h1>
            <label class="input-label">E-mail
                <input name="email" type="text" placeholder="E-mail">
            </label>
            <label class="input-label">Hasło
                <input name="password" type="password">
            </label>
            <label class="checkbox-label">
                <input name="remember" type="checkbox" value="yes">
                Pamiętaj mnie
            </label>
            <input id="submit-button" name="submit" type="submit" value="Zaloguj się">
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/login.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
