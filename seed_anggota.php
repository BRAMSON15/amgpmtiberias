<?php
require_once 'config/database.php';

$first_names_m = ['Glenn', 'Yabes', 'Marchel', 'Erick', 'Roy', 'Frans', 'Johan', 'Michael', 'Chris', 'Ongen', 'Simon', 'Pieter', 'Daniel', 'Jose', 'Albert', 'Vano', 'Bryan', 'Jevin', 'Reza'];
$first_names_f = ['Nova', 'Yanti', 'Sherly', 'Grace', 'Maria', 'Intan', 'Rina', 'Sarah', 'Rachel', 'Nita', 'Monic', 'Selvi', 'Dessy', 'Vina', 'Gaby', 'Hana', 'Angel', 'Mey'];
$margas = ['Pattinama', 'Hetharia', 'Latuconsina', 'Noya', 'Salampessy', 'Hutuely', 'Pelupessy', 'Leiwakabessy', 'Siahaya', 'Ruhulessin', 'Wattimena', 'Manuputty', 'Tanamal', 'Latumahina', 'Tuhaleru', 'Tahalele', 'Manuhutu', 'Silooy', 'Souisa', 'Latupeirissa', 'Kastanya', 'Matulessy', 'Siwabessy', 'Nanlohy', 'Pariela', 'Sahetapy', 'Tahitu'];

$statuses = [
    'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif', 'Aktif',
    'Pasif', 'Pasif',
    'Studi di Luar Daerah', 'Studi di Luar Daerah',
    'Bekerja di Luar Daerah'
];

$count = 60;
$inserted = 0;

for ($i = 0; $i < $count; $i++) {
    // Generate Gender & Name
    $is_male = rand(0, 1) == 1;
    $jk = $is_male ? 'Laki-laki' : 'Perempuan';
    
    $fn = $is_male ? $first_names_m[array_rand($first_names_m)] : $first_names_f[array_rand($first_names_f)];
    $ln = $margas[array_rand($margas)];
    $nama = "$fn $ln";
    
    // Generate Age (prioritize young youth 20-30)
    $age_weight = rand(1, 100);
    if ($age_weight <= 75) {
        $umur = rand(20, 28);
    } elseif ($age_weight <= 90) {
        $umur = rand(29, 35);
    } else {
        $umur = rand(36, 45);
    }
    
    // Status
    $status = $statuses[array_rand($statuses)];
    
    $query = "INSERT INTO anggota (nama, jenis_kelamin, umur, status) VALUES ('$nama', '$jk', $umur, '$status')";
    if (mysqli_query($conn, $query)) {
        $inserted++;
    }
}

echo "Successfully seeded $inserted members from Maluku/Ambon into the database.\n";
?>
