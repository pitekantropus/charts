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
echo '</tr>';

foreach($rows as $row) {
    $sourceUrl = $row['source'];
    $title = $row['title'];
    $categories = $row['categories'];
    $timespan = $row['timespan'];
    $country = $row['country'];
    $id = $row['id'];
    echo '<tr>';
    echo "<td class='title-cell'><a href='/charts/$id/'>$title</a><a href='/edit-charts/$id/'> [Edytuj]</a></td>";
    echo '<td class="labels-cell">';
    printLabels($categories);
    echo '</td>';
    echo "<td>$timespan</td>";
    echo "<td>$country</td>";
    echo "<td class='source-cell'><a href='$sourceUrl'>$sourceUrl</a></td>";
    echo '</tr>';
}

?>