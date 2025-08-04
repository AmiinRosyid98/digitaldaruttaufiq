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
                                    <li class="breadcrumb-item active">Kelas</li>
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
                                <h3 class="card-title">Data Kelas / rombel </h3>
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
                                        <th>Nama Kelas</th>
                                        <th>Kode Kelas</th>
                                        <th>Kode Tingkat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kelas as $index => $kelas) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $kelas['nama_kelas']; ?></td>
                                            <td class="text-center"><?php echo $kelas['no_kelas']; ?></td>
                                            <td class="text-center"><?php echo $kelas['kode_tingkat']; ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteKelas(<?php echo $kelas['id_kelas']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="editKelas(<?php echo $kelas['id_kelas']; ?>)"><i class="fas fa-edit"></i></a>
                                                <a class='btn btn-primary btn-sm' href='<?php echo base_url("admin/kelas/cetak_siswakelas/" . $kelas['no_kelas']); ?>' target='_blank'><i class='fas fa-print'></i></a>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/masterdata/simpan_kelas'); ?>" id="simpan_kelas" method="POST">
                                <div class="form-group">
                                    <label for="kodeLayanan">Kode Kelas</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kodeLayanan" name="no_kelas" required readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary" id="generateKode">Generate Kode</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" oninput="this.value = this.value.toUpperCase()" required>
                                </div>

                                <div class="form-group">
                                    <label for="kode_tingkat">Tingkat</label>
                                    <select class="form-control" id="kode_tingkat" name="kode_tingkat" required>
                                        <option value="">Pilih Tingkat</option>
                                        <?php foreach ($tingkat as $item_tingkat) : ?>
                                            <option value="<?php echo $item_tingkat['nama_tingkat']; ?>"><?php echo $item_tingkat['nama_tingkat']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kode_tingkat">Wali Kelas</label>
                                    <select class="form-control" id="id_guru" name="id_guru" >
                                        <option value="">Pilih Wali Kelas</option>
                                        <?php foreach ($ptk as $wali) : ?>
                                            <option value="<?php echo $wali['id_guru']; ?>"><?php echo $wali['nama_ptk']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" id="btn_simpan_kelas" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Kelas -->
            <div class="modal fade" id="editKelasModal" tabindex="-1" role="dialog" aria-labelledby="editKelasModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKelasModalLabel">Edit Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editKelasForm">
                            <div class="modal-body">
                                <input type="hidden" id="editKelasId" name="editKelasId">
                                <div class="form-group">
                                    <label for="editKodeKelas">Kode Kelas</label>
                                    <input type="text" class="form-control" id="editKodeKelas" name="editKodeKelas" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="editNamaKelas">Nama Kelas</label>
                                    <input type="text" class="form-control" id="editNamaKelas" name="editNamaKelas" oninput="this.value = this.value.toUpperCase()" required>
                                </div>

                                <div class="form-group">
                                    <label for="editKodeTingkat">Tingkat</label>
                                    <select class="form-control" id="editKodeTingkat" name="editKodeTingkat" required>
                                        <option value="">Pilih Tingkat</option>
                                        <?php foreach ($tingkat as $item_tingkat) : ?>
                                            <option value="<?php echo $item_tingkat['nama_tingkat']; ?>"><?php echo $item_tingkat['nama_tingkat']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit_id_guru">Wali Kelas</label>
                                    <select class="form-control" id="edit_id_guru" name="edit_id_guru" required>
                                        <option value="">Pilih Wali Kelas</option>
                                        <?php foreach ($ptk as $wali) : ?>
                                            <option value="<?php echo $wali['id_guru']; ?>"><?php echo $wali['nama_ptk']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                //Fungsi Hapus Kelas
                function deleteKelas(kelasId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Kelas/Rombel ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/masterdata/hapus_kelas/'); ?>" + kelasId;
                        }
                    });
                }
            </script>

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