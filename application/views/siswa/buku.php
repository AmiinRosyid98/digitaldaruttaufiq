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
                                <h3 class="card-title"><i class="fa-solid fa-magnifying-glass-dollar"></i> E-Book </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped ">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>File Buku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($buku as $index => $data_buku) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td><?php echo $data_buku['nama_buku']; ?><br><span class="badge badge-primary"><?php echo $data_buku['terbitan']; ?></span><br>
                                                <?php echo $data_buku['nama_ptk']; ?> - <?php echo date('d-m-Y H:i:s', strtotime($data_buku['timestamp_buku'])); ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url() ?>upload/filebuku/<?php echo $data_buku['file_buku']; ?>" target="_blank">
                                                    <img src="https://cdn.excode.my.id/assets/material/pdf.png" class="card-img-top" alt="E-PERPUSTAKAAN Logo" style="width: 100px; height: 100px;">
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
            </div>


            <!-- ======================================================================================================= -->









            <!-- ======================================================================================================= -->
            <!-- Footer -->
            <?php $this->load->view('siswa/_partials/footer.php') ?>