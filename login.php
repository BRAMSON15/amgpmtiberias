<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: views/dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        header("Location: views/dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi AMGPM Tiberias</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-bg">
    <div class="login-card">
        <div class="login-logo text-center">
            AMGPM<br><span>Ranting Tiberias</span>
        </div>
        <form method="POST" action="">
            <?php if ($error): ?>
                <div class="alert alert-danger py-2 text-center"><?= $error ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Username</label>
                <input type="text" name="username" class="form-control form-control-lg" required autofocus placeholder="Masukkan username">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-muted">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" required placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase rounded-3 shadow-sm mb-3">Masuk Sistem</button>
            <a href="index.php" class="btn btn-outline-secondary w-100 py-3 fw-bold text-uppercase rounded-3 shadow-sm">Kembali ke Beranda</a>
        </form>
    </div>
</body>
</html>
