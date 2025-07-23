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
            <div class="content-wrapper" style="min-height: 1700px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Kehadiran Siswa </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama siswa</th>
                                                <th>Kelas</th>
                                                <th>No Absen</th>
                                                <th>Kehadiran</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($absensionline)) : ?>
                                                <?php foreach ($absensionline as $index => $itemabsen) : ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                                        <td><?php echo html_escape($itemabsen['nama_siswa']); ?></td>
                                                        <td class="text-center"><?php echo html_escape($itemabsen['nama_kelas']); ?></td>
                                                        <td class="text-center"><?php echo html_escape($itemabsen['no_absen']); ?></td>
                                                        <td class="text-center <?php echo isset($itemabsen['absen']) && $itemabsen['absen'] == 'Masuk' ? 'text-success' : 'text-danger'; ?>">
                                                            <?php echo isset($itemabsen['absen']) ? html_escape($itemabsen['absen']) : 'Tidak Masuk'; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo !empty($itemabsen['timestamp']) ? date('d-m-Y', strtotime($itemabsen['timestamp'])) : '-'; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo !empty($itemabsen['timestamp']) ? date('H:i:s', strtotime($itemabsen['timestamp'])) : '-'; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data absensi ditemukan.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <div class="pagination">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="card">

                                <div class="card-body">
                                    <form method="get" action="<?php echo base_url('ptk/kehadiransiswa/index'); ?>">
                                        <div class="row">
                                            <div class="col-sm-5 text-end">
                                                <label for="start_date" class="col-form-label">Mulai Tanggal:</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-sm-5 text-end">
                                                <label for="end_date" class="col-form-label">Sampai Tanggal:</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-sm-5 text-end">
                                                <label for="kelas" class="col-form-label">Kelas:</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <select name="kelas" id="kelas" class="form-control">
                                                    <option value="">Pilih Kelas</option>
                                                    <?php foreach ($list_kelas as $kelas) : ?>
                                                        <option value="<?php echo $kelas['id_kelas']; ?>" <?php echo isset($selected_kelas) && $selected_kelas == $kelas['id_kelas'] ? 'selected' : ''; ?>><?php echo $kelas['nama_kelas']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-success">Tampilkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ======================================================================================================= -->

                    <!-- Modal Tambah Bank Soal Digital -->
                    <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Bank Soal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo site_url('ptk/filearsip/simpan_banksoal'); ?>" method="POST" enctype="multipart/form-data" enctype="multipart/form-data" role="form" onsubmit="return validateForm()">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama_arsip">Nama / Judul Bank Soal</label>
                                                    <input type="text" class="form-control" id="nama_arsip" name="nama_arsip" placeholder="Matematika Kelas X" oninput="this.value = this.value.toUpperCase()" required>
                                                    <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                                    <input type="hidden" class="form-control" id="timestamp_buku" name="timestamp_buku" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="file_arsip">File Bank Soal (PDF/Word)</label>
                                            <input type="file" class="form-control-file" id="file_arsip" name="file_arsip">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>










                    <?php $this->load->view('ptk/_partials/footer.php') ?>






                    <script>
                        //Fungsi Hapus Buku
                        function deleteBanksoal(banksoalId) {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "File Bank Soal akan terhapus permanen !",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?php echo base_url('/ptk/filearsip/hapus_banksoal/'); ?>" + banksoalId;
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