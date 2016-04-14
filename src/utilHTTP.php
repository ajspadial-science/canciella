<?php

function parseMIME($mime) 
{
    if (strpos($mime, ";") !== false) {
        list($names, $params) = explode(";", $mime);
    } else {
        $names = $mime;
        $params = "";
    }

    list($type_name, $subtype_name) = explode("/", $names);
    return array(
        'full-type' => $names,
        'type' => $type_name,
        'subtype' => $subtype_name,
        'params' => $params,
    );
}
