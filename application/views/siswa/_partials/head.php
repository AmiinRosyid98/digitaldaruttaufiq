<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $profilsekolah['nama_lembaga'] ?? ''; ?></title>
<link rel="alternate icon" type="image/png" href="<?php echo base_url() ?>assets/web/<?php echo $profilsekolah['logo'] ?? ''; ?>">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/c67daa5af8.js" crossorigin="anonymous"></script>
<!-- Bootstap -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
<!-- Toastr Alert -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/toastr/toastr.min.css '); ?>">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url('/assets/admin/css/adminlte.min.css '); ?>">
<!-- Bootstrap Bundle dengan Popper -->


<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/bs-stepper/css/bs-stepper.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/admin/plugins/dropzone/min/dropzone.min.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
  #map {
    height: 400px;
  }
</style>
<style>
  .carousel-item.active .alert {
    animation: fadeIn 1s ease-in-out;
    font-style: italic;
  }

  @keyframes fadeIn {
    0% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }
</style>