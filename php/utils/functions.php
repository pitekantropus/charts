<?php
function addProtocolToUrlIfNeeded($url) {
    if($url && substr( $url, 0, 4 ) != "http") {
        return 'http://' . $url;
    }
    return $url;
}

function assertPost() {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('location: /');
        die();
    }
}
?>