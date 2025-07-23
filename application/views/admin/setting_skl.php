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
            <div class="content-wrapper" style="min-height: 1200px;">
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
                                        <h5 class="card-title"><i class="fas far fa-envelope-open-text mr-1"></i> Pengaturan Surat Keterangan Lulus</h5>
                                    </div>
                                    <form action="<?php echo site_url('admin/kelulusan/settingskl'); ?>" method="POST">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="judul_skl" class="font-weight-normal">Nama Surat</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo isset($templateskl['id']) ? $templateskl['id'] : ''; ?>">
                                                    <input type="text" id="njudul_sklpsn" class="form-control" name="judul_skl" value="<?php echo isset($templateskl['judul_skl']) ? $templateskl['judul_skl'] : ''; ?>" oninput="this.value = this.value.toUpperCase()" Placeholder="SURAT KETERANGAN LULUS">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="no_skl" class="font-weight-normal">No Surat</label>
                                                    <input type="text" id="no_skl" class="form-control" name="no_skl" value="<?php echo isset($templateskl['no_skl']) ? $templateskl['no_skl'] : ''; ?>" oninput="this.value = this.value.toUpperCase()" placeholder="198/SKL/SMA/AKT/V/2024">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="tgl_skl" class="font-weight-normal">Tanggal Surat</label>
                                                    <input type="date" id="tgl_skl" class="form-control" name="tgl_skl" value="<?php echo isset($templateskl['tgl_skl']) ? $templateskl['tgl_skl'] : ''; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="target_time" class="font-weight-normal">Tanggal Pengumuman</label>
                                                    <input type="datetime-local" id="target_time" class="form-control" name="target_time" value="<?php echo isset($templateskl['target_time']) ? $templateskl['target_time'] : ''; ?>" required>
                                                    <!-- value di atas diatur dengan format Y-m-d\TH:i untuk memastikan tampilan waktu lokal yang sesuai dengan input type datetime-local -->
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="dasar_skl" class="font-weight-normal">Dasar Surat</label>
                                                <textarea class="form-control" id="dasar_skl" name="dasar_skl" required><?php echo $templateskl['dasar_skl']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="isi_skl" class="font-weight-normal">Isi Surat</label>
                                                <textarea class="form-control" id="isi_skl" name="isi_skl" required><?php echo $templateskl['isi_skl']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="penutup_skl" class="font-weight-normal">Penutup Surat</label>
                                                <textarea class="form-control" id="penutup_skl" name="penutup_skl" required><?php echo $templateskl['penutup_skl']; ?></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="status_pengumuman" class="font-weight-normal">Tampilkan Menu Kelulusan siswa</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="status_pengumuman_ya" name="status_pengumuman" value="1" onclick="limitCheckboxSelection(this)" <?php echo ($templateskl['status_pengumuman'] == '1') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="status_pengumuman_ya">YA</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="status_pengumuman_tidak" name="status_pengumuman" value="0" onclick="limitCheckboxSelection(this)" <?php echo ($templateskl['status_pengumuman'] == '0') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="status_pengumuman_tidak">TIDAK</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <img src="https://cdn.excode.my.id/assets/landing/form_searchnis.png" alt="logo Pengguna" style="width:400px; height: 220px;">
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
                                        <h3 class="card-title">Logo Sekolah</h3>
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
                                        <h3 class="card-title">Logo Kab/Kota/Provinsi</h3>
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
            <script>
                function limitCheckboxSelection(checkbox) {
                    var checkboxes = document.querySelectorAll('input[name="' + checkbox.name + '"]');
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox) {
                            cb.checked = false;
                        }
                    });
                }
            </script>

            <!-- Memuat skrip CKEditor -->
            <?php echo $ckeditor_script; ?>



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