<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3"></i>
            <div><?= $this->session->flashdata('error') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Government Hero Section -->
<section class="gov-hero mb-5 text-white rounded-4 overflow-hidden position-relative"
    style="background: var(--gov-gradient); min-height: 300px;">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-7 py-5 position-relative z-2">
                <h1 class="display-6 fw-bold mb-3">Portal Sistem Penerimaan Murid Baru (SPMB)</h1>
                <h2 class="mb-0 fw-bold" style="color: #f85f02;"><?= $data_site->nama_lembaga ?></h2>
                <h2>Tahun Ajaran <?= $setting->tahun_ajaran ?></h2>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge badge-gov rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <?= date('d F Y', strtotime($setting->tanggal_mulai)) ?> - <?= date('d F Y', strtotime($setting->tanggal_selesai)) ?>
                    </span>
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2">
                        <i class="fas fa-users me-1"></i>
                        Kuota <?= number_format($setting->kuota, 0, ',', '.') ?> Siswa
                    </span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center position-relative z-2">
                <img src="https://png.pngtree.com/png-vector/20240528/ourmid/pngtree-ppdb-banner-logo-vector-png-image_12510663.png" alt="PPDB Illustration" class="img-fluid" style="max-height: 250px;">
            </div>
        </div>
    </div>

</section>

<!-- Status Section -->
<section class="mb-2">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-3">Status Pendaftaran</h3>
                    <?php if ($setting->status_ppdb == 1): ?>
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-success">Pendaftaran Dibuka</h4>
                                <p class="mb-0 text-muted">Periode aktif sampai <?= date('d F Y', strtotime($setting->tanggal_selesai)) ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-danger">Pendaftaran Ditutup</h4>
                                <p class="mb-0 text-muted">Periode telah berakhir pada <?= date('d F Y', strtotime($setting->tanggal_selesai)) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <?php if ($setting->status_ppdb == 1): ?>
                        <a href="<?= site_url('landing/daftar') ?>" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg rounded-pill px-4" disabled>
                            <i class="fas fa-clock me-2"></i> Pendaftaran Ditutup
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modern Jalur Pendaftaran-->
<section class="mb-2">
    <div class="glass-card p-4 rounded-4" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="fas fa-route me-2 text-primary"></i>
                <span class="fw-bold">Jalur Pendaftaran</span>
            </h3>
            <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                Total Kuota: <?= number_format($setting->kuota, 0, ',', '.') ?> Siswa
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($jalur as $j): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="pathway-card h-100 p-4 rounded-4 position-relative overflow-hidden border-0 shadow">

                        <!-- Badge Kuota -->
                        <div class="pathway-badge mb-3">
                            <?= $j->persentase_kuota ?>% Kuota
                        </div>

                        <!-- Nama Jalur -->
                        <h4 class="fw-bold mb-2"><?= $j->nama_jalur ?></h4>

                        <!-- Ketentuan -->
                        <div class="mb-4 ketentuan-text-ellipsis">
                            <small class="text-muted"><?= $j->ketentuan ?></small>
                        </div>

                        <!-- Kuota Tersedia -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kuota Tersedia</span>
                            <span class="fw-semibold"><?= number_format(($setting->kuota * $j->persentase_kuota / 100), 0, ',', '.') ?></span>
                        </div>

                        <!-- Total Pendaftar -->
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Total Pendaftar</span>
                            <span class="fw-semibold"><?= number_format($j->total_pendaftar, 0, ',', '.') ?></span>
                        </div>

                        <?php
                        // Hitung kuota jalur
                        $kuota_jalur = ($setting->kuota * $j->persentase_kuota / 100);
                        // Hitung persentase terisi
                        $persentase_terisi = ($kuota_jalur > 0) ? ($j->total_pendaftar / $kuota_jalur) * 100 : 0;
                        $persentase_terisi = ($persentase_terisi > 100) ? 100 : $persentase_terisi;
                        ?>

                        <!-- Progress Bar -->
                        <div class="progress mb-4" style="height: 8px;">
                            <div class="progress-bar bg-gradient-primary" role="progressbar"
                                style="width: <?= number_format($persentase_terisi, 2, '.', '') ?>%;"
                                aria-valuenow="<?= number_format($persentase_terisi, 2, '.', '') ?>"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>

                        <!-- Tombol Detail Persyaratan -->
                        <button class="btn btn-sm btn-outline-primary rounded-pill w-100 pathway-detail-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#syaratModal<?= $j->id ?>">
                            <i class="fas fa-info-circle me-2"></i> Detail Persyaratan
                        </button>

                        <!-- Hover effect -->
                        <div class="pathway-hover-effect"></div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!-- Modals for Requirements -->
<?php foreach ($jalur as $j): ?>
    <div class="modal fade" id="syaratModal<?= $j->id ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title">Persyaratan Jalur <?= $j->nama_jalur ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i> <?= $j->persyaratan ?></li>
                        <?php if ($j->id == 1): ?>
                            <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i> Surat Keterangan Hasil UN</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Additional CSS -->
<style>
    .gov-hero {
        position: relative;
        overflow: hidden;
    }
</style>