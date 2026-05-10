<?php
require_once '../../config/database.php';
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/tiberias";
require_once '../../includes/auth.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = "DELETE FROM pengeluaran WHERE id = $id";

if (mysqli_query($conn, $query)) {
    $_SESSION['success'] = "Data pengeluaran berhasil dihapus!";
} else {
    $_SESSION['error'] = "Error: " . mysqli_error($conn);
}

header("Location: index.php");
exit;
?>
