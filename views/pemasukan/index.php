<?php
require_once '../../config/database.php';
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/tiberias";
require_once '../../includes/auth.php';
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/tiberias";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Filter and Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$where_clause = "";
if ($search) {
    $where_clause = "WHERE bidang LIKE '%$search%' OR sumber LIKE '%$search%' ";
}

$query = "SELECT * FROM pemasukan $where_clause ORDER BY tanggal DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

$count_query = "SELECT COUNT(*) as total FROM pemasukan $where_clause";
$count_result = mysqli_query($conn, $count_query);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$total_amount_query = "SELECT SUM(jumlah) as total_pemasukan FROM pemasukan $where_clause";
$total_amount_result = mysqli_query($conn, $total_amount_query);
$total_pemasukan = mysqli_fetch_assoc($total_amount_result)['total_pemasukan'] ?? 0;

$bidang_query = "SELECT bidang, SUM(jumlah) as total_per_bidang FROM pemasukan $where_clause GROUP BY bidang ORDER BY total_per_bidang DESC";
$bidang_result = mysqli_query($conn, $bidang_query);
?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">Catatan Pemasukan</h1>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Pemasukan</a>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Keseluruhan</h6>
                        <h3 class="mb-0">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h3>
                    </div>
                    <div class="stat-icon bg-white text-success">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title mb-3 fw-bold text-muted"><i class="fas fa-chart-pie me-2"></i>Pemasukan per Bidang</h6>
                <div class="d-flex flex-wrap gap-2">
                    <?php if(mysqli_num_rows($bidang_result) > 0): ?>
                        <?php while($b = mysqli_fetch_assoc($bidang_result)): ?>
                            <div class="border rounded p-2 flex-fill" style="min-width: 160px; background-color: #fcfcfc; border-left: 4px solid #198754 !important;">
                                <div class="text-secondary small fw-bold text-truncate" title="<?= htmlspecialchars($b['bidang']) ?>"><?= htmlspecialchars($b['bidang']) ?></div>
                                <div class="text-success fw-bold">Rp <?= number_format($b['total_per_bidang'], 0, ',', '.') ?></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-muted small">Belum ada data pemasukan.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6 ms-auto">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari bidang atau sumber..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                    <?php if($search): ?>
                        <a href="index.php" class="btn btn-outline-danger ms-2">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Bidang</th>
                        <th>Sumber</th>
                        <th>Jumlah (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $no = $start + 1; while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['bidang']) ?></span></td>
                                <td><?= htmlspecialchars($row['sumber']) ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-3">Tidak ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($total_pages > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                </li>
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
