<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lembaga['nama_lembaga'] ?? ''; ?></title>
</head>
<body>
    <!-- KOP SURAT -->
    <?php include 'kop_surat.php'; ?>

    <!-- Tampilkan judul dan teks nama kelas dan bulan -->
    <div style="text-align: center;"><br>
        <span style="font-weight: bold;"><?php echo $settingabsensi['judul_absensi'] ?? ''; ?></span><br>
        <span style="font-size: 11px;">Tahun Pelajaran <?php echo $settingabsensi['start_tahun'] ?? ''; ?>/<?php echo $settingabsensi['end_tahun'] ?? ''; ?></span>
    </div>

    <table>
        <tr>
            <th style="width: 70px;">Nama Kelas</th>
            <th style="width: 10px;">:</th>
            <th><strong><?= $nama_kelas ?></strong></th>
        </tr>
        <tr>
            <th style="width: 70px;">Bulan</th>
            <th style="width: 10px;">:</th>
            <th><strong><?php echo $settingabsensi['bulan_absensi'] ?? ''; ?></strong></th>
        </tr>
        <tr>
            <th></th>
        </tr>
    </table>

    <?php
    // Periksa apakah ada data siswa yang diterima dari controller
    if (!empty($siswa)) {
    ?>
        <table border="1" cellpadding="3">
            <tr style="text-align: center; font-weight: bold;">
                <th rowspan="2" style="width: 25px; text-align: center;">NO</th>
                <th rowspan="2" style="width: 180px;">Nama Lengkap</th>
                <th rowspan="2" style="width: 25px; text-align: center;">LP</th>
                <th rowspan="2" style="width: 50px; text-align: center;">No Induk</th>
                <th colspan="9" style="width: 180px;">Tanggal</th>
                <th colspan="3" style="width: 80px;">Keterangan</th>
            </tr>
            <tr style="text-align: center; font-weight: bold;">
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;"></td>
                <td style="width: 20px;">S</td>
                <td style="width: 20px;">I</td>
                <td style="width: 20px;">A</td>
                <td style="width: 20px;">D</td>
            </tr>
            
        <?php 
            $counter = 1; // Counter untuk nomor urut
            foreach ($siswa as $data): ?>
                <tr>
                    <td style="font-size: 10px; text-align: center;"><?= $counter++ ?></td> <!-- Menampilkan nomor urut -->
                    <td style="font-size: 11px;"><?= $data['nama_siswa'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['jeniskelamin'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['nis'] ?> </td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                    <td style="width: 20px;"></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php
    } else {
        // Tampilkan pesan jika tidak ada data siswa yang diterima
        echo "Tidak ada data siswa yang ditemukan.";
    }
    ?>


</body>
</html>
