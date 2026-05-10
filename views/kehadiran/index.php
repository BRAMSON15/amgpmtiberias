<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
$query = "SELECT * FROM kehadiran ORDER BY tanggal_ibadah DESC";
$result = mysqli_query($conn, $query);

// Data for Chart
$chart_labels = [];
$chart_data_persentase = [];
$chart_data_hadir = [];
$chart_data_absen = [];

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Statistik Kehadiran Ibadah</h3>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary fw-bold shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Data Kehadiran</a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-check-circle me-2"></i>Berhasil!</strong> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white pb-3 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Daftar Kehadiran Mingguan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%" class="text-center py-3">No</th>
                                <th class="py-3">Tanggal Ibadah</th>
                                <th class="py-3 text-center border-start">Minggu Ke</th>
                                <th class="py-3 text-center border-start">Rincian Kehadiran</th>
                                <th class="py-3 text-center border-start bg-primary text-white" width="20%">Capaian Persentase</th>
                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <th width="12%" class="text-center py-3 border-start">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <?php 
                            $no = 1;
                            $chart_temp = []; // temporary array to store data for chart processing
                            if (mysqli_num_rows($result) > 0):
                                while($row = mysqli_fetch_assoc($result)): 
                                    $persentase = ($row['total_anggota'] > 0) ? ($row['jumlah_hadir'] / $row['total_anggota']) * 100 : 0;
                                    $persentase = round($persentase, 1);
                                    $absen = $row['total_anggota'] - $row['jumlah_hadir'];
                                    
                                    // store data for chart (this will be in DESC order)
                                    $chart_temp[] = [
                                        'label' => "Mg " . $row['minggu_ke'] . " (" . date('d/m/y', strtotime($row['tanggal_ibadah'])) . ")",
                                        'persentase' => $persentase,
                                        'hadir' => $row['jumlah_hadir'],
                                        'absen' => $absen
                                    ];
                            ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                                <td>
                                    <span style="background-color: #f8fafc; color: #1e293b; padding: 8px 16px; border-radius: 8px; font-weight: 700; display: inline-block; border: 1px solid #e2e8f0;">
                                        <i class="far fa-calendar-alt me-2 text-primary"></i><?= date('d F Y', strtotime($row['tanggal_ibadah'])) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-circle p-3 shadow-sm fs-6" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;">
                                        <?= $row['minggu_ke'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-3">
                                        <div class="text-center">
                                            <div class="fw-bold text-success" style="font-size: 1.15rem;"><?= $row['jumlah_hadir'] ?></div>
                                            <div class="text-muted fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Hadir</div>
                                        </div>
                                        <div class="text-center border-start border-end px-3">
                                            <div class="fw-bold text-danger" style="font-size: 1.15rem;"><?= $absen ?></div>
                                            <div class="text-muted fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Absen</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="fw-bold text-primary" style="font-size: 1.15rem;"><?= $row['total_anggota'] ?></div>
                                            <div class="text-muted fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Total</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle px-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted fw-bold" style="font-size: 0.8rem;">Presentase:</span>
                                        <span class="fw-bold fs-6 <?= $persentase >= 75 ? 'text-success' : ($persentase >= 50 ? 'text-warning' : 'text-danger') ?>"><?= $persentase ?>%</span>
                                    </div>
                                    <div class="progress shadow-sm" style="height: 12px; border-radius: 12px; background-color: #e2e8f0;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated <?= $persentase >= 75 ? 'bg-success' : ($persentase >= 50 ? 'bg-warning' : 'bg-danger') ?>" 
                                             role="progressbar" 
                                             style="width: <?= $persentase ?>%;" 
                                             aria-valuenow="<?= $persentase ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </td>
                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary mb-1 shadow-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger mb-1 shadow-sm" onclick="return confirm('Yakin ingin menghapus data kehadiran ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php 
                                endwhile;
                                
                                // prepare final chart data (get latest 10, then reverse to chronological order)
                                $chart_temp = array_slice($chart_temp, 0, 10);
                                $chart_temp = array_reverse($chart_temp);
                                
                                foreach($chart_temp as $item) {
                                    $chart_labels[] = $item['label'];
                                    $chart_data_persentase[] = $item['persentase'];
                                    $chart_data_hadir[] = $item['hadir'];
                                    $chart_data_absen[] = $item['absen'];
                                }
                            else:
                            ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-chart-bar fa-4x mb-3 opacity-25"></i><br>
                                    <span class="fs-5 fw-semibold">Belum ada data kehadiran mingguan.</span>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white pb-3 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-warning border-start border-4 border-warning ps-2">Grafik Persentase (10 Terbaru)</h5>
            </div>
            <div class="card-body" style="height: 400px;">
                <canvas id="kehadiranChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kehadiranChart').getContext('2d');
    const chartLabels = <?= json_encode($chart_labels) ?>;
    const chartDataPersentase = <?= json_encode($chart_data_persentase) ?>;
    const chartDataHadir = <?= json_encode($chart_data_hadir) ?>;
    const chartDataAbsen = <?= json_encode($chart_data_absen) ?>;
    
    if(chartLabels.length > 0) {
        new Chart(ctx, {
            type: 'bar', // Mixed chart base
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Persentase (%)',
                        data: chartDataPersentase,
                        borderColor: '#f59e0b',
                        backgroundColor: '#f59e0b',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: false,
                        tension: 0.3,
                        yAxisID: 'y1',
                        order: 1 // Draw line on top
                    },
                    {
                        type: 'bar',
                        label: 'Jumlah Hadir',
                        data: chartDataHadir,
                        backgroundColor: '#10b981',
                        borderRadius: 4,
                        yAxisID: 'y',
                        order: 2
                    },
                    {
                        type: 'bar',
                        label: 'Tidak Hadir (Absen)',
                        data: chartDataAbsen,
                        backgroundColor: '#ef4444',
                        borderRadius: 4,
                        yAxisID: 'y',
                        order: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Jumlah Anggota',
                            color: '#1e293b',
                            font: { weight: 'bold' }
                        },
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Persentase Kehadiran (%)',
                            color: '#f59e0b',
                            font: { weight: 'bold' }
                        },
                        min: 0,
                        max: 100,
                        grid: {
                            drawOnChartArea: false, // only draw grid lines for one axis
                        },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: '500'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 13,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 14, family: "'Inter', sans-serif" },
                        bodyFont: { size: 13, family: "'Inter', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                }
            }
        });
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
