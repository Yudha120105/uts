<?php
include 'config.php';
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}
//id tersedia
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$conn->query("DELETE FROM alat WHERE id=$id");
header("Location: index.php");
exit;
?>
