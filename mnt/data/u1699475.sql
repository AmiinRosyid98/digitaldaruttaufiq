-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 07:55 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev-smartschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensiguru`
--

CREATE TABLE `absensiguru` (
  `id` int(11) NOT NULL,
  `id_guru` varchar(100) NOT NULL,
  `absen` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `absensionline`
--

CREATE TABLE `absensionline` (
  `id` int(11) NOT NULL,
  `id_siswa` varchar(100) NOT NULL,
  `absen` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(15) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `token` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `avatar`, `last_login`, `created_at`, `token`, `role`) VALUES
(101, 'ADMINISTRATOR', 'admin@gmail.com', 'admin', '$2y$10$dTX7Y1Lqci7eb4CQXjybsuQ4pb.Ok0wDTro1vZI8/HEVYUjqq/QrO', '101_default.png', '2025-05-11 17:52:39', '2021-08-14 23:22:33', '6f634973f41b20f65981899ef5f56382', 'admin'),
(103, 'BENDAHARA', 'bendahara@gmail.com', 'bendahara', '$2y$10$sXOs0Jhj67TzP8XlzlZU/OcrNs7OCdcAWqdYG4AV3WnbDSilMz5Ye', 'default.png', '2024-06-18 12:11:09', '2024-06-14 13:58:56', '', 'bendahara'),
(107, 'BK', 'bk@gmail.com', 'bk', '$2y$10$Nv4Zoc1fq714cKbQtSNcy.taaTctMXHVw12PxmDIpC0i.CELuD4q6', 'default.png', '2024-08-04 23:27:54', '2024-07-15 22:59:38', '', 'bk');

-- --------------------------------------------------------

--
-- Table structure for table `arsip_banksoal`
--

CREATE TABLE `arsip_banksoal` (
  `id` int(11) NOT NULL,
  `nama_arsip` varchar(100) NOT NULL,
  `file_arsip` varchar(100) NOT NULL,
  `id_guru` varchar(100) NOT NULL,
  `timestamp_arsip` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `judul_berita` varchar(100) NOT NULL,
  `isi_berita` varchar(500) NOT NULL,
  `penulis_berita` varchar(100) NOT NULL,
  `gambar_berita` varchar(100) NOT NULL,
  `tanggal_berita` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `nama_buku` varchar(100) NOT NULL,
  `kode_buku` varchar(100) NOT NULL,
  `kode_kelas` varchar(100) NOT NULL,
  `file_buku` varchar(255) NOT NULL,
  `terbitan` varchar(100) NOT NULL,
  `id_guru` varchar(100) NOT NULL,
  `timestamp_buku` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenispelanggaran`
--

