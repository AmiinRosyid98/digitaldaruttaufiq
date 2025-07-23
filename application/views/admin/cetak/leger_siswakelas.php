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
        <span style="font-weight: bold;">DATA SISWA KELAS <strong><?= $nama_kelas ?></span><br>
    </div>


    <?php
    // Periksa apakah ada data siswa yang diterima dari controller
    if (!empty($siswa)) {
    ?>
        <table border="1" cellpadding="3">
            <tr style="text-align: center; font-weight: bold;">
                <th style="width: 25px; text-align: center;">NO</th>
                <th style="width: 180px;">Nama Lengkap</th>
                <th style="width: 25px; text-align: center;">LP</th>
                <th style="width: 80px; text-align: center;">No Induk</th>
                <th style="width: 80px; text-align: center;">NISN</th>
                <th style="width: 150px; text-align: center;">Tempat, Tanggal Lahir</th>
                <th style="width: 50px; text-align: center;">Agama</th>
                <th style="width: 80px; text-align: center;">Nama Bapak</th>
                <th style="width: 80px; text-align: center;">Nama Ibu</th>
                <th style="width: 120px; text-align: center;">Asal Sekolah</th>


            </tr>

            <?php
            $counter = 1; // Counter untuk nomor urut
            foreach ($siswa as $data) : ?>
                <tr>
                    <td style="font-size: 10px; text-align: center;"><?= $counter++ ?></td> <!-- Menampilkan nomor urut -->
                    <td style="font-size: 11px; text-align: left;"><?= $data['nama_siswa'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['jeniskelamin'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['nis'] ?> </td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['nisn'] ?> </td>
                    <td style="font-size: 10px; text-align: center;">
                        <?= $data['tempatlahir'] ?>, <?= date('d-m-Y', strtotime($data['tanggallahir'])) ?>
                    </td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['agama'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['ayah_nama'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['ibu_nama'] ?></td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['asal_sekolah'] ?></td>

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