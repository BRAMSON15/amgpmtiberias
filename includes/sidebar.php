<?php 
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<div class="sidebar col-md-3 col-lg-2 p-0 d-md-flex flex-column collapse" id="sidebarCollapse">
    <div class="sidebar-heading">
        AMGPM<br><span>Ranting Tiberias</span>
    </div>
    <ul class="nav flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/dashboard.php" class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/pengurus/index.php" class="nav-link <?= ($current_dir == 'pengurus') ? 'active' : '' ?>">
                <i class="fas fa-user-tie me-2"></i> Data Pengurus
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/anggota/index.php" class="nav-link <?= ($current_dir == 'anggota') ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i> Data Anggota
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/pembina/index.php" class="nav-link <?= ($current_dir == 'pembina') ? 'active' : '' ?>">
                <i class="fas fa-user-shield me-2"></i> Data Pembina
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/proker/index.php" class="nav-link <?= ($current_dir == 'proker') ? 'active' : '' ?>">
                <i class="fas fa-tasks me-2"></i> Program Kerja
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/kehadiran/index.php" class="nav-link <?= ($current_dir == 'kehadiran') ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> Kehadiran Ibadah
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/jadwal/index.php" class="nav-link <?= ($current_dir == 'jadwal') ? 'active' : '' ?>">
                <i class="fas fa-calendar-alt me-2"></i> Jadwal Ibadah
            </a>
        </li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/pengeluaran/index.php" class="nav-link <?= ($current_dir == 'pengeluaran') ? 'active' : '' ?>">
                <i class="fas fa-money-bill-wave me-2"></i> Catatan Pengeluaran
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= $base_url ?>/views/pemasukan/index.php" class="nav-link <?= ($current_dir == 'pemasukan') ? 'active' : '' ?>">
                <i class="fas fa-hand-holding-usd me-2"></i> Catatan Pemasukan
            </a>
        </li>
        <?php endif; ?>
    </ul>
    
    <div class="mt-auto p-3">
        <a href="<?= $base_url ?>/logout.php" class="btn btn-danger w-100 p-2 text-start">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
