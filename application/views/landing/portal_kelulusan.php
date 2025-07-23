<!DOCTYPE html>
<html lang="en">
<?php foreach ($data_site as $res) { ?> <?php } ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?> - Portal Kelulusan</title>
    <link rel="icon" href="<?= base_url('assets/web/' . $res->logo) ?>">

    <!-- Font & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* ========== BASE STYLES ========== */
        :root {
            --primary: #05654F;
            --primary-light: #E6F2EF;
            --secondary: #EC6B00;
            --accent: #FFC107;
            --light: #FFFFFF;
            --light-gray: #F8F9FA;
            --dark: #212529;
            --gradient: linear-gradient(135deg, var(--primary) 0%, #034837 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ========== CARD STYLES ========== */
        .neuro-card {
            background: var(--light);
            border-radius: 24px;
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.1),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 40px;
            margin-bottom: 30px;
        }

        /* ========== IMPROVED INPUT STYLES ========== */
        .input-container {
            position: relative;
            margin: 30px 0;
            width: 100%;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
        }

        .liquid-input {
            flex: 1;
            padding: 20px 25px;
            border: none;
            border-radius: 12px;
            background: var(--light);
            box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }

        .input-placeholder {
            position: absolute;
            left: 25px;
            top: 20px;
            color: #999;
            pointer-events: none;
            transition: all 0.3s;
        }

        .liquid-input:focus~.input-placeholder,
        .liquid-input:not(:placeholder-shown)~.input-placeholder {
            top: -12px;
            left: 15px;
            font-size: 0.8rem;
            background: var(--light);
            padding: 0 10px;
            color: var(--primary);
        }

        /* ========== BUTTON STYLES ========== */
        .quantum-btn {
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 18px 36px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(5, 101, 79, 0.2);
            transition: all 0.4s;
            z-index: 1;
            font-family: inherit;
            margin-left: 15px;
        }

        /* ========== COUNTDOWN STYLES ========== */
        .holo-countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 40px 0;
        }

        /* ========== IMPROVED TABLE STYLES ========== */
        .result-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            margin: 30px 0;
        }

        .result-table th {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .result-table td {
            background: white;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .result-table tr:first-child td {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .result-table tr:last-child td {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* ========== IMPROVED LOADER STYLES ========== */
        .nano-loader {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .nano-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            animation: nano-pulse 1.4s infinite ease-in-out;
        }

        @keyframes nano-pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.7;
                background: var(--secondary);
            }
        }

        /* Dot positions */
        .nano-dot:nth-child(1) {
            top: 10px;
            left: 10px;
            animation-delay: 0s;
        }

        .nano-dot:nth-child(2) {
            top: 10px;
            left: 36px;
            animation-delay: 0.2s;
        }

        .nano-dot:nth-child(3) {
            top: 10px;
            right: 10px;
            animation-delay: 0.4s;
        }

        .nano-dot:nth-child(4) {
            top: 36px;
            right: 10px;
            animation-delay: 0.6s;
        }

        .nano-dot:nth-child(5) {
            bottom: 10px;
            right: 10px;
            animation-delay: 0.8s;
        }

        .nano-dot:nth-child(6) {
            bottom: 10px;
            left: 36px;
            animation-delay: 1.0s;
        }

        .nano-dot:nth-child(7) {
            bottom: 10px;
            left: 10px;
            animation-delay: 1.2s;
        }

        .nano-dot:nth-child(8) {
            top: 36px;
            left: 10px;
            animation-delay: 1.4s;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
        }

        .status-lulus {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }

        .status-tidak-lulus {
            background: rgba(244, 67, 54, 0.1);
            color: #F44336;
        }

        /* ========== RESPONSIVE STYLES ========== */
        @media (max-width: 992px) {
            .holo-countdown {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .neuro-card {
                padding: 30px 20px;
            }

            .input-wrapper {
                flex-direction: column;
            }

            .quantum-btn {
                margin-left: 0;
                margin-top: 15px;
                width: 100%;
            }

            .liquid-input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Countdown Card -->
                <div id="countdown-container" class="neuro-card text-center">
                    <div class="logo-container mb-4">
                        <img src="<?= base_url('assets/web/' . $res->logo) ?>" alt="Logo Sekolah" style="height:80px;">
                    </div>
                    <h1 class="mb-3" style="font-weight:700;color:var(--primary)">Pengumuman Kelulusan</h1>
                    <h5 class="mb-4" style="color:#666"><?php echo htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?></h5>

                    <div class="holo-countdown">
                        <div class="holo-unit">
                            <div id="days" style="font-size:3rem;font-weight:800;color:var(--primary)">00</div>
                            <div style="font-size:0.9rem;color:#666">Hari</div>
                        </div>
                        <div class="holo-unit">
                            <div id="hours" style="font-size:3rem;font-weight:800;color:var(--primary)">00</div>
                            <div style="font-size:0.9rem;color:#666">Jam</div>
                        </div>
                        <div class="holo-unit">
                            <div id="minutes" style="font-size:3rem;font-weight:800;color:var(--primary)">00</div>
                            <div style="font-size:0.9rem;color:#666">Menit</div>
                        </div>
                        <div class="holo-unit">
                            <div id="seconds" style="font-size:3rem;font-weight:800;color:var(--primary)">00</div>
                            <div style="font-size:0.9rem;color:#666">Detik</div>
                        </div>
                    </div>

                    <p style="color:#666;margin-top:20px">Pengumuman akan dibuka pada:</p>
                    <h5 id="target-date" style="color:var(--secondary);font-weight:600"></h5>
                </div>

                <!-- Portal Content -->
                <div id="portal-content" class="neuro-card" style="display:none">
                    <div class="text-center mb-5">
                        <div class="logo-container mb-4">
                            <img src="<?= base_url('assets/web/' . $res->logo) ?>" alt="Logo Sekolah" style="height:60px;">
                        </div>
                        <h1 style="font-weight:700;color:var(--primary)">Portal Kelulusan</h1>
                        <p style="color:#666">Masukkan NIS Anda untuk melihat hasil kelulusan</p>
                    </div>

                    <form id="searchForm" class="mb-5">
                        <div class="input-container">
                            <div class="input-wrapper">
                                <input type="text" id="nis" name="nis" class="liquid-input" placeholder=" " required>
                                <span class="input-placeholder">Nomor Induk Siswa</span>
                                <button type="submit" id="searchBtn" class="quantum-btn">
                                    <i class="fas fa-search me-2"></i> Verifikasi
                                </button>
                            </div>
                        </div>

                        <!-- Tambahkan checkbox persetujuan -->
                        <div class="form-check mt-3 text-start" style="margin-left:15px;">
                            <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                            <label class="form-check-label" for="privacyCheck" style="color:#666;font-size:0.9rem;">
                                Saya menyetujui bahwa data yang dimasukkan akan digunakan untuk verifikasi kelulusan
                            </label>
                        </div>
                    </form>
                    <div id="searchResults" class="text-center">
                        <div style="padding:40px">
                            <i class="fas fa-graduation-cap mb-4" style="font-size:3rem;color:var(--primary-light)"></i>
                            <h4 style="color:var(--primary);margin-bottom:15px">Verifikasi Kelulusan</h4>
                            <p style="color:#666">Masukkan NIS Anda di atas untuk memeriksa status kelulusan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Improved Loading Overlay -->
    <div id="overlay" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.95);z-index:9999;backdrop-filter:blur(3px)">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center">
            <div class="nano-loader">
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
                <div class="nano-dot"></div>
            </div>
            <h4 style="color:var(--primary);margin-top:30px;font-weight:600">Memverifikasi Data</h4>
            <p style="color:#666;margin-top:10px">Sedang memproses permintaan Anda...</p>
            <div class="progress-bar" style="width:200px;height:4px;background:rgba(5,101,79,0.1);margin:20px auto;border-radius:2px;overflow:hidden">
                <div class="progress-fill" style="height:100%;width:0%;background:var(--primary);animation:loadingBar 2s infinite ease-in-out"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            // Format tanggal target
            var targetDate = new Date(<?php echo $target_time; ?>);
            document.getElementById('target-date').textContent = targetDate.toLocaleString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Countdown Timer
            function updateCountdown() {
                var now = new Date().getTime();
                var distance = targetDate - now;

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    $('#countdown-container').fadeOut(400, function() {
                        $('#portal-content').fadeIn(600).addClass('animate__animated animate__fadeInUp');
                    });
                    return;
                }

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            }

            var countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();

            // Form Submission with improved loading
            $('#searchForm').submit(function(event) {
                event.preventDefault();

                var nis = $('#nis').val().trim();

                if (!nis) {
                    $('#nis').focus();
                    return;
                }

                // Show loading with animation
                $('#overlay').css('display', 'flex').hide().fadeIn(300);
                $('#searchResults').html('');

                // Simulate processing delay
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('landing/cari_siswa'); ?>',
                        data: {
                            nis: nis
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#overlay').fadeOut(300, function() {
                                if (response.length > 0) {
                                    var html = '<div style="width:100%;overflow-x:auto">';
                                    html += '<table class="result-table animate__animated animate__fadeIn">';
                                    html += '<thead><tr>';
                                    html += '<th>Nama Siswa</th>';
                                    html += '<th>NIS</th>';
                                    html += '<th>Status</th>';
                                    html += '</tr></thead><tbody>';

                                    $.each(response, function(index, siswa) {
                                        var statusClass = '';
                                        var statusText = '';

                                        if (siswa.status_kelulusan == '1') {
                                            statusClass = 'status-lulus';
                                            statusText = 'LULUS';
                                        } else if (siswa.status_kelulusan == '2') {
                                            statusClass = 'status-tidak-lulus';
                                            statusText = 'TIDAK LULUS';
                                        } else {
                                            statusText = 'BELUM DIKETAHUI';
                                        }

                                        html += '<tr class="animate__animated animate__fadeInUp" style="animation-delay:' + (index * 0.1) + 's">';
                                        html += '<td>' + siswa.nama_siswa + '</td>';
                                        html += '<td>' + siswa.nis + '</td>';
                                        html += '<td><span class="status-badge ' + statusClass + '">' + statusText + '</span></td>';
                                        html += '</tr>';
                                    });

                                    html += '</tbody></table></div>';

                                    $('#searchResults').html(html);
                                } else {
                                    $('#searchResults').html(
                                        '<div class="animate__animated animate__fadeIn" style="padding:40px;text-align:center">' +
                                        '<i class="fas fa-exclamation-circle mb-4" style="font-size:3rem;color:var(--secondary)"></i>' +
                                        '<h4 style="color:var(--dark);margin-bottom:15px">Data Tidak Ditemukan</h4>' +
                                        '<p style="color:#666;margin-bottom:20px">NIS yang Anda masukkan tidak ditemukan atau belum diproses.</p>' +
                                        '<button onclick="$(\'#nis\').focus()" style="background:var(--primary-light);border:none;padding:10px 20px;border-radius:8px;cursor:pointer">' +
                                        '<i class="fas fa-redo me-2"></i>Coba Lagi</button>' +
                                        '</div>'
                                    );
                                }
                            });
                        },
                        error: function() {
                            $('#overlay').fadeOut(300, function() {
                                $('#searchResults').html(
                                    '<div class="animate__animated animate__fadeIn" style="padding:40px;text-align:center">' +
                                    '<i class="fas fa-times-circle mb-4" style="font-size:3rem;color:#F44336"></i>' +
                                    '<h4 style="color:var(--dark);margin-bottom:15px">Terjadi Kesalahan</h4>' +
                                    '<p style="color:#666;margin-bottom:20px">Gagal memverifikasi data. Silakan coba lagi nanti.</p>' +
                                    '<button onclick="location.reload()" style="background:var(--primary-light);border:none;padding:10px 20px;border-radius:8px;cursor:pointer">' +
                                    '<i class="fas fa-sync-alt me-2"></i>Refresh Halaman</button>' +
                                    '</div>'
                                );
                            });
                        }
                    });
                }, 1500);
            });
        });
    </script>
</body>

</html>