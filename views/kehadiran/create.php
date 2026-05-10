<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

// Coba hitung total anggota dari database untuk default value
$q_anggota = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
$t_anggota = 0;
if ($row = mysqli_fetch_assoc($q_anggota)) {
    $t_anggota = $row['total'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal_ibadah']);
    $minggu_ke = (int)$_POST['minggu_ke'];
    $jumlah_hadir = (int)$_POST['jumlah_hadir'];
    $total_anggota = (int)$_POST['total_anggota'];
    
    $query = "INSERT INTO kehadiran (tanggal_ibadah, minggu_ke, jumlah_hadir, total_anggota) VALUES ('$tanggal', $minggu_ke, $jumlah_hadir, $total_anggota)";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=Data kehadiran berhasil ditambahkan");
        exit();
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Tambah Data Kehadiran</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Input Kehadiran Ibadah Mingguan</h5>
    </div>
    <div class="card-body p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark">Tanggal Ibadah</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="fas fa-calendar-day"></i></span>
                        <input type="date" name="tanggal_ibadah" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Minggu Ke-</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="fas fa-list-ol"></i></span>
                        <input type="number" name="minggu_ke" class="form-control" required min="1" max="52" placeholder="Contoh: 1">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark">Jumlah Anggota Hadir</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light text-primary"><i class="fas fa-user-check"></i></span>
                        <input type="number" name="jumlah_hadir" id="jumlah_hadir" class="form-control" required min="0" placeholder="0">
                        <span class="input-group-text bg-light">Orang</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Total Seluruh Anggota</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light text-secondary"><i class="fas fa-users"></i></span>
                        <input type="number" name="total_anggota" id="total_anggota" class="form-control" required min="1" value="<?= $t_anggota ?>" placeholder="0">
                        <span class="input-group-text bg-light">Orang</span>
                    </div>
                    <div class="form-text mt-2"><i class="fas fa-info-circle"></i> Diambil otomatis dari jumlah data anggota saat ini. Bisa diubah jika perlu.</div>
                </div>
            </div>
            
            <div class="bg-light p-3 rounded-3 mb-4 text-center border">
                <span class="text-muted fw-bold d-block mb-1">Prediksi Persentase:</span>
                <h2 class="fw-bold text-primary mb-0" id="preview_persen">0%</h2>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary py-3 fw-bold fs-5 text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Kehadiran</button>
            </div>
        </form>
    </div>
</div>

<script>
// Live percentage preview
document.getElementById('jumlah_hadir').addEventListener('input', calculatePercent);
document.getElementById('total_anggota').addEventListener('input', calculatePercent);

function calculatePercent() {
    let hadir = parseFloat(document.getElementById('jumlah_hadir').value) || 0;
    let total = parseFloat(document.getElementById('total_anggota').value) || 0;
    
    if(total > 0) {
        let persen = (hadir / total) * 100;
        document.getElementById('preview_persen').innerText = persen.toFixed(1) + '%';
        
        if(persen >= 75) document.getElementById('preview_persen').className = "fw-bold text-success mb-0";
        else if (persen >= 50) document.getElementById('preview_persen').className = "fw-bold text-warning mb-0";
        else document.getElementById('preview_persen').className = "fw-bold text-danger mb-0";
    } else {
        document.getElementById('preview_persen').innerText = '0%';
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>
