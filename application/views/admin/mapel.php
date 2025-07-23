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
                                    <li class="breadcrumb-item active">Mapel</li>
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
                                <h3 class="card-title">Data Mapel </h3>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahmapelModal">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Mapel</th>
                                        <th>Kelompok</th>
                                        <th>No Urut</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mapel as $index => $datamapel) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center" style="font-weight: bold;"><?php echo $datamapel['nama_mapel']; ?></td>
                                            <td class="text-center" style="font-weight: bold;"><?php echo $datamapel['kelompok_mapel']; ?></td>
                                            <td class="text-center" style="font-weight: bold;"><?php echo $datamapel['nourut_mapel']; ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteMapel(<?php echo $datamapel['id_mapel']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="editMapel(<?php echo $datamapel['id_mapel']; ?>)"><i class="fas fa-edit"></i></a>

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

            <!-- Modal Tambah Mapel -->
            <div class="modal fade" id="tambahmapelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Mapel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/masterdata/simpan_mapel'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_mapel">Nama Mapel</label>
                                    <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kelompok_mapel">Kelompok Mapel</label>
                                            <select class="form-control" id="kelompok_mapel" name="kelompok_mapel" required>
                                                <option value="">Pilih Kelompok Mapel</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">No Urut</label>
                                            <input type="number" class="form-control" id="nourut_mapel" name="nourut_mapel" required>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Mapel -->
            <div class="modal fade" id="editMapelModal" tabindex="-1" role="dialog" aria-labelledby="editMapelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMapelModalLabel">Edit Mapel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editMapelForm">
                            <div class="modal-body">
                                <input type="hidden" id="editMapelId" name="editMapelId">
                                <div class="form-group">
                                    <label for="editNamaMapel">Nama Mapel</label>
                                    <input type="text" class="form-control" id="editNamaMapel" name="editNamaMapel" required>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="editKelompokMapel">Kelompok Mapel</label>
                                            <select class="form-control" id="editKelompokMapel" name="editKelompokMapel" required>
                                                <option value="">Pilih Kelompok Mapel</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="editNourutMapel">No Urut</label>
                                            <input type="number" class="form-control" id="editNourutMapel" name="editNourutMapel" required>
                                        </div>
                                    </div>
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
                //Fungsi Edit Mapel
                function editMapel(mapelId) {
                    $.ajax({
                        url: 'get_mapel',
                        type: 'GET',
                        data: {
                            mapel_id: mapelId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#editMapelId').val(response.mapel.id_mapel);
                            $('#editNamaMapel').val(response.mapel.nama_mapel);
                            $('#editKelompokMapel').val(response.mapel.kelompok_mapel);
                            $('#editNourutMapel').val(response.mapel.nourut_mapel);
                            $('#editMapelModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data Mapel.');
                        }
                    });
                }


                $(document).ready(function() {
                    $('#editMapelForm').submit(function(event) {
                        event.preventDefault();

                        $.ajax({
                            url: 'update_mapel',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#editMapelModal').modal('hide');
                                    showToast('success', 'Data Mapel berhasil diperbarui.');
                                    location.reload();
                                } else {
                                    showToast('error', 'Gagal menyimpan perubahan.');
                                }
                            },
                            error: function() {
                                showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                            }
                        });
                    });
                });

                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }
            </script>

            <script>
                //Fungsi Hapus Tingkat
                function deleteMapel(mapelId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Mapel ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/masterdata/hapus_mapel/'); ?>" + mapelId;
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