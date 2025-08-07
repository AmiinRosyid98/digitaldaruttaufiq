<!DOCTYPE html>
<html lang="id">
<?php foreach ($data_site as $res) { ?> <?php } ?>
<?php foreach ($versi as $version) { ?> <?php } ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $res->nama_lembaga; ?> - SISMA</title>
    <!-- SEO Meta Tags -->
    <!-- *
    ----------------------------------------------------------------------------------
    SISMA APLICATION
    Pembuat Original Hainur Cahya Utama
    Beli Produk resmi dan original melalui whatsapp - 082183930485
    Note : Aplikasi Bajakan Tidak Didukung Fitur Update Secara Berkala 
    ----------------------------------------------------------------------------------
    * -->
    <meta name="description" content="Aplikasi SISMA <?php echo $res->nama_lembaga; ?> - Sistem Manajemen Sekolah Terpadu">
    <meta name="keywords" content="SISMA, <?php echo $res->nama_lembaga; ?>, aplikasi sekolah digital, e-learning, manajemen sekolah">
    <meta name="author" content="<?php echo $res->nama_lembaga; ?>">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo $res->nama_lembaga; ?> - SISMA">
    <meta property="og:description" content="Sistem Informasi Sekolah dan Madrasah  untuk mendukung kegiatan belajar mengajar">
    <meta property="og:image" content="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">
    <meta property="og:url" content="<?php echo current_url(); ?>">
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $res->nama_lembaga; ?> - SISMA">
    <meta name="twitter:description" content="Sistem Informasi Sekolah dan Madrasah  untuk mendukung kegiatan belajar mengajar">
    <meta name="twitter:image" content="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">

    <!-- Preconnect untuk optimasi -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>" type="image/png">

    <!-- Google Fonts - Poppins + Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">


    <!-- CSS Libraries Upgrade -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1.7.8/glider.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/landing/landing-page.css">
    <style>
        .link-card {
            width: 110px;
            background-color: #ffffff;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease-in-out;
            text-align: center;
        }

        .link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .logo-img {
            height: 20px;
            object-fit: contain;
            filter: grayscale(0.2);
            transition: filter 0.3s ease;
        }

        .link-card:hover .logo-img {
            filter: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/web/' . $res->logo) ?>" alt="<?= $res->nama_lembaga ?>" class="nav-brand">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" style="margin-right: 20px;">
                        <a class="nav-link active text-white fw-bold" aria-current="page" href="<?php echo base_url('/'); ?>">Beranda</a>
                    </li>
                    <li class="nav-item dropdown" style="margin-right: 10px;">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdownRuangBelajar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fitur Siswa
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right animate__animated animate__bounceIn" aria-labelledby="navbarDropdownRuangBelajar" style="font-size: 14px; width: 700px;">
                            <div class="row" style="margin: 10px;">
                                <div class="col-12 col-md-4 p-2">
                                    <a href="#" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-PERPUSTAKAAN</h6>
                                            <p class="card-text">Layanan perpustakaan serta berbasis digital</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <a href="<?php echo base_url('auth/loginsiswa'); ?>" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-BOOK</h6>
                                            <p class="card-text">Layanan buku belajar siswa elektronik daring</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <a href="<?php echo base_url('auth/loginsiswa'); ?>" class="card card-hover" style="text-decoration: none; color: inherit; ">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-OSIS</h6>
                                            <p class="card-text">Layanan pemilihan ketua osis berbasis voting</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <a href="<?php echo base_url('auth/loginsiswa'); ?>" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-LEARNING</h6>
                                            <p class="card-text">Layanan pembelajaran dan tugas daring</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <a href="<?php echo base_url('auth/loginbk'); ?>" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-POIN</h6>
                                            <p class="card-text">Layanan pencatatan pelanggaran poin siswa</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <a href="#" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/png_hak2s1_5879.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold">E-KELULUSAN</h6>
                                            <p class="card-text">Layanan pengumuman kelulusan siswa</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </ul>
                    </li>

                    <li class="nav-item dropdown" style="margin-right: 10px;">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdownManajemen" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manajemen
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right animate__animated animate__bounceIn" aria-labelledby="navbarDropdownManajemen" style="font-size: 14px; width: 400px;">
                            <div class="row" style="margin: 5px;">
                                <div class="col-12 col-md-6 p-2">
                                    <a href="<?php echo base_url() ?>Auth/loginptk" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/superLMSBAONSidebarBackgrond.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold"> GURU</h6>
                                            <p class="card-text">Portal manajemen PTK dan STAFF</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <a href="<?php echo base_url() ?>Auth/loginbendahara" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/superLMSBAONSidebarBackgrond.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold"> BENDAHARA</h6>
                                            <p class="card-text">Portal manajemen BENDAHARA</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <a href="<?php echo base_url() ?>Auth/loginbk" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/superLMSBAONSidebarBackgrond.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold"> BK</h6>
                                            <p class="card-text">Portal manajemen Bimbingan Konseling</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <a href="<?php echo base_url() ?>Auth/loginadmin" class="card card-hover" style="text-decoration: none; color: inherit;">
                                        <div class="card-body" style="background-image: url('<?= base_url('assets/landing/superLMSBAONSidebarBackgrond.png') ?>'); background-size: cover; background-position: center; height: 100px;">
                                            <h6 class="card-title fw-bold"> OPERATOR</h6>
                                            <p class="card-text">Portal manajemen OPERATOR & ADMIN</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <?php foreach ($portalppdb as $menuppdb) : ?>
                        <?php if ($menuppdb->status_ppdb == 1) : ?>
                            <li class="nav-item" style="margin-right: 20px;">
                                <a class="nav-link active text-white fw-bold" aria-current="page" href="<?php echo base_url('landing/portalppdb'); ?>"> PPDB</a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach ($portalkelulusan as $status) : ?>
                        <?php if ($status->status_pengumuman == 1) : ?>
                            <li class="nav-item" style="margin-right: 20px;">
                                <a class="nav-link active text-white fw-bold" aria-current="page" href="<?php echo base_url('landing/portalkelulusan'); ?>"> Kelulusan</a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

                <div class="ms-lg-3 mt-3 mt-lg-0">
                    <a href="<?= base_url('auth/loginsiswa') ?>" class="btn btn-primary px-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <!-- Konten Kiri -->
                <div class="col-lg-8 hero-content" data-aos="fade-right">
                    <h1 class="hero-title mb-4"><?php echo $res->nama_lembaga; ?></h1>
                    <p class="hero-subtitle">
                        Layanan Sistem Informasi Sekolah dan Madrasah <br>
                        <span class="fw-bold">SISMA </span>
                        <span class="badge bg-light text-primary rounded-pill">
                            Version <?php echo htmlspecialchars($version->current_version, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </p>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#features" class="btn btn-light btn-lg rounded-pill px-4">
                            <i class="fas fa-play-circle me-2"></i>Lihat Fitur
                        </a>
                        <a href="#stats" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            <i class="fas fa-chart-line me-2"></i>Prestasi Sekolah
                        </a>
                    </div>
                    <!-- Link Dinamis dengan Logo -->
                    <?php if (!empty($link_dinamis)): ?>
                        <div class="mt-5 d-flex flex-wrap gap-4 justify-content-start align-items-start">
                            <?php foreach ($link_dinamis as $link): ?>
                                <a href="<?php echo htmlspecialchars($link->link, ENT_QUOTES, 'UTF-8'); ?>"
                                    target="_blank"
                                    class="link-card text-decoration-none text-center shadow-sm p-3 rounded-3 bg-white transition"
                                    title="<?php echo htmlspecialchars($link->nama_link); ?>">
                                    <img src="<?php echo base_url('upload/logo_link/' . $link->logo_link); ?>"
                                        alt="<?php echo htmlspecialchars($link->nama_link); ?>"
                                        class="img-fluid mb-2 logo-img" />
                                    <div class="text-muted fw-bold" style="font-size: 10px;">
                                        <?php echo htmlspecialchars($link->nama_link); ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Konten Kanan: Login Siswa -->
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="login-card float">
                        <div class="login-card-header">
                            <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login Siswa</h4>
                        </div>
                        <div class="login-card-body" style="padding: 20px;">
                            <form id="studentLoginForm" action="<?php echo base_url('siswa/auth'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </button>
                            </form>
                        </div>
                        <div class="card-footer text-center bg-light py-3">
                            <small class="text-muted">Belum punya akun? Hubungi Bagian ICT Sekolah</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Stats Section -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <i class="fas fa-users fa-4x mb-3 icon-hover"></i>
                        <h3 class="counter" data-count="<?php echo $total_siswa; ?>">0</h3>
                        <p class="mb-0 fw-bold text-muted">Jumlah Siswa</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <i class="fas fa-chalkboard-teacher fa-4x mb-3  icon-hover"></i>
                        <h3 class="counter" data-count="<?php echo $total_guru; ?>">0</h3>
                        <p class="mb-0 fw-bold text-muted">Jumlah Guru</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card">
                        <i class="fas fa-school fa-4x mb-3 icon-hover"></i> <!-- Ikon diubah -->
                        <h3 class="counter" data-count="<?php echo $total_kelas; ?>">0</h3>
                        <p class="mb-0 fw-bold text-muted">Jumlah Kelas</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card">
                        <i class="fas fa-graduation-cap fa-4x mb-3 icon-hover"></i> <!-- Ikon diubah -->
                        <h3 class="counter" data-count="<?php echo $total_alumni; ?>">0</h3>
                        <p class="mb-0 fw-bold text-muted">Jumlah Alumni</p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- Section Daftar Buku -->
    <section class="book-section">
        <div class="book-container">
            <div class="book-header">
                <h2 class="book-title">Koleksi Buku Library</h2>
                <p class="book-subtitle">Jelajahi pilihan Buku pengetahuan digital</p>
            </div>

            <div class="book-grid">
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <div class="book-glow"></div>

                        <div class="book-content">
                            <div class="book-cover">
                                <div class="book-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                        <defs>
                                            <linearGradient id="bookGradient" x1="0" y1="0" x2="1" y2="1">
                                                <stop offset="0%" stop-color="#00f0ff" />
                                                <stop offset="100%" stop-color="#0084ff" />
                                            </linearGradient>
                                        </defs>
                                        <rect x="8" y="8" width="48" height="48" rx="6" fill="url(#bookGradient)" />
                                        <path d="M20 20H44M20 28H44M20 36H36" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
                                        <path d="M16 8V56" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
                                        <circle cx="16" cy="8" r="2" fill="#ffffff" />
                                    </svg>
                                </div>

                                <div class="book-actions">
                                    <a href="<?= base_url('upload/filebuku/' . $book->file_buku) ?>"
                                        class="download-btn"
                                        target="_blank"
                                        download>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>

                            <div class="book-info">
                                <h5 class="book-name"><?= $book->nama_buku ?></h5>
                                <div class="book-meta">
                                    <span class="book-year">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?= $book->timestamp_buku ?>
                                    </span>
                                    <span class="book-format">PDF</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Enhanced Pagination -->
            <?php if ($pagination_books): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?= str_replace(
                            ['<a', '<span class="current">'],
                            ['<a class="page-link"', '<span class="page-link current">'],
                            $pagination_books
                        ) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section" id="news">
        <div class="container">
            <h2 class="section-title text-center">Pengumuman dan Informasi Terbaru</h2>

            <div class="row g-4">
                <?php $counter = 0; ?>
                <?php foreach ($berita as $kartu) : ?>
                    <?php if ($counter < 4) : ?>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo ($counter + 1) * 100; ?>">
                            <div class="news-card">
                                <img src="<?php echo base_url() ?>upload/berita/<?php echo htmlspecialchars($kartu->gambar_berita, ENT_QUOTES, 'UTF-8'); ?>" class="news-img" alt="<?php echo htmlspecialchars($kartu->judul_berita, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="card-body">
                                    <small class="news-date"><i class="far fa-calendar-alt me-2"></i><?php echo date('d M Y', strtotime($kartu->tanggal_berita)); ?></small>
                                    <h5 class="news-title"><?php echo htmlspecialchars($kartu->judul_berita, ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="news-excerpt">
                                        <?php
                                        $max_chars = 250;
                                        $isi_berita = $kartu->isi_berita;
                                        // Decode HTML entities jika perlu
                                        $isi_berita = htmlspecialchars_decode($isi_berita);
                                        // Potong teks jika lebih dari batas karakter
                                        $isi_berita_display = (strlen($isi_berita) > $max_chars) ? substr($isi_berita, 0, $max_chars) . '...' : $isi_berita;
                                        ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <button class="btn btn-outline-primary w-100 news-btn lihat-detail-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        data-judul="<?php echo htmlspecialchars($kartu->judul_berita, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-isi=" <?php echo $isi_berita_display; ?>"
                                        data-gambar="<?php echo base_url() ?>upload/berita/<?php echo htmlspecialchars($kartu->gambar_berita, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-tanggal="<?php echo date('d F Y', strtotime($kartu->tanggal_berita)); ?>">
                                        Baca Selengkapnya
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">
                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Pengumuman
                </a>
            </div>
        </div>
    </section>




    <!-- Section Minat & Bakat -->
    <section class="hobby-section py-5" id="hobbies">
        <div class="container">
            <h2 class="text-center mb-5">Profil Minat Siswa</h2>

            <div class="row g-4">
                <!-- Chart Kegemaran Olahraga -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h4 class="card-title text-center">
                                <i class="fas fa-running me-2"></i>Kegemaran Olahraga
                            </h4>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="olahragaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Bakat Seni -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h4 class="card-title text-center">
                                <i class="fas fa-paint-brush me-2"></i>Bakat Seni
                            </h4>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="seniChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <!-- Teachers Section -->
    <section class="teachers-section" id="teachers">
        <div class="container">
            <h2 class="section-title text-center">Guru dan Staff Kami</h2>

            <div class="teacher-carousel">
                <div id="teacherCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < count($dataguru); $i += 6) : ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <div class="row justify-content-center">
                                    <?php for ($j = $i; $j < $i + 6; $j++) : ?>
                                        <?php if ($j < count($dataguru)) : ?>
                                            <div class="col-6 col-md-4 col-lg-2 text-center mb-4" data-aos="zoom-in">
                                                <img src="<?= base_url('assets/ptk/profile/' . $dataguru[$j]->avatar) ?>" class="teacher-img mb-3" alt="Guru <?= $j + 1 ?>">
                                            </div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#teacherCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#teacherCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>







    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="<?php echo htmlspecialchars(base_url('assets/web/' . $res->logo), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?>" class="footer-logo">
                    <p class="text-white-50"><?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?> adalah lembaga pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas dengan dukungan teknologi modern.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h5 class="text-white">Tautan Cepat</h5>
                        <ul>
                            <li><a href="<?php echo base_url('/'); ?>">Beranda</a></li>
                            <li><a href="#features">Fitur</a></li>
                            <li><a href="#news">Pengumuman</a></li>
                            <li><a href="#teachers">Guru</a></li>
                            <li><a href="#contact">Kontak</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="footer-links">
                        <h5 class="text-white">Layanan</h5>
                        <ul>
                            <li><a href="<?php echo base_url('auth/loginsiswa'); ?>">Login Siswa</a></li>
                            <li><a href="<?php echo base_url() ?>Auth/loginptk">Login Guru</a></li>
                            <li><a href="<?php echo base_url() ?>Auth/loginadmin">Login Admin</a></li>
                            <?php foreach ($portalppdb as $menuppdb) : ?>
                                <?php if ($menuppdb->status_ppdb == 1) : ?>
                                    <li><a href="<?php echo base_url('landing/portalppdb'); ?>">PPDB Online</a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="footer-links">
                        <h5 class="text-white">Kontak Kami</h5>
                        <ul class="text-white-50">
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> <?php echo htmlspecialchars($res->alamat_lembaga, ENT_QUOTES, 'UTF-8'); ?></li>
                            <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> <?php echo htmlspecialchars($res->notelp_lembaga, ENT_QUOTES, 'UTF-8'); ?></li>
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo htmlspecialchars($res->email_lembaga, ENT_QUOTES, 'UTF-8'); ?></li>
                            <li class="mb-2"><i class="fas fa-clock me-2"></i> Senin - Jumat, 07:00 - 16:00</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="copyright text-center text-white-50">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?>. All Rights Reserved. Powered by <a href="#" class="text-white">SISMA</a></p>
            </div>
        </div>
    </footer>



    <!-- News Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" class="img-fluid rounded mb-4 w-100" alt="" style="max-height: 300px; object-fit: cover;">
                    <small class="text-muted d-block mb-3"><i class="far fa-calendar-alt me-2"></i><span id="modalDate"></span></small>
                    <h3 id="modalJudul" class="mb-4"></h3>
                    <div id="modalIsi" class="news-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.8/glider.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Custom Scripts -->
    <!-- Di head atau sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wordcloud2@1.0.0/src/wordcloud2.min.js"></script>


    <!-- JavaScript chart-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Controller
            const olahragaData = {
                labels: <?= json_encode(array_column($hobby_stats['olahraga'], 'kegemaran')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($hobby_stats['olahraga'], 'total')) ?>,
                    backgroundColor: [
                        '#05654F', '#0A8F6F', '#28a745', '#5cb85c', '#7ccba2'
                    ],
                    borderWidth: 0
                }]
            };

            const seniData = {
                labels: <?= json_encode(array_column($hobby_stats['kesenian'], 'kegemaran')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($hobby_stats['kesenian'], 'total')) ?>,
                    backgroundColor: [
                        '#EC6B00', '#fd7e14', '#ff9800', '#ffb74d', '#ffcc80'
                    ],
                    borderWidth: 0
                }]
            };

            // Chart Olahraga
            new Chart(
                document.getElementById('olahragaChart'), {
                    type: 'bar',
                    data: olahragaData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.raw} siswa`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: (value) => `${value} siswa`
                                }
                            }
                        }
                    }
                }
            );

            // Chart Seni
            new Chart(
                document.getElementById('seniChart'), {
                    type: 'doughnut',
                    data: seniData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.label}: ${ctx.raw} siswa`
                                }
                            }
                        }
                    }
                }
            );
        });
    </script>

    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Counter animation
        $(document).ready(function() {
            $('.counter').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).data('count')
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

            // Back to top button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#backToTop').fadeIn('slow');
                } else {
                    $('#backToTop').fadeOut('slow');
                }
            });

            $('#backToTop').click(function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

            // Password toggle
            $('.toggle-password').click(function() {
                const icon = $(this).find('i');
                const password = $('#password');
                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Modal for news detail
            $('.lihat-detail-btn').click(function() {
                const judul = $(this).data('judul');
                const isi = $(this).data('isi');
                const gambar = $(this).data('gambar');
                const tanggal = $(this).data('tanggal');

                $('#modalJudul').text(judul);
                $('#modalIsi').html(isi);
                $('#modalImage').attr('src', gambar);
                $('#modalDate').text(tanggal);
            });
        });


        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Handle form submission with AJAX
        $(document).ready(function() {
            // Show any existing flash messages
            <?php if ($this->session->flashdata('message_login_error')) : ?>
                toastr.error('<?= $this->session->flashdata('message_login_error') ?>', 'Login Gagal');
            <?php endif; ?>

            // Toggle password visibility
            $('.toggle-password').click(function() {
                const input = $(this).parent().find('input');
                const icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Handle form submission
            $('#studentLoginForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                const formData = {
                    username: $('#username').val(),
                    password: $('#password').val()
                };

                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Memproses...');
                submitBtn.prop('disabled', true);

                // AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'auth/loginsiswa',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Login successful - redirect
                            toastr.success(response.message, 'Berhasil');
                            window.location.href = response.redirect;
                        } else {
                            // Login failed - show error
                            toastr.error(response.message, 'Gagal Login');
                            submitBtn.html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
                            submitBtn.prop('disabled', false);

                            // Add shake animation to form
                            $('.neuro-card').addClass('animate__animated animate__headShake');
                            setTimeout(function() {
                                $('.neuro-card').removeClass('animate__animated animate__headShake');
                            }, 1000);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Terjadi kesalahan saat memproses login', 'Error');
                        submitBtn.html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
                        submitBtn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <!-- Script Rendering -->

</body>

</html>