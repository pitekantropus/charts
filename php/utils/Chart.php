<?php
require_once('DBConnection.php');
require_once('Constants.php');
require_once('functions.php');

class Chart {
    public $id;
    public $title;
    public $tags;
    public $country;
    public $categories;
    public $source;
    public $description;
    public $chartType;
    public $filePath;
    private const DATA_DIR =  '../../data/';

    function __construct($id) {
        $this->id = $id;
        $this->fetchData();
    }

    private function fetchData() {
        $db = new DBConnection();
        $result = $db->fetchSingleRowById('charts', $this->id);
        if(!$result) {
            die('Failed to fetch data from chart: ' . $this->id);
        }
        $this->title = $result['title'];
        $this->categories = $result['categories'];
        $this->country = $result['country'];
        $this->source = $result['source'];
        $this->description = $result['description'];
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
        foreach($array as $label) {
            $polishLabel = getPolishCategory($label);
            echo "<a class='chart-label' href='/charts/$type/$label/'>$polishLabel</a>";
        }
    }

    public function printChartSection() {
        echo "<h1 id='title'>$this->title</h1>";
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

        echo '<p id="source">Źródło: <a href="' . $this->source . '">' . $this->source . '</a></p>';
        $this->printLabels('categories');
        echo '<p id="description">' . $this->description . '</p>';
    }
}
?>
