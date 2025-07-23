<!DOCTYPE html>
<html>

<head>
    <title><?php echo $lembaga['nama_lembaga'] ?? ''; ?></title>
</head>

<body>


    <div style="text-align: center;"><br>
        <span style="font-weight: bold; font-size: 11px;">AGENDA DAN JURNAL HARIAN</span>
    </div>
    <table>
        <tr>
            <th style="width: 100px;">Mata Pelajaran</th>
            <th style="width: 10px;">:</th>
            <th><strong><?= isset($jurnalguru[0]['nama_mapel']) ? $jurnalguru[0]['nama_mapel'] : '' ?></strong></th>
        </tr>
        <tr>
            <th style="width: 100px;">Kelas / Semester</th>
            <th style="width: 10px;">:</th>
            <th><strong><?= isset($jurnalguru[0]['nama_kelas']) ? $jurnalguru[0]['nama_kelas'] : '' ?></strong></th>
        </tr>
        <tr>
            <th style="width: 100px;">Tahun Pelajaran</th>
            <th style="width: 10px;">:</th>
            <th><strong><?php echo $tahunajaran['tahun_pelajaran'] ?? ''; ?></strong></th>
        </tr>
        <tr>
            <th></th>
        </tr>
    </table>
    <?php
    // Periksa apakah ada data siswa yang diterima dari controller
    if (!empty($jurnalguru)) {
    ?>
        <table border="1" cellpadding="3">
            <tr style="text-align: center; font-weight: bold; font-size: 11px;">
                <th rowspan="1" style="width: 25px; text-align: center;">NO</th>
                <th rowspan="1" style="width: 100px;">Hari / Tanggal</th>
                <th rowspan="1" style="width: 50px; text-align: center;">Jam Ke</th>
                <th rowspan="1" style="width: 250px; text-align: center;">Kompetensi Inti / Kompetensi Dasar</th>
                <th colspan="1" style="width: 180px;">Materi</th>
                <th colspan="1" style="width: 180px;">Indikator</th>
                <th colspan="1" style="width: 80px;">Pencapaian</th>
                <th colspan="1" style="width: 80px;">Absen Siswa</th>
            </tr>


            <?php
            $counter = 1; // Counter untuk nomor urut
            foreach ($jurnalguru as $data) : ?>
                <tr>
                    <td style="font-size: 10px; text-align: center;"><?= $counter++ ?></td> <!-- Menampilkan nomor urut -->
                    <td style="font-size: 11px;">
                        <?php echo date('d-m-Y', strtotime($data['tanggal'])); ?>
                    </td>
                    <td style="font-size: 10px; text-align: center;"><?= $data['mulaijamke'] ?> - <?= $data['sampaijamke'] ?></td>
                    <td style="font-size: 10px; text-align: left;"><?= $data['kompetensi'] ?></td>
                    <td style="font-size: 10px; text-align: left;"><?= $data['materi'] ?> </td>
                    <td style="font-size: 10px; text-align: left;"><?= $data['indikator'] ?></td>
                    <td style="font-size: 10px; text-align: center;">Tuntas</td>
                    <td style="font-size: 10px; text-align: center;">Terlampir</td>


                </tr>
            <?php endforeach; ?>
        </table>
    <?php
    } else {
        // Tampilkan pesan jika tidak ada data siswa yang diterima
        echo "Tidak ada data siswa yang ditemukan.";
    }
    ?>





    <table style="border: none; font-family: Times New Roman, Times, serif">
        <tr>

            <td width="100">

            </td>


            <td width="200">
                <div style="border: none; padding-top: 10px;">
                    <div style="font-size: 12px;">
                        <span>
                        </span><br>
                        <span>Kepala Sekolah</span><br><br><br><br><br><br>
                        <span><?php echo strtoupper($lembaga['nama_kepsek']); ?></span><br>
                        <span>NIP.<?php echo strtoupper($lembaga['nip_kepsek']); ?></span>

                    </div>
                </div>
            </td>

            <td width="400">

            </td>


            <?php
            setlocale(LC_TIME, 'id_ID.utf8'); // Set locale untuk bahasa Indonesia

            // Tampilkan bulan dan tahun dalam bahasa Indonesia
            ?>
            <td width="200">
                <div style="border: none; padding-top: 10px;">
                    <div style="font-size: 12px;">
                        <span><?php echo $lembaga['kab_lembaga'] ?? ''; ?>, <?php echo strftime('%B %Y'); ?>
                        </span><br>
                        <span>Guru Mata Pelajaran</span><br><br><br><br><br><br>
                        <span><?= isset($jurnalguru[0]['nama_ptk']) ? $jurnalguru[0]['nama_ptk'] : '' ?></span><br>
                        <span>NIP.<?= isset($jurnalguru[0]['nip']) ? $jurnalguru[0]['nip'] : '' ?></span>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>