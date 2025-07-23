<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
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
            transition: transform 1s ease-in-out;
            /* Durasi transisi menjadi 1 detik */
        }

        .image-container:hover img {
            transform: scale(1.1);
        }
    </style>
    <style>
        #map {
            height: 400px;
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
            <div class="content-wrapper" style="min-height: 1200px;">
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
                                                        <span class="info-box-text">Data masuk ke dalam database</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3 bg-success">
                                                    <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-user-nurse"></i></span>
                                                    <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                        <span class="info-box-text font-weight-bold">Guru Dan Pegawai</span>
                                                        <span class="info-box-number"><?php echo $total_guru; ?> PTK</span>
                                                        <span class="info-box-text">Data masuk ke dalam database</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix hidden-md-up"></div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3 bg-dark">
                                                    <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-building "></i></span>
                                                    <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                        <span class="info-box-text font-weight-bold">Kelas</span>
                                                        <span class="info-box-number"><?php echo $total_kelas; ?> Ruang</span>
                                                        <span class="info-box-text">Data masuk ke dalam database</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="info-box mb-3 bg-primary">
                                                    <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-sim-card"></i></span>
                                                    <div class="info-box-content" style="background-color: #FFFFFF; color: #000000;">
                                                        <span class="info-box-text font-weight-bold">Alumni</span>
                                                        <span class="info-box-number"><?php echo $total_siswalulus; ?> Siswa</span>
                                                        <span class="info-box-text">Data masuk ke dalam database</span>
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
                                <div class="card" style="background-image: url('<?php echo base_url('assets/admin/bg-section-2_.png'); ?>'); background-size: cover; opacity: 0.9;">
                                    <div class="card-header" style="padding: 15px; border-bottom: 2px solid #fff; background-color: #01687E;">
                                        <h5 class=" mb-0" style="color: #fff;">Versi saat ini: <?php echo $current_version; ?></h5>
                                        <p id="latestVersion" style="display: none; color: #fff;">Versi terbaru: <?php echo isset($latest_version) ? $latest_version : 'Belum diperiksa'; ?></p>
                                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                                            <button class="btn btn-warning btn-sm" onclick="confirmCheckUpdate()">Check Update</button>
                                            <a href="#" class="btn btn-success btn-sm" id="upgradeButton" data-toggle="modal" data-target="#upgradeModal" style="display: none;">
                                                Upgrade
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: 10px;">
                                        <h5 class="card-title" style="font-weight: bold; color: #333;">Layanan Bantuan</h5>
                                        <p class="card-text" style="color: #555;">Hubungi kami melalui WhatsApp untuk pertanyaan lebih lanjut.</p>
                                        <a href="https://api.whatsapp.com/send?phone=6282183930485" target="_blank" class="btn btn-success" style="font-size: 15px; font-weight: bold; margin-bottom: 20px;">
                                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                        </a>
                                    </div>
                                    <div class="card-body" style="padding: 10px;">
                                        <!-- Bagian baru untuk fitur "Apa yang Baru pada Versi Ini" -->
                                        <h5 style="font-weight: bold; margin-top: 0px; color: #099A56;"><i class="fa-solid fa-infinity"></i> Apa yang Baru pada Versi Ini</h5>
                                        <ul style="list-style-type: disc; padding-left: 40px; color: #555; line-height: 1.6;">
                                            <li>Fitur Link Dinamis</li>
                                            <li>Fitur E-learning Pada Guru</li>
                                            <li>Pemisahan data siswa aktif dan alumni</li>
                                            <li>Siswa Dapat Mengerjakan Tugas</li>
                                            <li>Penyempurnaan Fitur E-Dokumen</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer" style="padding: 10px; border-top: 2px solid #fff;">
                                        <a href="https://update.excode.my.id/assets/Manual-Book-SMARTSCHOOL.pdf" target="_blank" class="btn btn-danger" style="font-size: 15px; font-weight: bold;">
                                            <i class="fa-regular fa-lightbulb"></i> Buku Panduan
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
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div id="map" style="height: 400px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







            <!-- Modal untuk konfirmasi Check Update -->
            <div class="modal fade" id="checkUpdateModal" tabindex="-1" role="dialog" aria-labelledby="checkUpdateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="checkUpdateModalLabel">Cek Versi Update Terbaru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin melanjutkan proses cek versi update terbaru?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning" onclick="checkForUpdates()">Check Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="upgradeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="upgradeModalLabel">Upgrade ke Versi Terbaru</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center mb-3">Anda yakin ingin melakukan upgrade ke versi terbaru?</p>
                            <!-- Elemen loading spinner -->
                            <div id="loadingSpinner" class="text-center" style="display: none;">
                                <div class="spinner-border text-primary mb-2" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mb-0">Mohon tunggu...</p>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success" id="upgradeButton" onclick="upgradeToLatestVersion()">Lanjutkan Proses</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- ======================================================================================================= -->
            <script>
                function confirmCheckUpdate() {
                    $('#checkUpdateModal').modal('show');
                }

                function checkForUpdates() {
                    // Logika untuk mengecek pembaruan
                    var latest_version = "<?php echo isset($latest_version) ? $latest_version : ''; ?>";
                    var latestVersion = document.getElementById("latestVersion");

                    if (latest_version) {
                        latestVersion.textContent = "Versi terbaru: " + latest_version;
                    } else {
                        latestVersion.textContent = "Versi terbaru: Belum diperiksa";
                    }

                    latestVersion.style.display = "block";
                    document.getElementById("upgradeButton").style.display = "block";

                    // Tutup modal checkUpdateModal setelah melakukan pengecekan
                    $('#checkUpdateModal').modal('hide');
                }

                function confirmUpgrade() {
                    $('#upgradeModal').modal('show');
                }

                function upgradeToLatestVersion() {
                    // Tampilkan loading spinner
                    $('#loadingSpinner').show();

                    // Lakukan AJAX request
                    $.ajax({
                        url: '<?php echo base_url('admin/dashboard/upgrade'); ?>',
                        type: 'POST',
                        dataType: 'json', // Mengharapkan respons dalam format JSON
                        success: function(response) {
                            setTimeout(function() {
                                if (response.success) {
                                    // Sembunyikan modal upgrade
                                    $('#upgradeModal').modal('hide');
                                    // Tampilkan pesan sukses
                                    showToast('success', response.message);
                                    // Tambahkan kode lain yang diperlukan untuk memperbarui halaman atau melakukan tindakan setelah upgrade berhasil
                                } else {
                                    // Tampilkan pesan error jika ada kesalahan
                                    showToast('error', response.message);
                                }
                            }, 10000); // Tunggu 5 detik sebelum menampilkan pesan
                        },

                        error: function(xhr, status, error) {
                            showToast('error', 'Terjadi kesalahan saat melakukan upgrade: ' + error); // Menampilkan pesan error jika request gagal
                        },
                        complete: function() {
                            // Sembunyikan loading spinner atau pesan loading setelah 5 detik
                            setTimeout(function() {
                                $('#loadingSpinner').hide(); // Sesuaikan dengan kelas atau ID elemen loading spinner
                            }, 10000); // 5000 milidetik (5 detik)
                        }
                    });
                }
            </script>

            <!-- Footer -->
            <?php $this->load->view('admin/_partials/footer.php') ?>

            <script>
                // Inisialisasi peta
                var map = L.map('map').setView([<?php echo $templateabsen['latitude'] ?? ''; ?>, <?php echo $templateabsen['longitude'] ?? ''; ?>], 13); // Ganti dengan koordinat sekolah Anda

                // Tambahkan layer tile dari OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Tambahkan marker pada lokasi sekolah
                var marker = L.marker([<?php echo $templateabsen['latitude'] ?? ''; ?>, <?php echo $templateabsen['longitude'] ?? ''; ?>]).addTo(map) // Ganti dengan koordinat sekolah Anda
                    .bindPopup("<b><?php echo $profilsekolah['nama_lembaga'] ?? ''; ?></b><br><?php echo $profilsekolah['alamat_lembaga'] ?? ''; ?>")
                    .openPopup();
            </script>