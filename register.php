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
        <title>Dodaj wykres</title>
        <link rel="stylesheet" href="/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/css/register.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <form id="registration-form" method="POST" enctype="multipart/form-data" action="/php/register.php">
            <h1>Tworzenie konta</h1>
            <label class="input-label">E-mail, będący również loginem
                <input name="email" type="text" placeholder="E-mail">
            </label>
            <label class="input-label">Nick
                <input name="nick" type="text" placeholder="Nick">
            </label>
            <label class="input-label">Hasło (6-30 znaków)
                <input name="password" type="password">
            </label>
            <label class="input-label">Powtórz hasło
                <input name="password2" type="password">
            </label>
            <input id="submit-button" name="submit" type="submit" value="Utwórz konto">
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/register.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
