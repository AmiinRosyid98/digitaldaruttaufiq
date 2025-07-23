<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lembaga['nama_lembaga'] ?? ''; ?></title>
</head>
<body>
    <!-- KOP SURAT -->
    <?php include 'kop_surat.php'; ?>
    <br>

    <div>
        <div style="display: inline-block; position: relative; text-align: center; margin-top: 5px;">
            <span style="font-size: 14px; font-weight: bold;"><u style="display: inline-block;">SURAT KETERANGAN KELULUS</u></span><br>
            Nomor : 
        </div>

        <div style="text-align: justify;" >
            <p style="text-indent: 50px; font-size: 12px; font-family: Times New Roman, Times, serif">Yang bertanda tangan di bawah ini Kepala <?php echo $lembaga['nama_lembaga'] ?? ''; ?>. Dengan ini menerangkan bahwa :</p>
            <table style="border: none; font-family: Times New Roman, Times, serif">                
                <tr>
                    <td width="160">Nama</td>
                    <td width="10">:</td>
                    <td><?php echo $siswa['nama_siswa'] ?? ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Jenis Kelamin</td>
                    <td width="10">:</td>
                    <td><?php $jenis_kelamin = isset($siswa['jeniskelamin']) ? (strtolower($siswa['jeniskelamin']) == 'p' ? 'Perempuan' : 'Laki-laki') : 'Jenis kelamin tidak diketahui'; echo $jenis_kelamin; ?></td>
                </tr>
                <tr>
                    <td width="160">Tempat, Tanggal Lahir</td>
                    <td width="10">:</td>
                    <td><?php echo $siswa['tempatlahir'] ?? ''; ?>, <?php echo date('d-m-Y', strtotime($siswa['tanggallahir'])); ?></td>
                </tr>
                <tr>
                    <td width="160">Nomor Induk Siswa</td>
                    <td width="10">:</td>
                    <td><?php echo $siswa['nis'] ?? ''; ?></td>
                </tr>
                <tr>
                    <td width="160">Nomor Induk Siswa Nasional</td>
                    <td width="10">:</td>
                    <td><?php echo $siswa['nisn'] ?? ''; ?></td>
                </tr>
            </table>
        </div>

      

    </div>




    
</body>
</html>
