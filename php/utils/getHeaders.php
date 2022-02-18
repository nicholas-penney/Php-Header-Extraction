<?php

function parseHeader($headerString, $assocArray) {
    // Split into array of key & value
    $headerArray = explode("\n", $headerString);

    $headerObject = [];
    $statusString = "";

    // Parse each line and separate into Key/Value Object/Associative Array
    foreach ($headerArray as $line) {
        $key = "";
        $value = "";
        //$statusHeader = "HTTP/1.1";
        $statusHeader = "HTTP/";
        $breakPoint = strpos($line, ":");

        $httpPos = strpos($line, $statusHeader);
        if ($httpPos !== false) {
            // Edge case: Status code at Line 0, stash now, allocate after loop
            $statusHeaderLen = strpos($line, " ");
            $statusString = substr($line, $statusHeaderLen+1);
        } else if (boolval($breakPoint) === true) {
            // Key/Value pair found
            $key = substr($line, 0, $breakPoint);
            $value = substr($line, $breakPoint+2);
        }
        if (!empty($key)) {
            // Add any Key/Value pairs
            $headerObject[$key] = $value;
        }
    }

    // Instantiate default status vals
    $statusCode = 0;
    $statusMessage = "";

    // Parse status string
    $statusWhiteSpacePos = strpos($statusString, " ");
    $statusCode = intval(substr($statusString, 0, $statusWhiteSpacePos));
    $statusMessage = substr($statusString, $statusWhiteSpacePos+1);

    $headerObject["Status"]["Code"] = $statusCode;
    $headerObject["Status"]["Message"] = $statusMessage;

    // Add status to input assocArray parameter
    $assocArray["Header"] = $headerObject;
    return $assocArray;
}

?>