<html lang="en">

<head>

    <?php $this->load->view('siswa/_partials/head.php') ?>
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
            <?php $this->load->view('siswa/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
               <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
               <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
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
                                                <a href="<?php echo base_url('siswa/akun/cetakbukuinduk/' . $siswa['id_siswa']); ?>" class="btn btn-secondary btn-block">
                                                    <b><i class="fas fa-print mr-1"></i> Cetak Buku Induk</b>
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
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#dataayah" data-toggle="tab">Data Ayah</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#dataibu" data-toggle="tab">Data Ibu</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#datalainnya" data-toggle="tab">Data Lainnya</a></li>
                                                </ul>
                                            </div>

                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="datadiri">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('siswa/akun/updatedatadirisiswa') . '#datadiri'; ?>" method="post">
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


                                                   


                                                    <div class="tab-pane" id="dataayah">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('siswa/akun/updatedataayah') . '#dataayah'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Nama Ayah</label>
                                                                        <input type="text" class="form-control" id="editNamayah" name="editNamayah" value="<?php echo $siswa['ayah_nama']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editAgamaayah">Agama</label>
                                                                        <select class="form-control" id="editAgamaayah" name="editAgamaayah">
                                                                            <option value="Islam" <?php echo ($siswa['ayah_agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                                                            <option value="Kristen Protestan" <?php echo ($siswa['ayah_agama'] == 'Kristen Protestan') ? 'selected' : ''; ?>>Kristen Protestan</option>
                                                                            <option value="Katolik" <?php echo ($siswa['ayah_agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                                                            <option value="Hindu" <?php echo ($siswa['ayah_agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                                                            <option value="Buddha" <?php echo ($siswa['ayah_agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                                                                            <option value="Konghucu" <?php echo ($siswa['ayah_agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNikayah">NIK</label>
                                                                        <input type="text" class="form-control" id="editNikayah" name="editNikayah" value="<?php echo $siswa['ayah_nik']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editStatusayah">Status</label>
                                                                        <select class="form-control" id="editStatusayah" name="editStatusayah">
                                                                            <option value="HIDUP" <?php echo $siswa['ayah_status'] == 'HIDUP' ? 'selected' : ''; ?>>HIDUP</option>
                                                                            <option value="MENINGGAL" <?php echo $siswa['ayah_status'] == 'MENINGGAL' ? 'selected' : ''; ?>>MENINGGAL</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTanggallahirayah">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control" id="editTanggallahirayah" name="editTanggallahirayah" value="<?php echo $siswa['ayah_tanggallahir']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTempatlahirayah">Tempat Lahir</label>
                                                                        <input type="text" class="form-control" id="editTempatlahirayah" name="editTempatlahirayah" value="<?php echo $siswa['ayah_tempatlahir']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editAlamatayah">Alamat</label>
                                                                    <textarea class="form-control" id="editAlamatayah" name="editAlamatayah"><?php echo $siswa['ayah_alamat'];  ?> </textarea>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKelurahanayah">Desa / Kelurahan</label>
                                                                        <input type="text" class="form-control" id="editKelurahanayah" name="editKelurahanayah" value="<?php echo $siswa['ayah_desakel']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKecamatanayah">Kecamatan</label>
                                                                        <input type="text" class="form-control" id="editKecamatanayah" name="editKecamatanayah" value="<?php echo $siswa['ayah_kecamatan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKabupatenayah">Kabupaten</label>
                                                                        <input type="text" class="form-control" id="editKabupatenayah" name="editKabupatenayah" value="<?php echo $siswa['ayah_kabupaten']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editProvinsiayah">Provinsi</label>
                                                                        <input type="text" class="form-control" id="editProvinsiayah" name="editProvinsiayah" value="<?php echo $siswa['ayah_provinsi']; ?>">
                                                                    </div>
                                                                </div>


                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPekerjaanayah">Pekerjaan</label>
                                                                        <input type="text" class="form-control" id="editPekerjaanayah" name="editPekerjaanayah" value="<?php echo $siswa['ayah_pekerjaan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPendapatanayah">Pendapatan Dalam 1 Bulan</label>
                                                                        <input type="text" class="form-control" id="editPendapatanayah" name="editPendapatanayah" value="<?php echo $siswa['ayah_penghasilan']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="editTelpayah">No Telp</label>
                                                                        <input type="text" class="form-control" id="editTelpayah" name="editTelpayah" value="<?php echo $siswa['ayah_nohp']; ?>">
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="tab-pane" id="dataibu">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('siswa/akun/updatedataibu') . '#dataibu'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamaibu">Nama Ibu</label>
                                                                        <input type="text" class="form-control" id="editNamaibu" name="editNamaibu" value="<?php echo $siswa['ibu_nama']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editAgamaibu">Agama</label>
                                                                        <select class="form-control" id="editAgamaibu" name="editAgamaibu">
                                                                            <option value="Islam" <?php echo ($siswa['ibu_agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                                                            <option value="Kristen Protestan" <?php echo ($siswa['ibu_agama'] == 'Kristen Protestan') ? 'selected' : ''; ?>>Kristen Protestan</option>
                                                                            <option value="Katolik" <?php echo ($siswa['ibu_agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                                                            <option value="Hindu" <?php echo ($siswa['ibu_agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                                                            <option value="Buddha" <?php echo ($siswa['ibu_agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                                                                            <option value="Konghucu" <?php echo ($siswa['ibu_agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNikibu">NIK</label>
                                                                        <input type="text" class="form-control" id="editNikibu" name="editNikibu" value="<?php echo $siswa['ibu_nik']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editStatusibu">Status</label>
                                                                        <select class="form-control" id="editStatusibu" name="editStatusibu">
                                                                            <option value="HIDUP" <?php echo $siswa['ibu_status'] == 'HIDUP' ? 'selected' : ''; ?>>HIDUP</option>
                                                                            <option value="MENINGGAL" <?php echo $siswa['ibu_status'] == 'MENINGGAL' ? 'selected' : ''; ?>>MENINGGAL</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTanggallahiribu">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control" id="editTanggallahiribu" name="editTanggallahiribu" value="<?php echo $siswa['ibu_tanggallahir']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTempatlahiribu">Tempat Lahir</label>
                                                                        <input type="text" class="form-control" id="editTempatlahiribu" name="editTempatlahiribu" value="<?php echo $siswa['ibu_tempatlahir']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editAlamatibu">Alamat</label>
                                                                    <textarea class="form-control" id="editAlamatibu" name="editAlamatibu"><?php echo $siswa['ibu_alamat'];  ?> </textarea>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKelurahanibu">Desa / Kelurahan</label>
                                                                        <input type="text" class="form-control" id="editKelurahanibu" name="editKelurahanibu" value="<?php echo $siswa['ibu_desakel']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKecamatanibu">Kecamatan</label>
                                                                        <input type="text" class="form-control" id="editKecamatanibu" name="editKecamatanibu" value="<?php echo $siswa['ibu_kecamatan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editKabupatenibu">Kabupaten</label>
                                                                        <input type="text" class="form-control" id="editKabupatenibu" name="editKabupatenibu" value="<?php echo $siswa['ibu_kabupaten']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label for="editProvinsiibu">Provinsi</label>
                                                                        <input type="text" class="form-control" id="editProvinsiibu" name="editProvinsiibu" value="<?php echo $siswa['ibu_provinsi']; ?>">
                                                                    </div>
                                                                </div>


                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPekerjaanibu">Pekerjaan</label>
                                                                        <input type="text" class="form-control" id="editPekerjaanibu" name="editPekerjaanibu" value="<?php echo $siswa['ibu_pekerjaan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPendapatanibu">Pendapatan Dalam 1 Bulan</label>
                                                                        <input type="text" class="form-control" id="editPendapatanibu" name="editPendapatanibu" value="<?php echo $siswa['ibu_penghasilan']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="editTelpibu">No Telp</label>
                                                                        <input type="text" class="form-control" id="editTelpibu" name="editTelpibu" value="<?php echo $siswa['ibu_nohp']; ?>">
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="datalainnya">
                                                        <div class="post">
                                                            <form id="formEditSiswa" action="<?php echo base_url('siswa/akun/updatedatalainnya') . '#datalainnya'; ?>" method="post">
                                                                <input type="hidden" name="editSiswaId" value="<?php echo $siswa['id_siswa']; ?>">

                                                                <?php 
                                                                    // Check if saudara data exists
                                                                    if (!empty($siswa['saudara'])) {
                                                                        // Decode the JSON data if it's a string
                                                                        $saudara_data = is_string($siswa['saudara']) ? json_decode($siswa['saudara'], true) : $siswa['saudara'];
                                                                        
                                                                        // Loop through each saudara
                                                                        foreach ($saudara_data as $index => $saudara): 
                                                                            $is_first = ($index === 0);
                                                                    ?>
                                                                    <div class="form-row" id="saudara-row-<?php echo $index; ?>">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="editHubunganSaudara_<?php echo $index; ?>">Hubungan Saudara</label>
                                                                            <select class="form-control" id="editHubunganSaudara_<?php echo $index; ?>" name="editHubunganSaudara[]">
                                                                                <option value="">-- Pilih Hubungan --</option>
                                                                                <option value="kakak_kandung" <?php echo ($saudara['hub'] == 'kakak_kandung') ? 'selected' : ''; ?>>Kakak Kandung</option>
                                                                                <option value="adik_kandung" <?php echo ($saudara['hub'] == 'adik_kandung') ? 'selected' : ''; ?>>Adik Kandung</option>
                                                                                <option value="kakak_tiri" <?php echo ($saudara['hub'] == 'kakak_tiri') ? 'selected' : ''; ?>>Kakak Tiri</option>
                                                                                <option value="adik_tiri" <?php echo ($saudara['hub'] == 'adik_tiri') ? 'selected' : ''; ?>>Adik Tiri</option>
                                                                                <option value="sepupu" <?php echo ($saudara['hub'] == 'sepupu') ? 'selected' : ''; ?>>Sepupu</option>
                                                                                <option value="lainnya" <?php echo ($saudara['hub'] == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label for="editNamaSaudara_<?php echo $index; ?>">Nama Saudara</label>
                                                                            <input type="text" class="form-control" id="editNamaSaudara_<?php echo $index; ?>" 
                                                                                name="editNamaSaudara[]" value="<?php echo htmlspecialchars($saudara['nama']); ?>">
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-3">
                                                                            <label for="editUsiaSaudara_<?php echo $index; ?>">Usia Saudara</label>
                                                                            <input type="number" class="form-control" id="editUsiaSaudara_<?php echo $index; ?>" 
                                                                                name="editUsiaSaudara[]" value="<?php echo htmlspecialchars($saudara['usia']); ?>">
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-1 d-flex align-items-end">
                                                                            <?php if (!$is_first): ?>
                                                                                <button type="button" class="btn btn-danger btn-block" onclick="hapusSaudara(<?php echo $index; ?>)">
                                                                                    <i class="fas fa-trash"></i> 
                                                                                </button>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                        endforeach; 
                                                                    } else {
                                                                        // Default empty row if no data
                                                                    ?>
                                                                    <div class="form-row" id="saudara-row-0">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="editHubunganSaudara_0">Hubungan Saudara</label>
                                                                            <select class="form-control" id="editHubunganSaudara_0" name="editHubunganSaudara[]">
                                                                                <option value="">-- Pilih Hubungan --</option>
                                                                                <option value="kakak_kandung">Kakak Kandung</option>
                                                                                <option value="adik_kandung">Adik Kandung</option>
                                                                                <option value="kakak_tiri">Kakak Tiri</option>
                                                                                <option value="adik_tiri">Adik Tiri</option>
                                                                                <option value="sepupu">Sepupu</option>
                                                                                <option value="lainnya">Lainnya</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label for="editNamaSaudara_0">Nama Saudara</label>
                                                                            <input type="text" class="form-control" id="editNamaSaudara_0" name="editNamaSaudara[]">
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-3">
                                                                            <label for="editUsiaSaudara_0">Usia Saudara</label>
                                                                            <input type="number" class="form-control" id="editUsiaSaudara_0" name="editUsiaSaudara[]">
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>

                                                                    <!-- Hidden template for adding new rows -->
                                                                    <div id="saudara-template" style="display: none;">
                                                                        <div class="form-row" id="saudara-row-{index}">
                                                                            <div class="form-group col-md-4">
                                                                                <label for="editHubunganSaudara">Hubungan Saudara</label>
                                                                                <select class="form-control" name="editHubunganSaudara[]">
                                                                                    <option value="">-- Pilih Hubungan --</option>
                                                                                    <option value="kakak_kandung">Kakak Kandung</option>
                                                                                    <option value="adik_kandung">Adik Kandung</option>
                                                                                    <option value="kakak_tiri">Kakak Tiri</option>
                                                                                    <option value="adik_tiri">Adik Tiri</option>
                                                                                    <option value="sepupu">Sepupu</option>
                                                                                    <option value="lainnya">Lainnya</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="editNamaSaudara">Nama Saudara</label>
                                                                                <input type="text" class="form-control" name="editNamaSaudara[]">
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label for="editUsiaSaudara">Usia Saudara</label>
                                                                                <input type="number" class="form-control" name="editUsiaSaudara[]">
                                                                            </div>
                                                                            <div class="form-group col-md-1 d-flex align-items-end">
                                                                                <button type="button" class="btn btn-danger btn-block" onclick="hapusSaudara({index})">
                                                                                    <i class="fas fa-trash"></i> 
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Add Row Button -->
                                                                    <div class="form-row mt-1 mb-4">
                                                                        <div class="col-12">
                                                                            <span class="text-primary" id="tambah-saudara" style="cursor: pointer;">
                                                                                <i class="fas fa-plus"></i> Tambah Saudara
                                                                            </span>
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
        // Initialize saudara counter
        let saudaraCounter = <?php echo !empty($saudara_data) ? count($saudara_data) : 1; ?>;

        // Function to add new saudara row
        function tambahSaudara() {
            const template = document.getElementById('saudara-template');
            const newRow = template.innerHTML.replace(/\{index\}/g, saudaraCounter);
            
            const container = template.parentNode;
            const newElement = document.createElement('div');
            newElement.innerHTML = newRow;
            container.insertBefore(newElement.firstElementChild, template);
            
            // Show the delete button for the first row if it's the second row being added
            if (saudaraCounter === 1) {
                const firstRow = document.getElementById('saudara-row-0');
                if (firstRow) {
                    const deleteBtn = document.createElement('div');
                    deleteBtn.className = 'form-group col-md-2 d-flex align-items-end';
                    // deleteBtn.innerHTML = `
                    //     <button type="button" class="btn btn-danger btn-block" onclick="hapusSaudara(0)">
                    //         <i class="fas fa-trash"></i> Hapus
                    //     </button>
                    // `;
                    firstRow.appendChild(deleteBtn);
                }
            }
            
            saudaraCounter++;
        }

        // Function to delete saudara row
        function hapusSaudara(index) {
            const row = document.getElementById('saudara-row-' + index);
            if (row) {
                row.remove();
                
                // If this was the first row and there are no more rows, add an empty first row
                if (index === 0 && document.querySelectorAll('[id^="saudara-row-"]').length === 0) {
                    const container = document.getElementById('saudara-template').parentNode;
                    const newRow = document.createElement('div');
                    newRow.className = 'form-row';
                    newRow.id = 'saudara-row-0';
                    newRow.innerHTML = `
                        <div class="form-group col-md-4">
                            <label for="editHubunganSaudara_0">Hubungan Saudara</label>
                            <select class="form-control" id="editHubunganSaudara_0" name="editHubunganSaudara[]">
                                <option value="">-- Pilih Hubungan --</option>
                                <option value="kakak_kandung">Kakak Kandung</option>
                                <option value="adik_kandung">Adik Kandung</option>
                                <option value="kakak_tiri">Kakak Tiri</option>
                                <option value="adik_tiri">Adik Tiri</option>
                                <option value="sepupu">Sepupu</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editNamaSaudara_0">Nama Saudara</label>
                            <input type="text" class="form-control" id="editNamaSaudara_0" name="editNamaSaudara[]">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editUsiaSaudara_0">Usia Saudara</label>
                            <input type="number" class="form-control" id="editUsiaSaudara_0" name="editUsiaSaudara[]">
                        </div>
                    `;
                    container.insertBefore(newRow, document.getElementById('saudara-template'));
                    
                    // Reset counter if needed
                    saudaraCounter = 1;
                }
            }
        }

        // Add event listener for tambah button
        document.addEventListener('DOMContentLoaded', function() {
            const tambahBtn = document.getElementById('tambah-saudara');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', tambahSaudara);
            }
        });
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



        <?php $this->load->view('siswa/_partials/footer.php') ?>





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