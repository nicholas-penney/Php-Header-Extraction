<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include('../utils/getHeaders.php');

$headerJson = 'Content-Type: application/json; charset=UTF-8';

$url = "https://api.site.com/api/request?key=YOURKEY";

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);
$responseArray = json_decode($response, true);

// Instantiate assoc array for response to AJAX
$returnArray = [];

// Set default status
$returnArray['Status']['Code'] = 200;
$returnArray['Status']['Message'] = "OK";

// Get response header
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headerStr = substr($response, 0, $header_size);
$returnArray = parseHeader($headerStr, $returnArray);

// Get response body and set as data
$bodyRaw = substr($response, $header_size);
$returnArray["data"] = json_decode(substr($response, $header_size), true);

$json = json_encode($returnArray, JSON_UNESCAPED_UNICODE);

curl_close($ch);
header($headerJson);
echo $json;

?>