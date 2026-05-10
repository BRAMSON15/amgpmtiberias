<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

// Flash message
$success = isset($_GET['success']) ? $_GET['success'] : '';

$query = "SELECT * FROM pengurus ORDER BY FIELD(jabatan, 
    'Ketua Ranting', 'Sekretaris Ranting',
    'Ketua Bidang 1', 'Sekretaris Bidang 1',
    'Ketua Bidang 2', 'Sekretaris Bidang 2',
    'Ketua Bidang 3', 'Sekretaris Bidang 3',
    'Ketua Bidang 4', 'Sekretaris Bidang 4',
    'Ketua Bidang 5', 'Sekretaris Bidang 5',
    'Bendahara Umum', 'Bendahara 1', 'Bendahara 2'
)";
$result = mysqli_query($conn, $query);

$query_lk = "SELECT COUNT(*) as count FROM pengurus WHERE jenis_kelamin='Laki-laki'";
$result_lk = mysqli_query($conn, $query_lk);
$total_lk = mysqli_fetch_assoc($result_lk)['count'];

$query_pr = "SELECT COUNT(*) as count FROM pengurus WHERE jenis_kelamin='Perempuan'";
$result_pr = mysqli_query($conn, $query_pr);
$total_pr = mysqli_fetch_assoc($result_pr)['count'];

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Pengurus</h3>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary fw-bold shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Pengurus</a>
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

<div class="card">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Daftar Pengurus Ranting</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center py-3">No</th>
                        <th width="10%" class="text-center py-3 border-start">Foto</th>
                        <th class="py-3 border-start">Nama Pengurus</th>
                        <th class="py-3 border-start">J. Kelamin</th>
                        <th class="py-3 border-start">Jabatan</th>
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
                        <td class="text-center">
                            <?php if(!empty($row['foto'])): ?>
                                <a href="javascript:void(0)" onclick="showPhotoModal('../../assets/images/pengurus/<?= $row['foto'] ?>', '<?= htmlspecialchars(addslashes($row['nama'])) ?>', '<?= htmlspecialchars(addslashes($row['jabatan'])) ?>')" title="Klik untuk perbesar">
                                    <img src="../../assets/images/pengurus/<?= $row['foto'] ?>" alt="Foto" width="50" height="50" class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </a>
                            <?php else: ?>
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold fs-6" style="color: #fbbf24; text-shadow: 0 0 10px rgba(251,191,36,0.3);"><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= $row['jenis_kelamin'] == 'Laki-laki' ? '<span class="badge bg-primary rounded-pill px-3 py-2"><i class="fas fa-male me-1"></i> Laki-laki</span>' : '<span class="badge" style="background-color: #e91e63; border-radius: 50rem; padding: 0.5em 1em;"><i class="fas fa-female me-1"></i> Perempuan</span>' ?></td>
                        <td><span class="badge" style="background-color: #e3f2fd; color: #0d47a1; border: 1px solid #90caf9; font-size: 0.85rem; padding: 0.5em 1em; font-weight: 600;"><?= htmlspecialchars($row['jabatan']) ?></span></td>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pengurus ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i><br>
                            Belum ada data pengurus. Silakan klik tombol "Tambah Pengurus"
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Zoom Foto Global -->
<div class="modal fade" id="globalPhotoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
      <div class="modal-header border-0 pb-0 position-absolute w-100 p-3" style="z-index: 10;">
        <button type="button" class="btn-close bg-white rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-0">
        <img id="modalPhotoImg" src="" alt="Foto" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
        <div class="p-4 bg-white text-dark">
            <h4 id="modalPhotoName" class="fw-bold mb-1" style="color: #fbbf24; text-shadow: 0 0 10px rgba(251,191,36,0.3);"></h4>
            <p id="modalPhotoJabatan" class="text-primary fw-semibold mb-0 fs-5"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showPhotoModal(imgSrc, name, jabatan) {
    document.getElementById('modalPhotoImg').src = imgSrc;
    document.getElementById('modalPhotoName').innerText = name;
    document.getElementById('modalPhotoJabatan').innerText = jabatan;
    
    var myModal = new bootstrap.Modal(document.getElementById('globalPhotoModal'));
    myModal.show();
}
</script>

<?php require_once '../../includes/footer.php'; ?>
