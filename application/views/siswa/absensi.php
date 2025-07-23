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
            <?php $this->load->view('siswa/_partials/navbar.php') ?>
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
                <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1200px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">

                    </div>
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Absensi</h3>
                                </div>
                                <div class="card-body">
                                    <form id="absensiForm" method="post" action="<?php echo base_url('siswa/absensi/submit_absensi'); ?>">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">Lokasi:</label>
                                            <div class="col-sm-9">
                                                <div id="locationStatus" class="alert alert-info">Lokasi belum tersedia.</div>
                                                <input type="hidden" id="latitude" name="latitude">
                                                <input type="hidden" id="longitude" name="longitude">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="button" class="btn btn-primary" id="getCurrentLocation">Ambil Lokasi</button>
                                                <button type="submit" class="btn btn-success ml-2" id="submitBtn" disabled>Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Absensi Harian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Waktu Absen</th>
                                                    <th>Status Kehadiran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($absensi_harian)) : ?>
                                                    <?php foreach ($absensi_harian as $index => $absensi) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                                            <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($absensi['timestamp'])); ?></td>
                                                            <td class="text-center <?php echo $absensi['absen'] == 'Masuk' ? 'text-success' : 'text-danger'; ?>">
                                                                <?php echo $absensi['absen']; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center">Belum ada data absensi untuk hari ini.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- ======================================================================================================= -->







        <!-- ======================================================================================================= -->
        <!-- Footer -->
        <?php $this->load->view('siswa/_partials/footer.php') ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var latitudeInput = document.getElementById('latitude');
                var longitudeInput = document.getElementById('longitude');
                var locationStatus = document.getElementById('locationStatus');
                var submitBtn = document.getElementById('submitBtn');

                document.getElementById('getCurrentLocation').addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;

                            latitudeInput.value = lat;
                            longitudeInput.value = lng;

                            // Hitung jarak menggunakan haversine distance atau metode lain
                            var radiusAbsen = <?php echo json_encode($batas_waktu_absen_masuk['radius_absen']); ?>; // Ambil dari PHP, sesuaikan dengan kebutuhan
                            var latitudeTemplate = <?php echo json_encode($batas_waktu_absen_masuk['latitude']); ?>;
                            var longitudeTemplate = <?php echo json_encode($batas_waktu_absen_masuk['longitude']); ?>;
                            var distance = haversineDistance(latitudeTemplate, longitudeTemplate, lat, lng);

                            // Cek apakah jarak lebih besar dari radius absen
                            if (distance > radiusAbsen) {
                                // Lokasi di luar radius absen
                                locationStatus.classList.remove('alert-success');
                                locationStatus.classList.add('alert-danger');
                                locationStatus.textContent = 'Anda berada di luar radius absen yang ditentukan.';
                                submitBtn.setAttribute('disabled', 'disabled');
                            } else {
                                // Lokasi dalam radius absen
                                locationStatus.classList.remove('alert-danger');
                                locationStatus.classList.add('alert-success');
                                locationStatus.textContent = 'Lokasi telah tersedia. Anda dapat melakukan absen.';
                                submitBtn.removeAttribute('disabled');
                            }
                        }, function(error) {
                            console.error('Error getting current position:', error);
                            alert('Tidak dapat menemukan lokasi saat ini.');
                        });
                    } else {
                        alert('Geolokasi tidak didukung oleh browser Anda.');
                    }
                });

                // Menambahkan event listener untuk submit form
                document.getElementById('absensiForm').addEventListener('submit', function(event) {
                    var radiusAbsen = <?php echo json_encode($batas_waktu_absen_masuk['radius_absen']); ?>; // Ambil dari PHP, sesuaikan dengan kebutuhan
                    var latitudeTemplate = <?php echo json_encode($batas_waktu_absen_masuk['latitude']); ?>;
                    var longitudeTemplate = <?php echo json_encode($batas_waktu_absen_masuk['longitude']); ?>;
                    var latitudeInput = parseFloat(latitudeInput.value);
                    var longitudeInput = parseFloat(longitudeInput.value);

                    // Hitung jarak menggunakan haversine distance atau metode lain
                    var distance = haversineDistance(latitudeTemplate, longitudeTemplate, latitudeInput, longitudeInput);

                    // Cek apakah jarak lebih besar dari radius absen
                    if (distance > radiusAbsen) {
                        event.preventDefault(); // Mencegah form untuk melakukan submit
                        alert('Anda berada di luar radius absen yang ditentukan.');
                        return false;
                    }
                });

                // Fungsi untuk menghitung jarak menggunakan Haversine formula
                function haversineDistance(lat1, lon1, lat2, lon2) {
                    var earthRadius = 6371; // Radius bumi dalam kilometer
                    var dLat = deg2rad(lat2 - lat1);
                    var dLon = deg2rad(lon2 - lon1);
                    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    var distance = earthRadius * c;
                    return distance;
                }

                function deg2rad(deg) {
                    return deg * (Math.PI / 180);
                }
            });
        </script>



        <script>
            function showToast(type, message) {
                toastr.options.positionClass = 'toast-top-right';
                toastr[type](message);
            }

            <?php if ($this->session->flashdata('success')) : ?>
                showToast('success', '<?php echo $this->session->flashdata('success'); ?>');
            <?php endif; ?>

            <?php if ($this->session->flashdata('info')) : ?>
                showToast('info', '<?php echo $this->session->flashdata('info'); ?>');
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')) : ?>
                showToast('error', '<?php echo $this->session->flashdata('error'); ?>');
            <?php endif; ?>
        </script>