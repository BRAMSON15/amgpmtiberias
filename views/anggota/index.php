<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
$query = "SELECT * FROM anggota ORDER BY id ASC";
$result = mysqli_query($conn, $query);

$query_lk = "SELECT COUNT(*) as count FROM anggota WHERE jenis_kelamin='Laki-laki'";
$result_lk = mysqli_query($conn, $query_lk);
$total_lk = mysqli_fetch_assoc($result_lk)['count'];

$query_pr = "SELECT COUNT(*) as count FROM anggota WHERE jenis_kelamin='Perempuan'";
$result_pr = mysqli_query($conn, $query_pr);
$total_pr = mysqli_fetch_assoc($result_pr)['count'];

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Anggota</h3>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary fw-bold shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Anggota</a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-check-circle me-2"></i>Berhasil!</strong> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="card shadow-sm h-100 border-0" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6); color: white;">
            <div class="card-body py-3 d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-male fs-4 text-white"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-normal text-white-50">Total Laki-laki</h6>
                    <h3 class="mb-0 fw-bold"><?= $total_lk ?> <span class="fs-6 fw-normal text-white-50">Orang</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-0" style="background: linear-gradient(135deg, #ec4899, #e11d48); color: white;">
            <div class="card-body py-3 d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-female fs-4 text-white"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-normal text-white-50">Total Perempuan</h6>
                    <h3 class="mb-0 fw-bold"><?= $total_pr ?> <span class="fs-6 fw-normal text-white-50">Orang</span></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Daftar Anggota Ranting</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center py-3">No</th>
                        <th class="py-3">Nama Anggota</th>
                        <th class="py-3 border-start py-3">J. Kelamin</th>
                        <th class="py-3 border-start py-3">Umur</th>
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
                    ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                        <td class="fw-bold fs-6" style="color: #38bdf8; text-shadow: 0 0 10px rgba(56,189,248,0.3);"><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= $row['jenis_kelamin'] == 'Laki-laki' ? '<span class="badge bg-primary rounded-pill px-3 py-2"><i class="fas fa-male me-1"></i> Laki-laki</span>' : '<span class="badge" style="background-color: #e91e63; border-radius: 50rem; padding: 0.5em 1em;"><i class="fas fa-female me-1"></i> Perempuan</span>' ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['umur']) ?> thn</td>
                        <td>
                            <?php if(strtolower($row['status']) == 'aktif'): ?>
                                <span class="badge bg-success rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($row['status']) ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary rounded-pill px-3 py-2"><?= htmlspecialchars($row['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-3x mb-3 opacity-25"></i><br>
                            Belum ada data anggota.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
