<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // Arahkan ke login jika belum login
    // Kami butuh $base_url untuk jalur absolut agar aman
    if (isset($base_url)) {
        header("Location: $base_url/login.php");
    } else {
        header("Location: /tiberias/login.php");
    }
    exit();
}

// Batasi akses pengguna biasa (bukan admin) dari proses tambah, ubah, dan hapus
$current_page = basename($_SERVER['PHP_SELF']);
if (in_array($current_page, ['create.php', 'edit.php', 'delete.php'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }
}
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
if (in_array($current_dir, ['pengeluaran', 'pemasukan'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
        if (isset($base_url)) {
            header("Location: $base_url/views/dashboard.php");
        } else {
            header("Location: /tiberias/views/dashboard.php");
        }
        exit();
    }
}
?>
