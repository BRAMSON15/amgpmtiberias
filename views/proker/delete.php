<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "DELETE FROM program_kerja WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=Program kerja berhasil dihapus");
    } else {
        header("Location: index.php?error=Gagal menghapus data");
    }
} else {
    header("Location: index.php");
}
exit();
?>
