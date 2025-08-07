<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="<?php echo base_url() ?>assets/web/<?php echo $profilsekolah['logo'] ?? ''; ?>" class="brand-image">
    <span class="brand-text" style="font-size: 12px; margin-left: 0px; font-weight: bold;">SISMA</span><br>
    <span class="brand-text" style="font-size: 10px; margin-left: 0px;">Sistem Informasi Sekolah dan Madrasah</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-right">
        <div class="image mb-2">
            <img src="<?php echo base_url('assets/ptk/profile/' . $current_user->avatar); ?>" class="elevation-2" alt="User Image" style="width: 90px; height: 100px; border: 2px solid #fff; border-radius: 6px;">
        </div>
        <div class="info">
            <a href="#" class="text-white font-weight-bold" style="font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100px; text-align: center;"><?php echo $current_user->nama_ptk ?></a>
        </div>
    </div>