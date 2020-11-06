<?php
require_once('DBConnection.php');
require_once('Constants.php');
require_once('functions.php');

class Chart {
    public $id;
    private $urlName;
    public $title;
    public $tags;
    public $country;
    public $categories;
    public $startMonth;
    public $startYear;
    public $endMonth;
    public $endYear;
    public $source;
    public $description;
    private $addDate;
    public $chartType;
    public $filePath;
    public $error = null;
    private const DATA_DIR =  '../../data/';

    function __construct($id, $urlName = '') {
        $this->urlName = $urlName;
        $this->id = $id;
        $this->fetchData();
    }

    private function fetchData() {
        $db = new DBConnection();
        $result = $db->fetchSingleRowById('charts', $this->id);
        if(!$result) {
            die('Failed to fetch data from chart: ' . $this->id);
        }
        if($result['urlName'] != $this->urlName) {
            $this->error = 'Wrong urlName';
        }
        $this->title = $result['title'];
        $this->categories = $result['categories'];
        $this->country = $result['country'];
        $this->startMonth = $result['startMonth'];
        $this->startYear = $result['startYear'];
        $this->endMonth = $result['endMonth'];
        $this->endYear = $result['endYear'];
        $this->source = $result['source'];
        $this->description = $result['description'];
        $this->addDate = date('d-m-Y', strtotime($result['createTimestamp']));
        $this->chartType = $result['type'];
        $fileDir = self::DATA_DIR . $this->id . '/';
        switch($this->chartType) {
            case Constants::IMAGE_TYPE:
                $this->filePath = $fileDir . Constants::IMAGE_FILENAME;
                break;
            case Constants::DATA_TYPE:
                $this->filePath = $fileDir . Constants::DATA_FILENAME;
                break;
        }
    }

    private function printLabels($type) {
        if(empty($this->categories)) {
            return;
        }
        $array = explode(';', $this->categories);
        echo '<div id="labels">';
        foreach($array as $label) {
            $polishLabel = getPolishCategory($label);
            echo "<a class='chart-label' href='/charts/$type/$label/'>$polishLabel</a>";
        }
        echo '</div>';
    }

    public function printChartSection() {
        echo "<h1 id='title'>$this->title</h1>";
        echo "<div id='chart-and-data-container'>";
        switch($this->chartType) {
            case Constants::IMAGE_TYPE:
                echo "<img id='chart-image' src='$this->filePath'>";
                break;
            case Constants::DATA_TYPE:
                echo "<div id='chart-container'>";
                echo "<canvas id='chart-canvas'></canvas>";
                echo "</div>";
                break;
        }

        echo '<div id="data-container">';
        echo '<p id="description">' . $this->description . '</p>';
        $this->printLabels('categories');
        echo "<p id='addDate'>Data dodania: <span>$this->addDate</span></p>";
        echo '<p id="source">Źródło: <a href="' . $this->source . '">' . $this->source . '</a></p>';
        echo '</div>';
        echo '</div>';
    }

    public function categoriesMapWithValues($value) {
        $categoriesMap = array();
        foreach(explode(';', $this->categories) as $category) {
            $categoriesMap[$category] = $value;
        }
        return $categoriesMap;
    }
}
?>
