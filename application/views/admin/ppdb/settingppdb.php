<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $info_message = $this->session->flashdata('info_message');
    ?>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <?php $this->load->view('admin/_partials/navbar.php') ?>

            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <?php $this->load->view('admin/_partials/sidebar_information.php') ?>
                <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>
            </aside>

            <div class="content-wrapper" style="min-height: 1300px;">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Setting PPDB</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">PPDB</a></li>
                                    <li class="breadcrumb-item active">Setting</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pengaturan PPDB</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo site_url('admin/ppdb/update_setting'); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_ppdb">Status PPDB</label>
                                            <select class="form-control" id="status_ppdb" name="status_ppdb" required>
                                                <option value="0" <?= ($setting_ppdb->status_ppdb == '0') ? 'selected' : '' ?>>Nonaktif</option>
                                                <option value="1" <?= ($setting_ppdb->status_ppdb == '1') ? 'selected' : '' ?>>Aktif</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <div class="input-group date" id="tanggal_mulai_datepicker">
                                                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                                    value="<?php echo $setting_ppdb->tanggal_mulai ?? ''; ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="kuota">Kuota Penerimaan</label>
                                            <input type="number" class="form-control" id="kuota" name="kuota"
                                                value="<?php echo $setting_ppdb->kuota ?? ''; ?>" min="1" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                                                value="<?php echo $setting_ppdb->tahun_ajaran ?? ''; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <div class="input-group date" id="tanggal_selesai_datepicker">
                                                <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                                    value="<?php echo $setting_ppdb->tanggal_selesai ?? ''; ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_multi_jalur">Multi Jalur Penerimaan</label>
                                            <select class="form-control" id="is_multi_jalur" name="is_multi_jalur" required>
                                                <option value="0" <?= ($setting_ppdb->is_multi_jalur == '0') ? 'selected' : '' ?>>Tidak</option>
                                                <option value="1" <?= ($setting_ppdb->is_multi_jalur == '1') ? 'selected' : '' ?>>Ya</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pesan">Pesan Pembukaan Portal PPDB</label>
                                            <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Tulis salam pembukaan atau pesan di sini..." required><?php echo $setting_ppdb->pesan ?? ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>

                            <?php if ($setting_ppdb->is_multi_jalur == 1): ?>
                                <hr class="mt-4">

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h4 class="mb-3">Kelola Jalur Penerimaan</h4>

                                        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#modalJalur">
                                            <i class="fas fa-plus"></i> Tambah Jalur
                                        </button>

                                        <!-- Tampilkan Kuota Per Jalur -->
                                        <?php if (isset($kuota_per_jalur)): ?>
                                            <div class="alert alert-info">
                                                <strong>Distribusi Kuota:</strong>
                                                <ul class="mb-0">
                                                    <?php foreach ($kuota_per_jalur as $jalur): ?>
                                                        <li><?= htmlspecialchars($jalur['nama_jalur']) ?>: <?= $jalur['kuota'] ?> siswa (<?= $jalur['persentase'] ?>%)</li>
                                                    <?php endforeach; ?>
                                                    <li class="font-weight-bold">Total: <?= $setting_ppdb->kuota ?> siswa</li>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Nama Jalur</th>
                                                        <th>Persentase Kuota</th>
                                                        <th>Peryaratan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($jalur_ppdb as $jalur): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($jalur->nama_jalur) ?></td>
                                                            <td><?= $jalur->persentase_kuota ?>%</td>
                                                            <td><?= $jalur->persyaratan ?></td>

                                                            <td>
                                                                <?php if ($jalur->is_active == 1): ?>
                                                                    <span class="badge badge-success">Aktif</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-warning edit-jalur"
                                                                    data-id="<?= $jalur->id ?>"
                                                                    data-nama="<?= htmlspecialchars($jalur->nama_jalur) ?>"
                                                                    data-persentase="<?= $jalur->persentase_kuota ?>"
                                                                    data-ketentuan="<?= $jalur->ketentuan ?>"
                                                                    data-persyaratan="<?= $jalur->persyaratan ?>"
                                                                    data-status="<?= $jalur->is_active ?>">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>

                                                                <a href="<?= site_url('admin/ppdb/toggle_jalur/' . $jalur->id) ?>"
                                                                    class="btn btn-sm <?= $jalur->is_active ? 'btn-secondary' : 'btn-success' ?>">
                                                                    <i class="fas fa-power-off"></i> <?= $jalur->is_active ? 'Nonaktifkan' : 'Aktifkan' ?>
                                                                </a>

                                                                <a href="<?= site_url('admin/ppdb/delete_jalur/' . $jalur->id) ?>"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jalur ini?')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah/Edit Jalur -->
            <div class="modal fade" id="modalJalur" tabindex="-1" role="dialog" aria-labelledby="modalJalurLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= site_url('admin/ppdb/save_jalur') ?>" method="post" id="formJalur">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalJalurLabel">Tambah Jalur Penerimaan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="id" id="jalur_id">

                                <div class="form-group">
                                    <label>Nama Jalur</label>
                                    <input type="text" name="nama_jalur" id="nama_jalur" class="form-control" required maxlength="100">
                                </div>

                                <div class="form-group">
                                    <label>Persentase Kuota (%)</label>
                                    <input type="number" name="persentase_kuota" id="persentase_kuota" class="form-control" min="1" max="100" required>
                                    <small class="text-muted">Total semua persentase jalur aktif harus 100%</small>
                                </div>

                                <div class="form-group">
                                    <label>Ketentuan</label>
                                    <textarea name="ketentuan" id="ketentuan" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Persyaratan Jalur</label>
                                    <textarea name="persyaratan" id="persyaratan" class="form-control" rows="4" placeholder="Masukkan persyaratan jalur..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" checked>
                                        <label class="custom-control-label" for="is_active">Aktif</label>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <?php $this->load->view('admin/_partials/footer.php') ?>

            <!-- SweetAlert2 JS -->
            <script src="<?= base_url('assets/admin/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
            <!-- Datepicker JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

            <script>
                $(document).ready(function() {
                    // Initialize datepicker
                    $('#tanggal_mulai_datepicker, #tanggal_selesai_datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        language: 'id'
                    });

                    // Handle edit button click
                    $('.edit-jalur').click(function() {
                        $('#jalur_id').val($(this).data('id'));
                        $('#nama_jalur').val($(this).data('nama'));
                        $('#persentase_kuota').val($(this).data('persentase'));
                        $('#ketentuan').val($(this).data('ketentuan'));
                        $('#persyaratan').val($(this).data('persyaratan'));

                        $('#is_active').prop('checked', $(this).data('status') == 1);

                        $('#modalJalurLabel').text('Edit Jalur Penerimaan');
                        $('#modalJalur').modal('show');
                    });

                    // Reset modal when closed
                    $('#modalJalur').on('hidden.bs.modal', function() {
                        $('#jalur_id').val('');
                        $('#nama_jalur').val('');
                        $('#persentase_kuota').val('');
                        $('#ketentuan').val('');
                        $('#persyaratan').val('');

                        $('#is_active').prop('checked', true);
                        $('#modalJalurLabel').text('Tambah Jalur Penerimaan');
                    });

                    // Validasi total persentase kuota sebelum submit
                    $('#formJalur').submit(function(e) {
                        var is_multi_jalur = <?= $setting_ppdb->is_multi_jalur ?? 0 ?>;
                        if (is_multi_jalur == 1) {
                            var current_persentase = parseInt($('#persentase_kuota').val()) || 0;
                            var total_persentase = <?= $this->Ppdb_Model->get_total_persentase_kuota() ?>;
                            var jalur_id = $('#jalur_id').val();

                            // Jika edit jalur, kurangi persentase lama
                            if (jalur_id) {
                                var old_persentase = $('.edit-jalur[data-id="' + jalur_id + '"]').data('persentase');
                                total_persentase = total_persentase - old_persentase;
                            }

                            var new_total = total_persentase + current_persentase;

                            if (new_total > 100) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Total persentase kuota semua jalur tidak boleh melebihi 100%. Saat ini total: ' + new_total + '%',
                                });
                                return false;
                            }
                        }
                        return true;
                    });

                    // SweetAlert for flash messages
                    <?php if ($success_message): ?>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: '<?= addslashes($success_message) ?>',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: '<?= addslashes($error_message) ?>',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    <?php endif; ?>

                    <?php if ($info_message): ?>
                        Swal.fire({
                            icon: 'info',
                            title: 'Informasi',
                            text: '<?= addslashes($info_message) ?>',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    <?php endif; ?>
                });
            </script>
    </body>

</html>