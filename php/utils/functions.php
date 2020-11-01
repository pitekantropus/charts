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

function getPolishCategory($category) {
    $categoryMap = array(
        'health' => 'Zdrowie i życie',
        'economy' => 'Ekonomia',
        'demography' => 'Demografia',
        'geology' => 'Geologia',
        'interesting' => 'Ciekawostki'
    );
    return $categoryMap[$category];
}

function my_mb_str_split($string, $split_length = 1, $encoding = null)
{
    if (null !== $string && !\is_scalar($string) && !(\is_object($string) && \method_exists($string, '__toString'))) {
        trigger_error('mb_str_split(): expects parameter 1 to be string, '.\gettype($string).' given', E_USER_WARNING);
        return null;
    }
    if (null !== $split_length && !\is_bool($split_length) && !\is_numeric($split_length)) {
        trigger_error('mb_str_split(): expects parameter 2 to be int, '.\gettype($split_length).' given', E_USER_WARNING);
        return null;
    }
    $split_length = (int) $split_length;
    if (1 > $split_length) {
        trigger_error('mb_str_split(): The length of each segment must be greater than zero', E_USER_WARNING);
        return false;
    }
    if (null === $encoding) {
        $encoding = mb_internal_encoding();
    } else {
        $encoding = (string) $encoding;
    }

    if (! in_array($encoding, mb_list_encodings(), true)) {
        static $aliases;
        if ($aliases === null) {
            $aliases = [];
            foreach (mb_list_encodings() as $encoding) {
                $encoding_aliases = mb_encoding_aliases($encoding);
                if ($encoding_aliases) {
                    foreach ($encoding_aliases as $alias) {
                        $aliases[] = $alias;
                    }
                }
            }
        }
        if (! in_array($encoding, $aliases, true)) {
            trigger_error('mb_str_split(): Unknown encoding "'.$encoding.'"', E_USER_WARNING);
            return null;
        }
    }

    $result = [];
    $length = mb_strlen($string, $encoding);
    for ($i = 0; $i < $length; $i += $split_length) {
        $result[] = mb_substr($string, $i, $split_length, $encoding);
    }
    return $result;
}

function removePolishSigns($string) {
    $polishSignsMap = array(
        'ą' => 'a',
        'ć' => 'c',
        'ę' => 'e',
        'ł' => 'l',
        'ń' => 'n',
        'ó' => 'o',
        'ś' => 's',
        'ź' => 'z',
        'ż' => 'z',
        'Ą' => 'A',
        'Ć' => 'C',
        'Ę' => 'E',
        'Ł' => 'L',
        'Ń' => 'N',
        'Ó' => 'O',
        'Ś' => 'S',
        'Ź' => 'Z',
        'Ż' => 'Z'
    );
    $result = '';
    foreach(my_mb_str_split($string) as $char) {
        if(isset($polishSignsMap[$char])) {
            $result .= $polishSignsMap[$char];
        } else {
            $result .= $char;
        }
    }
    return $result;
}

function convertTitleToUrlName($string) {
    $polishSignsRemoved = removePolishSigns($string);
    $lowercase = strtolower($polishSignsRemoved);
    return str_replace(' ', '+', $lowercase);
}

?>