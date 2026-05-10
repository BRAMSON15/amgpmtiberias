<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
$query = "SELECT * FROM program_kerja ORDER BY nama_bidang ASC, id ASC";
$result = mysqli_query($conn, $query);

$total_programs = mysqli_num_rows($result);
$query_stats = "SELECT nama_bidang, COUNT(*) as total FROM program_kerja GROUP BY nama_bidang ORDER BY nama_bidang ASC";
$result_stats = mysqli_query($conn, $query_stats);
$stats = [];
if ($result_stats) {
    while ($row = mysqli_fetch_assoc($result_stats)) {
        $stats[] = $row;
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Program Kerja Bidang</h3>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary fw-bold shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Program Kerja</a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-check-circle me-2"></i>Berhasil!</strong> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Statistik Program Kerja -->
<div class="row mb-4">
    <div class="col-12 mb-3">
        <div class="card text-white shadow-sm border-0" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Total Keseluruhan Program Ranting</h5>
                        <p class="mb-0 text-white-50" style="font-size: 0.95rem;">Jumlah keseluruhan program yang diangkat pada periode ini</p>
                    </div>
                </div>
                <h1 class="display-4 fw-bold mb-0 text-white"><?= $total_programs ?></h1>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="row g-3">
            <?php 
            $colors = ['#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e'];
            $i = 0;
            foreach($stats as $stat): 
                $color = $colors[$i % count($colors)];
            ?>
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; overflow: hidden; transition: transform 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: 0; left: 0; width: 5px; height: 100%; background-color: <?= $color ?>;"></div>
                        <div class="d-flex justify-content-between align-items-center ps-2">
                            <div>
                                <p class="text-uppercase fw-bold mb-1 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Bidang</p>
                                <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem; line-height: 1.3; min-height: 40px;"><?= htmlspecialchars($stat['nama_bidang']) ?></h6>
                                <div class="d-flex align-items-baseline gap-1">
                                    <h3 class="fw-bold mb-0" style="color: <?= $color ?>;"><?= $stat['total'] ?></h3>
                                    <span class="text-muted fw-medium" style="font-size: 0.85rem;">Program</span>
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px; background-color: <?= $color ?>15; color: <?= $color ?>;">
                                <i class="fas fa-layer-group fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $i++;
            endforeach; 
            ?>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Daftar Program Kerja (5 Bidang)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center py-3">No</th>
                        <th class="py-3">Bidang</th>
                        <th class="py-3 border-start py-3">Nama Program</th>
                        <th class="py-3 border-start py-3">Anggaran</th>
                        <th class="py-3 border-start py-3">Status</th>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <th width="15%" class="text-center py-3 border-start">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($result) > 0):
                        while($row = mysqli_fetch_assoc($result)): 
                            
                            $status_class = 'bg-secondary';
                            if ($row['status_program'] == 'Sudah berjalan') $status_class = 'bg-success';
                            if ($row['status_program'] == 'Sedang berjalan') $status_class = 'bg-warning text-dark';
                    ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                        <td class="fw-bold text-dark"><span class="badge border border-primary text-primary px-2 py-1"><?= htmlspecialchars($row['nama_bidang']) ?></span></td>
                        <td>
                            <div class="fw-bold fs-6" style="color: #fbbf24; text-shadow: 0 0 10px rgba(251,191,36,0.3);"><?= htmlspecialchars($row['nama_program']) ?></div>
                            <?php if(!empty($row['keterangan'])): ?>
                                <small class="d-block mt-1" style="color: #0d47a1;"><i class="fas fa-info-circle me-1"></i><?= htmlspecialchars($row['keterangan']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold text-success">Rp <?= number_format($row['anggaran'], 0, ',', '.') ?></td>
                        <td><span class="badge <?= $status_class ?> rounded-pill px-3 py-2"><?= htmlspecialchars($row['status_program']) ?></span></td>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus program ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-tasks fa-3x mb-3 opacity-25"></i><br>
                            Belum ada data program kerja.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
