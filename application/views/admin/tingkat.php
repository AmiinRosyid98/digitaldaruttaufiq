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

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
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
                                    <li class="breadcrumb-item active">Tingkat</li>
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
                                <h3 class="card-title">Data Tingkat </h3>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkelasModal">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Tingkat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tingkat as $index => $tingkat) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $tingkat['nama_tingkat']; ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteTingkat(<?php echo $tingkat['id_tingkat']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="editTingkat(<?php echo $tingkat['id_tingkat']; ?>)"><i class="fas fa-edit"></i></a>

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

            <!-- Modal Tambah Kelas -->
            <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Tingkat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/masterdata/simpan_tingkat'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_tingkat">Nama Tingkat</label>
                                    <input type="text" class="form-control" id="nama_tingkat" name="nama_tingkat" oninput="this.value = this.value.toUpperCase()" required>
                                </div>


                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Kelas -->
            <div class="modal fade" id="editTingkatModal" tabindex="-1" role="dialog" aria-labelledby="editTingkatModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTingkatModalLabel">Edit Tingkat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editTingkatForm">
                            <div class="modal-body">
                                <input type="hidden" id="editTingkatId" name="editTingkatId">
                                <div class="form-group">
                                    <label for="editNamaTingkat">Nama Tingkat</label>
                                    <input type="text" class="form-control" id="editNamaTingkat" name="editNamaTingkat" oninput="this.value = this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>









            <?php $this->load->view('admin/_partials/footer.php') ?>



            <script>
                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }

                <?php if ($success_message) : ?>
                    showToast('success', '<?php echo $success_message; ?>');
                <?php endif; ?>

                <?php if ($info_message) : ?>
                    showToast('info', '<?php echo $info_message; ?>');
                <?php endif; ?>

                <?php if ($error_message) : ?>
                    showToast('error', '<?php echo $error_message; ?>');
                <?php endif; ?>
            </script>