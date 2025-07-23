<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i> Pendaftaran Berhasil</h3>
    </div>
    <div class="card-body text-center">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Terima kasih telah mendaftar!</h4>
            <p>No. Pendaftaran Anda: <strong><?= $pendaftaran->no_pendaftaran ?></strong></p>
        </div>

        <div class="card mb-4">
            <div class="card-body text-start">
                <h5 class="card-title">Informasi Pendaftaran</h5>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td><?= $pendaftaran->nama_lengkap ?></td>
                        </tr>
                        <tr>
                            <th>No. Pendaftaran</th>
                            <td><?= $pendaftaran->no_pendaftaran ?></td>
                        </tr>
                        <tr>
                            <th>Jalur</th>
                            <td><?= $pendaftaran->nama_jalur ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td><?= date('d/m/Y H:i', strtotime($pendaftaran->created_at)) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if ($pendaftaran->status == 'diterima'): ?>
                                    <span class="badge bg-success">Diterima</span>
                                <?php elseif ($pendaftaran->status == 'ditolak'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert alert-info text-start" role="alert">
            <h5 class="alert-heading">Catatan Penting</h5>
            <ul class="mb-0">
                <li>Simpan baik-baik nomor pendaftaran Anda</li>
                <li>Anda dapat mengecek status pendaftaran <a href="<?= site_url('ppdb/cek_status') ?>" class="text-decoration-underline">di sini</a></li>
                <li>Proses seleksi membutuhkan waktu 3-7 hari kerja</li>
            </ul>
        </div>

        <a href="<?= site_url('landing/portalppdb') ?>" class="btn btn-primary mt-3">
            <i class="fas fa-home me-1"></i> Kembali ke Beranda
        </a>
    </div>
</div>