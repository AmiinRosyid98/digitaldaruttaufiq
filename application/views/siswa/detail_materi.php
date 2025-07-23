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

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php $this->load->view('siswa/_partials/navbar.php') ?>
        <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
            <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1200px;">
            <div class="content">
                <div class="card m-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa-solid fa-book-open-reader"></i> Detail Materi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3><?= htmlspecialchars($materi['judul_materi']) ?></h3>
                        <p class="text-muted">Mata Pelajaran: <strong><?= $materi['nama_mapel'] ?></strong></p>
                        <p class="text-muted">Guru: <?= $materi['nama_ptk'] ?> | Kelas: <?= $materi['nama_kelas'] ?></p>

                        <hr>
                        <div><?= $materi['deskripsi'] ?></div>

                        <?php if (!empty($materi['link_google_drive'])): ?>
                            <hr>
                            <p><strong>Preview Google Drive:</strong></p>
                            <!-- Tombol buka modal -->
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#previewGoogleDriveModal">
                                <i class="fas fa-eye"></i> Preview
                            </button>

                            <!-- Modal Preview Google Drive -->
                            <div class="modal fade" id="previewGoogleDriveModal" tabindex="-1" role="dialog" aria-labelledby="previewGoogleDriveLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 90vw;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="previewGoogleDriveLabel">Preview Google Drive - <?= htmlspecialchars($materi['judul_materi']) ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="height: 80vh;">
                                            <iframe src="<?= htmlspecialchars($materi['link_google_drive']) ?>" frameborder="0" style="width: 100%; height: 100%;" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <h4><i class="fas fa-tasks"></i> Tugas dari Materi Ini</h4>
                        <?php if (empty($tugas)) : ?>
                            <div class="alert alert-info">Belum ada tugas dari materi ini.</div>
                        <?php else : ?>
                            <ul class="list-group">
                                <?php foreach ($tugas as $t) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap">
                                        <div class="me-2" style="max-width: 75%;">
                                            <strong><?= htmlspecialchars($t['judul_tugas']) ?></strong><br>
                                            <p class="mb-1"><?= nl2br(htmlspecialchars($t['deskripsi'])) ?></p>
                                            <small class="text-muted">Deadline: <?= date('d M Y', strtotime($t['tanggal_deadline'])) ?></small>
                                            <?php if (!empty($t['lampiran'])) : ?>
                                                <div class="mt-2">
                                                    <i class="fas fa-paperclip"></i>
                                                    <a href="<?= base_url('upload/tugas/' . $t['lampiran']) ?>" target="_blank">
                                                        <?= htmlspecialchars($t['lampiran']) ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-end">
                                            <a href="<?= base_url('siswa/elearning/detail_tugas/' . $t['id_tugas']) ?>" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-upload"></i> Kerjakan
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('siswa/_partials/footer.php') ?>
    </div>