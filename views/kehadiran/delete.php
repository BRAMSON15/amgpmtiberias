<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "DELETE FROM kehadiran WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=Data kehadiran berhasil dihapus");
    } else {
        header("Location: index.php?error=Gagal menghapus data");
    }
} else {
    header("Location: index.php");
}
exit();
?>
