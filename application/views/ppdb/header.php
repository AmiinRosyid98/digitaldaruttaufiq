<!DOCTYPE html>
<html lang="id" class="smooth-scroll">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB <?= date('Y') ?> - <?= $data_site->nama_lembaga ?></title>
    <link rel="icon" href="<?php echo base_url() ?>assets/web/<?php echo $data_site->logo; ?>" type="image/png">

    <!-- Government Standard Assets -->
    <link rel="shortcut icon" href="<?= base_url('assets/web/favicon.png') ?>" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        :root {
            --primary: #005F73;
            /* Government blue */
            --primary-light: #0A9396;
            --secondary: #94D2BD;
            /* Complementary */
            --accent: #EE9B00;
            /* Gold for highlights */
            --dark: #001219;
            --light: #F8F9FA;
            --gov-gradient: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            line-height: 1.6;
        }

        .gov-header {
            background: var(--gov-gradient);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid var(--accent);
        }

        .nav-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .nav-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -3px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .badge-gov {
            background-color: var(--accent);
            color: var(--dark);
            font-weight: 600;
        }

        .pathway-card {
            background: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .pathway-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .pathway-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--primary);
            color: white;
            padding: 0.25rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-bottom-left-radius: 1rem;
        }

        .pathway-hover-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(25, 123, 100, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .pathway-card:hover .pathway-hover-effect {
            opacity: 1;
        }

        .pathway-detail-btn {
            transition: all 0.3s ease;
        }

        .pathway-card:hover .pathway-detail-btn {
            background: var(--primary);
            color: white;
        }

        .bg-gradient-primary {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .ketentuan-text-ellipsis {
            min-height: 48px;
            /* atau berapa pun, supaya 2-3 baris */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* batas maksimum 3 baris */
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body>
    <!-- Government Header -->
    <header class="gov-header navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand nav-brand" href="<?= site_url('landing/portalppdb') ?>">
                <img src="<?php echo base_url() ?>assets/web/<?php echo $data_site->logo; ?>" alt="Logo">
                <span>SPMB <?php echo $data_site->nama_lembaga; ?> <?= date('Y') ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('landing/portalppdb') ?>">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('landing/daftar') ?>">
                            <i class="fas fa-user-plus me-1"></i> Pendaftaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('landing/cek_status') ?>">
                            <i class="fas fa-search me-1"></i> Cek Status
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container py-5">