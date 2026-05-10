<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$jabatans = [
    'Ketua Ranting', 'Sekretaris Ranting',
    'Ketua Bidang 1', 'Sekretaris Bidang 1',
    'Ketua Bidang 2', 'Sekretaris Bidang 2',
    'Ketua Bidang 3', 'Sekretaris Bidang 3',
    'Ketua Bidang 4', 'Sekretaris Bidang 4',
    'Ketua Bidang 5', 'Sekretaris Bidang 5',
    'Bendahara Umum', 'Bendahara 1', 'Bendahara 2'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    
    $foto_name = NULL;
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto_name = time() . '_' . rand(100,999) . '.' . $ext;
            $destination = '../../assets/images/pengurus/' . $foto_name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destination);
        } else {
            $error = "Format foto tidak didukung. Gunakan JPG, PNG, atau GIF.";
        }
    }
    
    if (!isset($error)) {
        if ($foto_name) {
            $query = "INSERT INTO pengurus (nama, jenis_kelamin, jabatan, foto) VALUES ('$nama', '$jenis_kelamin', '$jabatan', '$foto_name')";
        } else {
            $query = "INSERT INTO pengurus (nama, jenis_kelamin, jabatan) VALUES ('$nama', '$jenis_kelamin', '$jabatan')";
        }
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?success=Data pengurus berhasil ditambahkan");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Tambah Pengurus</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Data Pengurus Baru</h5>
    </div>
    <div class="card-body p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Lengkap Pengurus</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: John Doe">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Jenis Kelamin</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-venus-mars"></i></span>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Jabatan</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-briefcase"></i></span>
                    <select name="jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatans as $jb): ?>
                        <option value="<?= $jb ?>"><?= $jb ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Foto Pengurus <span class="text-muted fw-normal fs-6">(Opsional)</span></label>
                <input type="file" name="foto" class="form-control form-control-lg" accept="image/*">
                <div class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal ukuran biasanya 2MB.</div>
            </div>
            
            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-primary py-3 fw-bold fs-5 text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
