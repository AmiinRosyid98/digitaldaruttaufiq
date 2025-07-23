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
            <th></th>
        </tr>
        <tr>
            <th style="width: 70px;">Periode</th>
            <th style="width: 10px;">:</th>
            <th><strong><?php echo date('d-m-Y', strtotime($start_date)); ?></strong></th>
        </tr>
        <tr>
            <th></th>
        </tr>
    </table>

    <?php
    // Periksa apakah ada data siswa yang diterima dari controller
    if (!empty($absensionline)) {
    ?>
        <table border="1" cellpadding="3">
            <tr style="text-align: center; font-weight: bold;">
                <th rowspan="2" style="width: 25px; text-align: center;">NO</th>
                <th rowspan="2" style="width: 180px;">Nama Lengkap</th>
                <th rowspan="2" style="width: 25px; text-align: center;">LP</th>
                <th rowspan="2" style="width: 50px; text-align: center;">No Induk</th>
                <th colspan="9" rowspan="2" style="width: 130px;">Tanggal</th>
                <th colspan="3" style="width: 125px;">Keterangan</th>
            </tr>
            <tr style="text-align: center; font-weight: bold;">
                <td style="width: 25px;">H</td>
                <td style="width: 25px;">T</td>
                <td style="width: 25px;">S</td>
                <td style="width: 25px;">I</td>
                <td style="width: 25px;">A</td>
            </tr>

            <?php
            $counter = 1; // Counter untuk nomor urut
            foreach ($absensionline as $index => $data) : ?>
                <tr>
                    <td style="font-size: 10px; text-align: center;"><?= $counter++ ?></td> <!-- Menampilkan nomor urut -->
                    <td style="font-size: 11px;"><?= $data['nama_siswa'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['jeniskelamin'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['nis'] ?></td>
                    <td style="width: 130px;">
                        <?php echo !empty($data['timestamp']) ? date('d-m-Y H:i:s', strtotime($data['timestamp'])) : ''; ?>
                    </td>
                    <td style="width: 25px; text-align: center; font-size: 12px; font-family: 'DejaVuSans', Arial, sans-serif; padding: 0; margin: 0;">
                        <?php if ($data['absen'] == 'Masuk') : ?>
                            ✓ <!-- Centang Unicode -->
                        <?php endif; ?>
                    </td>
                    <td style="width: 25px; text-align: center; font-size: 12px; font-family: 'DejaVuSans', Arial, sans-serif; padding: 0; margin: 0;">
                        <?php if ($data['absen'] == 'Telat') : ?>
                            ✓ <!-- Kosongkan untuk kolom D -->
                        <?php endif; ?>
                    </td>
                    <td style="width: 25px; text-align: center; font-size: 12px; font-family: 'DejaVuSans', Arial, sans-serif; padding: 0; margin: 0;">
                        <?php if ($data['absen'] == 'Sakit') : ?>
                            ✓ <!-- Centang Unicode -->
                        <?php endif; ?>
                    </td>
                    <td style="width: 25px; text-align: center; font-size: 12px; font-family: 'DejaVuSans', Arial, sans-serif; padding: 0; margin: 0;">
                        <?php if ($data['absen'] == 'Izin') : ?>
                            ✓ <!-- Centang Unicode -->
                        <?php endif; ?>
                    </td>
                    <td style="width: 25px; text-align: center; font-size: 12px; font-family: 'DejaVuSans', Arial, sans-serif; padding: 0; margin: 0;">
                        <?php if ($data['absen'] == '') : ?>
                            ✓ <!-- Centang Unicode -->
                        <?php endif; ?>
                    </td>

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