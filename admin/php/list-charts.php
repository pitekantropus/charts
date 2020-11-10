<?php
require_once('../../php/utils/Session.php');
$session = new Session();
if(!$session->checkPermission('admin')) {
    header("location: /");
}
require_once('../../php/utils/DBConnection.php');
require_once('../../php/utils/functions.php');

$db = new DBConnection();
$rows = $db->fetchFromTable('charts', '*');

function printLabels($labels) {
    if(empty($labels)) {
        return;
    }
    $array = explode(';', $labels);
    foreach($array as $label) {
        $polishLabel = getPolishCategory($label);
        echo "<button class='chart-label'>$polishLabel</button>";
    }
}

echo '<tr>';
echo '<th class="title-col">Nazwa</td>';
echo '<th class="categories-col">Kategorie</td>';
echo '<th class="timespan-col">Przedział czasowy</td>';
echo '<th class="country-col">Państwo</td>';
echo '<th class="source-col">Źródło</td>';
echo '<th class="action-col">Akcja</td>';
echo '</tr>';

foreach($rows as $row) {
    $sourceUrl = $row['source'];
    $title = $row['title'];
    $categories = $row['categories'];
    $timespan = encodeTimespan($row['startMonth'], $row['startYear'], $row['endMonth'], $row['endYear']);
    $country = $row['country'];
    $id = $row['id'];
    $urlName = $row['urlName'];
    echo '<tr>';
    echo "<td class='title-cell'><a href='/charts/$urlName-$id/'>$title</a></td>";
    echo '<td class="labels-cell">';
    printLabels($categories);
    echo '</td>';
    echo "<td>$timespan</td>";
    echo "<td>$country</td>";
    echo "<td class='source-cell'><a href='$sourceUrl'>$sourceUrl</a></td>";
    echo '<td class="action-cell">';
    echo "<a class='action' href='/edit-charts/$id/'><div class='icon-container'><img src='/admin/images/edit-icon.svg'></div><span>Edytuj</span></a>";
    echo "<button class='action hide' data-id='$id'><div class='icon-container'><img src='/admin/images/hide-icon.svg'></div><span>Ukryj</span></button>";
    echo "<button class='action remove' data-id='$id'><div class='icon-container'><img src='/admin/images/delete-icon.svg'></div><span>Usuń</span></button>";
    echo '</td>';
    echo '</tr>';
}

?>