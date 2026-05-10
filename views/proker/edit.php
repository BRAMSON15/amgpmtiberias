<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM program_kerja WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$data = mysqli_fetch_assoc($result);

$bidangs = [
    'Bidang 1: ORGANISASI DAN KERUMAHTANGGAAN',
    'Bidang 2: PELAYANAN PENDIDIKAN, PEMBANGUNAN MASYARAKAT DAN IPTEKS',
    'Bidang 3: KEESAAN DAN PEMBINAAN UMAT',
    'Bidang 4: PEKABARAN INJIL DAN KOMUNIKASI',
    'Bidang 5: FINANSIAL DAN EKONOMI'
];

$statuses = ['Belum berjalan', 'Sedang berjalan', 'Sudah berjalan'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bidang = mysqli_real_escape_string($conn, $_POST['nama_bidang']);
    $program = mysqli_real_escape_string($conn, $_POST['nama_program']);
    // Filter out non-numeric characters for anggaran
    $anggaran_raw = preg_replace('/[^0-9]/', '', $_POST['anggaran']);
    $anggaran = (float) $anggaran_raw;
    
    $status = mysqli_real_escape_string($conn, $_POST['status_program']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $update = "UPDATE program_kerja SET nama_bidang='$bidang', nama_program='$program', anggaran=$anggaran, status_program='$status', keterangan='$keterangan' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: index.php?success=Program kerja berhasil diperbarui");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Edit Program Kerja</h3>
    <a href="index.php" class="btn btn-outline-secondary fw-bold bg-white"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card col-md-8 mx-auto shadow-sm">
    <div class="card-header bg-white pb-3 pt-4 px-4">
        <h5 class="fw-bold mb-0 text-primary border-start border-4 border-primary ps-2">Form Edit Data Program Kerja</h5>
    </div>
    <div class="card-body p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Bidang</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-sitemap"></i></span>
                    <select name="nama_bidang" class="form-select" required>
                        <?php foreach ($bidangs as $b): ?>
                        <option value="<?= $b ?>" <?= ($data['nama_bidang'] == $b) ? 'selected' : '' ?>><?= $b ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Program Kegiatan</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-clipboard-list"></i></span>
                    <input type="text" name="nama_program" class="form-control" value="<?= htmlspecialchars($data['nama_program']) ?>" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark">Rencana Anggaran (Rp)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text fw-bold bg-light">Rp</span>
                        <input type="text" name="anggaran" id="anggaran" class="form-control" value="<?= number_format($data['anggaran'], 0, ',', '.') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Status Pelaksanaan</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="fas fa-info-circle"></i></span>
                        <select name="status_program" class="form-select" required>
                            <?php foreach ($statuses as $s): ?>
                            <option value="<?= $s ?>" <?= ($data['status_program'] == $s) ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>

            <div class="d-grid mt-5">
                <button type="submit" class="btn btn-warning py-3 fw-bold fs-5 text-dark text-uppercase rounded-3 shadow-sm"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Format Rupiah on type
var rupiah = document.getElementById('anggaran');
rupiah.addEventListener('keyup', function(e) {
    rupiah.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>

<?php require_once '../../includes/footer.php'; ?>
