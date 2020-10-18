<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

class FileUpload {
    private $file;
    private $formField;
    private $isUploaded = false;
    private const DATA_DIR = ROOT . '/data/';

    function __construct($formField) {
        $this->formField = $formField;
        $this->file = $_FILES[$formField];
        if(file_exists($this->file['tmp_name']) && is_uploaded_file($this->file['tmp_name'])) {
            $this->isUploaded = true;
        }
    }

    public function isUploaded() {
        return $this->isUploaded;
    }

    public function moveDataFile($chartId, $fileName) {
        $absolutePath = self::DATA_DIR . $chartId . '/';
        if(!is_dir($absolutePath)) {
            mkdir($absolutePath);
        }
        move_uploaded_file($this->file['tmp_name'], $absolutePath . $fileName);
    }
}
?>