CREATE TABLE `jenispelanggaran` (
  `id` int(11) NOT NULL,
  `nama_pelanggaran` varchar(25) NOT NULL,
  `poin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenispelanggaran`
--

INSERT INTO `jenispelanggaran` (`id`, `nama_pelanggaran`, `poin`) VALUES
(6, 'Mengeluarkan Baju', '5'),
(7, 'Berkelahi', '10'),
(8, 'Menghina Guru, Karyawan S', '25');

-- --------------------------------------------------------

--
-- Table structure for table `jenispembayaran`
--

CREATE TABLE `jenispembayaran` (
  `id_jenispembayaran` int(11) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `kode_tahunpelajaran` varchar(100) NOT NULL,
  `tipe_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurnalguru`
--

CREATE TABLE `jurnalguru` (
  `id` int(11) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `id_master` varchar(10) NOT NULL,
  `id_guru` varchar(100) NOT NULL,
  `mulaijamke` varchar(100) NOT NULL,
  `sampaijamke` varchar(10) NOT NULL,
  `kompetensi` varchar(500) NOT NULL,
  `materi` varchar(500) NOT NULL,
  `indikator` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurnalmaster`
--

CREATE TABLE `jurnalmaster` (
  `id` int(11) NOT NULL,
  `id_guru` varchar(100) NOT NULL,
  `kode_master` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `no_kelas` varchar(100) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `kode_tingkat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `kelompok_mapel` varchar(100) NOT NULL,
  `nourut_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` varchar(100) NOT NULL,
  `nama_tipepembayaran` varchar(100) NOT NULL,
  `id_pos` varchar(100) NOT NULL,
  `id_pembayaran` varchar(100) NOT NULL,
  `id_tahunpelajaran` varchar(10) NOT NULL,
  `jumlah_tarif` varchar(100) NOT NULL,
  `jumlah_pembayaran` varchar(100) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `created_at` datetime NOT NULL,
  `statuspembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `npsn` varchar(12) NOT NULL,
  `status_lembaga` varchar(255) NOT NULL,
  `pemerintah_lembaga` varchar(12) NOT NULL,
  `tahun_pelajaran` varchar(10) NOT NULL,
  `nama_lembaga` varchar(255) NOT NULL,
  `alamat_lembaga` varchar(100) NOT NULL,
  `kab_lembaga` varchar(100) NOT NULL,
  `prov_lembaga` varchar(100) NOT NULL,
  `kodepos_lembaga` varchar(10) NOT NULL,
  `notelp_lembaga` varchar(25) NOT NULL,
  `email_lembaga` varchar(50) NOT NULL,
  `website_lembaga` varchar(50) NOT NULL,
  `nama_kepsek` varchar(100) NOT NULL,
  `nip_kepsek` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logopemerintah` varchar(100) NOT NULL,
  `menu_active` varchar(100) NOT NULL,
  `bg_active` varchar(100) NOT NULL,
  `status` varchar(25) NOT NULL,
  `naungan_lembaga` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `npsn`, `status_lembaga`, `pemerintah_lembaga`, `tahun_pelajaran`, `nama_lembaga`, `alamat_lembaga`, `kab_lembaga`, `prov_lembaga`, `kodepos_lembaga`, `notelp_lembaga`, `email_lembaga`, `website_lembaga`, `nama_kepsek`, `nip_kepsek`, `logo`, `logopemerintah`, `menu_active`, `bg_active`, `status`, `naungan_lembaga`) VALUES
(1, '30315579', 'NEGERI', 'KOTA', '7', 'MAN 2 Kota Banjarmasin', 'Jl. Pramuka No.28 RT. 20, Sungai Lulut', 'Kota Banjarmasin', 'Kalimantan Selatan', '70653', '(021) 073221513', 'man2banjarmasin@gmail.com', '', '', '', '_logo.png', '_images.png', 'yellow', '#0C5B48', 'aktif', 'Kementerian Agama Republik Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `poinpelanggaran`
--

CREATE TABLE `poinpelanggaran` (
  `id` int(11) NOT NULL,
  `tanggal` varchar(25) NOT NULL,
  `id_siswa` varchar(10) NOT NULL,
  `poin` varchar(10) NOT NULL,
  `nama_pelanggaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poskeuangan`
--

CREATE TABLE `poskeuangan` (
  `id_pos` int(11) NOT NULL,
  `nama_pos` varchar(255) NOT NULL,
  `ket_pos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_jalur`
--

CREATE TABLE `ppdb_jalur` (
  `id` int(11) NOT NULL,
  `nama_jalur` varchar(100) NOT NULL,
  `persentase_kuota` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_logs`
--

CREATE TABLE `ppdb_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL COMMENT 'insert, update, delete',
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_pendaftaran`
--

CREATE TABLE `ppdb_pendaftaran` (
  `id` int(11) NOT NULL,
  `no_pendaftaran` varchar(20) NOT NULL,
  `no_peserta_ujian` varchar(50) NOT NULL,
  `rata_nilai_ijazah` varchar(5) NOT NULL,
  `prestasi` varchar(100) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `no_kk` varchar(16) DEFAULT NULL,
  `nisn` varchar(15) NOT NULL,
  `jalur_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(15) NOT NULL,
  `agama` varchar(15) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(5) NOT NULL,
  `rw` varchar(5) NOT NULL,
  `kelurahan` varchar(25) NOT NULL,
  `kecamatan` varchar(25) NOT NULL,
  `kabupaten` varchar(25) NOT NULL,
  `status_ortu` varchar(20) NOT NULL,
  `anakke` varchar(2) NOT NULL,
  `jumlah_saudara` varchar(2) NOT NULL,
  `nama_ayah` varchar(50) NOT NULL,
  `pekerjaan_ayah` varchar(20) NOT NULL,
  `pendidikan_ayah` varchar(20) NOT NULL,
  `nama_ibu` varchar(50) NOT NULL,
  `pekerjaan_ibu` varchar(20) NOT NULL,
  `pendidikan_ibu` varchar(20) NOT NULL,
  `telp_ortu` varchar(20) NOT NULL,
  `status` enum('pending','terverifikasi','diterima','ditolak') DEFAULT 'pending',
  `foto_siswa` varchar(100) NOT NULL,
  `tahun_lulus` varchar(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ppdb_setting`
--

CREATE TABLE `ppdb_setting` (
  `id` int(11) NOT NULL,
  `status_ppdb` tinyint(1) NOT NULL DEFAULT 0,
  `tahun_ajaran` varchar(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `kuota` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_multi_jalur` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ppdb_setting`
--

INSERT INTO `ppdb_setting` (`id`, `status_ppdb`, `tahun_ajaran`, `tanggal_mulai`, `tanggal_selesai`, `kuota`, `created_at`, `updated_at`, `is_multi_jalur`) VALUES
(1, 1, '2025', '2025-05-09', '2025-05-11', 100, '2025-05-09 10:55:02', '2025-05-11 09:27:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ptk`
--

CREATE TABLE `ptk` (
  `id_guru` int(11) NOT NULL,
  `nama_ptk` varchar(255) NOT NULL,
  `jeniskelamin` varchar(100) NOT NULL,
  `agama` varchar(100) NOT NULL,
  `tempatlahir_ptk` varchar(100) NOT NULL,
  `tanggallahir_ptk` varchar(100) NOT NULL,
  `ptk_alamat` varchar(100) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `kode_kelas` varchar(255) NOT NULL,
  `mapel_mengajar` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `ptk_token` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `qrcode_ptk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jeniskelamin` varchar(25) NOT NULL,
  `tempatlahir` varchar(40) NOT NULL,
  `tanggallahir` varchar(20) NOT NULL,
  `agama` varchar(25) NOT NULL,
  `siswa_alamat` varchar(50) NOT NULL,
  `siswa_kelurahan` varchar(50) NOT NULL,
  `siswa_kecamatan` varchar(50) NOT NULL,
  `siswa_kabupaten` varchar(50) NOT NULL,
  `siswa_provinsi` varchar(50) NOT NULL,
  `siswa_jaraksekolah` varchar(50) NOT NULL,
  `siswa_transportasi` varchar(50) NOT NULL,
  `siswa_tinggal` varchar(50) NOT NULL,
  `pendukung_golongandarah` varchar(50) NOT NULL,
  `pendukung_penyakit` varchar(50) NOT NULL,
  `pendukung_kelainanjasmani` varchar(50) NOT NULL,
  `pendukung_tinggibadan` varchar(50) NOT NULL,
  `pendukung_beratbadan` varchar(50) NOT NULL,
  `kewarganegaraan` varchar(50) NOT NULL,
  `anakke` varchar(5) NOT NULL,
  `jumlahsaudara` varchar(5) NOT NULL,
  `status_anakyatim` varchar(10) NOT NULL,
  `asal_sekolah` varchar(50) NOT NULL,
  `asal_noijazah` varchar(50) NOT NULL,
  `asal_noskhu` varchar(50) NOT NULL,
  `asal_tanggal` varchar(50) NOT NULL,
  `pindahan_asalsekolah` varchar(50) NOT NULL,
  `pindahan_alasan` varchar(50) NOT NULL,
  `pindahan_tanggal` varchar(50) NOT NULL,
  `ayah_nik` varchar(50) NOT NULL,
  `ayah_nama` varchar(50) NOT NULL,
  `ayah_tempatlahir` varchar(50) NOT NULL,
  `ayah_tanggallahir` varchar(50) NOT NULL,
  `ayah_agama` varchar(50) NOT NULL,
  `ayah_kewarganegaraan` varchar(50) NOT NULL,
  `ayah_pendidikan` varchar(50) NOT NULL,
  `ayah_pekerjaan` varchar(50) NOT NULL,
  `ayah_penghasilan` varchar(50) NOT NULL,
  `ayah_alamat` varchar(50) NOT NULL,
  `ayah_desakel` varchar(50) NOT NULL,
  `ayah_kecamatan` varchar(50) NOT NULL,
  `ayah_kabupaten` varchar(50) NOT NULL,
  `ayah_provinsi` varchar(50) NOT NULL,
  `ayah_nohp` varchar(50) NOT NULL,
  `ayah_status` varchar(50) NOT NULL,
  `ibu_nik` varchar(50) NOT NULL,
  `ibu_nama` varchar(50) NOT NULL,
  `ibu_tempatlahir` varchar(50) NOT NULL,
  `ibu_tanggallahir` varchar(50) NOT NULL,
  `ibu_agama` varchar(50) NOT NULL,
  `ibu_kewarganegaraan` varchar(50) NOT NULL,
  `ibu_pendidikan` varchar(50) NOT NULL,
  `ibu_pekerjaan` varchar(50) NOT NULL,
  `ibu_penghasilan` varchar(50) NOT NULL,
  `ibu_alamat` varchar(50) NOT NULL,
  `ibu_desakel` varchar(50) NOT NULL,
  `ibu_kecamatan` varchar(100) NOT NULL,
  `ibu_kabupaten` varchar(100) NOT NULL,
  `ibu_provinsi` varchar(100) NOT NULL,
  `ibu_nohp` varchar(100) NOT NULL,
  `ibu_status` varchar(100) NOT NULL,
  `wali_nik` varchar(100) NOT NULL,
  `wali_nama` varchar(100) NOT NULL,
  `wali_tempatlahir` varchar(100) NOT NULL,
  `wali_tanggallahir` varchar(100) NOT NULL,
  `wali_agama` varchar(100) NOT NULL,
  `wali_kewarganegaraan` varchar(100) NOT NULL,
  `wali_pendidikan` varchar(100) NOT NULL,
  `wali_pekerjaan` varchar(100) NOT NULL,
  `wali_penghasilan` varchar(100) NOT NULL,
  `wali_alamat` varchar(100) NOT NULL,
  `wali_desakel` varchar(100) NOT NULL,
  `wali_kecamatan` varchar(100) NOT NULL,
  `wali_kabupaten` varchar(100) NOT NULL,
  `wali_provinsi` varchar(100) NOT NULL,
  `wali_nohp` varchar(100) NOT NULL,
  `wali_status` varchar(100) NOT NULL,
  `kegemaran_kesenian` varchar(100) NOT NULL,
  `kegemaran_olahraga` varchar(100) NOT NULL,
  `kegemaran_organisasi` varchar(100) NOT NULL,
  `kegemaran_lainlain` varchar(100) NOT NULL,
  `beasiswa_nama` varchar(100) NOT NULL,
  `beasiswa_tahun` varchar(100) NOT NULL,
  `beasiswa_nominal` varchar(100) NOT NULL,
  `lulus_tahun` varchar(100) NOT NULL,
  `lulus_noijazah` varchar(100) NOT NULL,
  `lulus_tanggalijazah` varchar(100) NOT NULL,
  `lulus_noskhu` varchar(100) NOT NULL,
  `lulus_tanggalskhu` varchar(100) NOT NULL,
  `lanjut_nama` varchar(100) NOT NULL,
  `lanjut_bekerja` varchar(100) NOT NULL,
  `lanjut_bekerjamulai` varchar(100) NOT NULL,
  `lanjut_bekerjaperusahaan` varchar(50) NOT NULL,
  `lanjut_penghasilan` varchar(50) NOT NULL,
  `bahasa` varchar(50) NOT NULL,
  `hobi` varchar(50) NOT NULL,
  `citacita` varchar(50) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `no_absen` int(11) NOT NULL,
  `kode_kelas` varchar(50) NOT NULL,
  `nis` varchar(25) NOT NULL,
  `nisn` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `tahun_angkatan` varchar(50) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `avatar` varchar(100) NOT NULL,
  `status_kelulusan` int(11) NOT NULL,
  `qrcode_siswa` varchar(100) DEFAULT NULL,
  `saldo_siswa` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tahunangkatan`
--

CREATE TABLE `tahunangkatan` (
  `id_tahunangkatan` int(11) NOT NULL,
  `tahun` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tahunpelajaran`
--

CREATE TABLE `tahunpelajaran` (
  `id_tahunpelajaran` int(11) NOT NULL,
  `tahun_pelajaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tarifpembayaran`
--

CREATE TABLE `tarifpembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `kode_kelas` varchar(500) NOT NULL,
  `kode_pembayaran` varchar(255) NOT NULL,
  `jumlah_tarif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `templateabsensi`
--

CREATE TABLE `templateabsensi` (
  `id` int(11) NOT NULL,
  `judul_absensi` varchar(100) NOT NULL,
  `bulan_absensi` varchar(50) NOT NULL,
  `start_tahun` int(4) NOT NULL,
  `end_tahun` int(4) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `batas_waktu_absen_masuk` varchar(25) NOT NULL,
  `batas_waktu_absen_pulang` varchar(25) NOT NULL,
  `radius_absen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templateabsensi`
--

INSERT INTO `templateabsensi` (`id`, `judul_absensi`, `bulan_absensi`, `start_tahun`, `end_tahun`, `latitude`, `longitude`, `batas_waktu_absen_masuk`, `batas_waktu_absen_pulang`, `radius_absen`) VALUES
(1, 'DAFTAR KEHADIRAN SISWA', 'APRIL', 2025, 2026, '-4.24950', '104.58653', '14:00', '14:55', '10');

-- --------------------------------------------------------

--
-- Table structure for table `templateskl`
--

CREATE TABLE `templateskl` (
  `id` int(11) NOT NULL,
  `judul_skl` varchar(100) NOT NULL,
  `no_skl` varchar(50) NOT NULL,
  `tgl_skl` varchar(25) NOT NULL,
  `dasar_skl` varchar(255) NOT NULL,
  `isi_skl` varchar(255) NOT NULL,
  `penutup_skl` varchar(255) NOT NULL,
  `status_pengumuman` int(10) NOT NULL,
  `target_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templateskl`
--

INSERT INTO `templateskl` (`id`, `judul_skl`, `no_skl`, `tgl_skl`, `dasar_skl`, `isi_skl`, `penutup_skl`, `status_pengumuman`, `target_time`) VALUES
(1, 'SURAT KETERANGAN KELULUSAN', '421.3/001/III.04.20/2024', '2024-06-10', '<p>…</p>', '<p>…</p>', '<p>…</p>', 1, '2025-05-11 17:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `tingkat`
--

CREATE TABLE `tingkat` (
  `id_tingkat` int(11) NOT NULL,
  `nama_tingkat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipepembayaran`
--

CREATE TABLE `tipepembayaran` (
  `id_tipepembayaran` int(11) NOT NULL,
  `nama_tipepembayaran` varchar(100) NOT NULL,
  `durasi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipepembayaran`
--

INSERT INTO `tipepembayaran` (`id_tipepembayaran`, `nama_tipepembayaran`, `durasi`) VALUES
(1, 'BULANAN', '1'),
(2, 'TAHUNAN', '12'),
(3, 'BEBAS', '0');

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `id` int(11) NOT NULL,
  `current_version` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`id`, `current_version`) VALUES
(1, '10.4.9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensiguru`
--
ALTER TABLE `absensiguru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absensionline`
--
ALTER TABLE `absensionline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arsip_banksoal`
--
ALTER TABLE `arsip_banksoal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `jenispelanggaran`
--
ALTER TABLE `jenispelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
  ADD PRIMARY KEY (`id_jenispembayaran`);

--
-- Indexes for table `jurnalguru`
--
ALTER TABLE `jurnalguru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnalmaster`
--
ALTER TABLE `jurnalmaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poinpelanggaran`
--
ALTER TABLE `poinpelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poskeuangan`
--
ALTER TABLE `poskeuangan`
  ADD PRIMARY KEY (`id_pos`);

--
-- Indexes for table `ppdb_jalur`
--
ALTER TABLE `ppdb_jalur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppdb_logs`
--
ALTER TABLE `ppdb_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `table_record` (`table_name`,`record_id`);

--
-- Indexes for table `ppdb_pendaftaran`
--
ALTER TABLE `ppdb_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppdb_setting`
--
ALTER TABLE `ppdb_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptk`
--
ALTER TABLE `ptk`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tahunangkatan`
--
ALTER TABLE `tahunangkatan`
  ADD PRIMARY KEY (`id_tahunangkatan`);

--
-- Indexes for table `tahunpelajaran`
--
ALTER TABLE `tahunpelajaran`
  ADD PRIMARY KEY (`id_tahunpelajaran`);

--
-- Indexes for table `tarifpembayaran`
--
ALTER TABLE `tarifpembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `templateabsensi`
--
ALTER TABLE `templateabsensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templateskl`
--
ALTER TABLE `templateskl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tingkat`
--
ALTER TABLE `tingkat`
  ADD PRIMARY KEY (`id_tingkat`);

--
-- Indexes for table `tipepembayaran`
--
ALTER TABLE `tipepembayaran`
  ADD PRIMARY KEY (`id_tipepembayaran`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensiguru`
--
ALTER TABLE `absensiguru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `absensionline`
--
ALTER TABLE `absensionline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `arsip_banksoal`
--
ALTER TABLE `arsip_banksoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jenispelanggaran`
--
ALTER TABLE `jenispelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
  MODIFY `id_jenispembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `jurnalguru`
--
ALTER TABLE `jurnalguru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jurnalmaster`
--
ALTER TABLE `jurnalmaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poinpelanggaran`
--
ALTER TABLE `poinpelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `poskeuangan`
--
ALTER TABLE `poskeuangan`
  MODIFY `id_pos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppdb_jalur`
--
ALTER TABLE `ppdb_jalur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ppdb_logs`
--
ALTER TABLE `ppdb_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppdb_pendaftaran`
--
ALTER TABLE `ppdb_pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ppdb_setting`
--
ALTER TABLE `ppdb_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ptk`
--
ALTER TABLE `ptk`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahunangkatan`
--
ALTER TABLE `tahunangkatan`
  MODIFY `id_tahunangkatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahunpelajaran`
--
ALTER TABLE `tahunpelajaran`
  MODIFY `id_tahunpelajaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarifpembayaran`
--
ALTER TABLE `tarifpembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templateabsensi`
--
ALTER TABLE `templateabsensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templateskl`
--
ALTER TABLE `templateskl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tingkat`
--
ALTER TABLE `tingkat`
  MODIFY `id_tingkat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tipepembayaran`
--
ALTER TABLE `tipepembayaran`
  MODIFY `id_tipepembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
