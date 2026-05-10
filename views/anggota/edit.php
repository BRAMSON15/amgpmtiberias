<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM anggota WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $umur = (int) $_POST['umur'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update = "UPDATE anggota SET nama='$nama', jenis_kelamin='$jk', umur=$umur, status='$status' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: index.php?success=Data anggota berhasil diperbarui");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Edit Anggota</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Edit Data Anggota</h5>
    </div>
    <div class="card-body p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark">Jenis Kelamin</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="fas fa-venus-mars"></i></span>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Umur</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                        <input type="number" name="umur" class="form-control" value="<?= htmlspecialchars($data['umur']) ?>" required min="15" max="45">
                        <span class="input-group-text bg-light">Tahun</span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Status</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-info-circle"></i></span>
                    <select name="status" class="form-select" required>
                        <?php 
                        $status_options = ['Aktif', 'Pasif', 'Studi di Luar Daerah', 'Bekerja di Luar Daerah'];
                        foreach ($status_options as $opt) {
                            $sel = ($data['status'] == $opt) ? 'selected' : '';
                            echo "<option value=\"$opt\" $sel>$opt</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-warning py-3 fw-bold fs-5 text-dark text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
