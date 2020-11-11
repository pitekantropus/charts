<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

class Imager {
    private const DATA_DIR = ROOT . '/data/';
    private $imagesDir;
    private $originalImage;
    private $bigImage;
    private $thumbnail;

    function __construct($id) {
        $this->id = $id;
        $this->imagesDir = SELF::DATA_DIR . "$id/";
        $this->originalImage = $this->imagesDir . 'original.jpg';
        $this->bigImage = $this->imagesDir . 'image.jpg';
        $this->thumbnail = $this->imagesDir . 'thumbnail.jpg';
        $this->log("imagesDir: $this->imagesDir");
        $this->log("originalImage: $this->originalImage");
        $this->log("bigImage: $this->bigImage");
        $this->log("thubnail: $this->thumbnail");
    }

    private function log($content) {
        file_put_contents(ROOT . '/log.txt', $content . '\n', FILE_APPEND);
    }

    public function saveBase64Image($base64Data) {
        $this->log("base64Data: $base64Data");
        $pngData = base64_decode(explode(',', $base64Data)[1]);
        $this->log("pngData: $pngData");
        if($pngData === false) {
            return;
        }
        $tempFile = $this->imagesDir . time() . '.png';
        $this->log("tempFile: $tempFile");
        file_put_contents($tempFile, $pngData);
        $this->convertPngToJpg($tempFile, $this->originalImage);
        unlink($tempFile);
    }

    public function generateScaledImages() {
        $bigImage = $this->getScaledImageContain($this->originalImage, 1536, 864);
        $this->log("bigImage: $bigImage");
        $thumbnail = $this->getScaledImageCover($this->originalImage, 350, 300);
        $this->log("thumbnail: $thumbnail");
        imagejpeg($bigImage, $this->bigImage, 80);
        imagejpeg($thumbnail, $this->thumbnail, 100);
    }

    private function convertPngToJpg($sourcePath, $destinationPath) {
        $image = imagecreatefrompng($sourcePath);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 80; // 0 = worst / smaller file, 100 = better / bigger file
        imagejpeg($bg, $destinationPath, $quality);
        imagedestroy($bg);
    }

    private function getScaledImageContain($file, $max_width, $max_height) {
        $image = imagecreatefromjpeg($file);
        $max_ratio = $max_width / $max_height;
        list($width, $height) = getimagesize($file);
        $ratio = $width / $height;
        if($width > $max_width || $height > $max_height) {
            if($ratio > $max_ratio) {
                $new_height = round($max_width / $ratio);
                $newImage = imagecreatetruecolor($max_width, $new_height);
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $max_width, $new_height, $width, $height);
                return $newImage;
            } else {
                $new_width = round($max_height * $ratio);
                $newImage = imagecreatetruecolor($new_width, $max_height);
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $new_width, $max_height, $width, $height);
                return $newImage;
            }
        }
        return $image;
    }

    private function getScaledImageCover($file, $max_width, $max_height) {
        $image = imagecreatefromjpeg($file);
        $max_ratio = $max_width / $max_height;
        list($width, $height) = getimagesize($file);
        $ratio = $width / $height;
        if($width > $max_width && $height > $max_height) {
            if($ratio < $max_ratio) {
                $new_height = round($max_width / $ratio);
                $newImage = imagecreatetruecolor($max_width, $new_height);
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $max_width, $new_height, $width, $height);
                return $newImage;
            } else {
                $new_width = round($max_height * $ratio);
                $newImage = imagecreatetruecolor($new_width, $max_height);
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $new_width, $max_height, $width, $height);
                return $newImage;
            }
        }

        return $image;
    }
}
?>