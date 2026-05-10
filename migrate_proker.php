<?php
require_once 'config/database.php';

$migrations = [
    'Bidang 1 (Keesaan dan Persekutuan)' => 'Bidang 1: ORGANISASI DAN KERUMAHTANGGAAN',
    'Bidang 2 (Kesaksian dan Pelayanan)' => 'Bidang 2: PELAYANAN PENDIDIKAN, PEMBANGUNAN MASYARAKAT DAN IPTEKS',
    'Bidang 3 (Pengembangan Oikumenis/Kemitraan)' => 'Bidang 3: KEESAAN DAN PEMBINAAN UMAT',
    'Bidang 4 (Pendidikan & Pengembangan SDM)' => 'Bidang 4: PEKABARAN INJIL DAN KOMUNIKASI',
    'Bidang 5 (Penatalayanan dan Keuangan)' => 'Bidang 5: FINANSIAL DAN EKONOMI'
];

foreach ($migrations as $old => $new) {
    if ($old == $new) continue;
    $old_esc = mysqli_real_escape_string($conn, $old);
    $new_esc = mysqli_real_escape_string($conn, $new);
    mysqli_query($conn, "UPDATE program_kerja SET nama_bidang = '$new_esc' WHERE nama_bidang = '$old_esc'");
    
    // Also try matching just "Bidang 1" format if that existed previously
    preg_match('/^(Bidang \d+)/', $old, $matches);
    if (!empty($matches)) {
        $prefix_esc = mysqli_real_escape_string($conn, $matches[1] . ' %');
        mysqli_query($conn, "UPDATE program_kerja SET nama_bidang = '$new_esc' WHERE nama_bidang LIKE '$prefix_esc' AND nama_bidang != '$new_esc'");
    }
}

echo "Proker Migration complete!\n";
?>
