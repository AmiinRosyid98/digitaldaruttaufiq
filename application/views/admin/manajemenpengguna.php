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
                                    <li class="breadcrumb-item active">Manajemen Pengguna</li>
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
                                <h3 class="card-title">Manajemen Pengguna </h3>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkelasModal">
                                    <i class="fa-solid fa-user-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username </th>
                                        <th>Email </th>
                                        <th>Role </th>
                                        <th>Login Terakhir </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($manajemenpengguna as $index => $manajemenpengguna) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $manajemenpengguna['name']; ?></td>
                                            <td class="text-center"><?php echo $manajemenpengguna['username']; ?></td>
                                            <td class="text-center"><?php echo $manajemenpengguna['email']; ?></td>
                                            <td class="text-center"><?php echo $manajemenpengguna['role']; ?></td>

                                            <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($manajemenpengguna['last_login'])); ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deletePengguna(<?php echo $manajemenpengguna['id']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="editPengguna(<?php echo $manajemenpengguna['id']; ?>)"><i class="fas fa-edit"></i></a>

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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/manajemenpengguna/simpan_pengguna'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" required>
                                    <input type="hidden" class="form-control" id="avatar" name="avatar" value="default.png" required>
                                    <input type="hidden" class="form-control" id="created_at" name="created_at" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="email">Email / Username</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role">Pilih peran:</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="admin">Admin</option>
                                        <option value="bendahara">Bendahara</option>
                                        <option value="bk">BK</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Pengguna -->
            <div class="modal fade" id="editPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="editTingkatModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTingkatModalLabel">Edit Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editPenggunaForm">
                            <div class="modal-body">
                                <input type="hidden" id="editPenggunaId" name="editPenggunaId">
                                <div class="form-group">
                                    <label for="editNamaPengguna">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="editNamaPengguna" name="editNamaPengguna" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editUserPengguna">Username</label>
                                        <input type="text" class="form-control" id="editUserPengguna" name="editUserPengguna" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editEmailPengguna">Email</label>
                                        <input type="email" class="form-control" id="editEmailPengguna" name="editEmailPengguna" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="editPasswordPengguna">Password Baru (Opsional)</label>
                                    <input type="password" class="form-control" id="editPasswordPengguna" name="editPasswordPengguna">
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
                //Fungsi Edit Siswa
                function editPengguna(penggunaId) {
                    $.ajax({
                        url: 'manajemenpengguna/get_pengguna',
                        type: 'GET',
                        data: {
                            pengguna_id: penggunaId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#editPenggunaId').val(response.pengguna.id);
                            $('#editNamaPengguna').val(response.pengguna.name);
                            $('#editUserPengguna').val(response.pengguna.username);
                            $('#editEmailPengguna').val(response.pengguna.email);

                            $('#editPenggunaModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data member.');
                        }
                    });
                }

                $(document).ready(function() {
                    $('#editPenggunaForm').submit(function(event) {
                        event.preventDefault();

                        $.ajax({
                            url: 'manajemenpengguna/update_pengguna',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#editPenggunaModal').modal('hide');
                                    showToast('success', 'Data Pengguna berhasil diperbarui.');
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
                //Fungsi Hapus Pengguna
                function deletePengguna(pengggunaId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Pengguna ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/manajemenpengguna/hapus_pengguna/'); ?>" + pengggunaId;
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