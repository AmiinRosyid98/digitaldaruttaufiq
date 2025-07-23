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
            <div class="content-wrapper" style="min-height: 1700px;">
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
                                <h3 class="card-title">DATA PTK</h3>
                                <div>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahPenggunaModal">
                                        <i class="fa fa-user-plus"></i> PTK
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="importButton" data-toggle="modal" data-target="#importPtkModal">
                                        <i class="fa fa-user-plus"></i> Import
                                    </button>
                                    <a href="<?= base_url('admin/ptk/export_excel') ?>" class="btn btn-sm btn-info">
                                        <i class="fa fa-file-excel"></i> Ekspor Excel
                                    </a>


                                    <a class="btn btn-danger btn-sm" href="#" onclick="deleteallPtk()"><i class="fa fa-eraser"></i> Kosongkan PTK</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kelas Mengajar</th>
                                        <th>QR</th>
                                        <th>Generate</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ptk as $index => $ptk) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center">
                                                <?php
                                                $foto_path = 'assets/ptk/profile/' . $ptk['avatar'];
                                                if (file_exists(FCPATH . $foto_path)) {
                                                    echo '<img src="' . base_url($foto_path) . '" style="max-width: 80px; width: 80px; height: 100px;" />';
                                                } else {
                                                    echo '<img src="https://cdn.excode.my.id/assets/material/placeholderupload.jpg" style="max-width: 100px; height: auto;" />';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $ptk['nama_ptk']; ?><br>
                                                <ul>
                                                    <li><span><small class="badge badge-danger"><?php echo $ptk['nip']; ?></small></span></li>
                                                    <li><span><small class="badge badge-primary"><?php echo $ptk['nama_mapel']; ?></small></span></li>
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                <small class="badge <?php echo (isset($ptk['nama_kelas']) && ($ptk['nama_kelas'] == 0 || $ptk['nama_kelas'] === null)) ? 'badge-info' : 'badge-Secondary'; ?>">
                                                    <?php echo isset($ptk['nama_kelas']) && $ptk['nama_kelas'] !== null ? $ptk['nama_kelas'] : 'Tidak Mengajar'; ?>
                                                </small>
                                            </td>
                                            <td class="text-center" id="qrcode_<?php echo $ptk['id_guru']; ?>">
                                                <?php
                                                $qr_code_path = 'assets/qr_code/' . $ptk['nama_ptk'] . '_' . $ptk['id_guru'] . '.png';
                                                if (file_exists(FCPATH . $qr_code_path)) {
                                                    echo '<img src="' . base_url($qr_code_path) . '" style="max-width: 100px; height: auto;" />';
                                                } else {
                                                    echo '<img src="https://cdn.excode.my.id/assets/material/placeholderupload.jpg" style="max-width: 100px; height: auto;" />';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-success btn-sm" href="#" onclick="generateQR(<?php echo $ptk['id_guru']; ?>)"><i class="fas fa-qrcode"></i> Generate</a>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm mb-0" href="#" onclick="deletePtk(<?= $ptk['id_guru']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-warning btn-sm mb-0" href="#" onclick="editPtk(<?= $ptk['id_guru']; ?>)"><i class="fas fa-pen"></i></a>
                                                <!-- Form Upload Foto -->
                                                <form action="<?= site_url('admin/ptk/upload_foto/' . $ptk['id_guru']); ?>" method="post" enctype="multipart/form-data" class="d-inline">
                                                    <label class="btn btn-primary btn-sm mb-0">
                                                        <input type="file" name="foto_guru" required style="display: none;" onchange="this.form.submit()">
                                                        <i class="fas fa-upload"></i> Foto
                                                    </label>
                                                </form>
                                            </td>
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
            <!-- Modal Tambah PTK -->
            <div class="modal fade" id="tambahPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah DATA PTK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/ptk/simpan_ptk'); ?>" method="POST" onsubmit="return validateForm()">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nama_ptk">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_ptk" name="nama_ptk" placeholder="Nama Lengkap" oninput="this.value = this.value.toUpperCase()" required>
                                            <input type="hidden" class="form-control" id="avatar" name="avatar" value="default.png">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nip">NIP</label>
                                            <input type="number" class="form-control" id="nip" name="nip" placeholder="Nip / Nuptk / No pegawai" required>
                                        </div>
                                    </div>
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
                                            <label for="tempatlahir_ptk">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempatlahir_ptk" name="tempatlahir_ptk" placeholder="Tempat Lahir" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tanggallahir_ptk">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggallahir_ptk" name="tanggallahir_ptk">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ptk_alamat">Alamat Lengkap</label>
                                    <textarea class="form-control" id="ptk_alamat" name="ptk_alamat" oninput="this.value = this.value.toUpperCase()"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="kode_kelas"><span class="badge bg-primary" style="font-size: 13px;">Mengajar di kelas</span></label>
                                    <div class="row">
                                        <?php foreach ($kelas as $item_kelas) : ?>
                                            <div class="col-auto mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="kode_kelas_<?php echo $item_kelas['no_kelas']; ?>" name="kode_kelas[]" value="<?php echo $item_kelas['no_kelas']; ?>">
                                                    <label class="form-check-label ml-2" for="kode_kelas_<?php echo $item_kelas['no_kelas']; ?>" style="width: 50px;"><?php echo $item_kelas['nama_kelas']; ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- Tambahkan pilihan "Tidak Mengajar" -->
                                        <div class="col-auto mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="tidak_mengajar" name="kode_kelas[]" value="0">
                                                <label class="form-check-label ml-2" for="tidak_mengajar" style="width: 200px;"><span class="badge bg-info">TIDAK MENGAJAR</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mengajar_mapel"><span class="badge bg-primary" style="font-size: 13px;">Mata Pelajaran yang Diajar</span></label>
                                    <div class="row">
                                        <?php foreach ($mapel as $item_mapel) : ?>
                                            <div class="col-auto mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="mengajar_mapel_<?php echo $item_mapel['id_mapel']; ?>"
                                                        name="mengajar_mapel[]" value="<?php echo $item_mapel['id_mapel']; ?>">
                                                    <label class="form-check-label ml-2" for="mengajar_mapel_<?php echo $item_mapel['id_mapel']; ?>"
                                                        style="width: 200px;"><?php echo $item_mapel['nama_mapel']; ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- Tambahkan pilihan "Tidak Mengajar Mapel" -->
                                        <div class="col-auto mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="tidak_mengajar_mapel"
                                                    name="mengajar_mapel[]" value="0">
                                                <label class="form-check-label ml-2" for="tidak_mengajar_mapel"
                                                    style="width: 200px;"><span class="badge bg-info">TIDAK MENGAJAR MAPEL</span></label>
                                            </div>
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
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal untuk Edit PTK -->
            <div class="modal fade" id="editPtkModal" tabindex="-1" role="dialog" aria-labelledby="editPTKModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPTKModalLabel">DATA PTK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editPtkForm">
                            <div class="modal-body">
                                <p><code>*Data Informasi Pribadi PTK</code></p>
                                <div class="row">
                                    <input type="hidden" id="editPtkId" name="editPtkId">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editNama">Nama PTK</label>
                                        <input type="text" class="form-control" id="editNama" name="editNama" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editNip">NIP</label>
                                        <input type="number" class="form-control" id="editNip" name="editNip" oninput="this.value = this.value.toUpperCase()" required>
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
                                    <label for="editAlamat">Alamat Lengkap</label>
                                    <textarea class="form-control" id="editAlamat" name="editAlamat"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="editKodeKelas">Mengajar Kelas</label>
                                    <div class="row">
                                        <?php foreach ($kelas as $item_kelas) : ?>
                                            <div class="col-auto mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="editKodeKelas_<?php echo $item_kelas['no_kelas']; ?>" name="editKodeKelas[]" value="<?php echo $item_kelas['no_kelas']; ?>">
                                                    <label class="form-check-label ml-2" for="editKodeKelas_<?php echo $item_kelas['no_kelas']; ?>" style="width: 50px;"><?php echo $item_kelas['nama_kelas']; ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- Tambahkan pilihan "Tidak Mengajar" -->
                                        <div class="col-auto mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="tidak_mengajar" name="editKodeKelas[]" value="0">
                                                <label class="form-check-label ml-2" for="tidak_mengajar" style="width: 200px;"><span class="badge bg-info">TIDAK MENGAJAR</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="editMapel"><span class="badge bg-primary" style="font-size: 13px;">Mata Pelajaran yang Diajar</span></label>
                                    <div class="row">
                                        <?php foreach ($mapel as $item_mapel) : ?>
                                            <div class="col-auto mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editMapel_<?php echo $item_mapel['id_mapel']; ?>"
                                                        name="editMapel[]"
                                                        value="<?php echo $item_mapel['id_mapel']; ?>">
                                                    <label class="form-check-label ml-2" for="editMapel_<?php echo $item_mapel['id_mapel']; ?>"
                                                        style="width: 200px;"><?php echo $item_mapel['nama_mapel']; ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- Tambahkan pilihan "Tidak Mengajar Mapel" -->
                                        <div class="col-auto mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="editTidakMengajarMapel"
                                                    name="editMapel[]" value="0">
                                                <label class="form-check-label ml-2" for="editTidakMengajarMapel"
                                                    style="width: 200px;"><span class="badge bg-info">TIDAK MENGAJAR MAPEL</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-danger"><?php echo form_error('editMapel[]'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="editUsername">Username</label>
                                    <textarea class="form-control" id="editUsername" name="editUsername" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="editPassword">Password Baru</label>
                                        <input type="password" class="form-control" id="editPassword" name="editPassword">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="editPasswordConfirm">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="editPasswordConfirm" name="editPasswordConfirm">
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
            <!-- Modal Import Data PTK-->
            <div class="modal fade" id="importPtkModal" tabindex="-1" aria-labelledby="importPtkModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importPtkModalLabel">Import Data PTK dari Excel</h5>
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
            <?php $this->load->view('admin/_partials/footer.php') ?>
            <script>
                // Function untuk generate QR Code menggunakan AJAX
                function generateQR(id_guru) {
                    $.ajax({
                        url: '<?php echo base_url('admin/ptk/generate_qr_code/'); ?>' + id_guru,
                        type: 'GET',
                        dataType: 'json', // Tambahkan dataType: 'json' untuk menerima respons JSON
                        success: function(response) {
                            if (response.success) {
                                // Tampilkan QR Code di tempat yang diinginkan
                                $('#qrcode_' + id_guru).html('<img src="' + response.qr_code_path + '" style="max-width: 100px; height: auto;" />');
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
                //Fungsi Edit PTK
                // Fungsi Edit PTK
                function editPtk(ptkId) {
                    $.ajax({
                        url: 'ptk/get_ptk',
                        type: 'GET',
                        data: {
                            ptk_id: ptkId
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Isi data dasar
                            $('#editPtkId').val(response.ptk.id_guru);
                            $('#editNip').val(response.ptk.nip);
                            $('#editNama').val(response.ptk.nama_ptk);
                            $('#editJeniskelamin').val(response.ptk.jeniskelamin);
                            $('#editAgama').val(response.ptk.agama);
                            $('#editTempatlahir').val(response.ptk.tempatlahir_ptk);
                            $('#editTanggallahir').val(response.ptk.tanggallahir_ptk);
                            $('#editAlamat').val(response.ptk.ptk_alamat);
                            $('#editUsername').val(response.ptk.username);

                            // Reset password fields
                            $('#editPassword').val('');
                            $('#editPasswordConfirm').val('');

                            // Handle kelas yang diajar
                            var kodeKelas = response.ptk.kode_kelas ? response.ptk.kode_kelas.split(',') : [];
                            $('input[name="editKodeKelas[]"]').prop('checked', false);
                            kodeKelas.forEach(function(kelas) {
                                $('#editKodeKelas_' + kelas).prop('checked', true);
                            });

                            // Handle mapel yang diajar (multiple selection)
                            $('input[name="editMapel[]"]').prop('checked', false);
                            if (response.ptk.mapel && response.ptk.mapel.length > 0) {
                                response.ptk.mapel.forEach(function(mapel) {
                                    $('#editMapel_' + mapel.id_mapel).prop('checked', true);
                                });
                            } else if (response.ptk.mapel_mengajar) {
                                // Fallback untuk kompatibilitas dengan data lama
                                var mapelArray = response.ptk.mapel_mengajar.split(',');
                                mapelArray.forEach(function(id_mapel) {
                                    $('#editMapel_' + id_mapel).prop('checked', true);
                                });
                            }

                            $('#editPtkModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data PTK.');
                        }
                    });
                }

                $(document).ready(function() {
                    $('#editPtkForm').submit(function(event) {
                        event.preventDefault();

                        // Validasi minimal satu mapel dipilih
                        if ($('input[name="editMapel[]"]:checked').length === 0) {
                            alert('Pilih minimal satu mata pelajaran yang diajar!');
                            return false;
                        }

                        $.ajax({
                            url: 'ptk/update_ptk',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                $('#submitBtn').prop('disabled', true).html('Menyimpan...');
                            },
                            success: function(response) {
                                $('#submitBtn').prop('disabled', false).html('Simpan');
                                if (response.success) {
                                    $('#editPtkModal').modal('hide');
                                    showToast('success', 'Data PTK berhasil diperbarui.');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                } else {
                                    showToast('error', response.message || 'Gagal menyimpan perubahan.');
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#submitBtn').prop('disabled', false).html('Simpan');
                                var errorMessage = xhr.status + ': ' + xhr.statusText;
                                showToast('error', 'Terjadi kesalahan. (' + errorMessage + ')');
                            }
                        });
                    });
                });
            </script>
            <script>
                //Fungsi Hapus semua PTK
                function deleteallPtk() {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Semua Data PTK akan dihapus secara permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('admin/ptk/kosongkan_ptk/'); ?>";
                        }
                    });

                }
            </script>
            <script>
                //Fungsi Hapus PTK
                function deletePtk(ptkId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data PTK ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/ptk/hapus_ptk/'); ?>" + ptkId;
                        }
                    });
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('#importSubmit').on('click', function(e) {
                        e.preventDefault();

                        var formData = new FormData($('#importForm')[0]);
                        $.ajax({
                            url: "<?php echo base_url('admin/ptk/import_data_excel'); ?>",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                alert('Data berhasil diimpor dari Excel!');
                                $('#importPtkModal').modal('hide');
                                // Me-refresh halaman setelah 1 detik
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr, status, error) {
                                alert('Terjadi kesalahan saat mengimpor data dari Excel: ' + xhr.responseText);
                            }
                        });
                    });
                });
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
            <script>
                function validateForm() {
                    var checkboxes = document.getElementsByName('kode_kelas[]');
                    var isChecked = false;
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked) {
                            isChecked = true;
                            break;
                        }
                    }
                    if (!isChecked) {
                        alert('Pilih setidaknya satu kelas.');
                        return false;
                    }
                    return true;
                }
            </script>