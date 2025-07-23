<html lang="en">

<head>

    <?php $this->load->view('admin/_partials/head.php') ?>
</head>

<body>
    <?php
    // Ambil pesan flash success
    $success_message = $this->session->flashdata('success_message');
    $success_delete_message = $this->session->flashdata('success_delete_message');
    $error_message = $this->session->flashdata('error_message');
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

                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Link Dinamis</h3>
                                <button type="button"
                                    class="btn btn-sm btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2"
                                    data-toggle="modal"
                                    data-target="#tambahLink"
                                    title="Tambah Link Baru">
                                    <i class="fa-solid fa-link"></i>
                                    <span class="fw-semibold">Tambah</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Link</th>
                                        <th>Link</th>
                                        <th>Logo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($linkdinamis as $index => $item) : ?>
                                        <tr>
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td class="text-center"><?= htmlspecialchars($item['nama_link']) ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($item['link'])) : ?>
                                                    <a href="<?= htmlspecialchars($item['link']) ?>"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="btn btn-icon btn-sm btn-outline-info"
                                                        title="Buka Link">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        <span class="visually-hidden">Menuju Link</span>
                                                    </a>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">No Link</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($item['logo_link'])) : ?>
                                                    <img src="<?= base_url('upload/logo_link/' . htmlspecialchars($item['logo_link'])) ?>" alt="Logo" style="max-height: 60px;">
                                                <?php else : ?>
                                                    No Logo
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm btn-edit-link"
                                                        data-toggle="modal"
                                                        data-target="#editLink"
                                                        data-id="<?= $item['id'] ?>"
                                                        data-nama="<?= htmlspecialchars($item['nama_link']) ?>"
                                                        data-link="<?= htmlspecialchars($item['link']) ?>"
                                                        data-logo="<?= htmlspecialchars($item['logo_link']) ?>"
                                                        data-toggle="tooltip"
                                                        title="Edit Data">
                                                        <i class="fas fa-pen text-primary"></i>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm"
                                                        onclick="deletelink(<?= (int)$item['id'] ?>)"
                                                        data-toggle="tooltip"
                                                        title="Hapus Data">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </div>
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

            <!-- Modal Link Dinamis -->
            <div class="modal fade" id="tambahLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Link Dinamis</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/linkdinamis/simpan_linkdinamis'); ?>" method="POST" enctype="multipart/form-data" role="form" onsubmit="return validateForm()">

                                <div class="form-group">
                                    <label for="nama_link">Nama Link</label>
                                    <input type="text" class="form-control" id="nama_link" name="nama_link" placeholder="Nama Link" required>
                                </div>

                                <div class="form-group">
                                    <label for="link">Alamat Link</label>
                                    <input type="text" class="form-control" id="link" name="link" placeholder="Alamat Link" required>
                                </div>

                                <div class="form-group">
                                    <label for="logo_link">File Dokumen (jpg/jpeg/png) Max 3MB</label>
                                    <input type="file" class="form-control-file" id="logo_link" name="logo_link" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Link Dinamis -->
            <div class="modal fade" id="editLink" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?php echo site_url('admin/linkdinamis/update_linkdinamis'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Link Dinamis</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="id" id="edit_id">

                                <div class="form-group">
                                    <label for="edit_nama_link">Nama Link</label>
                                    <input type="text" class="form-control" id="edit_nama_link" name="nama_link" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_link">Alamat Link</label>
                                    <input type="text" class="form-control" id="edit_link" name="link" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_logo_link">Ganti Logo (Opsional)</label>
                                    <input type="file" class="form-control-file" id="edit_logo_link" name="logo_link">
                                    <small>Biarkan kosong jika tidak ingin mengubah logo.</small>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>










            <?php $this->load->view('admin/_partials/footer.php') ?>

            <script>
                //Fungsi Hapus Pengguna
                function deletelink(pengggunaId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/linkdinamis/hapus_link/'); ?>" + pengggunaId;
                        }
                    });
                }
            </script>

            <script>
                $(document).ready(function() {
                    $('.btn-edit-link').on('click', function() {
                        var id = $(this).data('id');
                        var nama = $(this).data('nama');
                        var link = $(this).data('link');
                        var logo = $(this).data('logo');

                        $('#edit_id').val(id);
                        $('#edit_nama_link').val(nama);
                        $('#edit_link').val(link);
                    });
                });
            </script>


            <script>
                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }

                <?php if ($success_message) : ?>
                    showToast('success', '<?php echo $success_message; ?>');
                <?php endif; ?>
                <?php if ($success_delete_message) : ?>
                    showToast('error', '<?php echo $success_delete_message; ?>');
                <?php endif; ?>
            </script>