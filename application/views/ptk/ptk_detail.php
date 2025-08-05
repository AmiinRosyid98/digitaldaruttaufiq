<html lang="en">

<head>

    <?php $this->load->view('ptk/_partials/head.php') ?>
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
            <?php $this->load->view('ptk/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>

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
                                <?php if (!empty($ptk)) : ?>
                                    <div class="col-md-3">
                                        <div class="card card-danger card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">

                                                    <?php if ($ptk['avatar'] != "default.png") { ?>
                                                        <img class="profile-user-img img-fluid img-circle" style="width: 100px;height: 100px; object-fit: cover;" src="<?php echo base_url(); ?>assets/ptk/profile/<?= $ptk['avatar'] ?>" alt="User profile picture">
                                                    <?php } else { ?>
                                                        <img class="profile-user-img img-fluid img-circle" style="width: 100px;height: 100px; object-fit: cover;" src="<?php echo base_url('assets/siswa/profile/default.png'); ?>" alt="User profile picture">
                                                    <?php } ?>
                                                </div>
                                                <h3 class="profile-username text-center"><?php echo $ptk['nama_ptk']; ?></h3>
                                                <p class="text-muted text-center"><strong> Kelas Mengajar <small class="badge badge-danger"><?php echo $ptk['nama_kelas']; ?></small> </strong></p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item"><b>NIP</b> <b><a class="float-right text-dark"><?php echo $ptk['nip']; ?></a></b></li>
                                                    
                                                </ul>
                                                

                                            </div>
                                        </div>


                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">Data Diri Guru</h3>
                                            </div>

                                            <div class="card-body">
                                                <strong><i class="far fa-file-alt mr-1"></i> Tempat, Tanggal Lahir</strong>
                                                <p class="text-muted"><?php echo $ptk['tempatlahir_ptk']; ?>, <?php echo date('d-m-Y', strtotime($ptk['tanggallahir_ptk'])); ?></p>
                                                <hr>
                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                                                <p class="text-muted"><?php echo $ptk['ptk_alamat']; ?>, <?php echo $ptk['kelurahan']; ?>, <?php echo $ptk['kecamatan']; ?>,<?php echo $ptk['kabupaten']; ?>, <?php echo $ptk['provinsi']; ?> </p>
                                                <hr>
                                                <strong><i class="fas fa-venus mr-1"></i> Jenis Kelamin</strong>
                                                <p class="text-muted">
                                                    <span class="tag tag-danger">
                                                        <?php if ($ptk['jeniskelamin'] == 'L') : ?>
                                                            Laki-Laki
                                                        <?php elseif ($ptk['jeniskelamin'] == 'P') : ?>
                                                            Perempuan
                                                        <?php else : ?>
                                                            Jenis Kelamin tidak valid
                                                        <?php endif; ?>
                                                </p>
                                                <hr>
                                                <strong><i class="fas fa-mobile mr-1"></i> Nomor HP/WA</strong>
                                                <p class="text-muted"><?php echo $ptk['no_telepon']; ?>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-header p-2 bg-secondary">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link active" href="#datadiri" data-toggle="tab">Data Diri</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#datapendidikan" data-toggle="tab">Data Pendidikan</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#datakepegawaian" data-toggle="tab">Data Kepegawaian</a></li>
                                                    <li class="nav-item mr-2"><a class="btn-warning nav-link" href="#dokumenpendukung" data-toggle="tab">Dokumen Pendukung</a></li>
                                                </ul>
                                            </div>

                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="datadiri">
                                                        <div class="post">
                                                            <form id="formEditPtk" action="<?php echo base_url('ptk/akun/updatedatadiriguru') . '#datadiri'; ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="editGuruId" value="<?php echo $ptk['id_guru']; ?>">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="editNamaPtk">Nama Siswa</label>
                                                                        <input type="text" class="form-control" id="editNamaPtk" name="editNamaPtk" value="<?php echo $ptk['nama_ptk']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="editNamaPtk">NIP / NUPTK</label>
                                                                        <input type="text" class="form-control" id="editNipPtk" name="editNipPtk" value="<?php echo $ptk['nip']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="editNamaPtk">NIK</label>
                                                                        <input type="text" class="form-control" id="editNikPtk" name="editNikPtk" value="<?php echo $ptk['nik']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editJeniskelamin">Jenis Kelamin</label>
                                                                        <select class="form-control" id="editJeniskelamin" name="editJeniskelamin">
                                                                            <option value="L" <?php echo ($ptk['jeniskelamin'] == 'L') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                                            <option value="P" <?php echo ($ptk['jeniskelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editAgama">Agama</label>
                                                                        <select class="form-control" id="editAgama" name="editAgama">
                                                                            <option value="Islam" <?php echo ($ptk['agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                                                            <option value="Kristen Protestan" <?php echo ($ptk['agama'] == 'Kristen Protestan') ? 'selected' : ''; ?>>Kristen Protestan</option>
                                                                            <option value="Katolik" <?php echo ($ptk['agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                                                            <option value="Hindu" <?php echo ($ptk['agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                                                            <option value="Buddha" <?php echo ($ptk['agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                                                                            <option value="Konghucu" <?php echo ($ptk['agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTempatlahir">Tempat Lahir</label>
                                                                        <input type="text" class="form-control" id="editTempatlahir" name="editTempatlahir" value="<?php echo $ptk['tempatlahir_ptk']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTanggallahir">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control" id="editTanggallahir" name="editTanggallahir" value="<?php echo $ptk['tanggallahir_ptk']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editPtkAlamat">Alamat</label>
                                                                    <textarea class="form-control" id="editPtkAlamat" name="editPtkAlamat"><?php echo $ptk['ptk_alamat'];  ?> </textarea>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="editPtkKelurahan">Kelurahan</label>
                                                                        <input type="text" class="form-control" id="editPtkKelurahan" name="editPtkKelurahan" value="<?php echo $ptk['kelurahan']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="editPtkKecamatan">Kecamatan</label>
                                                                        <input type="text" class="form-control" id="editPtkKecamatan" name="editPtkKecamatan" value="<?php echo $ptk['kecamatan']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="editPtkKabupaten">Kabupaten</label>
                                                                        <input type="text" class="form-control" id="editPtkKabupaten" name="editPtkKabupaten" value="<?php echo $ptk['kabupaten']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="editPtkProvinsi">Provinsi</label>
                                                                    <input type="text" class="form-control" id="editPtkProvinsi" name="editPtkProvinsi" value="<?php echo $ptk['provinsi']; ?>" required>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNohp">Nomor Telepon</label>
                                                                        <input type="text" class="form-control" id="editNohp" name="editNohp" value="<?php echo $ptk['no_telepon']; ?>">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="editPtkemail">Email</label>
                                                                        <input type="email" class="form-control" id="editPtkemail" name="editPtkemail" value="<?php echo $ptk['email']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNohp">Foto Profil</label><br>
                                                                        <?php if ($ptk['avatar'] != "default.png") { ?>
                                                                            <img class="" style="width: 100px;" src="<?php echo base_url(); ?>assets/ptk/profile/<?= $ptk['avatar'] ?>" alt="User profile picture">
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px;" src="<?php echo base_url('assets/siswa/profile/default.png'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input style="margin-top:10px" type="file" class="form-control" id="editPhoto" name="editPhoto" >
                                                                    </div>
                                                                </div>



                                                                <!-- Tambahkan input lainnya sesuai kebutuhan -->

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Simpan</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="datapendidikan">
                                                        <div class="post">
                                                            <form id="formEditPtk" action="<?php echo base_url('ptk/akun/updatedatapendidikan') . '#datapendidikan'; ?>" method="post">
                                                                <input type="hidden" name="editGuruId" value="<?php echo $ptk['id_guru']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Pendidikan Terakhir</label>
                                                                        <select class="form-control" id="editPendidikanTerakhir" name="editPendidikanTerakhir">
                                                                            <option value="">Pilih Pendidikan Terakhir</option>
                                                                            <option value="S1" <?php echo ($ptk['pendidikan_terakhir'] == 'S1') ? 'selected' : ''; ?>>S1</option>
                                                                            <option value="S2" <?php echo ($ptk['pendidikan_terakhir'] == 'S2') ? 'selected' : ''; ?>>S2</option>
                                                                            <option value="S3" <?php echo ($ptk['pendidikan_terakhir'] == 'S3') ? 'selected' : ''; ?>>S3</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Nama Insitusi Pendidikan</label>
                                                                        <input type="text" class="form-control" id="editInstitusiPendidikan" name="editInstitusiPendidikan" value="<?php echo $ptk['nama_institusi_pendidikan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Jurusan</label>
                                                                        <input type="text" class="form-control" id="editJurusan" name="editJurusan" value="<?php echo $ptk['jurusan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Tahun Lulus</label>
                                                                        <input type="number" class="form-control" id="editTahunLulus" name="editTahunLulus" value="<?php echo $ptk['tahun_lulus']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Ijazah / Transkip Nilai</label>
                                                                        <input type="text" class="form-control" id="editIjazah" name="editIjazah" value="<?php echo $ptk['ijazah_transkrip']; ?>">
                                                                    </div>

                                                                    
                                                                </div>  

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="datakepegawaian">
                                                        <div class="post">
                                                            <form id="formEditPtk" action="<?php echo base_url('ptk/akun/updatedatakepegawaian') . '#datakepegawaian'; ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="editGuruId" value="<?php echo $ptk['id_guru']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Status Kepegawaian</label>
                                                                        <select class="form-control" id="editStatusKepegawaian" name="editStatusKepegawaian">
                                                                            <option value="">Pilih Status Kepegawaian</option>
                                                                            <option value="PNS" <?php echo ($ptk['status_kepegawaian'] == 'PNS') ? 'selected' : ''; ?>>PNS</option>
                                                                            <option value="Honorer" <?php echo ($ptk['status_kepegawaian'] == 'Honorer') ? 'selected' : ''; ?>>Honorer</option>
                                                                            <option value="Kontrak" <?php echo ($ptk['status_kepegawaian'] == 'Kontrak') ? 'selected' : ''; ?>>Kontrak</option>
                                                                            <option value="Tetap Yayasan" <?php echo ($ptk['status_kepegawaian'] == 'Tetap Yayasan') ? 'selected' : ''; ?>>Tetap Yayasan</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editTanggalMulaiTugas">Tanggal Mulai Tugas (TMT)</label>
                                                                        <input type="date" class="form-control" id="editTanggalMulaiTugas" name="editTanggalMulaiTugas" value="<?php echo $ptk['tmt']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Jabatan / Tugas Tambahan</label>
                                                                        <input type="text" class="form-control" id="editJabatan" name="editJabatan" value="<?php echo $ptk['jabatan_tambahan']; ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Status</label>
                                                                        <select class="form-control" id="editStatusAktif" name="editStatusAktif">
                                                                            <option value="">Pilih Status </option>
                                                                            <option value="Aktif" <?php echo ($ptk['status_aktif'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                                            <option value="Tidak Aktif" <?php echo ($ptk['status_aktif'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">SK Pengangkatan</label><br>

                                                                        <?php if ($ptk['sk_pengangkatan'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sk_pengangkatan'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['sk_pengangkatan'], -4)) === '.pdf') {
                                                                                ?>

                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sk_pengangkatan'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" style="margin-top:10px" class="form-control" id="editSkPengangkatan" name="editSkPengangkatan" >
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Nomor Rekening</label>
                                                                        <input type="text" class="form-control" id="editNomorRekening" name="editNomorRekening" value="<?php echo $ptk['nomor_rekening']; ?>">
                                                                        <small>Digunakan untuk pembayaran honor.</small>
                                                                    </div>

                                                                    
                                                                </div>

                                                                


                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>


                                                    <div class="tab-pane" id="dokumenpendukung">
                                                        <div class="post">
                                                            <form id="formEditPtk" action="<?php echo base_url('ptk/akun/updatedokumenpendukung') . '#dokumenpendukung'; ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="editGuruId" value="<?php echo $ptk['id_guru']; ?>">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Scan Ijazah</label><br>
                                                                        <?php if ($ptk['scan_ijazah'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['scan_ijazah'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['scan_ijazah'], -4)) === '.pdf') {
                                                                                ?>
                                                                                
                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['scan_ijazah'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" class="form-control" id="editScanIjazah" name="editScanIjazah" style="margin-top:10px" >
                                                                    </div>
                                                                
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Scan KTP</label><br>
                                                                        <?php if ($ptk['scan_ktp'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['scan_ktp'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['scan_ktp'], -4)) === '.pdf') {
                                                                                ?>
                                                                                
                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['scan_ktp'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" class="form-control" id="editScanKtp" name="editScanKtp" style="margin-top:10px" >
                                                                    </div>
                                                                
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Sertifikat Pendidik</label><br>
                                                                        <?php if ($ptk['sertifikat_pendidik'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sertifikat_pendidik'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['sertifikat_pendidik'], -4)) === '.pdf') {
                                                                                ?>
                                                                                
                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sertifikat_pendidik'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" class="form-control" id="editSertifikatPendidik" name="editSertifikatPendidik" style="margin-top:10px" >
                                                                    </div>
                                                                
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Sertifikat Pelatihan / Workshop</label><br>
                                                                        <?php if ($ptk['sertifikat_pelatihan'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sertifikat_pelatihan'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['sertifikat_pelatihan'], -4)) === '.pdf') {
                                                                                ?>
                                                                                
                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['sertifikat_pelatihan'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" class="form-control" id="editSertifikatPelatihan" name="editSertifikatPelatihan" style="margin-top:10px">
                                                                    </div>
                                                                
                                                                    <div class="form-group col-md-6">
                                                                        <label for="editNamayah">Portofolio atau CV</label><br>
                                                                        <?php if ($ptk['portofolio_cv'] != "") { ?>
                                                                            <a href="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['portofolio_cv'] ?>" target="_blank">
                                                                                <?php if (strtolower(substr($ptk['portofolio_cv'], -4)) === '.pdf') {
                                                                                ?>
                                                                                
                                                                                <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/pdf.png" alt="User profile picture">
                                                                                <?php } else { ?>
                                                                                    <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url(); ?>assets/ptk/dokumen/<?= $ptk['portofolio_cv'] ?>" alt="User profile picture">
                                                                                <?php } ?>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <img class="" style="width: 100px; height: 100px; border-radius:5px; object-fit:cover;" src="<?php echo base_url('assets/ptk/dokumen/default.jpg'); ?>" alt="User profile picture">
                                                                        <?php } ?>
                                                                        <input type="file" class="form-control" id="editPortofolio" name="editPortofolio" style="margin-top:10px">
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



        <?php $this->load->view('ptk/_partials/footer.php') ?>





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