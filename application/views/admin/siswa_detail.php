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

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1100px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                    </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <?php if (!empty($siswa)) : ?>
                                    <div class="col-md-3">
                                        <div class="card card-danger card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets/siswa/profile/default.png'); ?>" alt="User profile picture">
                                                </div>
                                                <h3 class="profile-username text-center"><?php echo $siswa['nama_siswa']; ?></h3>
                                                <p class="text-muted text-center"><strong> Kelas <small class="badge badge-danger"><?php echo $siswa['nama_kelas']; ?></small> No Absen <small class="badge badge-success"><?php echo $siswa['no_absen']; ?></small></strong></p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item"><b>NIS</b> <b><a class="float-right text-dark"><?php echo $siswa['nis']; ?></a></b></li>
                                                    <li class="list-group-item"><b>NISN</b> <b><a class="float-right text-dark"><?php echo $siswa['nisn']; ?></a></b></li>
                                                </ul>
                                                <a href="<?php echo base_url('admin/siswa/cetakbukuinduk/' . $siswa['id_siswa']); ?>" class="btn btn-secondary btn-block">
                                                    <b>
                                                        <i class="fas fa-print mr-1"></i> Cetak Buku Induk
                                                    </b>
                                                </a>

                                            </div>
                                        </div>


                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">Data Diri Siswa</h3>
                                            </div>

                                            <div class="card-body">
                                                <strong><i class="far fa-file-alt mr-1"></i> Tempat, Tanggal Lahir</strong>
                                                <p class="text-muted"><?php echo $siswa['tempatlahir']; ?>, <?php echo date('d-m-Y', strtotime($siswa['tanggallahir'])); ?></p>
                                                <hr>
                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                                                <p class="text-muted"><?php echo $siswa['siswa_alamat']; ?>, <?php echo $siswa['siswa_kelurahan']; ?>, <?php echo $siswa['siswa_kecamatan']; ?>,<?php echo $siswa['siswa_kabupaten']; ?>, <?php echo $siswa['siswa_provinsi']; ?> </p>
                                                <hr>
                                                <strong><i class="fas fa-venus mr-1"></i> Jenis Kelamin</strong>
                                                <p class="text-muted">
                                                    <span class="tag tag-danger">
                                                        <?php if ($siswa['jeniskelamin'] == 'L') : ?>
                                                            Laki-Laki
                                                        <?php elseif ($siswa['jeniskelamin'] == 'P') : ?>
                                                            Perempuan
                                                        <?php else : ?>
                                                            Jenis Kelamin tidak valid
                                                        <?php endif; ?>
                                                </p>
                                                <hr>
                                                <strong><i class="fas fa-mobile mr-1"></i> Nomor HP/WA</strong>
                                                <p class="text-muted"><?php echo $siswa['nohp']; ?>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-header p-2 bg-secondary">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link active" href="#datadiri" data-toggle="tab">Data Diri</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#datakelas" data-toggle="tab">Data Kelas</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#dataakun" data-toggle="tab">Data Akun</a></li>
                                                </ul>
                                            </div>

                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="datadiri">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('admin/siswa/updatedatadirisiswa') . '#datadiri'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <div class="form-group">
                                                                    <label for="editNamaSiswa">Nama Siswa</label>
                                                                    <input type="text" class="form-control" id="editNamaSiswa" name="editNamaSiswa" value="<?php echo $siswa['nama_siswa']; ?>" required>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editJeniskelamin">Jenis Kelamin</label>
                                                                        <select class="form-control" id="editJeniskelamin" name="editJeniskelamin">
                                                                            <option value="L" <?php echo ($siswa['jeniskelamin'] == 'L') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                                            <option value="P" <?php echo ($siswa['jeniskelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editAgama">Agama</label>
                                                                        <select class="form-control" id="editAgama" name="editAgama">
                                                                            <option value="Islam" <?php echo ($siswa['agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                                                            <option value="Kristen Protestan" <?php echo ($siswa['agama'] == 'Kristen Protestan') ? 'selected' : ''; ?>>Kristen Protestan</option>
                                                                            <option value="Katolik" <?php echo ($siswa['agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                                                            <option value="Hindu" <?php echo ($siswa['agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                                                            <option value="Buddha" <?php echo ($siswa['agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                                                                            <option value="Konghucu" <?php echo ($siswa['agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTempatlahir">Tempat Lahir</label>
                                                                        <input type="text" class="form-control" id="editTempatlahir" name="editTempatlahir" value="<?php echo $siswa['tempatlahir']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTanggallahir">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control" id="editTanggallahir" name="editTanggallahir" value="<?php echo $siswa['tanggallahir']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editSiswaAlamat">Alamat</label>
                                                                    <textarea class="form-control" id="editSiswaAlamat" name="editSiswaAlamat"><?php echo $siswa['siswa_alamat'];  ?> </textarea>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="editSiswaKelurahan">Kelurahan</label>
                                                                        <input type="text" class="form-control" id="editSiswaKelurahan" name="editSiswaKelurahan" value="<?php echo $siswa['siswa_kelurahan']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="editSiswaKecamatan">Kecamatan</label>
                                                                        <input type="text" class="form-control" id="editSiswaKecamatan" name="editSiswaKecamatan" value="<?php echo $siswa['siswa_kecamatan']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="editSiswaKabupaten">Kabupaten</label>
                                                                        <input type="text" class="form-control" id="editSiswaKabupaten" name="editSiswaKabupaten" value="<?php echo $siswa['siswa_kabupaten']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editSiswaProvinsi">Provinsi</label>
                                                                    <input type="text" class="form-control" id="editSiswaProvinsi" name="editSiswaProvinsi" value="<?php echo $siswa['siswa_provinsi']; ?>" required>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNohp">Nomor Telepon</label>
                                                                        <input type="text" class="form-control" id="editNohp" name="editNohp" value="<?php echo $siswa['nohp']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editSiswaemail">Email</label>
                                                                        <input type="email" class="form-control" id="editSiswaemail" name="editSiswaemail" value="<?php echo $siswa['email']; ?>">
                                                                    </div>
                                                                </div>



                                                                <!-- Tambahkan input lainnya sesuai kebutuhan -->

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Simpan</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="datakelas">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('admin/siswa/updatedatakelassiswa') . '#datakelas'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTempatlahir">Kelas</label>
                                                                        <select class="form-control" id="editKodeKelas" name="editKodeKelas" required>
                                                                            <?php foreach ($kelas as $item_kelas) : ?>
                                                                                <option value="<?php echo $item_kelas['no_kelas']; ?>" <?php echo ($item_kelas['no_kelas'] == $siswa['kode_kelas']) ? 'selected' : ''; ?>><?php echo $item_kelas['nama_kelas']; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNoAbsen">Nomor Absen</label>
                                                                        <input type="text" class="form-control" id="editNoAbsen" name="editNoAbsen" value="<?php echo $siswa['no_absen']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNis">NIS</label>
                                                                        <input type="text" class="form-control" id="editNis" name="editNis" value="<?php echo $siswa['nis']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNisn">NISN</label>
                                                                        <input type="text" class="form-control" id="editNisn" name="editNisn" value="<?php echo $siswa['nisn']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Simpan</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="dataakun">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('admin/siswa/updatedataakunsiswa') . '#dataakun'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editUsername">Username</label>
                                                                        <input type="text" class="form-control" id="editUsername" name="editUsername" value="<?php echo $siswa['username']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPassword">Password</label>
                                                                        <input type="password" class="form-control" id="editPassword" name="editPassword" value="<?php echo $siswa['password']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Update</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                        </div>
                    </section>

                </div>
            </div>


            <!-- ======================================================================================================= -->
        <?php else : ?>
            <p>Data siswa tidak ditemukan.</p>
        <?php endif; ?>

        <script>
            $(document).ready(function() {
                // Menangkap submit form
                $('#formEditSiswa').submit(function(event) {
                    // Mencegah perilaku default dari form
                    event.preventDefault();

                    // Mendapatkan data dari form
                    var formData = $(this).serialize();

                    // Simpan referensi tab aktif sebelum pengiriman formulir
                    var activeTabId = $('.nav-link.active').attr('href');

                    // Melakukan request AJAX
                    $.ajax({
                        url: $(this).attr('action'),
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                // Jika perubahan berhasil, tampilkan pesan sukses
                                $('#successMessage').text('Data Siswa berhasil diperbarui.').show();

                                // Jika ingin tetap di tab tertentu setelah sukses, tambahkan kode berikut:
                                $('.nav-link').removeClass('active'); // Hapus kelas 'active' dari semua tab
                                $('a[href="' + activeTabId + '"]').addClass('active'); // Tambahkan kelas 'active' ke tab yang disimpan sebelumnya
                                $(activeTabId).addClass('show active'); // Tampilkan konten tab yang sesuai
                            } else {
                                // Jika tidak ada perubahan, tampilkan pesan kesalahan
                                $('#errorMessage').text('Tidak ada perubahan pada data siswa.').show();
                            }
                        },
                        error: function(xhr, status, error) {
                            // Jika terjadi kesalahan saat melakukan request AJAX
                            console.error(xhr.responseText);
                            $('#errorMessage').text('Terjadi kesalahan saat memperbarui data siswa.').show();
                        }
                    });
                });
            });
        </script>



        <?php $this->load->view('admin/_partials/footer.php') ?>





        <script>
            // Function to show toast messages
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