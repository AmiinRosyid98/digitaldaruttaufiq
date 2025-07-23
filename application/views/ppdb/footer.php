    </main>

    <!-- Government Footer -->
    <footer class="text-white pt-5 pb-4" style="background-color: rgb(29 73 75) !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">
                        <img src="<?php echo base_url() ?>assets/web/<?php echo $data_site->logo; ?>" alt="Logo" height="40" class="me-2">
                        <?= $data_site->nama_lembaga ?>
                    </h5>
                    <p><?= $data_site->nama_lembaga ?></p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <?= $data_site->alamat_lembaga ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone-alt me-2"></i>
                            <?= $data_site->notelp_lembaga ?>
                        </li>
                        <li>
                            <i class="fas fa-envelope me-2"></i>
                            <?= $data_site->email_lembaga ?>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="text-uppercase fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Informasi PPDB</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Persyaratan</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Alur Pendaftaran</a></li>
                        <li><a href="#" class="text-white text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">© <?= date('Y') ?> <?= $data_site->nama_lembaga ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Seluruh hak cipta dilindungi undang-undang</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Government Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        flatpickr("#tanggalLahir", {
            dateFormat: "d/m/Y", // Tampilkan ke user sebagai dd/mm/yyyy
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true
        });
    </script>
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <!-- JavaScript Jalur Pendaftaran -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to pathway cards
            const cards = document.querySelectorAll('.pathway-card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Only trigger if not clicking a button
                    if (!e.target.closest('button')) {
                        const button = this.querySelector('.pathway-detail-btn');
                        if (button) button.click();
                    }
                });

                // Add keyboard accessibility
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        const button = this.querySelector('.pathway-detail-btn');
                        if (button) button.click();
                        e.preventDefault();
                    }
                });
            });
        });
    </script>


    </body>

    </html>