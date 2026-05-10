<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: views/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi AMGPM Tiberias - Welcome</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: var(--bg-primary);
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(20, 184, 166, 0.15), transparent 40%);
            position: relative;
            overflow: hidden;
            padding-top: 100px;
            padding-bottom: 50px;
        }
        .hero-bg-shapes {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1; pointer-events: none;
        }
        .shape-1 {
            position: absolute; top: 10%; right: 10%;
            width: 400px; height: 400px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), transparent);
            filter: blur(60px);
            animation: pulse-glow 6s infinite alternate;
        }
        .shape-2 {
            position: absolute; bottom: 10%; left: 5%;
            width: 350px; height: 350px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), transparent);
            filter: blur(60px);
            animation: pulse-glow 8s infinite alternate-reverse;
        }
        .hero-content {
            z-index: 10;
            position: relative;
        }
        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            text-shadow: 0 0 40px rgba(255,255,255,0.1);
            line-height: 1.1;
        }
        .hero-title span {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 40px;
            font-weight: 300;
            line-height: 1.6;
        }
        .feature-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 30px;
            transition: all 0.4s ease;
            height: 100%;
            text-align: left;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.02), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 0 20px rgba(59, 130, 246, 0.1);
        }
        .feature-card:hover::before {
            opacity: 1;
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        .navbar-brand-custom {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-main) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .navbar-brand-custom i {
            color: var(--primary-color);
            margin-right: 10px;
        }
        .nav-link-custom {
            color: var(--text-muted);
            font-weight: 500;
            margin: 0 15px;
            text-decoration: none;
            transition: color 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .nav-link-custom:hover {
            color: white;
        }
        
        /* New Animations & About Section CSS */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes pulse-glow {
            0% { opacity: 0.6; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.1); }
        }
        .badge-50th {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #d97706, #fbbf24);
            color: #fff;
            padding: 8px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
            animation: float 4s ease-in-out infinite;
        }
        .badge-50th i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        .about-section {
            padding: 100px 0;
            position: relative;
            background: linear-gradient(to bottom, transparent, rgba(15, 23, 42, 0.95));
            border-top: 1px solid rgba(255,255,255,0.02);
            z-index: 5;
        }
        .about-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 60px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            transition: transform 0.5s ease;
        }
        .about-card:hover {
            transform: translateY(-5px);
            border-color: rgba(245, 158, 11, 0.3);
            box-shadow: 0 30px 60px rgba(0,0,0,0.6), inset 0 0 30px rgba(245, 158, 11, 0.05);
        }
        .about-card::before {
            content: '50';
            position: absolute;
            top: -30px;
            right: -10px;
            font-size: 20rem;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            line-height: 1;
            background: linear-gradient(135deg, rgba(255,255,255,0.04), transparent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            z-index: 0;
            pointer-events: none;
            transform: rotate(-5deg);
        }
        .about-content {
            position: relative;
            z-index: 10;
        }
        .about-content h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .about-content h2 span.highlight-gold {
            background: linear-gradient(135deg, #fcd34d, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .about-text {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.85);
            line-height: 1.9;
            margin-bottom: 25px;
        }
        .milestone-date {
            display: inline-flex;
            align-items: center;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            padding: 12px 25px;
            border-radius: 15px;
            color: #fcd34d;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .milestone-date:hover {
            background: rgba(245, 158, 11, 0.25);
            transform: scale(1.05);
        }
        .milestone-date i {
            margin-right: 12px;
            font-size: 1.3rem;
            color: #f59e0b;
        }
        .footer {
            background: #090e17;
            padding: 30px 0;
            border-top: 1px solid rgba(255,255,255,0.05);
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
        }
        
        @media (max-width: 991px) {
            .hero-title { font-size: 3rem; }
            .about-content h2 { font-size: 2.2rem; }
            .about-card::before { font-size: 12rem; top: 0; right: 0; }
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.1rem; }
            .feature-card { margin-bottom: 20px; }
            .about-card { padding: 40px 30px; }
            .about-content h2 { font-size: 1.8rem; }
            .milestone-date { width: 100%; justify-content: center; }
            .nav-link-custom { display: none; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: rgba(15, 23, 42, 0.8) !important; backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px 0; z-index: 1000;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand-custom" href="#">
                <i class="fas fa-cross"></i> AMGPM Tiberias
            </a>
            <div class="d-flex align-items-center">
                <a href="#about" class="nav-link-custom d-none d-md-block">Tentang Kami</a>
                <a href="#features" class="nav-link-custom d-none d-md-block">Fitur Utama</a>
                <a href="login.php" class="btn btn-primary rounded-pill px-4 ms-3 fw-bold shadow-sm">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Sistem
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg-shapes">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
        </div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                    <div class="badge-50th">
                        <i class="fas fa-award"></i> 50 Tahun Melayani (8 Desember)
                    </div>
                    <h1 class="hero-title">Sistem Informasi<br><span>Manajemen Ranting</span></h1>
                    <p class="hero-subtitle">Membangun organisasi yang tertata dan terpadu untuk pelayanan yang lebih baik. Kelola pangkalan data anggota, pengurus, program kerja, hingga jadwal secara presisi, terpusat dan efisien.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="login.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg d-flex align-items-center justify-content-center">
                            Mulai Gunakan <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#about" class="btn btn-outline-light btn-lg rounded-pill px-5 d-flex align-items-center justify-content-center" style="border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.05);">
                            Tentang Ranting
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4" id="features">
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <i class="fas fa-database feature-icon"></i>
                                <h4 class="fw-bold mb-3 text-white">Database Terpusat</h4>
                                <p class="text-muted mb-0">Pengelolaan data sejati dan sangat aman untuk seluruh anggota, pengurus, serta pembina ranting.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-lg-5">
                            <div class="feature-card">
                                <i class="fas fa-chart-pie feature-icon"></i>
                                <h4 class="fw-bold mb-3 text-white">Statistik Absensi</h4>
                                <p class="text-muted mb-0">Sistem terotomasi untuk melacak dan mengakumulasikan tren kehadiran ibadah demi kenyamanan evaluasi.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <i class="fas fa-tasks feature-icon"></i>
                                <h4 class="fw-bold mb-3 text-white">Manajemen Program</h4>
                                <p class="text-muted mb-0">Pantau tugas dan program kerja setiap bidang terintegrasi dengan penjadwalan yang teliti dan terstrukur.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-lg-5">
                            <div class="feature-card">
                                <i class="fas fa-wallet feature-icon"></i>
                                <h4 class="fw-bold mb-3 text-white">Pusat Keuangan</h4>
                                <p class="text-muted mb-0">Kontrol sistematis terhadap data pemasukan dan pengeluaran finansial secara mendetail oleh admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section (50th Anniversary) -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-card">
                        <div class="row align-items-center">
                            <div class="col-md-5 d-none d-md-block text-center position-relative">
                                <img src="assets/images/logo_tiberias.jpg" alt="Logo AMGPM Ranting Tiberias" class="img-fluid rounded-4 shadow-lg" style="object-fit: contain; height: 350px; width: 100%; background-color: #000;">
                                <div class="position-absolute" style="top: -15px; left: -15px; width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,0,0,0.3); z-index: 20;">
                                    <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 2rem; color: white; line-height: 1;">50</span>
                                </div>
                            </div>
                            <div class="col-md-7 about-content ps-md-5">
                                <h2>Sejarah <span class="highlight-gold">Ranting Tiberias</span></h2>
                                <p class="about-text">
                                    Berdiri kokoh sebagai wadah persekutuan dan pelayanan, <strong>AMGPM Ranting Tiberias</strong> merupakan wujud kesatuan pemuda Gereja Protestan Maluku dalam melayani Tuhan dan jemaat-Nya.
                                </p>
                                <p class="about-text">
                                    Kami telah mengabdi dan berkarya selama setengah abad. <strong>Dibentuk tepat pada tanggal 8 Desember</strong>, perjalanan 50 tahun Ranting Tiberias bukanlah waktu yang singkat; melainkan bukti nyata penyertaan Tuhan melalui regenerasi pengurus dan anggota yang mendedikasikan hidupnya untuk menjadi Garam dan Terang dunia.
                                </p>
                                <div class="milestone-date mt-3">
                                    <i class="fas fa-calendar-check"></i> Tanggal Pembentukan: 8 Desember
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">
                &copy; <?php echo date('Y'); ?> Sistem Informasi Manajemen AMGPM Ranting Tiberias. Didesain dengan <i class="fas fa-heart text-danger mx-1"></i> untuk Pelayanan.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
