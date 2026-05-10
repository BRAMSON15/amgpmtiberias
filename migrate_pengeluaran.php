<?php
require_once 'config/database.php';

$sql = "CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tanggal` DATE NOT NULL,
  `bidang` VARCHAR(100) NOT NULL,
  `tujuan` TEXT NOT NULL,
  `jumlah` DECIMAL(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql)) {
    echo "SUCCESS: Table 'pengeluaran' created successfully.\n";
} else {
    echo "ERROR: " . mysqli_error($conn) . "\n";
}
?>
