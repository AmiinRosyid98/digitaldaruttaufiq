<!DOCTYPE html>
<html lang="en">
<?php $profil_array = $profil->result_array(); ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php foreach ($profil_array as $row) : ?><?php echo $row['nama_lembaga']; ?><?php endforeach; ?> - SISWA LOGIN</title>
  <link rel="alternate icon" type="image/png" href="/assets/X_CODE.png">

  <!-- Font & Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    /* ========== BASE STYLES ========== */
    :root {
      --primary: #05654F;
      --primary-light: #E6F2EF;
      --primary-dark: #034837;
      --secondary: #EC6B00;
      --accent: #FFC107;
      --light: #FFFFFF;
      --light-gray: #F8F9FA;
      --dark: #212529;
      --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
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
    }

    /* ========== LOGIN LAYOUT ========== */
    .login-container {
      display: flex;
      min-height: 100vh;
    }

    .login-left {
      flex: 1;
      background: var(--gradient);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      position: relative;
      overflow: hidden;
    }

    .login-left::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
      animation: float 8s infinite ease-in-out;
    }

    .login-right {
      flex: 1;
      background: var(--light);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      position: relative;
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
      max-width: 500px;
      width: 100%;
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
      padding: 20px 25px 20px 50px;
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
      left: 50px;
      top: 20px;
      color: #999;
      pointer-events: none;
      transition: all 0.3s;
    }

    .liquid-input:focus~.input-placeholder,
    .liquid-input:not(:placeholder-shown)~.input-placeholder {
      top: -12px;
      left: 40px;
      font-size: 0.8rem;
      background: var(--light);
      padding: 0 10px;
      color: var(--primary);
    }

    .input-icon {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary);
      z-index: 2;
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
    }

    .quantum-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 25px rgba(5, 101, 79, 0.3);
    }

    .quantum-btn:active {
      transform: translateY(1px);
    }

    .quantum-btn-secondary {
      background: var(--light);
      color: var(--primary);
      border: 2px solid var(--primary-light);
    }

    /* ========== LOGO & HEADER STYLES ========== */
    .login-logo {
      height: 80px;
      margin-bottom: 20px;
      transition: all 0.3s;
    }

    .login-logo:hover {
      transform: scale(1.05) rotate(-5deg);
    }

    .login-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--light);
      margin-bottom: 10px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .login-subtitle {
      font-size: 1.2rem;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 30px;
    }

    .student-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 10px;
    }

    .student-subtitle {
      font-size: 1.2rem;
      color: #666;
      margin-bottom: 30px;
    }

    /* ========== ANIMATIONS ========== */
    @keyframes float {

      0%,
      100% {
        transform: translate(0, 0);
      }

      50% {
        transform: translate(50px, 50px);
      }
    }

    /* ========== TOAST STYLES ========== */
    toast {
      border-radius: 12px !important;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
      border: none !important;
      background-color: var(--light) !important;
    }

    .toast-success {
      background-color: var(--primary) !important;
    }

    .toast-error {
      background-color: #F44336 !important;
    }

    .toast-info {
      background-color: var(--secondary) !important;
    }

    .toast-warning {
      background-color: var(--accent) !important;
    }

    .toast-title {
      font-weight: 600 !important;
      font-size: 1rem !important;
    }

    .toast-message {
      font-size: 0.9rem !important;
      line-height: 1.4 !important;
    }

    .toast-close-button {
      color: white !important;
      opacity: 0.8 !important;
      text-shadow: none !important;
      font-size: 1.2rem !important;
    }

    .toast-progress {
      height: 3px !important;
    }


    /* ========== RESPONSIVE STYLES ========== */
    @media (max-width: 992px) {
      .login-container {
        flex-direction: column;
      }

      .login-left,
      .login-right {
        padding: 30px 20px;
      }

      .neuro-card {
        padding: 30px 20px;
      }

      .login-title,
      .student-title {
        font-size: 2rem;
      }
    }

    @media (max-width: 576px) {
      .input-wrapper {
        flex-direction: column;
      }

      .quantum-btn {
        width: 100%;
        margin-top: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <!-- Left Side (Branding) -->
    <div class="login-left animate__animated animate__fadeIn">
      <img src="<?php echo base_url() ?>assets/web/<?php foreach ($profil_array as $row) : ?><?php echo $row['logo']; ?><?php endforeach; ?>" alt="Logo" class="login-logo animate__animated animate__bounceIn">
      <h1 class="login-title animate__animated animate__fadeInUp"><?php foreach ($profil_array as $row) : ?><?php echo $row['nama_lembaga']; ?><?php endforeach; ?></h1>
      <p class="login-subtitle animate__animated animate__fadeInUp animate__delay-1s">Portal Akademik Siswa</p>
      <img src="https://cdn.excode.my.id/assets/banner-image.png" alt="Illustration" class="img-fluid animate__animated animate__fadeInUp animate__delay-1s" style="max-width: 80%;">
    </div>

    <!-- Right Side (Login Form) -->
    <div class="login-right">
      <div class="neuro-card animate__animated animate__fadeInRight">
        <img src="https://cdn.excode.my.id/assets/web/logo-kit.png" alt="Student Logo" style="height: 60px; margin-bottom: 20px; display: block; margin-left: auto;">
        <h1 class="student-title">Siswa Login</h1>
        <p class="student-subtitle">Masukkan kredensial Anda untuk mengakses portal siswa</p>

        <form id="studentLoginForm">
          <div class="input-container">
            <div class="input-wrapper">
              <i class="fas fa-user input-icon"></i>
              <input type="text" name="username" id="username" class="liquid-input" placeholder=" " required>
              <span class="input-placeholder">Username</span>
            </div>
          </div>

          <div class="input-container">
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" name="password" id="password" class="liquid-input" placeholder=" " required>
              <span class="input-placeholder">Password</span>
            </div>
          </div>

          <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="quantum-btn flex-grow-1 animate__animated animate__fadeInUp animate__delay-1s">
              <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
            <a href="<?php echo base_url(); ?>" class="quantum-btn quantum-btn-secondary flex-grow-1 animate__animated animate__fadeInUp animate__delay-1s" style="text-align: center;">
              <i class="fas fa-home me-2"></i> Beranda
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Configure Toastr with custom settings
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "tapToDismiss": false
    };

    // Handle form submission with AJAX
    $(document).ready(function() {
      // Show any existing flash messages
      <?php if ($this->session->flashdata('message_login_error')) : ?>
        toastr.error('<?= $this->session->flashdata('message_login_error') ?>', 'Login Gagal');
      <?php endif; ?>

      // Handle form submission
      $('#studentLoginForm').submit(function(e) {
        e.preventDefault();

        // Get form data
        var formData = {
          username: $('#username').val(),
          password: $('#password').val()
        };

        // Show loading state
        $('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i> Memproses...');
        $('button[type="submit"]').prop('disabled', true);

        // AJAX request
        $.ajax({
          type: 'POST',
          url: 'loginsiswa',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Login successful - redirect
              toastr.success(response.message, 'Berhasil');
              window.location.href = response.redirect;
            } else {
              // Login failed - show error
              toastr.error(response.message, 'Gagal Login');
              $('button[type="submit"]').html('<i class="fas fa-sign-in-alt me-2"></i> Sign In');
              $('button[type="submit"]').prop('disabled', false);

              // Add shake animation to form
              $('.neuro-card').addClass('animate__animated animate__headShake');
              setTimeout(function() {
                $('.neuro-card').removeClass('animate__animated animate__headShake');
              }, 1000);
            }
          },
          error: function(xhr, status, error) {
            toastr.error('Terjadi kesalahan saat memproses login', 'Error');
            $('button[type="submit"]').html('<i class="fas fa-sign-in-alt me-2"></i> Sign In');
            $('button[type="submit"]').prop('disabled', false);
          }
        });
      });
    });
  </script>
</body>

</html>