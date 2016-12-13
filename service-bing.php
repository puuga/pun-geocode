<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$q = $_GET["q"];
$key = $_GET["key"];

$url = "https://dev.virtualearth.net/REST/v1/Locations/";
$url .= urlencode($q);
$url .= "?output=json&c=th&key=$key";

// echo $url;

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $url);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

// $output = file_get_contents(urlencode($url));

header('Content-Type: application/json');
echo $output;
?>
