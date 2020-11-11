<?php
require_once('../php/utils/Session.php');
$session = new Session();
if(!$session->checkPermission('admin')) {
    header("location: /");
}
require_once('php/include-functions.php');
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="/admin/css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link rel="stylesheet" href="/admin/css/charts.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
<?php
includeTopBar();
?>
        <div id="edit-bar-container">
            <div id="edit-bar">
                <button id="edit-button" class='action' data-id='$id'>
                    <div class='icon-container'><img src='/admin/images/edit-icon.svg'></div>
                    <span>Edytuj</span>
                </button>
                <button id="hide-button" class='action' data-id='$id'>
                    <div class='icon-container'><img src='/admin/images/hide-icon.svg'></div>
                    <span>Ukryj</span>
                </button>
                <button id="remove-button" class='action' data-id='$id'>
                    <div class='icon-container'><img src='/admin/images/delete-icon.svg'></div>
                    <span>Usuń</span>
                </button>
            </div>
        </div>
        <section id="charts-section">
            <table id="charts-table"></table>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/admin/js/charts.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    </body>
</html>
