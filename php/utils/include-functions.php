<?php
function includeTopBar($logged) {
    echo '<div id="top-bar">';
    echo '<div id="top-logo">';
    echo '<a href="/"><h3>NOMBRE</h3></a>';
    echo '</div>';
    echo '<div id="top-login-buttons">';

    if($logged) {
        echo '<a href="/admin/dashboard/" class="top-button">Dashboard</a>';
        echo '<a href="/php/logout.php" class="top-button">Wyloguj</a>';
    } else {
        echo '<a href="/login/" id="login-button" class="top-button">Zaloguj się</a>';
        echo '<a href="/register/" id="register-button" class="top-button">Załóż konto</a>';
    }
    echo '</div>';
    echo '</div>';
}
?>
