<?php
// config.php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "db_kalibrasi";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
