<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "knizhnysite";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>
