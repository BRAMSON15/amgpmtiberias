<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

// Fetch quick stats
$q_anggota = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
$t_anggota = mysqli_fetch_assoc($q_anggota)['total'];

$q_pengurus = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengurus");
$t_pengurus = mysqli_fetch_assoc($q_pengurus)['total'];

$q_proker = mysqli_query($conn, "SELECT COUNT(*) as total FROM program_kerja");
$t_proker = mysqli_fetch_assoc($q_proker)['total'];

$q_pembina = mysqli_query($conn, "SELECT COUNT(*) as total FROM pembina");
$t_pembina = mysqli_fetch_assoc($q_pembina)['total'];

$q_pengeluaran = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM pengeluaran");
$t_pengeluaran = mysqli_fetch_assoc($q_pengeluaran)['total'] ?? 0;

require_once '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <div class="text-muted fw-semibold"><i class="fas fa-calendar-alt me-2"></i> <?= date('d F Y') ?></div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 mb-4 g-3">
    <div class="col">
        <div class="card bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 me-3 opacity-50"><i class="fas fa-users"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0">Anggota</h5>
                    <h2 class="fw-bold mb-0"><?= $t_anggota ?></h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="anggota/index.php" class="text-white text-decoration-none small fw-semibold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 me-3 opacity-50"><i class="fas fa-user-tie"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0">Pengurus</h5>
                    <h2 class="fw-bold mb-0"><?= $t_pengurus ?></h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="pengurus/index.php" class="text-dark text-decoration-none small fw-bold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card" style="background-color: #17a2b8; color: white;">
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 me-3 opacity-50"><i class="fas fa-tasks"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0">Proker</h5>
                    <h2 class="fw-bold mb-0"><?= $t_proker ?></h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="proker/index.php" class="text-white text-decoration-none small fw-semibold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card" style="background-color: #6f42c1; color: white;"> <!-- Changed color from success to purple for distinctiveness -->
            <div class="card-body d-flex align-items-center">
                <div class="fs-1 me-3 opacity-50"><i class="fas fa-user-shield"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0">Pembina</h5>
                    <h2 class="fw-bold mb-0"><?= $t_pembina ?></h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="pembina/index.php" class="text-white text-decoration-none small fw-semibold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <?php
    $q_pemasukan = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM pemasukan");
    $t_pemasukan = mysqli_fetch_assoc($q_pemasukan)['total'] ?? 0;
    ?>
    <div class="col">
        <div class="card text-white h-100" style="background-color: #28a745;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="fs-2 me-3 opacity-50"><i class="fas fa-hand-holding-usd"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0" style="font-size: 0.95rem;">Pemasukan</h5>
                    <h4 class="fw-bold mb-0 text-nowrap" style="letter-spacing: -0.5px;">Rp<?= number_format($t_pemasukan, 0, ',', '.') ?></h4>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end pt-0">
                <a href="pemasukan/index.php" class="text-white text-decoration-none small fw-semibold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-white h-100" style="background-color: #dc3545;">
            <div class="card-body d-flex align-items-center p-3">
                <div class="fs-2 me-3 opacity-50"><i class="fas fa-money-bill-wave"></i></div>
                <div>
                    <h5 class="card-title fw-semibold mb-0" style="font-size: 0.95rem;">Pengeluaran</h5>
                    <h4 class="fw-bold mb-0 text-nowrap" style="letter-spacing: -0.5px;">Rp<?= number_format($t_pengeluaran, 0, ',', '.') ?></h4>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end pt-0">
                <a href="pengeluaran/index.php" class="text-white text-decoration-none small fw-semibold">Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Informasi Ranting</h5>
            </div>
            <div class="card-body p-4">
                <h3 class="fw-bold text-primary">AMGPM Ranting Tiberias</h3>
                <h6 class="text-muted fw-semibold mb-4 text-uppercase">Jemaat GPM Rehoboth</h6>
                <p class="fs-5">Selamat datang di Sistem Informasi AMGPM Ranting Tiberias. Sistem ini dibangun untuk mempermudah pengelolaan data keorganisasian meliputi:</p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3 text-primary"><i class="fas fa-user-tie fa-lg"></i></div>
                            <div><strong class="d-block">Data Pengurus & Pembina</strong> Manajemen 15 struktur inti dan pembina</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3 text-success"><i class="fas fa-users fa-lg"></i></div>
                            <div><strong class="d-block">Database Anggota</strong> Pengelolaan informasi anggota Pemuda</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3 text-info"><i class="fas fa-tasks fa-lg"></i></div>
                            <div><strong class="d-block">Program Kerja</strong> Pemantauan realisasi progam dan anggaran</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3 text-warning"><i class="fas fa-chart-line fa-lg"></i></div>
                            <div><strong class="d-block">Statistik Kehadiran</strong> Evaluasi otomatis kehadiran ibadah</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3 text-secondary"><i class="fas fa-calendar-alt fa-lg"></i></div>
                            <div><strong class="d-block">Jadwal Ibadah</strong> File dokumen interaktif jadwal 1 tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-warning"></i> Kehadiran Terakhir</h5>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center p-4">
                <?php
                $q_hadir = mysqli_query($conn, "SELECT * FROM kehadiran ORDER BY tanggal_ibadah DESC LIMIT 1");
                if (mysqli_num_rows($q_hadir) > 0) {
                    $hadir = mysqli_fetch_assoc($q_hadir);
                    $persentase = ($hadir['total_anggota'] > 0) ? ($hadir['jumlah_hadir'] / $hadir['total_anggota']) * 100 : 0;
                    $persentase = round($persentase, 1);
                ?>
                <div class="position-relative d-inline-block mx-auto mb-3" style="width: 150px; height: 150px;">
                    <svg viewBox="0 0 36 36" class="circular-chart" style="fill: none; stroke-width: 3.8; stroke-linecap: round; width: 100%; height: 100%;">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" style="stroke: #eee;"></path>
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" style="stroke: <?= $persentase >= 50 ? 'var(--primary-color)' : '#dc3545' ?>; stroke-dasharray: <?= $persentase ?>, 100;"></path>
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h2 class="fw-bold mb-0"><?= $persentase ?>%</h2>
                    </div>
                </div>
                
                <p class="text-muted fw-bold">Ibadah Minggu Ke-<?= $hadir['minggu_ke'] ?><br><span class="fw-normal"><?= date('d F Y', strtotime($hadir['tanggal_ibadah'])) ?></span></p>
                <div class="mt-2 text-start bg-light p-3 rounded">
                    <div class="d-flex justify-content-between border-bottom border-white pb-2 mb-2">
                        <span class="text-muted fw-semibold">Hadir</span> <span class="fw-bold"><?= $hadir['jumlah_hadir'] ?> Orang</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted fw-semibold">Total Anggota</span> <span class="fw-bold"><?= $hadir['total_anggota'] ?> Orang</span>
                    </div>
                </div>
                <?php } else { ?>
                <div class="text-muted py-5 my-5">
                    <i class="fas fa-folder-open fa-3x mb-3 text-light"></i><br>
                    Belum ada data kehadiran.
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div class="col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="fas fa-chart-line me-2 text-primary"></i> Grafik Keuangan Mingguan</h5>
            </div>
            <div class="card-body p-4">
                <canvas id="keuanganChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'):
// Fetch financial data for chart
$chart_data_query = "
    SELECT 
        DATE_FORMAT(tanggal, '%Y-%u') AS minggu,
        MIN(tanggal) AS awal_minggu,
        SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) AS total_pemasukan,
        SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) AS total_pengeluaran
    FROM (
        SELECT tanggal, jumlah, 'pemasukan' AS jenis FROM pemasukan
        UNION ALL
        SELECT tanggal, jumlah, 'pengeluaran' AS jenis FROM pengeluaran
    ) AS gabungan
    GROUP BY minggu
    ORDER BY minggu ASC
    LIMIT 12
";
$q_chart = mysqli_query($conn, $chart_data_query);

$labels = [];
$pemasukan_data = [];
$pengeluaran_data = [];

while ($row = mysqli_fetch_assoc($q_chart)) {
    $labels[] = 'Minggu ke-' . date('W', strtotime($row['awal_minggu'])) . ' (' . date('M Y', strtotime($row['awal_minggu'])) . ')';
    $pemasukan_data[] = $row['total_pemasukan'];
    $pengeluaran_data[] = $row['total_pengeluaran'];
}
?>

<?php require_once '../includes/footer.php'; ?>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    
    const data = {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Pendapatan',
                data: <?= json_encode($pemasukan_data) ?>,
                borderColor: '#28a745', // Green
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#28a745',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Pengeluaran',
                data: <?= json_encode($pengeluaran_data) ?>,
                borderColor: '#dc3545', // Red
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#dc3545',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#dc3545',
                fill: true,
                tension: 0.4
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: "'Inter', sans-serif",
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000) + ' Jt';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000) + ' Rb';
                            }
                            return 'Rp ' + value;
                        },
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
        }
    };

    new Chart(ctx, config);
});
</script>
<?php endif; ?>
<?php endif; ?>
