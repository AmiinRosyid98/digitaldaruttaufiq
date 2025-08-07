<!DOCTYPE html>
<html lang="en">

<?php foreach ($data_site as $res) { ?> <?php } ?>
<?php foreach ($versi as $version) { ?> <?php } ?>

<?php 
    function formatTanggalIndo($datetime, $pakejam = null) {
        // Ubah ke timestamp
        if($datetime==""){
            return "";
        }
        $timestamp = strtotime($datetime);

        // Array nama bulan dalam Bahasa Indonesia
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

        $tgl = date('d', $timestamp);
        $bln = (int)date('m', $timestamp); // jadi integer untuk ambil dari array
        $thn = date('Y', $timestamp);
        $jam = $pakejam ? date('H:i', $timestamp) : '';
        if($pakejam != null){
            return "$tgl {$bulanIndo[$bln]} $thn, Pukul $jam WIB";
        }
        return "$tgl {$bulanIndo[$bln]} $thn";
    }

    
    function formatFileSize($bytes, $precision = 2) {
        $units = [ 'KB', 'MB', 'GB', 'TB'];
        
        // Pastikan input berupa angka
        $bytes = max($bytes, 0);
        
        // Hitung pangkat yang sesuai
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        // Hitung ukuran dalam unit yang sesuai
        $bytes /= (1 << (10 * $pow));
        
        // Bulatkan dan format output
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo $res->nama_lembaga; ?> - SISMA</title>
    <meta name="description" content="Aplikasi SISMA <?php echo $res->nama_lembaga; ?> - Sistem Manajemen Sekolah Terpadu">
    <meta name="keywords" content="SISMA, <?php echo $res->nama_lembaga; ?>, aplikasi sekolah digital, e-learning, manajemen sekolah">
    <meta name="author" content="<?php echo $res->nama_lembaga; ?>">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo $res->nama_lembaga; ?> - SISMA">
    <meta property="og:description" content="Sistem Informasi Sekolah dan Madrasah untuk mendukung kegiatan belajar mengajar">
    <meta property="og:image" content="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">
    <meta property="og:url" content="<?php echo current_url(); ?>">
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $res->nama_lembaga; ?> - SISMA">
    <meta name="twitter:description" content="Sistem Informasi Sekolah dan Madrasah untuk mendukung kegiatan belajar mengajar">
    <meta name="twitter:image" content="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">

    <!-- Favicons -->
    <link rel="icon" href="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url() ?>assets/landingnew/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/landingnew/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/landingnew/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/landingnew/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/landingnew/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?= base_url() ?>assets/landingnew/assets/css/main.css" rel="stylesheet">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>

    <!-- Slick JS -->
    

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

<style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* bg-gray-50 equivalent */
            color: #343a40; /* text-gray-800 equivalent */
        }

        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 3rem; /* mb-12 equivalent */
        }

        .header-section h1 {
            font-size: 3.5rem; /* text-5xl equivalent */
            font-weight: 800; /* font-extrabold equivalent */
            color: #212529; /* text-gray-900 equivalent */
            margin-bottom: 1rem; /* mb-4 equivalent */
            letter-spacing: -0.025em; /* tracking-tight equivalent */
        }

        .header-section p {
            font-size: 1.25rem; /* text-xl equivalent */
            color: #6c757d; /* text-gray-600 equivalent */
            max-width: 50rem; /* max-w-2xl equivalent */
            margin-left: auto;
            margin-right: auto;
        }

        /* File Grid Section */
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Adjusted for better fit with Bootstrap cards */
            gap: 2rem; /* gap-8 equivalent */
        }

        /* File Card */
        .file-card {
            background-color: #ffffff; /* bg-white equivalent */
            border-radius: 0.75rem; /* rounded-xl equivalent */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg equivalent */
            transition: all 0.3s ease-in-out; /* transition-all duration-300 */
            overflow: hidden; /* overflow-hidden */
            display: flex; /* d-flex */
            flex-direction: column; /* flex-column */
        }

        .file-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* hover:shadow-xl */
            transform: translateY(-0.25rem); /* hover:-translate-y-1 */
        }

        .file-card .card-body {
            padding: 1.5rem; /* p-6 equivalent */
            flex-grow: 1; /* Ensures content fills space */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .file-info {
            display: flex; /* flex */
            align-items: center; /* items-center */
            margin-bottom: 1rem; /* mb-4 */
        }

        /* File Icon Container */
        .file-icon-container {
            flex-shrink: 0; /* flex-shrink-0 */
            border-radius: 50%; /* rounded-full */
            padding: 0.75rem; /* p-3 */
            margin-right: 1rem; /* mr-4 */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Specific icon background colors for consistency */
        .file-icon-blue { background-color: #cfe2ff; } /* bg-blue-100 equivalent */
        .file-icon-green { background-color: #d1e7dd; } /* bg-green-100 equivalent */
        .file-icon-red { background-color: #f8d7da; } /* bg-red-100 equivalent */
        .file-icon-yellow { background-color: #fff3cd; } /* bg-yellow-100 equivalent */
        

        /* SVG Icon Styling */
        .file-icon-svg {
            height: 2rem; /* h-8 equivalent */
            width: 2rem; /* w-8 equivalent */
        }

        /* Specific icon colors for consistency */
        .file-icon-svg.text-blue { color: #0d6efd; } /* text-blue-600 equivalent */
        .file-icon-svg.text-green { color: #198754; } /* text-green-600 equivalent */
        .file-icon-svg.text-red { color: #dc3545; } /* text-red-600 equivalent */
        .file-icon-svg.text-yellow { color: #ffc107; } /* text-yellow-600 equivalent */


        .file-title {
            font-size: 1.25rem; /* text-xl equivalent */
            font-weight: 600; /* font-semibold equivalent */
            color: #212529; /* text-gray-900 equivalent */
            line-height: 1.2; /* leading-tight equivalent */
        }

        .file-type {
            font-size: 0.875rem; /* text-sm equivalent */
            color: #6c757d; /* text-gray-500 equivalent */
            text-transform: uppercase; /* uppercase */
            font-weight: 500; /* font-medium */
        }

        .file-metadata {
            color: #495057; /* text-gray-600 equivalent */
            font-size: 0.875rem; /* text-sm equivalent */
            margin-bottom: 1rem; /* mb-4 */
        }

        .file-metadata p {
            display: flex; /* flex */
            align-items: center; /* items-center */
        }

        .file-metadata p:not(:last-child) {
            margin-bottom: 0.25rem; /* mt-1 equivalent for spacing between metadata lines */
        }

        .file-metadata .icon-small {
            width: 1rem; /* w-4 equivalent */
            height: 1rem; /* h-4 equivalent */
            margin-right: 0.25rem; /* mr-1 equivalent */
            color: #adb5bd; /* text-gray-400 equivalent */
        }

        /* Download Button */
        .download-btn {
            display: block; /* block */
            width: 100%; /* w-full */
            padding: 0.75rem 1rem; /* py-3 px-4 equivalent */
            border-radius: 0.5rem; /* rounded-lg equivalent */
            text-align: center; /* text-center */
            font-weight: 600; /* font-semibold */
            text-decoration: none; /* remove underline */
            transition: background-color 0.2s ease-in-out; /* transition-colors duration-200 */
        }

        /* Specific button colors */
        .btn-blue { background-color: #6c9bff; color: white; } /* Warna biru yang lebih soft */
        .btn-blue:hover { background-color: #4a87ff; color: white; } /* Hover yang lebih gelap */

        .btn-green { background-color: #4caf50; color: white; } /* Warna hijau yang lebih soft */
        .btn-green:hover { background-color: #3d8b40; color: white; } /* Hover yang lebih gelap */

        .btn-red { background-color: #ff6b6b; color: white; } /* Warna merah yang lebih soft */
        .btn-red:hover { background-color: #ff5252; color: white; } /* Hover yang lebih gelap */

        .btn-yellow { background-color: #ffd93d; color: #4e4e4e; } /* Warna kuning yang lebih soft */
        .btn-yellow:hover { background-color: #ffd700; color: #4e4e4e; } /* Hover yang lebih gelap */

        /* Responsive adjustments for Bootstrap grid */
        @media (max-width: 575.98px) { /* Small devices (phones, less than 576px) */
            .header-section h1 {
                font-size: 2.5rem;
            }
            .header-section p {
                font-size: 1rem;
            }
            .file-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) { /* Medium devices (tablets, 576px and up) */
            .file-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) { /* Large devices (desktops, 768px and up) */
            .file-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 992px) { /* Extra large devices (large desktops, 992px and up) */
            .file-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .announcement-card {
            background-color: #ffffff; /* White card background */
            border-radius: 0.75rem; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); /* Soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
            display: flex; /* Flexbox for internal layout */
            flex-direction: column; /* Stack content vertically */
            height: 100%; /* Ensure cards in a row have equal height */
        }

        .announcement-card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Larger shadow on hover */
        }

        .announcement-image-container {
            width: 100%;
            height: 180px; /* Fixed height for image container */
            overflow: hidden; /* Hide overflowing parts of image */
            border-top-left-radius: 0.75rem; /* Match card border radius */
            border-top-right-radius: 0.75rem; /* Match card border radius */
            background-color: #e9ecef; /* Placeholder background if image fails */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .announcement-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the container, cropping if necessary */
            display: block;
        }

        .announcement-body {
            padding: 1.25rem; /* Padding inside the card body */
            flex-grow: 1; /* Allows content to expand */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes button to bottom */
        }

        .announcement-date {
            font-size: 0.875rem; /* Small font size for date */
            color: #6c757d; /* Muted color for date */
            margin-bottom: 0.5rem; /* Spacing below date */
            display: flex;
            align-items: center;
        }

        .announcement-date svg {
            width: 1rem; /* Icon size */
            height: 1rem; /* Icon size */
            margin-right: 0.25rem; /* Spacing next to icon */
            color: #adb5bd; /* Muted icon color */
        }

        .announcement-title {
            font-size: 1.15rem; /* Slightly larger title */
            font-weight: 600; /* Semi-bold title */
            color: #212529; /* Darker title text */
            margin-bottom: 1rem; /* Spacing below title */
            line-height: 1.4;
        }

        .read-more-btn {
            display: inline-block; /* Make it an inline-block for proper padding */
            width: auto; /* Auto width */
            padding: 0.6rem 1.25rem; /* Padding for the button */
            border-radius: 0.5rem; /* Rounded button corners */
            text-align: center; /* Center text */
            font-weight: 500; /* Medium font weight */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out; /* Smooth transition */
            border: 1px solid #0d6efd; /* Blue border */
            color: #0d6efd; /* Blue text */
            background-color: transparent; /* Transparent background */
        }

        .read-more-btn:hover {
            background-color: #6c9bff; /* Blue background on hover */
            color: #ffffff; /* White text on hover */
        }

        .view-all-button-container {
            text-align: center;
            margin-top: 3rem; /* Spacing above the button */
        }

        .view-all-button {
            display: inline-flex; /* Use inline-flex for icon alignment */
            align-items: center; /* Center icon and text vertically */
            background-color: #00a19e; /* Green background */
            color: white; /* White text */
            padding: 0.8rem 1.8rem; /* Generous padding */
            border-radius: 0.5rem; /* Rounded corners */
            font-weight: 600; /* Semi-bold font */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transitions */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        .view-all-button:hover {
            background-color: #00a19e; /* Darker green on hover */
            transform: translateY(-2px); /* Slight lift on hover */
            color: white; /* Keep text white on hover */
        }

        .view-all-button svg {
            width: 1.25rem; /* Icon size */
            height: 1.25rem; /* Icon size */
            margin-right: 0.5rem; /* Spacing next to icon */
        }

        /* Responsive adjustments for Bootstrap grid */
        @media (max-width: 767.98px) { /* Small devices (phones, less than 768px) */
            .section-header {
                font-size: 2rem;
                text-align: center;
                border-left: none;
                padding-left: 0;
            }
            .announcement-card {
                margin-bottom: 1.5rem; /* Add space between stacked cards */
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) { /* Medium devices (tablets, 768px to 991px) */
            /* For 2 columns on medium devices, Bootstrap's default col-md-6 works well */
        }
    </style>
    <style>
    .staff-carousel {
        padding: 20px 0;
    }

    .staff-img {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #bebebe;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .staff-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .staff-item{
        padding-top:10px;
    }

    .staff-item:hover .staff-img {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .staff-item:hover .staff-img img {
        transform: scale(1.05);
    }

    /* Custom arrow styles */
    .slick-prev:before, 
    .slick-next:before {
        color: #4e73df;
        font-size: 30px;
    }

    .slick-prev {
        left: -40px;
    }

    .slick-next {
        right: -30px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .staff-img {
            width: 120px;
            height: 120px;
        }
    }
</style>

  <!-- =======================================================
  * Template Name: Landify
  * Template URL: https://bootstrapmade.com/landify-bootstrap-landing-page-template/
  * Updated: Aug 04 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="<?php echo base_url('/'); ?>" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="<?= base_url() ?>assets/landingnew/assets/img/logo.webp" alt=""> -->
        <!-- <h1 class="sitename">Landify</h1>
          -->
          <img src="<?= base_url('assets/web/' . $res->logo) ?>" alt="<?= $res->nama_lembaga ?>" class="nav-brand">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#library">Library</a></li>
          <li><a href="#news">Pengumuman</a></li>
          <li><a href="#teachers">Guru</a></li>
          <li class="dropdown"><a href="#"><span>Fitur Siswa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="<?php echo base_url('login'); ?>">E-Perpustakaan</a></li>
              <li><a href="<?php echo base_url('login'); ?>">E-Book</a></li>
              <li><a href="<?php echo base_url('login'); ?>">E-Osis</a></li>
              <li><a href="<?php echo base_url('login'); ?>">E-Learning</a></li>
              <li><a href="<?php echo base_url('login'); ?>">E-Poin</a></li>
              <li><a href="<?php echo base_url('login'); ?>">E-Kelulusan</a></li>
            </ul>
          </li>
          <?php foreach ($portalppdb as $menuppdb) : ?>
            <?php if ($menuppdb->status_ppdb == 1) : ?>
                <li><a href="<?php echo base_url('landing/portalppdb'); ?>">PPDB</a></li>
          <?php endif; ?>
          <?php endforeach; ?>
          <?php foreach ($portalkelulusan as $status) : ?>
            <?php if ($status->status_pengumuman == 1) : ?>
                <li><a href="<?php echo base_url('landing/portalkelulusan'); ?>">Kelulusan</a></li>
          <?php endif; ?>
          <?php endforeach; ?>

          <li><a href="#footer">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="<?= base_url('login') ?>">Login</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">

          <div class="col-lg-7 order-2 order-lg-1" data-aos="fade-right" data-aos-delay="200">
            <div class="hero-content">
              <h1 class="hero-title pt-0"><?php echo $res->nama_lembaga; ?></h1>
              <p class="hero-description mb-3">
                    Layanan Sistem Informasi Sekolah dan Madrasah <br>
                    <span class="fw-bold">SISMA </span>
                    <span class="badge bg-light text-primary rounded-pill">
                        Version <?php echo htmlspecialchars($version->current_version, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
              </p>
              <div class="hero-actions mb-3">
                <a href="#interests" class="btn-primary"><i class="bi bi-chart-line"></i>Prestasi Sekolah</a>
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn-secondary glightbox">
                  <i class="bi bi-play-circle"></i>
                  <span>Lihat Fitur</span>
                </a>
              </div>

              <!-- Link Dinamis dengan Logo -->
              <?php if (!empty($link_dinamis)): ?>
                <div class="mt-2 d-flex flex-wrap gap-3 justify-content-start align-items-start">
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
              <!-- <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-number">150+</span>
                  <span class="stat-label">Projects Completed</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">98%</span>
                  <span class="stat-label">Client Satisfaction</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">24/7</span>
                  <span class="stat-label">Support Available</span>
                </div>
              </div> -->
            </div>
          </div>

          <div class="col-lg-5 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="300">
            <div class="hero-visual">
              <div class="hero-image-wrapper">
                <img src="<?= base_url() ?>assets/landingnew/assets/img/illustration/illustration-15.webp" class="img-fluid hero-image" alt="Hero Image">
                <div class="floating-elements">
                  <div class="floating-card card-1">
                    <i class="bi bi-lightbulb"></i>
                    <span>Innovation</span>
                  </div>
                  <div class="floating-card card-2">
                    <i class="bi bi-award"></i>
                    <span>Excellence</span>
                  </div>
                  <div class="floating-card card-3">
                    <i class="bi bi-people"></i>
                    <span>Collaboration</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">

          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="content-wrapper">
              <div class="section-header">
                <span class="section-badge">ABOUT OUR COMPANY</span>
                <h2>Mewujudkan Generasi Qur’ani, Berilmu, dan Berakhlak Mulia</h2>
              </div>

              <p class="lead-text">Mendidik generasi Qur'ani yang berilmu dan berakhlak mulia, siap menghadapi tantangan zaman dengan landasan iman dan taqwa yang kokoh, serta berwawasan global.</p>

              <p class="description-text">Yayasan Darut Taufiq berkomitmen untuk membentuk generasi yang beriman, berilmu, dan berakhlak mulia melalui pendidikan Al-Qur'an yang berkualitas. Kami hadir sebagai wadah pengembangan potensi anak didik dengan mengedepankan nilai-nilai Islami dan penguasaan ilmu pengetahuan.</p>

                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $total_siswa; ?></div>
                        <div class="stat-label">Jumlah Siswa</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $total_guru; ?></div>
                        <div class="stat-label">Jumlah Guru</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $total_kelas; ?></div>
                        <div class="stat-label">Jumlah Kelas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $total_alumni; ?></div>
                        <div class="stat-label">Jumlah Alumni</div>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="visual-section">
              <div class="main-image-container">
                <img src="<?= base_url() ?>assets/landingnew/assets/img/about/about-8.webp" alt="Professional team collaboration" class="img-fluid main-visual">
                <div class="overlay-card">
                  <div class="card-content">
                    <h4>Quality First</h4>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis.</p>
                    <div class="card-icon">
                      <i class="bi bi-award-fill"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="secondary-images">
                <div class="row g-3">
                  <div class="col-6">
                    <img src="<?= base_url() ?>assets/landingnew/assets/img/about/about-11.webp" alt="Team meeting" class="img-fluid secondary-img">
                  </div>
                  <div class="col-6">
                    <img src="<?= base_url() ?>assets/landingnew/assets/img/about/about-5.webp" alt="Office workspace" class="img-fluid secondary-img">
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- <div class="row mt-5">
          <div class="col-12" data-aos="fade-up" data-aos-delay="400">
            <div class="features-section">
              <div class="row gy-4">
                <div class="col-md-4">
                  <div class="feature-box">
                    <div class="feature-icon">
                      <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>Trusted Security</h5>
                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="feature-box">
                    <div class="feature-icon">
                      <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h5>Fast Performance</h5>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit sed quia consequuntur.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="feature-box">
                    <div class="feature-icon">
                      <i class="bi bi-headset"></i>
                    </div>
                    <h5>Expert Support</h5>
                    <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet consectetur adipisci velit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="library" class="library section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Library</span>
        <h2>Buku Library</h2>
        <p>Jelajahi pilihan Buku pengetahuan digital</p>
      </div><!-- End Section Title -->

        <!-- File Grid Section -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <!-- File Grid Section -->
            <div class="file-grid">

                <!-- Contoh Kartu File 1: Buku Digital -->
                <?php foreach ($books as $book): ?>
                <div class="file-card">
                    <div class="card-body">
                        <div class="file-info">
                                <?php if (strtolower(substr($book->file_buku, -4)) === '.pdf') {
                                                                                ?>
                                <div class="file-icon-container file-icon-blue">
                                    <svg class="file-icon-svg text-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.docx' || strtolower(substr($book->file_buku, -4)) === '.doc') {
                                                                                ?>
                                <div class="file-icon-container file-icon-green">
                                    <svg class="file-icon-svg text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.pptx' || strtolower(substr($book->file_buku, -4)) === '.ppt') {
                                                                                ?>
                                <div class="file-icon-container file-icon-red">
                                    <svg class="file-icon-svg text-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.xlsx' || strtolower(substr($book->file_buku, -4)) === '.xls') {
                                                                                ?>
                                <div class="file-icon-container file-icon-yellow">
                                    <svg class="file-icon-svg text-yellow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <?php } ?>

                            
                            <div>
                                <h3 class="file-title"><?= $book->nama_buku ?></h3>
                                <p class="file-type">
                                <?php if (strtolower(substr($book->file_buku, -4)) === '.pdf') {
                                                                                ?>
                                                                                PDF
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.docx' || strtolower(substr($book->file_buku, -4)) === '.doc') {
                                                                                ?>
                                                                                DOCX
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.pptx' || strtolower(substr($book->file_buku, -4)) === '.ppt') {
                                                                                ?>
                                                                                PPTX
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.xlsx' || strtolower(substr($book->file_buku, -4)) === '.xls') {
                                                                                ?>
                                                                                XLSX
                                <?php } ?>
                                </p>
                            </div>
                        </div>
                        <div class="file-metadata">
                            <p>
                                <svg class="icon-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M7 12h.01M11 12h.01M15 12h.01M17 12h.01M7 16h.01M11 16h.01M15 16h.01M17 16h.01M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Diunggah: <?= formatTanggalIndo($book->timestamp_buku) ?>
                            </p>
                            <p>
                                <svg class="icon-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Ukuran: <?= formatFileSize($book->file_size) ?>
                            </p>
                            
                        </div>
                        <a href="<?= base_url('upload/filebuku/' . $book->file_buku) ?>" class="download-btn
                        <?php if (strtolower(substr($book->file_buku, -4)) === '.pdf') {
                                                                                ?>
                                                                                btn-blue
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.docx' || strtolower(substr($book->file_buku, -4)) === '.doc') {
                                                                                ?>
                                                                                btn-green
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.pptx' || strtolower(substr($book->file_buku, -4)) === '.ppt') {
                                                                                ?>
                                                                                btn-red
                                <?php } else if (strtolower(substr($book->file_buku, -5)) === '.xlsx' || strtolower(substr($book->file_buku, -4)) === '.xls') {
                                                                                ?>
                                                                                btn-yellow
                                <?php } ?>
                        " target="_blank">
                            Unduh File
                        </a>
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

    </section><!-- /Features Section -->

    <section id="news" class="news section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Pengumuman</span>
        <h2>Pengumuman dan Informasi</h2>
        <p>Jelajahi pilihan Buku pengetahuan digital</p>
      </div><!-- End Section Title -->

        <!-- File Grid Section -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <!-- Announcement Grid Section -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                <?php $counter = 0; ?>
                    <?php foreach ($berita as $kartu) : ?>
                        <?php if ($counter < 4) : ?>
                            <div class="col">
                                <div class="announcement-card">
                                    <div class="announcement-image-container">
                                        <img src="<?php echo base_url() ?>upload/berita/<?php echo htmlspecialchars($kartu->gambar_berita, ENT_QUOTES, 'UTF-8'); ?>" alt="XL Prioritas" class="announcement-image">
                                    </div>
                                    <div class="announcement-body">
                                        <div>
                                            <p class="announcement-date">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <?= formatTanggalIndo($kartu->tanggal_berita) ?>
                                            </p>
                                            <h3 class="announcement-title"><?php echo htmlspecialchars($kartu->judul_berita, ENT_QUOTES, 'UTF-8'); ?></h3>
                                        </div>
                                        <a href="#" class="read-more-btn">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                            
                            
                

            </div>

        <!-- Lihat Semua Pengumuman Button -->
            <div class="view-all-button-container">
            <a href="#" class="view-all-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 16h.01" />
                </svg>
                Lihat Semua Pengumuman
            </a>
            </div>
        </div>

    </section><!-- /Features Section -->

    <section id="teachers" class="teachers section">
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">Guru</span>
            <h2>Guru & Staff Kami</h2>
            <p>Jelajahi pilihan Buku pengetahuan digital</p>
        </div><!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            
            <div class="staff-carousel">
                <!-- Item 1 -->

                <?php for ($i = 0; $i < count($dataguru); $i += 6) : ?>
                    <?php for ($j = $i; $j < $i + 6; $j++) : ?>
                        <?php if ($j < count($dataguru)) : ?>
                            <div class="staff-item text-center px-3">
                                <div class="staff-img mx-auto mb-3">
                                    <img src="<?= base_url('assets/ptk/profile/' . $dataguru[$j]->avatar) ?>" alt="Nama Guru" class="rounded-circle1">
                                </div>
                                <h5 class="mt-2 mb-1"><?= $dataguru[$j]->nama_ptk ?></h5>
                                <!-- <p class="text-muted">Guru Matematika</p> -->
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endfor; ?>
                
               
            </div>
        </div>
    </section>

    <section id="interests" class="interests section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Minat Siswa</span>
        <h2>Profil Minat Siswa</h2>
        <p>Jelajahi pilihan Buku pengetahuan digital</p>
      </div><!-- End Section Title -->
      <div class="container" data-aos="fade-up" data-aos-delay="100">
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

    

    

    <!-- Contact Section --
    <section id="contact" class="contact section light-background">

      <!-- Section Title --
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Contact</span>
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title --

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-5">
          <div class="col-lg-6">
            <div class="content" data-aos="fade-up" data-aos-delay="200">
              <div class="section-category mb-3">Contact US</div>
              <h2 class="display-5 mb-4">Nemo enim ipsam voluptatem quia voluptas aspernatur</h2>
              <p class="lead mb-4">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.</p>

              <div class="contact-info mt-5">
                <div class="info-item d-flex mb-3" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-envelope-at me-3"></i>
                  <span>info@example.com</span>
                </div>

                <div class="info-item d-flex mb-3" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-telephone me-3"></i>
                  <span>+1 5589 55488 558</span>
                </div>

                <div class="info-item d-flex mb-4" data-aos="fade-up" data-aos-delay="500">
                  <i class="bi bi-geo-alt me-3"></i>
                  <span>A108 Adam Street, New York, NY 535022</span>
                </div>

                <a href="#" class="map-link d-inline-flex align-items-center" data-aos="fade-up" data-aos-delay="600">
                  Open Map
                  <i class="bi bi-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="contact-form card" data-aos="fade-up" data-aos-delay="300">
              <div class="card-body p-4 p-lg-5">

                <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="600">
                  <div class="row gy-4">

                    <div class="col-12">
                      <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                    </div>

                    <div class="col-12 ">
                      <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                    </div>

                    <div class="col-12">
                      <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                    </div>

                    <div class="col-12">
                      <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                    </div>

                    <div class="col-12 text-center">
                      <div class="loading">Loading</div>
                      <div class="error-message"></div>
                      <div class="sent-message">Your message has been sent. Thank you!</div>

                      <button type="submit" class="btn btn-submit w-100">Submit Message</button>
                    </div>

                  </div>
                </form>

              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer position-relative dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
          <img src="<?php echo htmlspecialchars(base_url('assets/web/' . $res->logo), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?>" class="footer-logo">
          </a>
          <p><?php echo $res->nama_lembaga; ?> adalah lembaga pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas dengan dukungan teknologi modern.</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6 footer-links">
          <h4>Tautan Cepat</h4>
          <ul>
            <li><a href="<?php echo base_url('/'); ?>">Beranda</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#library">Library</a></li>
            <li><a href="#news">Pengumuman</a></li>
            <li><a href="#teachers">Guru</a></li>
            <li><a href="#footer">Kontak</a></li>
          </ul>
        </div>

        

        <div class="col-lg-4 col-md-12 footer-contact text-center text-md-start">
          <h4>Kontak Kami</h4>
          <p><?php echo htmlspecialchars($res->alamat_lembaga, ENT_QUOTES, 'UTF-8'); ?></p>
          <p class="mt-4"><strong>No. Telepon:</strong> <span><?php echo htmlspecialchars($res->notelp_lembaga, ENT_QUOTES, 'UTF-8'); ?></span></p>
          <p><strong>Email:</strong> <span><?php echo htmlspecialchars($res->email_lembaga, ENT_QUOTES, 'UTF-8'); ?></span></p>
          <p><strong>Jam Buka:</strong> <span>Senin - Jumat, 07:00 - 16:00</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?>. All Rights Reserved. Powered by <a href="#" class="text-white">SISMA</a></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/landingnew/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Main JS File -->
  <script src="<?= base_url() ?>assets/landingnew/assets/js/main.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

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

    <script>
        $(document).ready(function(){
            $('.staff-carousel').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow:2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>

</body>

</html>