
<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
<img src="<?php echo base_url() ?>assets/web/<?php echo $profilsekolah['logo'] ?? ''; ?>" class="brand-image">
<span class="brand-text font-weight-light-bold">SMARTSCHOOL</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex" >
    <div class="image">
        <img src="<?php echo base_url('assets/member/profile/' . $current_user->avatar); ?>" class="elevation-2" alt="User Image" style="width: 40px; height: 40px; border: 2px solid #fff; border-radius: 6px;">
    </div>
    <div class="info" style="overflow: hidden; width: 180px;">
        <a href="#" class="d-block text-white text-bold" style="font-size: 12px;"><?php echo $current_user->nama_siswa ?></a>
    </div>
</div>
