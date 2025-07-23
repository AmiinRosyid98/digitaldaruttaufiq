<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
</head>

<body>

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

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">

                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header ">
                                        <h5 class="card-title"><i class="fas far fa-home mr-1"></i> Identitas Lembaga</h5>
                                    </div>
                                    <form action="<?php echo site_url('admin/sistem/updatesistem'); ?>" method="POST">
                                        <div class="card-body">
                                            <style>
                                                /* Gaya kustom untuk input agar hanya memiliki garis bawah */
                                                .form-control {
                                                    border: none;
                                                    /* Menghapus border bawaan */
                                                    border-bottom: 2px solid #ced4da;
                                                    /* Menambahkan garis bawah */
                                                    border-radius: 0;
                                                    /* Menghapus sudut border */
                                                    box-shadow: none;
                                                    /* Menghapus shadow */
                                                    background-color: transparent;
                                                    /* Membuat background transparan */
                                                    padding-left: 0;
                                                    /* Menghapus padding kiri */
                                                }
                                            </style>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="npsn" class="font-weight-normal">NPSN</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo isset($profilsekolah['id']) ? $profilsekolah['id'] : ''; ?>">
                                                    <input type="text" id="npsn" class="form-control" name="npsn" value="<?php echo isset($profilsekolah['npsn']) ? $profilsekolah['npsn'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="nama_lembaga" class="font-weight-normal">NAMA LEMBAGA</label>
                                                    <input type="text" id="nama_lembaga" class="form-control" name="nama_lembaga" value="<?php echo isset($profilsekolah['nama_lembaga']) ? $profilsekolah['nama_lembaga'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="naungan_lembaga" class="font-weight-normal">LEMBAGA NAUNGAN</label>
                                                    <input type="text" id="naungan_lembaga" class="form-control" name="naungan_lembaga" value="<?php echo isset($profilsekolah['naungan_lembaga']) ? $profilsekolah['naungan_lembaga'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="status_lembaga" class="font-weight-normal">STATUS LEMBAGA</label>
                                                    <select id="status_lembaga" class="form-control" name="status_lembaga">
                                                        <?php
                                                        $status_lembaga = isset($profilsekolah['status_lembaga']) ? $profilsekolah['status_lembaga'] : ''; // Nilai dari database
                                                        ?>
                                                        <option value="NEGERI" <?php echo ($status_lembaga == 'NEGERI') ? 'selected' : ''; ?>>NEGERI</option>
                                                        <option value="SWASTA" <?php echo ($status_lembaga == 'SWASTA') ? 'selected' : ''; ?>>SWASTA</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="pemerintah_lembaga" class="font-weight-normal">PEMERINTAH</label>
                                                    <select id="pemerintah_lembaga" class="form-control" name="pemerintah_lembaga">
                                                        <?php
                                                        $status_lembaga = isset($profilsekolah['pemerintah_lembaga']) ? $profilsekolah['pemerintah_lembaga'] : ''; // Nilai dari database
                                                        ?>
                                                        <option value="KABUPATEN" <?php echo ($status_lembaga == 'KABUPATEN') ? 'selected' : ''; ?>>KABUPATEN</option>
                                                        <option value="KOTA" <?php echo ($status_lembaga == 'KOTA') ? 'selected' : ''; ?>>KOTA</option>
                                                        <option value="PROVINSI" <?php echo ($status_lembaga == 'PROVINSI') ? 'selected' : ''; ?>>PROVINSI</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="tahun_pelajaran" class="font-weight-normal">TAHUN PELAJARAN</label>
                                                    <select id="tahun_pelajaran" class="form-control" name="tahun_pelajaran">
                                                        <?php
                                                        $status_lembaga = isset($profilsekolah['tahun_pelajaran']) ? $profilsekolah['tahun_pelajaran'] : ''; // Nilai dari database
                                                        ?>
                                                        <option value="">Tahun Ajaran</option>
                                                        <?php foreach ($tahunpelajaran as $item_tahunpelajaran) : ?>
                                                            <option value="<?php echo $item_tahunpelajaran['id_tahunpelajaran']; ?>" <?php echo ($item_tahunpelajaran['id_tahunpelajaran'] == $status_lembaga) ? 'selected' : ''; ?>>
                                                                <?php echo $item_tahunpelajaran['tahun_pelajaran']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="notelp_lembaga" class="font-weight-normal">NOMOR TELP</label>
                                                    <input type="text" id="notelp_lembaga" class="form-control" name="notelp_lembaga" value="<?php echo isset($profilsekolah['notelp_lembaga']) ? $profilsekolah['notelp_lembaga'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="email_lembaga" class="font-weight-normal">E-MAIL</label>
                                                    <input type="text" id="email_lembaga" class="form-control" name="email_lembaga" value="<?php echo isset($profilsekolah['email_lembaga']) ? $profilsekolah['email_lembaga'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="website_lembaga" class="font-weight-normal">Website</label>
                                                    <input type="text" id="website_lembaga" class="form-control" name="website_lembaga" value="<?php echo isset($profilsekolah['website_lembaga']) ? $profilsekolah['website_lembaga'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="nama_kepsek" class="font-weight-normal">NAMA KEPALA SEKOLAH</label>
                                                    <input type="text" id="nama_kepsek" class="form-control" name="nama_kepsek" value="<?php echo isset($profilsekolah['nama_kepsek']) ? $profilsekolah['nama_kepsek'] : ''; ?>">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="nip_kepsek" class="font-weight-normal">NIP / NUPTK / NO PEGAWAI</label>
                                                    <input type="text" id="nip_kepsek" class="form-control" name="nip_kepsek" value="<?php echo isset($profilsekolah['nip_kepsek']) ? $profilsekolah['nip_kepsek'] : ''; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="alamat_lembaga" class="font-weight-normal">ALAMAT</label>
                                                    <input type="text" id="alamat_lembaga" class="form-control" name="alamat_lembaga" placeholder="Alamat" value="<?php echo isset($profilsekolah['alamat_lembaga']) ? $profilsekolah['alamat_lembaga'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="kab_lembaga" class="font-weight-normal">KAB/KOTA</label>
                                                    <input type="text" id="kab_lembaga" class="form-control" name="kab_lembaga" placeholder="Kabupaten/Kota" value="<?php echo isset($profilsekolah['kab_lembaga']) ? $profilsekolah['kab_lembaga'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="prov_lembaga" class="font-weight-normal">PROVINSI</label>
                                                    <input type="text" id="prov_lembaga" class="form-control" name="prov_lembaga" placeholder="Provinsi" value="<?php echo isset($profilsekolah['prov_lembaga']) ? $profilsekolah['prov_lembaga'] : ''; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="kodepos_lembaga" class="font-weight-normal">KODE POS</label>
                                                    <input type="number" id="kodepos_lembaga" class="form-control" name="kodepos_lembaga" value="<?php echo isset($profilsekolah['kodepos_lembaga']) ? $profilsekolah['kodepos_lembaga'] : ''; ?>">
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="menu_active" class="font-weight-normal">Menu Active</label>
                                                    <select id="menu_active" class="form-control" name="menu_active">
                                                        <?php
                                                        $menu_active = isset($profilsekolah['menu_active']) ? $profilsekolah['menu_active'] : ''; // Nilai dari database
                                                        ?>
                                                        <option value="white" <?php echo ($menu_active == 'white') ? 'selected' : ''; ?>>Putih</option>
                                                        <option value="blue" <?php echo ($menu_active == 'blue') ? 'selected' : ''; ?>>Biru</option>
                                                        <option value="red" <?php echo ($menu_active == 'red') ? 'selected' : ''; ?>>Merah</option>
                                                        <option value="yellow" <?php echo ($menu_active == 'yellow') ? 'selected' : ''; ?>>Kuning</option>
                                                        <option value="orange" <?php echo ($menu_active == 'orange') ? 'selected' : ''; ?>>Orange</option>
                                                        <option value="dark" <?php echo ($menu_active == 'dark') ? 'selected' : ''; ?>>Hitam</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="menu_bg" class="font-weight-normal">Menu Background</label>
                                                    <input type="text" id="menu_bg" class="form-control my-colorpicker1 colorpicker-element" data-colorpicker-id="1" data-original-title="" title="" name="bg_active" value="<?php echo isset($profilsekolah['bg_active']) ? $profilsekolah['bg_active'] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>



                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Informasi Server</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label class="mb-0 font-weight-normal">Tanggal</label>
                                                </div>
                                                <div class="col-9">
                                                    <p class="mb-0">
                                                        <i class="far fa-calendar mr-1"></i>
                                                        <?php echo date('d-m-Y'); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label class="mb-0 font-weight-normal">Waktu</label>
                                                </div>
                                                <div class="col-9">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span class="mb-0" id="live-clock"></span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Logo Lembaga</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <img src="<?php echo base_url('assets/web/' . $logo); ?>" alt="logo Pengguna" style="width: 110px; height: 110px;">
                                                <?php if ($this->session->flashdata('success')) : ?>
                                                    <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
                                                <?php elseif ($this->session->flashdata('error')) : ?>
                                                    <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-footer">
                                        <!-- Form unggah foto profil -->
                                        <?php echo form_open_multipart('admin/sistem/update_logo', 'class="d-flex justify-content-between align-items-start"'); ?>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label" for="logo">Pilih Foto</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary align-self-end" style="height: 100%;">Upload</button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>



                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Logo Pemerintah Kota/Kab/Provinsi</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <img src="<?php echo base_url('assets/pemerintah/' . $logopemerintah); ?>" alt="logo Pemerintah" style="width: 110px; height: 110px;">
                                                <?php if ($this->session->flashdata('success')) : ?>
                                                    <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
                                                <?php elseif ($this->session->flashdata('error')) : ?>
                                                    <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-footer">
                                        <!-- Form unggah foto profil -->
                                        <?php echo form_open_multipart('admin/sistem/update_logopemerintah', 'class="d-flex justify-content-between align-items-start"'); ?>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logopemerintah" name="logopemerintah">
                                                <label class="custom-file-label" for="logopemerintah">Pilih Foto</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary align-self-end" style="height: 100%;">Upload</button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================================================================================= -->



            <?php $this->load->view('admin/_partials/footer.php') ?>

            <?php if ($this->session->flashdata('toast_message')) : ?>
                <script>
                    $(document).ready(function() {
                        toastr.success('<?php echo $this->session->flashdata('toast_message'); ?>');
                    });
                </script>
            <?php endif; ?>

            <script>
                // Fungsi untuk mengupdate waktu setiap detik
                function updateClock() {
                    var now = new Date();
                    var hours = now.getHours();
                    var minutes = now.getMinutes();
                    var seconds = now.getSeconds();

                    // Menambahkan nol di depan angka jika hanya satu digit
                    hours = hours < 10 ? '0' + hours : hours;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    // Menampilkan waktu dalam format HH:mm:ss
                    var timeString = hours + ':' + minutes + ':' + seconds;

                    // Memperbarui teks waktu di elemen dengan id 'live-clock'
                    document.getElementById('live-clock').textContent = timeString;
                }

                // Memanggil fungsi updateClock setiap detik
                setInterval(updateClock, 1000);

                // Memanggil fungsi untuk memperbarui waktu saat halaman dimuat
                updateClock();
            </script>