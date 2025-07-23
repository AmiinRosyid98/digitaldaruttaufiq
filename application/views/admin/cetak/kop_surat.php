<table style="width: 100%; text-align: center; border-bottom: 2px solid black; padding: 2px 0;">
    <tr>
        <td style="text-align: left; width: 15%;">
            <img src="<?php echo $data['logo']; ?>" alt="Logo Lembaga" width="75" height="80">
        </td>
        <td nowrap style="width: 70%;">
            <span style="margin: 0; font-size: 16px;"><?php echo strtoupper($lembaga['naungan_lembaga']); ?></span><br>
            <span style="margin: 0; font-size: 18px; font-weight: bold;"><?php echo strtoupper($lembaga['nama_lembaga']); ?></span><br>
            <span style="margin: 0; font-size: 10px;"><?php echo $lembaga['alamat_lembaga']; ?>, <?php echo $lembaga['kab_lembaga']; ?>, <?php echo $lembaga['prov_lembaga']; ?> <?php echo $lembaga['kodepos_lembaga']; ?></span><br>
            <span style="margin: 0; font-size: 10px;">No Telp : <?php echo $lembaga['notelp_lembaga']; ?>, Faksimile : <?php echo $lembaga['notelp_lembaga']; ?></span><br>
            <span style="margin: 0; font-size: 9px;">Website : <?php echo $lembaga['website_lembaga']; ?>, Email : <?php echo $lembaga['email_lembaga']; ?></span><br>
        </td>
        <td style="text-align: right; width: 15%;">
            <img src="<?php echo $data['logopemerintah']; ?>" alt="Logo Pemerintah" width="75" height="80">
        </td>
    </tr>
</table>