<!-- Status Check Section -->
<div class="glass-card rounded-4 overflow-hidden shadow border-0 bg-white bg-opacity-75 backdrop-blur">
    <div class="status-header p-4 bg-gradient-primary">
        <div class="d-flex align-items-center">
            <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 me-3">
                <i class="fas fa-search fa-lg text-white"></i>
            </div>
            <div>
                <h3 class="text-white mb-1">Cek Status Pendaftaran</h3>
                <small class="text-white-50">Masukkan nomor pendaftaran Anda</small>
            </div>
        </div>
    </div>

    <div class="p-4">
        <form action="<?= site_url('landing/cek_status') ?>" method="post" class="needs-validation" novalidate>
            <div class="mb-4">
                <label for="no_pendaftaran" class="form-label fw-semibold">Nomor Pendaftaran</label>
                <div class="input-group input-group-lg">
                    <input type="text" name="no_pendaftaran" id="no_pendaftaran" class="form-control rounded-pill px-4"
                        placeholder="PPDB2023ABC123" required pattern="[A-Za-z0-9]{8,20}">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">
                        <i class="fas fa-search me-2"></i> Cari
                    </button>
                </div>
                <div class="form-text mt-2">
                    <i class="fas fa-info-circle me-1"></i> Contoh: PPDB2023ABC123
                </div>
            </div>
        </form>

        <?php if (isset($result)): ?>
            <?php if ($result): ?>
                <!-- Result Card -->
                <div class="result-card mt-4 p-4 rounded-4 bg-white border-0 shadow-sm animate__animated animate__fadeIn">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0">
                            <i class="fas fa-user-circle me-2 text-primary"></i> Data Peserta
                        </h4>
                        <div>
                            <?php if ($result->status == 'diterima'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Diterima
                                </span>
                            <?php elseif ($result->status == 'terverifikasi'): ?>
                                <span class="badge bg-primary bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                    <i class="fas fa-user-check me-1"></i> Terverifikasi
                                </span>
                            <?php elseif ($result->status == 'ditolak'): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning py-2 px-3 rounded-pill">
                                    <i class="fas fa-clock me-1"></i> Menunggu
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3 bg-light">
                                <small class="text-muted">Nomor Pendaftaran</small>
                                <p class="fw-semibold mb-0"><?= $result->no_pendaftaran ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3 bg-light">
                                <small class="text-muted">Nama Lengkap</small>
                                <p class="fw-semibold mb-0"><?= $result->nama_lengkap ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3 bg-light">
                                <small class="text-muted">Jalur Pendaftaran</small>
                                <p class="fw-semibold mb-0"><?= $result->nama_jalur ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3 bg-light">
                                <small class="text-muted">Tanggal Daftar</small>
                                <p class="fw-semibold mb-0"><?= date('d F Y', strtotime($result->created_at)) ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if ($result->status != 'pending'): ?>
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted mb-2 d-block">Terakhir diperbarui:</small>
                            <p class="fw-semibold mb-0"><?= date('d F Y H:i', strtotime($result->updated_at)) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Not Found -->
                <div class="not-found-state text-center p-5 mt-4 rounded-4 animate__animated animate__fadeIn">
                    <div class="icon-wrapper bg-danger bg-opacity-10 text-danger rounded-circle p-4 d-inline-block mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Data tidak ditemukan</h5>
                    <p class="text-muted mb-4">Pastikan nomor pendaftaran yang Anda masukkan benar</p>
                    <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt me-2"></i> Coba Lagi
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modernized CSS -->
<style>
    .bg-gradient-primary::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 0;
        width: 100%;
        height: 40px;
        background: white;
        transform: skewY(-2deg);
        transform-origin: top left;
    }

    .backdrop-blur {
        backdrop-filter: blur(10px);
    }

    .icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .result-card {
        transition: all 0.3s ease;
    }

    .result-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .info-item {
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: background 0.3s;
    }

    .info-item:hover {
        background: rgba(25, 123, 100, 0.05);
    }

    .not-found-state {
        background: rgba(255, 255, 255, 0.7);
        border: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(25, 123, 100, 0.25);
        border-color: #197B64;
    }
</style>

<!-- JS Enhancements -->
<script>
    // Form validation
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();

    // Auto-uppercase input
    document.getElementById('no_pendaftaran').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>