<html lang="id">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
    <style>
        .modern-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #0b6d8a;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .profile-img {
            width: 100%;
            max-width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
        }

        .btn-action {
            margin-right: 10px;
            margin-bottom: 10px;
            width: 120px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php $this->load->view('admin/_partials/navbar.php') ?>
        <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('admin/_partials/sidebar_information.php') ?>
            <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>
        </aside>

        <div class="content-wrapper" style="min-height: 1000px;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1>Detail Pendaftaran PPDB</h1>
                        </div>
                        <div class="col-6 text-right">
                            <a href="<?= site_url('admin/ppdb/pendaftaran') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pendaftar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- FOTO -->
                                <div class="col-md-2 text-center mb-3">
                                    <img src="<?= base_url('upload/foto_siswa/' . $pendaftaran['foto_siswa']) ?>" alt="Foto Siswa" class="profile-img">
                                    <div class="info-group mt-3">
                                        <div class="info-value">
                                            <?php if ($pendaftaran['status'] == 'diterima'): ?>
                                                <span class="badge bg-success">Diterima</span>
                                            <?php elseif ($pendaftaran['status'] == 'terverifikasi'): ?>
                                                <span class="badge bg-primary">Terverifikasi</span>
                                            <?php elseif ($pendaftaran['status'] == 'ditolak'): ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pendaftar Baru</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="info-value mt-1">
                                            <span class="badge bg-success">Jalur <?= htmlspecialchars($pendaftaran['nama_jalur']) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- INFORMASI -->
                                <div class="col-md-8">
                                    <label><u>DATA PRIBADI CALON SISWA</u></label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">No. Pendaftaran</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['no_pendaftaran']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">NIK</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['nik']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Nama Lengkap</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['nama_lengkap']) ?></div>
                                            </div>

                                            <div class="info-group">
                                                <div class="info-label">Tempat, Tanggal Lahir</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['tempat_lahir']) ?>, <?= date('d F Y', strtotime($pendaftaran['tanggal_lahir'])) ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">KK</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['no_kk']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Jenis Kelamin</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['jenis_kelamin']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Alamat</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['alamat']) ?>, RT.<?= htmlspecialchars($pendaftaran['rt']) ?>, RW <?= htmlspecialchars($pendaftaran['rw']) ?> - <?= htmlspecialchars($pendaftaran['kelurahan']) ?>, <?= htmlspecialchars($pendaftaran['kecamatan']) ?>, <?= htmlspecialchars($pendaftaran['kabupaten']) ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">Anak keberapa</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['anakke']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Nama Ayah</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['nama_ayah']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Pekerjaan Ayah</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['pekerjaan_ayah']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Pendidikan Ayah</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['pendidikan_ayah']) ?></div>
                                            </div>

                                        </div>
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">Jumlah Saudara</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['jumlah_saudara']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Nama Ibu</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['nama_ibu']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Pekerjaan Ibu</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['pekerjaan_ibu']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Pendidikan Ibu</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['pendidikan_ibu']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DATA NILAI CALON SISWA  -->
                        <div class="card-body">
                            <div class="row">
                                <!-- FOTO -->
                                <div class="col-md-2 text-center">
                                    <div class="info-group">
                                    </div>
                                </div>

                                <!-- INFORMASI -->
                                <div class="col-md-8">
                                    <label><u>DATA NILAI CALON SISWA</u></label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">NISN</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['nisn']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Nomor Peserta Ujian</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['no_peserta_ujian']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Rata - Rata Nilai Ijazah</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['rata_nilai_ijazah']) ?></div>
                                            </div>


                                        </div>
                                        <div class="col-sm-3">
                                            <div class="info-group">
                                                <div class="info-label">Asal Sekolah</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['asal_sekolah']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Tahun Lulus</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['tahun_lulus']) ?></div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Prestasi</div>
                                                <div class="info-value"><?= htmlspecialchars($pendaftaran['prestasi']) ?></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER BUTTON -->
                        <div class="card-footer text-center">
                            <button onclick="confirmAction('<?= $pendaftaran['id'] ?>', 'diterima')" class="btn btn-success btn-action">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button onclick="confirmAction('<?= $pendaftaran['id'] ?>', 'terverifikasi')" class="btn btn-primary btn-action">
                                <i class="fas fa-user-check"></i> Verifikasi
                            </button>
                            <button onclick="confirmAction('<?= $pendaftaran['id'] ?>', 'ditolak')" class="btn btn-danger btn-action">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <?php $this->load->view('admin/_partials/footer.php') ?>
        </div>
    </div>

    <script>
        function confirmAction(id, status) {
            let actionText, actionTitle, icon, confirmButtonColor;

            switch (status) {
                case 'diterima':
                    actionTitle = 'Konfirmasi Penerimaan';
                    actionText = 'Yakin ingin menerima pendaftaran ini?';
                    icon = 'success';
                    confirmButtonColor = '#28a745';
                    break;
                case 'terverifikasi':
                    actionTitle = 'Konfirmasi Verifikasi';
                    actionText = 'Yakin ingin memverifikasi pendaftaran ini?';
                    icon = 'info';
                    confirmButtonColor = '#17a2b8';
                    break;
                case 'ditolak':
                    actionTitle = 'Konfirmasi Penolakan';
                    actionText = 'Yakin ingin menolak pendaftaran ini?';
                    icon = 'warning';
                    confirmButtonColor = '#dc3545';
                    break;
            }

            Swal.fire({
                title: actionTitle,
                text: actionText,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `<?= site_url('admin/ppdb/update_status_pendaftaran/') ?>${id}?status=${status}`;
                }
            });
        }
    </script>