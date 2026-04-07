<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$databasename = 'ezbuslk_db';


$mysqli = new mysqli($hostname, $username, $password, $databasename);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
