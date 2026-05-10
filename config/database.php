<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "amgpm_tiberias";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Error: " . mysqli_connect_error());
}

$base_url = "http://localhost/tiberias";
?>
