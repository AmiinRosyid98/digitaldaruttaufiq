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
                                        <h3 class="card-title">Data Dokumen </h3>
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
                                                <th>Judul Dokumen</th>
                                                <th>File</th>
                                                <th>Kategori</th>
                                                <th>Waktu</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($banksoal as $index => $itembanksoal) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td class="text-left text-bold margin: 10;"><?php echo $itembanksoal['nama_arsip']; ?><br>
                                                        <span class="badge badge-pill badge-success"><?php echo $itembanksoal['nama_ptk']; ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        $file_path = base_url('upload/dokumen/') . $itembanksoal['file_arsip'];
                                                        $file_extension = pathinfo($itembanksoal['file_arsip'], PATHINFO_EXTENSION);

                                                        // Tentukan kelas ikon berdasarkan ekstensi file
                                                        switch ($file_extension) {
                                                            case 'pdf':
                                                                $icon_class = 'far fa-file-pdf fa-2x'; // Ikon PDF
                                                                $icon_style = 'color: red;'; // Gaya CSS untuk warna merah
                                                                break;
                                                            case 'zip':
                                                                $icon_class = 'far fa-file-zipper fa-2x'; // Ikon PDF
                                                                $icon_style = 'color: #544E4D;'; // Gaya CSS untuk warna merah
                                                                break;
                                                            case 'doc':
                                                            case 'docx':
                                                                $icon_class = 'far fa-file-word fa-2x'; // Ikon Word
                                                                $icon_style = ''; // Gaya CSS kosong untuk menghapus gaya sebelumnya jika ada
                                                                break;
                                                            default:
                                                                $icon_class = 'far fa-file-alt fa-2x'; // Ikon umum berkas
                                                                $icon_style = ''; // Gaya CSS kosong untuk menghapus gaya sebelumnya jika ada
                                                                break;
                                                        }
                                                        ?>

                                                        <a href="<?php echo $file_path; ?>" target="_blank">
                                                            <i class="<?php echo $icon_class; ?>" style="<?php echo $icon_style; ?>"></i>
                                                        </a>
                                                    </td>

                                                    <td class="text-center"><?php echo $itembanksoal['kategori']; ?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($itembanksoal['timestamp_arsip'])); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-danger btn-sm" href="#" onclick="deleteBanksoal(<?php echo $itembanksoal['id']; ?>)"><i class="fas fa-trash"></i></a>
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

                        <div class="col-12 col-md-3">
                            <div class="timeline">
                                <?php foreach ($banksoaltimeline as $index => $itemtimeline) : ?>
                                    <?php $random_color = '#' . substr(md5(mt_rand()), 0, 3); ?>
                                    <div class="time-label">
                                        <span style="background-color: <?php echo $random_color; ?>; color: white; padding: 2px 5px; border-radius: 3px;">
                                            <?php echo date('d-m-Y', strtotime($itemtimeline['timestamp_arsip'])); ?>
                                        </span>
                                    </div>
                                    <div>
                                    </div>
                                    <div>
                                        <i class="fas fa-folder-open bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <strong><?php echo date('d-m-Y H:i:s', strtotime($itemtimeline['timestamp_arsip'])); ?></strong></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo $itemtimeline['nama_ptk']; ?></a> Menyimpan</h3>
                                            <div class="timeline-body" style="font-size: 14px;">Telah menyimpan Dokumen<br><strong style="font-size: 15px;"><?php echo $itemtimeline['nama_arsip']; ?></strong></div>
                                            <div class="timeline-footer">
                                                <a class="btn btn-info btn-sm" href="<?php echo base_url() ?>upload/dokumen/<?php echo $itemtimeline['file_arsip']; ?>" target="_blank">Lihat File</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                    <!-- ======================================================================================================= -->

                    <!-- Modal Tambah Dokumen Digital -->
                    <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Dokumen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo site_url('ptk/filearsip/simpan_banksoal'); ?>" method="POST" enctype="multipart/form-data" role="form" onsubmit="return validateForm()">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama_arsip">Nama / Judul Dokumen</label>
                                                    <input type="text" class="form-control" id="nama_arsip" name="nama_arsip" placeholder="Matematika Kelas X" oninput="this.value = this.value.toUpperCase()" required>
                                                    <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                                    <input type="hidden" class="form-control" id="timestamp_buku" name="timestamp_buku" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tambahkan kategori dokumen di sini -->
                                        <div class="form-group">
                                            <label for="kategori">Kategori Dokumen</label>
                                            <select class="form-control" id="kategori" name="kategori" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="Dokumen">Dokumen</option>
                                                <option value="Soal">Soal</option>
                                                <option value="Materi">Materi</option>
                                                <option value="Kegiatan">Kegiatan</option>
                                                <option value="RPP">RPP</option>
                                                <option value="Silabus">Silabus</option>
                                                <!-- Tambah sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="file_arsip">File Dokumen (PDF/Word)</label>
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