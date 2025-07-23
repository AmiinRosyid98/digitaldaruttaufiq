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

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1000px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Jadwal KBM </h3>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#tambahkelasModal">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Hari</th>
                                                <th>Kelas</th>
                                                <th>Nama Mapel</th>
                                                <th>Jam</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($jadwalkbm as $index => $kbm) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td class="text-center"><?php echo $kbm['hari']; ?></td>
                                                    <td class="text-center"><?php echo $kbm['nama_kelas']; ?></td>
                                                    <td class="text-center"><?php echo $kbm['nama_mapel']; ?></td>
                                                    <td class="text-center"><?php echo $kbm['jam_mulai']; ?> - <?php echo $kbm['jam_selesai']; ?></td>

                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modalEditJadwal"
                                                            data-id="<?php echo $kbm['id']; ?>"
                                                            data-hari="<?php echo $kbm['hari']; ?>"
                                                            data-id_kelas="<?php echo $kbm['id_kelas']; ?>"
                                                            data-id_mapel="<?php echo $kbm['id_mapel']; ?>"
                                                            data-jam_mulai="<?php echo $kbm['jam_mulai']; ?>"
                                                            data-jam_selesai="<?php echo $kbm['jam_selesai']; ?>">
                                                            Edit
                                                        </button>
                                                        <button onclick="deleteJadwalKBM(<?php echo $kbm['id']; ?>)" class="btn btn-danger btn-sm">
                                                            Hapus
                                                        </button>
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
                </div>


                <!-- ======================================================================================================= -->


                <!-- Modal Tambah Jadwal KBM -->
                <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Jadwal KBM</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo site_url('ptk/Jadwal_kbm/simpan_jadwalkbm'); ?>" method="POST" role="form">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="hari">Hariddd</label>
                                                <select class="form-control" id="hari" name="hari" required>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                                <label for="kelas">Kelas</label>
                                                <select class="form-control" id="kelas" name="id_kelas" required>
                                                    <?php foreach ($kelas as $item_kelas) : ?>
                                                        <option value="<?= $item_kelas['id_kelas']; ?>"><?= $item_kelas['nama_kelas']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="jam_mulai">Jam Mulai</label>
                                                <select class="form-control" id="jam_mulai" name="jam_mulai" required>
                                                    <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                        <option value="<?= $i; ?>">Jam ke-<?= $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="jam_selesai">Jam Selesai</label>
                                                <select class="form-control" id="jam_selesai" name="jam_selesai" required>
                                                    <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                        <option value="<?= $i; ?>">Jam ke-<?= $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="mapel">Mata Pelajaran</label>
                                                <select class="form-control" id="mapel" name="id_mapel" required>
                                                    <?php foreach ($mapel as $item_mapel) : ?>
                                                        <option value="<?= $item_mapel['id_mapel']; ?>"><?= $item_mapel['nama_mapel']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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


                <!-- Modal Edit Jadwal -->
                <div class="modal fade" id="modalEditJadwal" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="<?php echo site_url('ptk/Jadwal_kbm/update_jadwalkbm'); ?>" method="post">
                            <input type="hidden" name="id" id="edit-id-jadwal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Jadwal KBM</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Hari</label>
                                        <select name="hari" id="edit-hari" class="form-control">
                                            <?php
                                            $hari_opsi = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                            foreach ($hari_opsi as $hari) {
                                                echo "<option value='$hari'>$hari</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select name="id_kelas" id="edit-id-kelas" class="form-control">
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?php echo $k['id_kelas']; ?>"><?php echo $k['nama_kelas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Tambahan Pilihan Jam Mulai dan Selesai -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="edit-jam-mulai">Jam Mulai</label>
                                            <select class="form-control" id="edit-jam-mulai" name="jam_mulai" required>
                                                <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                    <option value="<?= $i; ?>">Jam ke-<?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="edit-jam-selesai">Jam Selesai</label>
                                            <select class="form-control" id="edit-jam-selesai" name="jam_selesai" required>
                                                <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                    <option value="<?= $i; ?>">Jam ke-<?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Mapel</label>
                                        <select name="id_mapel" id="edit-id-mapel" class="form-control">
                                            <?php foreach ($mapel as $m) : ?>
                                                <option value="<?php echo $m['id_mapel']; ?>"><?php echo $m['nama_mapel']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <?php $this->load->view('ptk/_partials/footer.php') ?>





                <script>
                    function deleteJadwalKBM(idJadwal) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Jadwal KBM ini akan terhapus permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?php echo base_url('ptk/Jadwal_kbm/hapus_jadwalkbm/'); ?>" + idJadwal;
                            }
                        });
                    }
                </script>

                <script>
                    $('#modalEditJadwal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Tombol yang diklik
                        var id = button.data('id');
                        var hari = button.data('hari');
                        var id_kelas = button.data('id_kelas');
                        var id_mapel = button.data('id_mapel');
                        var jam_mulai = button.data('jam_mulai');
                        var jam_selesai = button.data('jam_selesai');

                        // Set value ke form di modal
                        var modal = $(this);
                        modal.find('#edit-id-jadwal').val(id);
                        modal.find('#edit-hari').val(hari);
                        modal.find('#edit-id-kelas').val(id_kelas);
                        modal.find('#edit-id-mapel').val(id_mapel);
                        modal.find('#edit-jam-mulai').val(jam_mulai);
                        modal.find('#edit-jam-selesai').val(jam_selesai);
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

                    <?php if ($info_message) : ?>
                        showToast('info', '<?php echo $info_message; ?>');
                    <?php endif; ?>

                    <?php if ($error_message) : ?>
                        showToast('error', '<?php echo $error_message; ?>');
                    <?php endif; ?>
                </script>