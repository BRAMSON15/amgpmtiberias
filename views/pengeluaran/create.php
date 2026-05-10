<?php
require_once '../../config/database.php';
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/tiberias";
require_once '../../includes/auth.php';
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/tiberias";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $bidang = mysqli_real_escape_string($conn, $_POST['bidang']);
    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);
    $jumlah = str_replace(['Rp', '.', ' '], '', $_POST['jumlah']);
    $jumlah = mysqli_real_escape_string($conn, $jumlah);

    $query = "INSERT INTO pengeluaran (tanggal, bidang, tujuan, jumlah) VALUES ('$tanggal', '$bidang', '$tujuan', '$jumlah')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Data pengeluaran berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">Tambah Catatan Pengeluaran</h1>
    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="tanggal" class="form-label fw-bold">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required value="<?= date('Y-m-d') ?>">
            </div>
            
            <div class="mb-3">
                <label for="bidang" class="form-label fw-bold">Bidang (Sumber Anggaran / Kategori) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="bidang" name="bidang" required placeholder="Contoh: Bidang III, Kesekretariatan, Bendahara, dll">
                <div class="form-text">Jelaskan dari mana bidang/bagian anggaran ini dikeluarkan.</div>
            </div>

            <div class="mb-3">
                <label for="tujuan" class="form-label fw-bold">Tujuan / Keterangan Pengeluaran <span class="text-danger">*</span></label>
                <textarea class="form-control" id="tujuan" name="tujuan" rows="3" required placeholder="Jelaskan untuk tujuan apa pengeluaran ini digunakan..."></textarea>
            </div>
            
            <div class="mb-4">
                <label for="jumlah" class="form-label fw-bold">Jumlah (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light">Rp</span>
                    <input type="text" class="form-control text-end" id="jumlah" name="jumlah" required placeholder="0" onkeyup="formatRupiah(this)">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2"><i class="fas fa-save me-2"></i>Simpan Data</button>
        </form>
    </div>
</div>

<script>
function formatRupiah(obj) {
    let value = obj.value.replace(/[^,\d]/g, '').toString();
    let split = value.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    obj.value = rupiah;
}
</script>

<?php include '../../includes/footer.php'; ?>
