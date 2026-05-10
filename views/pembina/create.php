<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    
    $foto_name = NULL;
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto_name = time() . '_' . rand(100,999) . '.' . $ext;
            $destination = '../../assets/images/pembina/' . $foto_name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destination);
        } else {
            $error = "Format foto tidak didukung. Gunakan JPG, PNG, atau GIF.";
        }
    }
    
    if (!isset($error)) {
        if ($foto_name) {
            $query = "INSERT INTO pembina (nama, jabatan, kontak, foto) VALUES ('$nama', '$jabatan', '$kontak', '$foto_name')";
        } else {
            $query = "INSERT INTO pembina (nama, jabatan, kontak) VALUES ('$nama', '$jabatan', '$kontak')";
        }
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?success=Data pembina berhasil ditambahkan");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Tambah Pembina</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Data Pembina Baru</h5>
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
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: Pdt. John Doe, S.Th">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Jabatan Pembina</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-star"></i></span>
                    <input type="text" name="jabatan" class="form-control" required placeholder="Contoh: Majelis Pembina, Ketua Majelis Jemaat">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Kontak / No. HP</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                    <input type="text" name="kontak" class="form-control" required placeholder="Contoh: 08123456789">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Foto Pembina <span class="text-muted fw-normal fs-6">(Opsional)</span></label>
                <input type="file" name="foto" class="form-control form-control-lg" accept="image/*">
                <div class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal ukuran 2MB.</div>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-primary py-3 fw-bold fs-5 text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
