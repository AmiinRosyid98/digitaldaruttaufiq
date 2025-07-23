<!-- Brand Logo -->
<a href="#" class="brand-link">
    <img src="<?php echo base_url('assets/web/' . $logo); ?>" alt="Logo" class="brand-image">
    <span class="brand-text" style="font-size: 12px; margin-left: 0px; font-weight: bold;">SMARTSCHOOL VERSI DESKTOP</span><br>
    <span class="brand-text" style="font-size: 10px; margin-left: 0px;">Manajemen sekolah berbasis digital</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?php echo base_url('assets/admin/profile/' . $current_user->avatar); ?>" class="img-circle elevation-2" alt="User Image" style="width: 45px; height: 45px;">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo $current_user->name ?></a>
        </div>
    </div>
    <span class="badge badge-danger">PROSES 0.0279 | MEMORY 4.22MB</span>