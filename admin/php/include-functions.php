<?php

function includeTopBar() {
?>
        <header>
            <div id="logo">DobreWykresy</div>
            <div id="menu">
                <a href="/admin/dashboard/" class="menu-button">
                    <img src="/admin/images/dashboard-icon.svg">
                    <h3 id="dashboard-header">Dashboard</h3>
                </a>
                <a href="/admin/charts/" class="menu-button">
                    <img src="/admin/images/charts-icon.svg">
                    <h3 id="charts-header">Wykresy</h3>
                </a>
                <a href="/admin/stats/" class="menu-button">
                    <img src="/admin/images/stats-icon.svg">
                    <h3 id="stats-header">Statystyki</h3>
                </a>
                <a href="/admin/users/" class="menu-button">
                    <img src="/admin/images/users-icon.svg">
                    <h3 id="users-header">Użytkownicy</h3>
                </a>
            </div>
            <div class="empty-filler"></div>
            <div id="top-buttons">
                <a href="/add-chart/" id="add-chart-button" class="top-button">Dodaj wykres</a>
                <a href="/php/logout.php" id="logout-button" class="top-button">Wyloguj się</a>
            </div>
        </header>
<?php
}

?>