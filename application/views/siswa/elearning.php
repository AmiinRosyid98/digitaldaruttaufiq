<html lang="en">

<head>
    <?php $this->load->view('siswa/_partials/head.php') ?>
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blink {
            animation: blink 3s infinite;
        }
    </style>
</head>

<body>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <?php $this->load->view('siswa/_partials/navbar.php') ?>
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
                <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1200px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">

                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title"><i class="fa-solid fa-magnifying-glass-dollar"></i> E-Learning </h3>
                            </div>
                        </div>
                        <div class="card-body">

                            <h4 class="mb-3">Materi Dan Tugas Untuk Kelas Anda</h4>

                            <?php if (empty($materi)) : ?>
                                <div class="alert alert-info">Belum ada materi yang tersedia untuk kelas Anda.</div>
                            <?php else : ?>
                                <div class="row">
                                    <?php foreach ($materi as $m) : ?>
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= htmlspecialchars($m['judul_materi']) ?></h5><br>
                                                    <span class="badge bg-primary"><?= $m['nama_mapel'] ?></span>
                                                    <span class="badge bg-success float-end"><?= $m['nama_kelas'] ?></span>
                                                    <p class="text-muted mt-2"><?= word_limiter(strip_tags($m['deskripsi']), 20) ?></p>
                                                    <a href="<?= base_url('siswa/elearning/detail_materi/' . $m['id_materi']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-book-open"></i> Lihat Materi
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


            <!-- ======================================================================================================= -->









            <!-- ======================================================================================================= -->
            <!-- Footer -->
            <?php $this->load->view('siswa/_partials/footer.php') ?>