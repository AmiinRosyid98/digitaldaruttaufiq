<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        #map {
            height: 460px;
            width: 100%;
        }
    </style>
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
            <div class="content-wrapper" style="min-height: 1100px;">
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
                                        <h5 class="card-title"><i class="fas far fa-calendar mr-1"></i> Pengaturan Absensi</h5>
                                    </div>
                                    <form action="<?php echo site_url('admin/absensi/settingabsen'); ?>" method="POST">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="judul_absensi" class="font-weight-normal">Judul Leger</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo isset($templateabsen['id']) ? $templateabsen['id'] : ''; ?>">
                                                    <input type="text" id="judul_absensi" class="form-control" name="judul_absensi" value="<?php echo isset($templateabsen['judul_absensi']) ? $templateabsen['judul_absensi'] : ''; ?>" oninput="this.value = this.value.toUpperCase()" Placeholder="DAFTAR HADIR ABSENSI SISWA">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="bulan_absensi" class="font-weight-normal">Bulan Leger</label>
                                                    <select id="bulan_absensi" class="form-control" name="bulan_absensi">
                                                        <?php $selected_bulan = isset($templateabsen['bulan_absensi']) ? $templateabsen['bulan_absensi'] : ''; ?>
                                                        <option value="JANUARI" <?php echo ($selected_bulan == 'JANUARI') ? 'selected' : ''; ?>>Januari</option>
                                                        <option value="FEBRUARI" <?php echo ($selected_bulan == 'FEBRUARI') ? 'selected' : ''; ?>>Februari</option>
                                                        <option value="MARET" <?php echo ($selected_bulan == 'MARET') ? 'selected' : ''; ?>>Maret</option>
                                                        <option value="APRIL" <?php echo ($selected_bulan == 'APRIL') ? 'selected' : ''; ?>>April</option>
                                                        <option value="MEI" <?php echo ($selected_bulan == 'MEI') ? 'selected' : ''; ?>>Mei</option>
                                                        <option value="JUNI" <?php echo ($selected_bulan == 'JUNI') ? 'selected' : ''; ?>>Juni</option>
                                                        <option value="JULI" <?php echo ($selected_bulan == 'JULI') ? 'selected' : ''; ?>>Juli</option>
                                                        <option value="AGUSTUS" <?php echo ($selected_bulan == 'AGUSTUS') ? 'selected' : ''; ?>>Agustus</option>
                                                        <option value="SEPTEMBER" <?php echo ($selected_bulan == 'SEPTEMBER') ? 'selected' : ''; ?>>September</option>
                                                        <option value="OKTOBER" <?php echo ($selected_bulan == 'OKTOBER') ? 'selected' : ''; ?>>Oktober</option>
                                                        <option value="NOVEMBER" <?php echo ($selected_bulan == 'NOVEMBER') ? 'selected' : ''; ?>>November</option>
                                                        <option value="DESEMBER" <?php echo ($selected_bulan == 'DESEMBER') ? 'selected' : ''; ?>>Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="start_tahun" class="font-weight-normal">Mulai</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo isset($templateabsen['id']) ? $templateabsen['id'] : ''; ?>">
                                                    <input type="number" id="start_tahun" class="form-control" name="start_tahun" value="<?php echo isset($templateabsen['start_tahun']) ? $templateabsen['start_tahun'] : ''; ?>">
                                                </div>

                                                <div>
                                                    <hr> -
                                                </div>


                                                <div class="col-md-4 form-group">
                                                    <label for="end_tahun" class="font-weight-normal">Sampai</label>
                                                    <input type="number" id="end_tahun" class="form-control" name="end_tahun" value="<?php echo isset($templateabsen['end_tahun']) ? $templateabsen['end_tahun'] : ''; ?>">
                                                </div>

                                                <div class="col-md-2 form-group">
                                                    <!-- <img src="https://cdn.excode.my.id/assets/material/Tahun_pelajaran.png" alt="logo Pengguna" style="width:160px; height: 110px;"> -->
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="latitude">Latitude Sekolah:</label>
                                                    <input type="text" id="latitude" name="latitude" class="form-control" value="<?php echo isset($templateabsen['latitude']) ? $templateabsen['latitude'] : ''; ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label for="longitude">Longitude Sekolah:</label>
                                                    <input type="text" id="longitude" name="longitude" class="form-control" value="<?php echo isset($templateabsen['longitude']) ? $templateabsen['longitude'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="batas_waktu_absen_masuk">Batas Waktu Masuk:</label>
                                                    <input type="time" id="batas_waktu_absen_masuk" name="batas_waktu_absen_masuk" class="form-control" value="<?php echo isset($templateabsen['batas_waktu_absen_masuk']) ? $templateabsen['batas_waktu_absen_masuk'] : ''; ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label for="batas_waktu_absen_pulang">Batas Waktu Pulang:</label>
                                                    <input type="time" id="batas_waktu_absen_pulang" name="batas_waktu_absen_pulang" class="form-control" value="<?php echo isset($templateabsen['batas_waktu_absen_pulang']) ? $templateabsen['batas_waktu_absen_pulang'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="radius_absen">Radius Absen (0.05 = 50 meter)</label>
                                                    <div class="input-group">
                                                        <input type="text" id="radius_absen" name="radius_absen" class="form-control" value="<?php echo isset($templateabsen['radius_absen']) ? $templateabsen['radius_absen'] : ''; ?>">
                                                        <span class="input-group-text">meter</span>
                                                    </div>
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
                                        <h3 class="card-title">Titik Absensi</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="map"></div>
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


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var latitude = <?php echo isset($templateabsen['latitude']) ? $templateabsen['latitude'] : '0'; ?>;
                    var longitude = <?php echo isset($templateabsen['longitude']) ? $templateabsen['longitude'] : '0'; ?>;

                    var map = L.map('map').setView([latitude, longitude], 13); // Mengatur peta berdasarkan latitude dan longitude dari database

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    var marker = L.marker([latitude, longitude]).addTo(map);

                    map.on('click', function(e) {
                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker(e.latlng).addTo(map);
                        document.getElementById('latitude').value = e.latlng.lat;
                        document.getElementById('longitude').value = e.latlng.lng;
                    });

                    // Tambahkan kontrol pencarian
                    var geocoder = L.Control.geocoder({
                        defaultMarkGeocode: false,
                        placeholder: 'Cari alamat atau tempat...',
                        geocoder: L.Control.Geocoder.nominatim()
                    }).addTo(map);

                    geocoder.on('markgeocode', function(e) {
                        var bbox = e.geocode.bbox;
                        var center = e.geocode.center;

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker(center).addTo(map);
                        map.fitBounds(bbox);
                    });
                });
            </script>