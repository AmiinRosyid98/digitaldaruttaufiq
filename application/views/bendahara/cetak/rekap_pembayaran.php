<!DOCTYPE html>
<html>

<head>
    <title><?php echo $lembaga['nama_lembaga'] ?? ''; ?></title>
</head>

<body>
    <!-- KOP SURAT -->
    <?php include 'kop_surat.php'; ?>
    <br>
    <br>

</body>

<?php
// Periksa apakah ada data siswa yang diterima dari controller
if (!empty($historypembayaran)) {
?>
    <!-- Tabel untuk menampilkan history pembayaran -->
    <table border="1" cellspacing="0" cellpadding="3">
        <thead>
            <tr>
                <th style="width: 32px; text-align: center;">No</th>
                <th style="width: 60px; text-align: center;">NIS</th>
                <th style="width: 250px; text-align: center;">Nama Siswa</th>
                <th style="width: 60px; text-align: center;">Kelas</th>
                <th style="width: 120px; text-align: center;">POS</th>
                <th style="width: 100px; text-align: center;">Tagihan</th>
                <th style="width: 100px; text-align: center;">Pembayaran</th>
                <th style="width: 90px; text-align: center;">Tahun Pelajaran</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historypembayaran as $key => $history) : ?>
                <tr>
                    <td style="width: 32px; font-size: 11px; text-align: center;"><?php echo $key + 1; ?></td>
                    <td style="width: 60px; font-size: 11px; text-align: center;"><?php echo htmlspecialchars($history['nis']); ?></td>
                    <td style="width: 250px; font-size: 11px; text-align: left;"><?php echo htmlspecialchars($history['nama_siswa']); ?></td>
                    <td style="width: 60px; font-size: 11px; text-align: center;"><?php echo htmlspecialchars($history['nama_kelas']); ?></td>
                    <td style="width: 120px; font-size: 11px; text-align: center;">
                        <?php if (isset($history['pembayaran'][0]['nama_pos'])) : ?>
                            <?php echo htmlspecialchars($history['pembayaran'][0]['nama_pos']); ?>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td style="width: 100px; font-size: 11px; text-align: center;">
                        <?php if (isset($history['pembayaran'][0]['jumlah_tarif'])) : ?>
                            Rp. <?php echo number_format($history['pembayaran'][0]['jumlah_tarif']); ?>
                        <?php else : ?>
                            0
                        <?php endif; ?>
                    </td>
                    <td style="width: 100px; font-size: 11px; text-align: center;">
                        <?php if (isset($history['pembayaran'][0]['jumlah_pembayaran'])) : ?>
                            Rp. <?php echo number_format($history['pembayaran'][0]['jumlah_pembayaran']); ?>
                        <?php else : ?>
                            0
                        <?php endif; ?>
                    </td>
                    <td style="width: 90px; font-size: 11px; text-align: center;">
                        <?php if (isset($history['pembayaran'][0]['tahun_pelajaran'])) : ?>
                            <?php echo htmlspecialchars($history['pembayaran'][0]['tahun_pelajaran']); ?>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
<?php
} else {
    // Tampilkan pesan jika tidak ada data siswa yang diterima
    echo "Tidak ada data siswa yang ditemukan.";
}
?>

</html>