<!-- . Meta Tags -->
<meta charset="utf-8">
<meta http-equiv="Content-Language" content="id">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- . Title -->
<title><?php echo $profilsekolah['nama_lembaga'] ?? ''; ?></title>

<!-- . Favicon -->
<link rel="alternate icon" type="image/png" href="<?php echo base_url('assets/web/' . $logo); ?>">

<!-- . Google Fonts (usahakan diletakkan awal agar font tampil cepat) -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- . Icon Fonts (Font Awesome) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://kit.fontawesome.com/c67daa5af8.js" crossorigin="anonymous"></script>

<!-- . Library CSS dari CDN (misal: Leaflet) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- . CSS Utama dan Plugin -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/toastr/toastr.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/css/adminlte.min.css'); ?>">

<!-- . DataTables & Plugins -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">

<!-- . Plugin Tambahan -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bs-stepper/css/bs-stepper.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/dropzone/min/dropzone.min.css'); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- . Library JS dari CDN (bisa dipindah ke body bawah untuk performa) -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>