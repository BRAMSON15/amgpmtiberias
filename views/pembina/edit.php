<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM pembina WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    
    $foto_name = $data['foto']; // Gunakan foto lama sebagai default
    
    // Cek apakah ada foto baru yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto_name = time() . '_' . rand(100,999) . '.' . $ext;
            $destination = '../../assets/images/pembina/' . $foto_name;
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                // Hapus foto lama jika ada
                if (!empty($data['foto']) && file_exists('../../assets/images/pembina/' . $data['foto'])) {
                    unlink('../../assets/images/pembina/' . $data['foto']);
                }
            }
        } else {
            $error = "Format foto tidak didukung. Gunakan JPG, PNG, atau GIF.";
        }
    }
    
    if (!isset($error)) {
        if ($foto_name) {
            $update = "UPDATE pembina SET nama='$nama', jabatan='$jabatan', kontak='$kontak', foto='$foto_name' WHERE id=$id";
        } else {
            $update = "UPDATE pembina SET nama='$nama', jabatan='$jabatan', kontak='$kontak' WHERE id=$id";
        }
        
        if (mysqli_query($conn, $update)) {
            header("Location: index.php?success=Data pembina berhasil diperbarui");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Edit Pembina</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Edit Data Pembina</h5>
    </div>
    <div class="card-body p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-user-shield"></i></span>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Jabatan Pembina</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-star"></i></span>
                    <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($data['jabatan']) ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Kontak / No. HP</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                    <input type="text" name="kontak" class="form-control" value="<?= htmlspecialchars($data['kontak']) ?>" required>
                </div>
            </div>
            
            <div class="mb-4 border p-3 rounded bg-light">
                <label class="form-label fw-bold text-dark mb-3">Foto Pembina</label>
                <div class="d-flex align-items-start">
                    <div class="me-4 text-center">
                        <?php if(!empty($data['foto'])): ?>
                            <img src="../../assets/images/pembina/<?= $data['foto'] ?>" alt="Foto" width="100" height="100" class="rounded object-fit-cover shadow-sm mb-2 d-block">
                        <?php else: ?>
                            <div class="bg-white rounded d-flex align-items-center justify-content-center border shadow-sm mb-2" style="width: 100px; height: 100px;">
                                <i class="fas fa-user-shield fa-3x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Foto Saat Ini</small>
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label fw-semibold">Ganti Foto Baru <span class="text-muted fw-normal fs-6">(Opsional)</span></label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Biarkan kosong jika tidak ingin mengubah foto.</div>
                    </div>
                </div>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-warning py-3 fw-bold fs-5 text-dark text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
