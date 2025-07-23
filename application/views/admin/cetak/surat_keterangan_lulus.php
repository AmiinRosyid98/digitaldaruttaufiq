<!-- view: admin/cetak/surat_keterangan_lulus.php -->

<!DOCTYPE html>
<html>

<head>
    <title><?php echo isset($lembaga['nama_lembaga']) ? $lembaga['nama_lembaga'] : ''; ?></title>
</head>

<body>
    <!-- KOP SURAT -->
    <?php include 'kop_surat.php'; ?>

    <div>
        <div style="display: inline-block; position: relative; text-align: center; margin-top: 5px;">
            <span style="font-size: 14px; font-weight: bold;"><u style="display: inline-block;"><?php echo isset($templateskl['judul_skl']) ? $templateskl['judul_skl'] : ''; ?></u></span><br>
            Nomor : <?php echo isset($templateskl['no_skl']) ? $templateskl['no_skl'] : ''; ?>
        </div>

        <div style="text-align: justify;">
            <p style="font-size: 12px; font-family: Times New Roman, Times, serif"><?php echo isset($templateskl['dasar_skl']) ? $templateskl['dasar_skl'] : ''; ?></p>
            <table style="border: none; font-family: Times New Roman, Times, serif">
                <tr>
                    <td width="160">Nama</td>
                    <td width="10">:</td>
                    <td><?php echo isset($siswa['nama_siswa']) ? $siswa['nama_siswa'] : ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Jenis Kelamin</td>
                    <td width="10">:</td>
                    <td><?php $jenis_kelamin = isset($siswa['jeniskelamin']) ? (strtolower($siswa['jeniskelamin']) == 'p' ? 'Perempuan' : 'Laki-laki') : 'Jenis kelamin tidak diketahui';
                        echo $jenis_kelamin; ?></td>
                </tr>
                <tr>
                    <td width="160">Tempat, Tanggal Lahir</td>
                    <td width="10">:</td>
                    <td><?php echo isset($siswa['tempatlahir']) ? $siswa['tempatlahir'] : ''; ?>, <?php echo isset($siswa['tanggallahir']) ? date('d-m-Y', strtotime($siswa['tanggallahir'])) : ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Kelas/Nomor Absen</td>
                    <td width="10">:</td>
                    <td><?php echo isset($siswa['nama_kelas']) ? $siswa['nama_kelas'] : ''; ?> / <?php echo isset($siswa['no_absen']) ? $siswa['no_absen'] : ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Nomor Induk Siswa</td>
                    <td width="10">:</td>
                    <td><?php echo isset($siswa['nis']) ? $siswa['nis'] : ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Nomor Induk Siswa Nasional</td>
                    <td width="10">:</td>
                    <td><?php echo isset($siswa['nisn']) ? $siswa['nisn'] : ''; ?></td>
                </tr>
            </table>
            <p style="font-size: 12px; font-family: Times New Roman, Times, serif"><?php echo isset($templateskl['isi_skl']) ? $templateskl['isi_skl'] : ''; ?></p>
            <div style="display: inline-block; position: relative; text-align: center; margin-top: 5px;">
                <span style="font-size: 22px; font-family: Times New Roman, Times, serif">
                    <u style="display: inline-block;"><?php echo isset($siswa['status_kelulusan']) && $siswa['status_kelulusan'] == 1 ? 'LULUS' : (isset($siswa['status_kelulusan']) && $siswa['status_kelulusan'] == 2 ? 'TIDAK LULUS' : ''); ?></u>
                </span>
            </div>
            <p style="font-size: 12px; font-family: Times New Roman, Times, serif"><?php echo isset($templateskl['penutup_skl']) ? $templateskl['penutup_skl'] : ''; ?></p>
            <table style="border: none; font-family: Times New Roman, Times, serif">
                <tr>
                    <td width="50">
                    </td>
                    <td width="120">
                        <div style="border: 1px solid #000; text-align: center;">
                            <div style="font-size: 10px;">
                                <br><br><br>3 cm x 4 cm<br><br><br><br>
                            </div>
                        </div>
                    </td>
                    <td width="150">
                        <div style="border: none; padding-top: 10px; text-align: right;">
                            <div style="font-size: 10px;">
                                <span>
                                    <?php echo '<img src="' . $siswa['qrcode_siswa'] . '" alt="QR Code Siswa" width="95" height="100">'; ?>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td width="200">
                        <div style="border: none; padding-top: 10px;">
                            <div style="font-size: 10px;">
                                <span><?php echo isset($lembaga['kab_lembaga']) ? $lembaga['kab_lembaga'] . ',' : ''; ?>
                                    <?php
                                    $bulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

                                    $tgl_skl = isset($templateskl['tgl_skl']) ? $templateskl['tgl_skl'] : '';

                                    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $tgl_skl, $matches)) {
                                        echo "{$matches[3]} {$bulan[$matches[2]]} {$matches[1]}";
                                    } else {
                                        echo "Format tanggal tidak valid.";
                                    }
                                    ?>
                                </span><br>
                                <span>Di tandatangani secara elektronik oleh: </span><br>
                                <span>Kepala <?php echo isset($lembaga['nama_lembaga']) ? strtoupper($lembaga['nama_lembaga']) : ''; ?></span><br>
                                <span style="font-weight: bold;"><?php echo isset($lembaga['nama_kepsek']) ? strtoupper($lembaga['nama_kepsek']) : ''; ?></span><br><br><br><br>
                                <span>NIP.<?php echo isset($lembaga['nip_kepsek']) ? strtoupper($lembaga['nip_kepsek']) : ''; ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>