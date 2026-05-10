<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil info foto sebelum dihapus dari DB
    $cek_foto = mysqli_query($conn, "SELECT foto FROM pengurus WHERE id = $id");
    $data_foto = mysqli_fetch_assoc($cek_foto);
    
    $query = "DELETE FROM pengurus WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // Hapus file foto jika ada
        if ($data_foto && !empty($data_foto['foto']) && file_exists('../../assets/images/pengurus/' . $data_foto['foto'])) {
            unlink('../../assets/images/pengurus/' . $data_foto['foto']);
        }
        
        header("Location: index.php?success=Data berhasil dihapus");
    } else {
        header("Location: index.php?error=Gagal menghapus data");
    }
} else {
    header("Location: index.php");
}
exit();
?>
