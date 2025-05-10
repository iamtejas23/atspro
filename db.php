<?php
$mysqli = new mysqli("localhost", "root", "", "ats_scanner");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>
