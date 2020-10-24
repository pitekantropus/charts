<?php
require_once('DBConnection.php');
require_once('Constants.php');

class Chart {
    public $id;
    public $title;
    private $subtitle;
    public $tags;
    private $country;
    private $source;
    private $description;
    private $chartType;
    private $filePath;
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
        $this->subtitle = $result['subtitle'];
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

    public function printChartSection() {
?>
            <h1 id="title"><?= $this->title ?></h1>
<?php
switch($this->chartType) {
    case Constants::IMAGE_TYPE:
        echo "<img id='chart-image\ src='$this->filePath'>";
        break;
    case Constants::DATA_TYPE:
        echo "<div id='chart-container'>";
        echo "<canvas id='chart-canvas'></canvas>";
        echo "</div>";
        break;
}
?>
            <p id="source"><a href="<?= $this->source ?>"><?= $this->source ?></a></p>
            <p id="description"><?= $this->description ?></p>
<?php
    }
}
?>
