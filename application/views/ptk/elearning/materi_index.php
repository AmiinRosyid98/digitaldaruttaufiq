<html lang="en">

<head>
    <?php $this->load->view('ptk/_partials/head.php') ?>
</head>

<body>
    <?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $info_message = $this->session->flashdata('info_message');
    ?>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('ptk/_partials/navbar.php') ?>
            <!-- /.navbar -->

            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper" style="min-height: 1000px;">
                <!-- Content Header -->
                <div class="content-header">
                    <div class="container-fluid">
                        <h1 class="m-0 text-dark">E-Learning</h1>
                    </div>
                </div>

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Daftar Materi</h3>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addMateriModal">
                                            <i class="fas fa-plus-circle"></i> Tambah Materi
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <!-- Menampilkan materi -->
                                        <?php if (empty($materi)) : ?>
                                            <p class="text-muted">Belum ada materi yang ditambahkan.</p>
                                        <?php else : ?>
                                            <div class="row">
                                                <?php foreach ($materi as $m) : ?>
                                                    <div class="col-md-6 col-xl-4 mb-4">
                                                        <div class="card materi-card">
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <i class="fas fa-book-open text-primary mr-2"></i>
                                                                    <?= htmlspecialchars($m['judul_materi']) ?> - <?= htmlspecialchars($m['nama_kelas']) ?>
                                                                </h5><br>
                                                                <span class="badge bg-gradient-info text-white">
                                                                    <?= htmlspecialchars($m['nama_mapel'] ?? 'Tanpa Mapel') ?>
                                                                </span>
                                                                <p class="card-text mt-2 text-muted">
                                                                    <?= word_limiter(strip_tags($m['deskripsi']), 20) ?>
                                                                </p>
                                                                <a href="<?= base_url('ptk/materi/detail/' . $m['id_materi']) ?>"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-arrow-right"></i> Buka Materi
                                                                </a>

                                                                <!-- Tombol Edit -->
                                                                <button type="button"
                                                                    class="btn btn-sm btn-warning btn-edit-materi"
                                                                    data-id="<?= $m['id_materi']; ?>"
                                                                    data-judul="<?= htmlspecialchars($m['judul_materi']); ?>"
                                                                    data-deskripsi="<?= htmlspecialchars($m['deskripsi']); ?>"
                                                                    data-link="<?= htmlspecialchars($m['link_google_drive']); ?>"
                                                                    data-mapel="<?= $m['id_mapel']; ?>"
                                                                    data-kelas="<?= $m['id_kelas']; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#editMateriModal">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>

                                                                <!-- Tombol Hapus -->
                                                                <a href="#"
                                                                    class="btn btn-sm btn-danger btn-hapus-materi"
                                                                    data-id="<?= $m['id_materi']; ?>"
                                                                    data-nama="<?= $m['judul_materi']; ?>"> <!-- jika ada nama materi -->
                                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                                </a>



                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal untuk Tambah Materi -->
            <div class="modal fade" id="addMateriModal" tabindex="-1" role="dialog" aria-labelledby="addMateriModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMateriModalLabel">Tambah Materi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('ptk/materi/tambah_materi') ?>" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="judul_materi">Judul Materi</label>
                                    <input type="text" class="form-control" id="judul_materi" name="judul_materi" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="link_google_drive">Link / Google Drive</label>
                                    <input type="text" class="form-control" id="link_google_drive" name="link_google_drive">
                                </div>
                                <div class="form-group">
                                    <label for="mapel">Mata Pelajaran</label>
                                    <select class="form-control" id="mapel" name="mapel" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $mp) : ?>
                                            <option value="<?= $mp['id_mapel'] ?>"><?= $mp['nama_mapel'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="mapel">Untuk Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $mp) : ?>
                                            <option value="<?= $mp['id_kelas'] ?>"><?= $mp['nama_kelas'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah Materi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Materi -->
            <div class="modal fade" id="editMateriModal" tabindex="-1" role="dialog" aria-labelledby="editMateriModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('ptk/materi/update_materi') ?>" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Materi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Hidden ID -->
                                <input type="hidden" name="id_materi" id="edit_id_materi">

                                <div class="form-group">
                                    <label for="edit_judul_materi">Judul Materi</label>
                                    <input type="text" class="form-control" id="edit_judul_materi" name="judul_materi" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="edit_link_google_drive">Link / Google Drive</label>
                                    <input type="text" class="form-control" id="edit_link_google_drive" name="link_google_drive">
                                </div>
                                <div class="form-group">
                                    <label for="edit_mapel">Mata Pelajaran</label>
                                    <select class="form-control" id="edit_mapel" name="mapel" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $mp) : ?>
                                            <option value="<?= $mp['id_mapel'] ?>"><?= $mp['nama_mapel'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_kelas">Untuk Kelas</label>
                                    <select class="form-control" id="edit_kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $mp) : ?>
                                            <option value="<?= $mp['id_kelas'] ?>"><?= $mp['nama_kelas'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Footer -->
            <?php $this->load->view('ptk/_partials/footer.php') ?>
        </div>

        <!-- Script Notifikasi Toast -->
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

        <script>
            $(document).on('click', '.btn-hapus-materi', function(e) {
                e.preventDefault();

                var id = $(this).data('id');
                var nama = $(this).data('nama') || 'materi ini';

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Hapus "${nama}" secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url("ptk/materi/hapus_materi_ajax"); ?>',
                            method: 'POST',
                            data: {
                                id_materi: id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message);
                                    setTimeout(() => location.reload(), 1200);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function() {
                                toastr.error("Gagal Menghapus Data karena masih digunakan.");
                            }
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.btn-edit-materi').on('click', function() {
                    $('#edit_id_materi').val($(this).data('id'));
                    $('#edit_judul_materi').val($(this).data('judul'));
                    $('#edit_deskripsi').val($(this).data('deskripsi'));
                    $('#edit_link_google_drive').val($(this).data('link'));
                    $('#edit_mapel').val($(this).data('mapel'));
                    $('#edit_kelas').val($(this).data('kelas'));
                });
            });
        </script>