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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">

                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa-brands fa-cloudflare"></i> Absensi Online </h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <form method="get" action="<?php echo base_url('admin/rekapabsensiguru/rekapharianguru'); ?>">
                                            <div class="row">
                                                <div class="col-sm-5 text-end">
                                                    <label for="start_date" class="col-form-label">Tanggal:</label>
                                                </div>
                                                <div class="col-sm-7">
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-12 text-end">
                                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                                </div>
                                            </div>
                                        </form>


                                        <?php if (!empty($start_date)) : ?>
                                            <div class="row mt-2">
                                                <div class="col-sm-12 text-end">
                                                    <a href="<?php echo base_url('admin/absensi/cetak_pdf_absensi_guru?start_date=' . $start_date); ?>" target="_blank" class="btn btn-secondary">
                                                        Cetak PDF
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>





                                    </div>


                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>NIP/No Pegawai</th>
                                                        <th>Kehadiran</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($absensionline)) : ?>
                                                        <?php foreach ($absensionline as $index => $itemabsen) : ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                                <td><?php echo html_escape($itemabsen['nama_ptk']); ?></td>
                                                                <td class="text-center"><?php echo html_escape($itemabsen['nip']); ?></td>
                                                                <td class="text-center <?php echo isset($itemabsen['absen']) && $itemabsen['absen'] == 'Masuk' ? 'text-success' : 'text-danger'; ?>">
                                                                    <?php echo isset($itemabsen['absen']) ? html_escape($itemabsen['absen']) : 'Tidak Masuk'; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php echo !empty($itemabsen['timestamp']) ? date('d-m-Y', strtotime($itemabsen['timestamp'])) : '-'; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php echo !empty($itemabsen['timestamp']) ? date('H:i:s', strtotime($itemabsen['timestamp'])) : '-'; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">Tidak ada data absensi ditemukan.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>

                                            </table>
                                        </div>

                                        <div class="pagination mt-3">
                                            <?php echo $this->pagination->create_links(); ?>
                                        </div>
                                    </div>
                                </div>
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