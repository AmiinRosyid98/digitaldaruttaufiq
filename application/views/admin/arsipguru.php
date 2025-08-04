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
            <div class="content-wrapper" style="min-height: 1700px;">
                <div class="content-header">

                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="card p-2">
                                <form method="get" action="<?php echo site_url('admin/arsipguru'); ?>" class="mb-3">
                                    <div class="form-row align-items-center">
                                        <div class="col-auto">
                                            <label for="kategori">Filter Kategori:</label>
                                        </div>
                                        <div class="col-auto">
                                            <select name="kategori" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="">Semua Kategori</option>
                                                <option value="Materi" <?php if ($selected_kategori == 'Materi') echo 'selected'; ?>>Materi</option>
                                                <option value="Soal" <?php if ($selected_kategori == 'Soal') echo 'selected'; ?>>Soal</option>
                                                <option value="Dokumen" <?php if ($selected_kategori == 'Dokumen') echo 'selected'; ?>>Dokumen</option>
                                                <option value="Kegiatan" <?php if ($selected_kategori == 'Kegiatan') echo 'selected'; ?>>Kegiatan</option>
                                                <option value="RPP" <?php if ($selected_kategori == 'RPP') echo 'selected'; ?>>RPP</option>
                                                <option value="Silabus" <?php if ($selected_kategori == 'Silabus') echo 'selected'; ?>>Silabus</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Konten untuk kolom pertama -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Dokumen PTK</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama/Judul Dokumen</th>
                                                <th>Kategori</th>
                                                <th>Author</th>
                                                <th>File E-Arsip</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($arsip as $index => $itembanksoal) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td width="40%" class="text-leaft"><?php echo $itembanksoal['nama_arsip']; ?></td>
                                                    <td class="text-center"><?php echo $itembanksoal['kategori']; ?></td>
                                                    <td class="text-center"><?php echo $itembanksoal['nama_ptk']; ?></td>

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
                                <?php foreach ($arsiptimeline as $index => $arsiptimeline) : ?>
                                    <?php $random_color = '#' . substr(md5(mt_rand()), 0, 3); ?>
                                    <div class="time-label">
                                        <span style="background-color: <?php echo $random_color; ?>; color: white; padding: 2px 5px; border-radius: 3px;">
                                            <?php echo date('d-m-Y', strtotime($arsiptimeline['timestamp_arsip'])); ?>
                                        </span>
                                    </div>
                                    <div>
                                    </div>

                                    <div>
                                        <i class="fas fa-book bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i><strong><?php echo date('d-m-Y H:i:s', strtotime($arsiptimeline['timestamp_arsip'])); ?></strong></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo $arsiptimeline['nama_ptk']; ?></a> Dokumen digital</h3>
                                            <div class="timeline-body" style="font-size: 14px;">Telah Melakukan Upload Dokumen Digital Dengan Judul<br><strong style="font-size: 15px;"><?php echo $arsiptimeline['nama_arsip']; ?></strong></div>
                                            <div class="timeline-footer">
                                                <a class="btn btn-info btn-sm">Lihat File</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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