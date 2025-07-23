<html lang="id">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php $this->load->view('admin/_partials/navbar.php') ?>

        <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('admin/_partials/sidebar_information.php') ?>
            <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>
        </aside>

        <div class="content-wrapper" style="min-height: 1000px;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Kelola Pendaftaran PPDB</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title">Daftar Calon Peserta Didik</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="<?= site_url('admin/ppdb/export') ?>" class="btn btn-success">
                                                <i class="fas fa-file-excel"></i> Export Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-striped">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>No Pendaftaran</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Jalur</th>
                                                    <th>Tanggal Daftar</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php $no = 1;
                                                foreach ($pendaftaran as $p): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $p->no_pendaftaran ?></td>
                                                        <td><?= htmlspecialchars($p->nama_lengkap) ?></td>
                                                        <td><?= $p->nama_jalur ?></td>
                                                        <td><?= date('d/m/Y H:i', strtotime($p->created_at)) ?></td>
                                                        <td>
                                                            <?php if ($p->status == 'diterima'): ?>
                                                                <span class="badge badge-success">Diterima</span>
                                                            <?php elseif ($p->status == 'terverifikasi'): ?>
                                                                <span class="badge bg-primary">Terverifikasi</span>
                                                            <?php elseif ($p->status == 'ditolak'): ?>
                                                                <span class="badge badge-danger">Ditolak</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-warning">Pendaftar Baru</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= site_url('admin/ppdb/detail_pendaftaran/' . $p->id) ?>" class="btn btn-sm btn-info" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="<?= site_url('admin/ppdb/update_status_pendaftaran/' . $p->id . '?status=diterima') ?>">
                                                                        <i class="fas fa-check-circle text-success me-2"></i> Terima
                                                                    </a>
                                                                    <a class="dropdown-item" href="<?= site_url('admin/ppdb/update_status_pendaftaran/' . $p->id . '?status=terverifikasi') ?>">
                                                                        <i class="fas fa-user-check text-primary me-2"></i> Verifikasi
                                                                    </a>
                                                                    <a class="dropdown-item" href="<?= site_url('admin/ppdb/update_status_pendaftaran/' . $p->id . '?status=ditolak') ?>">
                                                                        <i class="fas fa-times-circle text-danger me-2"></i> Tolak
                                                                    </a>
                                                                    <a class="dropdown-item" href="<?= site_url('admin/ppdb/update_status_pendaftaran/' . $p->id . '?status=pending') ?>">
                                                                        <i class="fas fa-hourglass-half text-warning me-2"></i> Pending
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-sm btn-danger"
                                                                title="Hapus"
                                                                onclick="confirmDelete('<?= site_url('admin/ppdb/hapus_pendaftaran/' . $p->id) ?>')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <?php $this->load->view('admin/_partials/footer.php') ?>



            <script>
                $(document).ready(function() {
                    $('#dataTable').DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "order": [
                            [4, 'desc']
                        ]
                    });
                });

                function confirmDelete(deleteUrl) {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika konfirmasi di "Hapus" klik, lakukan penghapusan
                            window.location.href = deleteUrl;
                        }
                    });
                }

                // Menampilkan Toast Notification setelah berhasil penghapusan
                <?php if ($this->session->flashdata('delete_success')): ?>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '<?= $this->session->flashdata('delete_success') ?>',
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true, // Menjadikan notifikasi sebagai toast
                        customClass: {
                            popup: 'small-toast', // Memastikan kelas custom diterapkan
                        },
                        timerProgressBar: true, // Menambahkan progress bar pada timer
                    });
                <?php endif; ?>
            </script>