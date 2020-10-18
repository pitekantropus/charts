<?php
function addProtocolToUrlIfNeeded($url) {
    if($url && substr( $url, 0, 4 ) != "http") {
        return 'http://' . $url;
    }
    return $url;
}
?>