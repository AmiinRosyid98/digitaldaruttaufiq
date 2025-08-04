<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>

    
</head>

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
        <div class="content-wrapper" style="min-height: 1100px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- isi content -->
            <div class="content">
            <div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-brands fa-cloudflare"></i> Absensi Bulanan Siswa</h3>
    </div>
    <div class="card-body">
        <form method="get" action="<?php echo base_url('admin/rekapabsensisiswa/rekapbulansiswa'); ?>" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="month">Bulan:</label>
                        <select id="month" name="month" class="form-control">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $month) ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="year">Tahun:</label>
                        <input type="number" id="year" name="year" class="form-control" value="<?php echo isset($year) ? $year : date('Y'); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kelas" >Kelas:</label>

                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($list_kelas as $kelas) : ?>
                                <option value="<?php echo $kelas['id_kelas']; ?>" <?php echo isset($selected_kelas) && $selected_kelas == $kelas['id_kelas'] ? 'selected' : ''; ?>><?php echo $kelas['nama_kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <button type="submit" class="btn btn-primary " style="margin-top: 31px;">Tampilkan</button>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table id="example12" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <?php 
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            for ($day = 1; $day <= $daysInMonth; $day++): ?>
                                <th><?php echo $day; ?></th>
                            <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($absensibulan)) : ?>
                        <?php 
                        $current_nama = '';
                        foreach ($absensibulan as $index => $itemabsen) : 
                            if ($current_nama != $itemabsen['nama_siswa']) :
                                $current_nama = $itemabsen['nama_siswa'];
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $index + 1; ?></td>
                            <td><?php echo html_escape($itemabsen['nama_siswa']); ?><br>
                                <small>Kelas : <?php echo html_escape($itemabsen['kode_tingkat']); ?> / <?php echo html_escape($itemabsen['nama_kelas']); ?></small>
                            </td>
                            <?php 
                            $attendance = array_fill(1, $daysInMonth, 'Tidak Masuk');
                            foreach ($absensibulan as $absen) {
                                if ($absen['nama_siswa'] == $current_nama && date('n', strtotime($absen['timestamp'])) == $month && date('Y', strtotime($absen['timestamp'])) == $year) {
                                    $attendance[date('j', strtotime($absen['timestamp']))] = html_escape($absen['absen']);
                                }
                            }
                            foreach ($attendance as $day => $status): ?>
                                <td class="text-center <?php echo ($status == 'Masuk') ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $status; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endif; endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="<?php echo 3 + $daysInMonth; ?>" class="text-center">Tidak ada data absensi ditemukan.</td>
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
            </div>
        </div>
    </div>
</body>

</html>
