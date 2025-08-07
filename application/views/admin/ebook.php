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
                            <!-- Konten untuk kolom pertama -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Ebook</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama E-Book</th>
                                                <th>Author</th>
                                                <th>File E-Book</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($buku as $index => $buku) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td width="40%" class="text-leaft"><?php echo $buku['nama_buku']; ?></td>
                                                    <td class="text-center"><?php echo $buku['nama_ptk']; ?></td>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url() ?>upload/filebuku/<?php echo $buku['file_buku']; ?>" target="_blank">
                                                            <!-- <img src="https://cdn.excode.my.id/assets/material/pdf.png" class="card-img-top" alt="E-PERPUSTAKAAN Logo" style="width: 100px; height: 100px;"> -->
                                                             <i class="far fa-file-pdf fa-2x" style="color: red;"></i>
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
                                <?php foreach ($bukutimeline as $index => $bukutimeline) : ?>
                                    <?php $random_color = '#' . substr(md5(mt_rand()), 0, 3); ?>
                                    <div class="time-label">
                                        <span style="background-color: <?php echo $random_color; ?>; color: white; padding: 2px 5px; border-radius: 3px;">
                                            <?php echo date('d-m-Y', strtotime($bukutimeline['timestamp_buku'])); ?>
                                        </span>
                                    </div>
                                    <div>
                                    </div>

                                    <div>
                                        <i class="fas fa-book bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i><strong><?php echo date('d-m-Y H:i:s', strtotime($buku['timestamp_buku'])); ?></strong></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo $bukutimeline['nama_ptk']; ?></a> membuat buku digital</h3>
                                            <div class="timeline-body" style="font-size: 14px;">Telah Melakukan Upload Buku Digital Dengan Judul<br><strong style="font-size: 15px;"><?php echo $bukutimeline['nama_buku']; ?></strong></div>
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