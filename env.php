<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function db_connect() {
  // $host = "localhost";
  $host = "128.199.120.166";
  $port = "5432";
  $dbname = "geocodedb";
  $user = "pun";
  $password = "punpun";

  $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
  return pg_connect($conn_string);
}
?>
