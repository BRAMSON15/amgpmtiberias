<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
$query = "SELECT * FROM pembina ORDER BY id ASC";
$result = mysqli_query($conn, $query);

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Pembina</h3>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="create.php" class="btn btn-primary fw-bold shadow-sm"><i class="fas fa-plus me-2"></i>Tambah Pembina</a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-check-circle me-2"></i>Berhasil!</strong> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Daftar Pembina Ranting</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center py-3">No</th>
                        <th width="10%" class="text-center py-3 border-start">Foto</th>
                        <th class="py-3 border-start">Nama Pembina</th>
                        <th class="py-3 border-start">Jabatan</th>
                        <th class="py-3 border-start">Kontak/HP</th>
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
                                <a href="#" data-bs-toggle="modal" data-bs-target="#photoModalPembina<?= $row['id'] ?>" title="Klik untuk perbesar">
                                    <img src="../../assets/images/pembina/<?= $row['foto'] ?>" alt="Foto" width="50" height="50" class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </a>
                                
                                <!-- Modal Zoom Foto Pembina -->
                                <div class="modal fade" id="photoModalPembina<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                                      <div class="modal-header border-0 pb-0 position-absolute w-100 p-3" style="z-index: 10;">
                                        <button type="button" class="btn-close bg-white rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center p-0">
                                        <img src="../../assets/images/pembina/<?= $row['foto'] ?>" alt="Foto <?= htmlspecialchars($row['nama']) ?>" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
                                        <div class="p-4 bg-white text-dark">
                                            <h4 class="fw-bold mb-1" style="color: #34d399; text-shadow: 0 0 10px rgba(52,211,153,0.3);"><?= htmlspecialchars($row['nama']) ?></h4>
                                            <p class="text-primary fw-semibold mb-2 fs-5"><?= htmlspecialchars($row['jabatan']) ?></p>
                                            <div class="d-inline-flex bg-light px-3 py-2 rounded-pill mt-1">
                                                <i class="fas fa-phone-alt text-secondary mt-1 me-2"></i> 
                                                <span class="fw-semibold text-secondary"><?= htmlspecialchars($row['kontak']) ?></span>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-shield text-secondary"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold fs-6" style="color: #34d399; text-shadow: 0 0 10px rgba(52,211,153,0.3);"><?= htmlspecialchars($row['nama']) ?></td>
                        <td><span class="badge bg-secondary rounded-pill px-3 py-2"><?= htmlspecialchars($row['jabatan']) ?></span></td>
                        <td><a href="tel:<?= htmlspecialchars($row['kontak']) ?>" class="text-decoration-none fw-semibold btn btn-sm btn-light border rounded-pill"><i class="fab fa-whatsapp text-success me-1"></i> <?= htmlspecialchars($row['kontak']) ?></a></td>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pembina ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-user-shield fa-3x mb-3 opacity-25"></i><br>
                            Belum ada data pembina.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
