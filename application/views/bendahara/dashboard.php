<html lang="en">
<head>
    <?php $this->load->view('bendahara/_partials/head.php') ?>
    <style>
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .image-container {
        position: relative;
        transition: transform 1s ease-in-out; /* Durasi transisi menjadi 1 detik */
        }

        .image-container:hover img {
            transform: scale(1.1);
        }
    </style>

</head>

<body>
    
    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('bendahara/_partials/navbar.php') ?>
            <!-- /.navbar -->

    
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('bendahara/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('bendahara/_partials/sidebar_menu.php') ?>
                
            </aside>

<!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                </div>
                </div>

                <!-- isi content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box bg-info">
                                                    <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-user-graduate"></i></span>
                                                    <div class="info-box-content elevation-4" style="background-color: #FFFFFF; color: #000000;">
                                                        <span class="info-box-text font-weight-bold ">Peserta Didik</span>
                                                        <span class="info-box-number"><?php echo $total_siswa; ?> Siswa</span>
                                                        <span class="info-box-text">Sinkronisasi Server</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3 bg-danger">
                                                    <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-coins"></i></span>
                                                    <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                        <span class="info-box-text font-weight-bold">Pos Keuangan</span>
                                                        <span class="info-box-number"><?php echo $total_poskeuangan; ?> POS</span>
                                                        <span class="info-box-text">Sinkronisasi Server</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix hidden-md-up"></div>
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <div class="info-box mb-3 bg-dark">
                                                        <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-wallet "></i></span>
                                                        <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                            <span class="info-box-text font-weight-bold">Jenis Pembayaran</span>
                                                            <span class="info-box-number"><?php echo $total_jenispembayaran; ?> Jenis</span>
                                                            <span class="info-box-text">Sinkronisasi Server</span>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <div class="info-box mb-3 bg-warning">
                                                        <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-money-check-dollar"></i></span>
                                                        <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                            <span class="info-box-text font-weight-bold">Tarif Pembayaran</span>
                                                            <span class="info-box-number"><?php echo $total_tarifpembayaran; ?> Tarif</span>
                                                            <span class="info-box-text">Sinkronisasi Server</span>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body text-center image-container">
                                            <img src="<?php echo base_url('assets/web/' . $logo); ?>" alt="Logo" style="max-width: 50%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 10px;"></div>
                                        </div>
                                    </div>
                                    <div class="card" style="background-image: url('<?php echo base_url('assets/bg-section-2_.png'); ?>'); background-size: cover; opacity: 0.8;">
                                        <div class="card-body">
                                            <h5 class="card-title">Layanan Bantuan</h5>
                                            <p class="card-text">Kami siap membantu Anda. Hubungi kami melalui WhatsApp untuk pertanyaan lebih lanjut.</p>
                                            <!-- <a href="https://api.whatsapp.com/send?phone=6282183930485" target="_blank" class="btn btn-success">
                                                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                            </a> -->
                                            <a href="https://api.whatsapp.com/send?phone=#" target="_blank" class="btn btn-success">
                                                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                            </a>
                                        </div>
                                    </div>





                                </div>
                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-header text-dark">
                                            <h3 class="font-weight-bold" style="color: #F06001;"><?php echo $profilsekolah['nama_lembaga'] ?? ''; ?></h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-2">
                                                        <h6 class="font-weight-bold mb-0">NPSN</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['npsn'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-1">
                                                        <h6 class="font-weight-bold">Status Lembaga</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['status_lembaga'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-1">
                                                        <h6 class="font-weight-bold">Pemerintah</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['pemerintah_lembaga'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-1">
                                                        <h6 class="font-weight-bold">Alamat</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['alamat_lembaga'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-1">
                                                        <h6 class="font-weight-bold">E-mail</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['email_lembaga'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="info-item border rounded p-1">
                                                        <h6 class="font-weight-bold">Nomor Telepon</h6>
                                                        <p class="mb-0"><?php echo $profilsekolah['notelp_lembaga'] ?? ''; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>







                            </div>


                        </div>

                        
                    </div>
                </div>

<!-- ======================================================================================================= -->

<!-- Footer -->
<?php $this->load->view('bendahara/_partials/footer.php') ?>


