<html lang="en">
<head>
    
    <?php $this->load->view('admin/_partials/head.php') ?>
</head>

<body>
<?php
// Ambil pesan flash success
$success_message = $this->session->flashdata('success_message');
// Ambil pesan flash error
$error_message = $this->session->flashdata('error_message');
// Ambil pesan flash info
$info_message = $this->session->flashdata('info_message');
?>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('admin/_partials/navbar.php') ?>
            <!-- /.navbar -->
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('admin/_partials/sidebar_information.php') ?>
                <!-- Sidebar Menu -->
                <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>
            </aside>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 900px;">                
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Leger Absensi Manual</li>
                        </ol>
                    </div>
                    </div>
                </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Leger Absensi Manual </h3>
                        </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Jumlah Siswa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($absensimanual as $index => $absensimanual): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td class="text-center"><?php echo $absensimanual['nama_kelas']; ?></td>
                                        <td class="text-center"><?php echo $absensimanual['jumlah_siswa']; ?></td>
                                        <td class="text-center">
                                        <a class='btn btn-danger btn-sm' href='<?php echo base_url("admin/absensi/cetak_leger_absensi/".$absensimanual['no_kelas']); ?>' target='_blank'><i class='fas fa-print'></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <div class="pagination">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

<!-- ======================================================================================================= -->

            

<?php $this->load->view('admin/_partials/footer.php') ?>


<script>
    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }

    <?php if($success_message): ?>
        showToast('success', '<?php echo $success_message; ?>');
    <?php endif; ?>

    <?php if($info_message): ?>
        showToast('info', '<?php echo $info_message; ?>');
    <?php endif; ?>

    <?php if($error_message): ?>
        showToast('error', '<?php echo $error_message; ?>');
    <?php endif; ?>

</script>


