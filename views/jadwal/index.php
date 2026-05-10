<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

$success = '';
$error = '';
$file_path = '../../assets/docs/jadwal_ibadah.pdf';

// Handle File Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['jadwal_pdf'])) {
    // Pengecekan akses admin dilakukan lagi untuk keamanan ganda
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        if ($_FILES['jadwal_pdf']['error'] == 0) {
            $allowed = ['pdf'];
            $filename = $_FILES['jadwal_pdf']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                // Selalu menimpa dengan nama yang sama agar tidak menumpuk file
                if (move_uploaded_file($_FILES['jadwal_pdf']['tmp_name'], $file_path)) {
                    $success = "Jadwal Ibadah berhasil diperbarui!";
                } else {
                    $error = "Gagal mengunggah file. Pastikan folder assets/docs/ memiliki hak akses tulis.";
                }
            } else {
                $error = "Format file tidak didukung. Harap unggah file berformat PDF.";
            }
        } else {
            $error = "Terjadi kesalahan saat mengunggah: " . $_FILES['jadwal_pdf']['error'];
        }
    } else {
        $error = "Anda tidak memiliki izin untuk mengunggah file.";
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Jadwal Pelayanan Ibadah (Tahunan)</h3>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-check-circle me-2"></i>Berhasil!</strong> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-exclamation-triangle me-2"></i>Gagal!</strong> <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<!-- Form Upload Khusus Admin -->
<div class="card shadow-sm mb-4 border-primary">
    <div class="card-header bg-primary text-white pb-2 pt-3 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-upload me-2"></i>Unggah / Perbarui Jadwal PDF</h5>
    </div>
    <div class="card-body p-4 bg-light">
        <form method="POST" action="" enctype="multipart/form-data" class="d-flex align-items-end gap-3">
            <div class="flex-grow-1">
                <label class="form-label fw-bold text-dark">Pilih File Jadwal Ibadah (Tahun ini)</label>
                <input type="file" name="jadwal_pdf" class="form-control form-control-lg bg-white" accept="application/pdf" required>
                <div class="form-text text-muted mt-2"><i class="fas fa-info-circle me-1"></i>Hanya menerima file berformat <strong>.pdf</strong>. Jika file sudah ada, upload terbaru akan otomatis menggantikan file yang lama.</div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-lg shadow-sm fw-bold px-4"><i class="fas fa-save me-2"></i>Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Area Penampil PDF -->
<div class="card shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-success border-start border-4 border-success ps-2">Dokumen Jadwal Ibadah Aktif</h5>
        <?php if (file_exists($file_path)): ?>
            <a href="<?= $file_path ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill fw-bold" download="Jadwal_Ibadah_Tiberias.pdf"><i class="fas fa-download me-1"></i> Unduh File</a>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">
        <?php if (file_exists($file_path)): ?>
            <!-- Menampilkan PDF -->
            <div style="height: 75vh; width: 100%;">
                <object data="<?= $file_path ?>?v=<?= time() ?>" type="application/pdf" width="100%" height="100%" style="border-bottom-left-radius: 0.25rem; border-bottom-right-radius: 0.25rem;">
                    <div class="p-5 text-center bg-light h-100 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                        <h4 class="fw-bold text-dark mb-2">Browser Anda Tidak Mendukung Penampil PDF Internal</h4>
                        <p class="text-muted w-50">Sayangnya file jadwal tidak bisa di-preview secara langsung. Anda masih dapat membaca jadwal tersebut dengan mengunduhnya melalui tombol di bawah.</p>
                        <a href="<?= $file_path ?>" class="btn btn-primary mt-3 px-4 py-2 fw-bold" download="Jadwal_Ibadah_Tiberias.pdf">Unduh PDF Sekarang</a>
                    </div>
                </object>
            </div>
        <?php else: ?>
            <!-- Belum Ada PDF -->
            <div class="text-center py-5 my-5 text-muted">
                <i class="fas fa-file-excel fa-4x mb-3 opacity-25"></i><br>
                <h5 class="fw-bold opacity-50">Jadwal Belum Tersedia</h5>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <p class="mt-2 mb-0">Silakan unggah dokumen PDF Jadwal Ibadah pada kotak berwarna biru di atas.</p>
                <?php else: ?>
                    <p class="mt-2 mb-0">Pengurus belum mengunggah dokumen jadwal ibadah saat ini.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
