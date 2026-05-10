CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `password`, `nama_lengkap`) VALUES ('admin', MD5('admin123'), 'Administrator');

CREATE TABLE `pengurus` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `anggota` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
  `umur` INT NOT NULL,
  `status` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pembina` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(50) NOT NULL,
  `kontak` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `program_kerja` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_bidang` VARCHAR(50) NOT NULL,
  `nama_program` VARCHAR(200) NOT NULL,
  `anggaran` DECIMAL(15,2) NOT NULL,
  `status_program` ENUM('Belum berjalan', 'Sedang berjalan', 'Sudah berjalan') NOT NULL,
  `keterangan` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kehadiran` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tanggal_ibadah` DATE NOT NULL,
  `minggu_ke` INT NOT NULL,
  `jumlah_hadir` INT NOT NULL,
  `total_anggota` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pengeluaran` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tanggal` DATE NOT NULL,
  `bidang` VARCHAR(100) NOT NULL,
  `tujuan` TEXT NOT NULL,
  `jumlah` DECIMAL(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;