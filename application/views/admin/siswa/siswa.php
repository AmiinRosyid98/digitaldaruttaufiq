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
            <div class="content-wrapper" style="min-height: 1900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                    </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Database Siswa</h3>
                                <div>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahPenggunaModal">
                                        <i class="fa fa-user-plus"></i> Siswa
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="importButton" data-toggle="modal" data-target="#importPenggunaModal">
                                        <i class="fa fa-upload"></i> Import
                                    </button>
                                    <a href="<?php echo base_url('admin/siswa/export_excel'); ?>" class="btn btn-warning btn-sm"> <i class="fa fa-file-export"></i> Export</a>
                                    <a class="btn btn-danger btn-sm" href="#" onclick="deleteallSiswa()"><i class="fa fa-eraser"></i> Kosongkan Siswa</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kelas</th>
                                        <th>Nomor Absen</th>
                                        <th>QR Code</th> <!-- Kolom untuk menampilkan QR Code -->
                                        <th>Aksi</th>
                                        <!-- Tambah kolom untuk QR Code -->
                                        <th>Generate</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($siswa as $index => $siswa_item) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $siswa_item['nis']; ?></td>
                                            <td class="text-center"><?php echo $siswa_item['nama_siswa']; ?></td>
                                            <td class="text-center"><small class="badge badge-danger"><?php echo $siswa_item['nama_kelas']; ?></small></td>
                                            <td class="text-center"><?php echo $siswa_item['no_absen']; ?></td>
                                            <td class="text-center" id="qrcode_<?php echo $siswa_item['id_siswa']; ?>">
                                                <?php
                                                $qr_code_path = 'assets/qr_code/' . $siswa_item['nama_siswa'] . '_' . $siswa_item['id_siswa'] . '.png';
                                                if (file_exists(FCPATH . $qr_code_path)) {
                                                    echo '<img src="' . base_url($qr_code_path) . '" style="max-width: 100px; height: auto;" />';
                                                } else {
                                                    echo '<img src="https://cdn.excode.my.id/assets/material/placeholderupload.jpg" style="max-width: 100px; height: auto;" />';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteSiswa(<?php echo $siswa_item['id_siswa']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-warning btn-sm" href="#" onclick="editSiswa(<?php echo $siswa_item['id_siswa']; ?>)"><i class="fas fa-pen"></i></a>
                                                <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/siswa/detailsiswa/') . $siswa_item['id_siswa']; ?>"><i class="fas fa-user-graduate"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="openPdfModal('<?php echo base_url('admin/siswa/cetakbukuinduk/' . $siswa_item['id_siswa']); ?>', '<?php echo $siswa_item['nama_siswa']; ?>')"><i class="fas fa-print"></i></a>
                                            </td>
                                            <!-- Tambah link untuk generate QR Code -->
                                            <td class="text-center">
                                                <a class="btn btn-info btn-sm" href="#" onclick="generateQR(<?php echo $siswa_item['id_siswa']; ?>)"><i class="fas fa-qrcode"></i> QR</a>
                                            </td>
                                            <!-- Kolom untuk menampilkan QR Code -->


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="pagination">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <!-- ======================================================================================================= -->
            <!-- Modal Tambah Siswa -->
            <div class="modal fade" id="tambahPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa Baru Manual</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulir untuk menambah pengguna -->
                            <form action="<?php echo site_url('admin/siswa/simpan_siswa'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" placeholder="Nama Lengkap" oninput="this.value = this.value.toUpperCase()" required>
                                    <input type="hidden" class="form-control" id="avatar" name="avatar" value="default.png">
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="jeniskelamin">Jenis Kelamin</label>
                                            <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <select class="form-control" id="agama" name="agama">
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tempatlahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" placeholder="Tempat Lahir" oninput="this.value = this.value.toUpperCase()" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tanggallahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" placeholder="Tanggal Lahir" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="siswa_alamat">Alamat Lengkap</label>
                                    <textarea class="form-control" id="siswa_alamat" name="siswa_alamat" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kode_kelas">Nama Kelas</label>
                                            <select class="form-control" id="kode_kelas" name="kode_kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <?php foreach ($kelas as $item_kelas) : ?>
                                                    <option value="<?php echo $item_kelas['no_kelas']; ?>"><?php echo $item_kelas['nama_kelas']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="no_absen">Nomor Absen</label>
                                            <input type="number" class="form-control" id="no_absen" name="no_absen" placeholder="Nomor absen" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nis">NIS</label>
                                            <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk Siswa Lokal" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nisn">NISN</label>
                                            <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Nomor Induk Siswa Nasional" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tahun_angkatan">Tahun Angkatan</label>
                                    <select class="form-control" id="tahun_angkatan" name="tahun_angkatan" required>
                                        <option value="">Pilih</option>
                                        <?php foreach ($tahunangkatan as $item_tahun) : ?>
                                            <option value="<?php echo $item_tahun['tahun']; ?>"><?php echo $item_tahun['tahun']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk Edit Siswa -->
            <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMemberModalLabel">Edit Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editMemberForm">
                            <div class="modal-body">
                                <p><code>*Data Informasi Pribadi Siswa</code></p>
                                <div class="row">
                                    <input type="hidden" id="editSiswaId" name="editSiswaId">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="editNamaSiswa">Nama Siswa</label>
                                        <input type="text" class="form-control" id="editNamaSiswa" name="editNamaSiswa" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editJeniskelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="editJeniskelamin" name="editJeniskelamin">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editAgama">Agama</label>
                                        <select class="form-control" id="editAgama" name="editAgama">
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen Protestan">Kristen Protestan</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editTempatlahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="editTempatlahir" name="editTempatlahir" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editTanggallahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="editTanggallahir" name="editTanggallahir" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="editAlamatSiswa">Alamat Lengkap</label>
                                    <textarea class="form-control" id="editAlamatSiswa" name="editAlamatSiswa" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editKodeKelas">Kelas</label>
                                        <select class="form-control" id="editKodeKelas" name="editKodeKelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <?php foreach ($kelas as $item_kelas) : ?>
                                                <option value="<?php echo $item_kelas['no_kelas']; ?>"><?php echo $item_kelas['nama_kelas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editNomorAbsen">Nomor Absen</label>
                                        <input type="number" class="form-control" id="editNomorAbsen" name="editNomorAbsen" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editNis">NIS</label>
                                        <input type="number" class="form-control" id="editNis" name="editNis" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editNisn">NISN</label>
                                        <input type="number" class="form-control" id="editNisn" name="editNisn" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="editTahunAngkatan">Tahun Angkatan</label>
                                        <select class="form-control" id="editTahunAngkatan" name="editTahunAngkatan" required>
                                            <option value="">Pilih</option>
                                            <?php foreach ($tahunangkatan as $item_tahun) : ?>
                                                <option value="<?php echo $item_tahun['tahun']; ?>"><?php echo $item_tahun['tahun']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Edit Data</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <!-- Modal Import Data Siswa-->
            <div class="modal fade" id="importPenggunaModal" tabindex="-1" aria-labelledby="importPenggunaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importPenggunaModalLabel">Import Data Siswa dari Excel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="importForm" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="excelFile">Pilih File Excel (.xls/.xlsx)</label>
                                    <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".xls,.xlsx">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="importSubmit">Import</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal untuk Cetak PDF Siswa -->
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 90vw; max-height: 90vh;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">Buku Induk - <span id="siswaName"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="pdfViewer" src="" width="100%" height="600" style="border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>




            <?php $this->load->view('admin/_partials/footer.php') ?>


            <script>
                // Function untuk generate QR Code menggunakan AJAX
                function generateQR(id_siswa) {
                    $.ajax({
                        url: '<?php echo base_url('admin/siswa/generate_qr_code/'); ?>' + id_siswa,
                        type: 'GET',
                        dataType: 'json', // Tambahkan dataType: 'json' untuk menerima respons JSON
                        success: function(response) {
                            if (response.success) {
                                // Tampilkan QR Code di tempat yang diinginkan
                                $('#qrcode_' + id_siswa).html('<img src="' + response.qr_code_path + '" style="max-width: 100px; height: auto;" />');
                                // Tampilkan toast berhasil
                                showToast('success', 'QR Code berhasil di-generate');
                            } else {
                                // Tampilkan pesan error
                                showToast('error', response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            showToast('error', 'Gagal meng-generate QR Code');
                        }
                    });
                }

                // Function untuk menampilkan toast messages
                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }
            </script>


            <script>
                function openPdfModal(pdfUrl, siswaName) {
                    $('#siswaName').text(siswaName);
                    $('#pdfViewer').attr('src', pdfUrl);
                    $('#pdfModal').modal('show');
                }
            </script>






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