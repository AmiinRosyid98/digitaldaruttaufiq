<!DOCTYPE html>
<html lang="id">
<?php foreach ($data_site as $res) { ?> <?php } ?>
<?php foreach ($versi as $version) { ?> <?php } ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nama_lembaga = htmlspecialchars($res->nama_lembaga, ENT_QUOTES, 'UTF-8'); ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #05654F;
            --secondary-color: #CF6105;
            --accent-color: #EC6B00;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(rgba(5, 101, 79, 0.05), rgba(5, 101, 79, 0.05));
            background-color: white;
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding-top: 60px;
            min-height: 100vh;
        }


        /* Modern Mobile Navbar */
        .mobile-navbar {
            background: rgba(5, 101, 79, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 10px 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .mobile-menu-toggle {
            color: white;
            font-size: 1.2rem;
            background: none;
            border: none;
        }

        .mobile-menu {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            display: none;
            z-index: 999;
        }

        .mobile-menu.show {
            display: block;
        }

        .mobile-menu-item {
            padding: 12px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .mobile-menu-item a {
            color: var(--dark-gray);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-item a i {
            color: var(--primary-color);
        }

        .mobile-dropdown {
            padding-left: 20px;
            background: var(--light-gray);
            display: none;
        }

        .mobile-dropdown.show {
            display: block;
        }

        .mobile-dropdown a {
            padding: 10px 15px;
            display: block;
            color: var(--dark-gray);
            text-decoration: none;
        }

        .mobile-dropdown a:hover {
            background: rgba(5, 101, 79, 0.1);
        }

        /* Login Container */
        .mobile-login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 25px;
            max-width: 360px;
        }


        .mobile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .mobile-header h1 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .mobile-header p {
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .mobile-badge {
            background: var(--primary-color);
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .mobile-logo {
            text-align: center;
            margin: 15px 0;
            color: var(--primary-color);
            font-size: 3rem;
        }

        .mobile-form-group {
            margin-bottom: 15px;
        }

        .mobile-form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .mobile-form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .mobile-form-description {
            font-size: 0.9rem;
            color: var(--dark-gray);
            text-align: center;
            margin: 15px 0;
        }

        .mobile-form-description a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .mobile-btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .mobile-btn-login:hover {
            background: #034a3a;
        }

        .mobile-footer-description {
            font-size: 0.8rem;
            color: var(--dark-gray);
            text-align: center;
            margin-top: 20px;
        }

        /* Notification */
        .mobile-notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            display: none;
        }

        .mobile-notification.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Modern Mobile Navbar -->
    <nav class="mobile-navbar">
        <a href="#" class="mobile-navbar-brand"><?php echo htmlspecialchars($res->nama_lembaga); ?></a>
        <button class="mobile-menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-item">
            <a href="#">Beranda</a>
        </div>
        <div class="mobile-menu-item">
            <a href="javascript:void(0)" id="loginDropdownToggle">
                <span>Login</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>

        <div class="mobile-dropdown" id="loginDropdownContent">
            <a href="<?php echo base_url('/auth/loginsiswa'); ?>">Login Siswa</a>
            <a href="<?php echo base_url('/auth/loginptk'); ?>">Login Guru</a>
            <a href="<?php echo base_url('/auth/loginadmin'); ?>">Login Operator</a>
            <a href="<?php echo base_url('/auth/loginbendahara'); ?>">Login Bendahara</a>
            <a href="<?php echo base_url('/auth/loginbk'); ?>">Login BK</a>
        </div>

        <?php foreach ($portalppdb as $menuppdb) : ?>
            <?php if ($menuppdb->status_ppdb == 1) : ?>
                <div class="mobile-menu-item">
                    <a href="<?php echo base_url('landing/portalppdb'); ?>">PPDB</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($portalkelulusan as $menuskl) : ?>
            <?php if ($menuskl->status_pengumuman == 1) : ?>
                <div class="mobile-menu-item">
                    <a href="<?php echo base_url('landing/portalkelulusan'); ?>">Kelulusan</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Notification -->
    <div class="mobile-notification" id="mobileNotification">
        <?php
        if (isset($message_login_error)) {
            echo $message_login_error;
        } elseif ($this->session->flashdata('message_error')) {
            echo $this->session->flashdata('message_error');
        }
        ?>
    </div>

    <!-- Login Container -->
    <div class="mobile-login-container">
        <div class="mobile-header">
            <h1><?php echo htmlspecialchars($res->nama_lembaga); ?></h1>
            <p>Sistem Informasi Sekolah dan Madrasah</p>
            <p>SISMA <span class="mobile-badge">Version <?php echo htmlspecialchars($version->current_version); ?></span></p>
        </div>

        <form action="auth/loginsiswa" method="POST">
            <div class="mobile-form-group">
                <label for="username">Email / Username</label>
                <input type="text" id="username" name="username" placeholder="Email atau Username" required>
            </div>

            <div class="mobile-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <p class="mobile-form-description">
                Lupa password? <a href="#">Hubungi Operator</a>
            </p>

            <button type="submit" class="mobile-btn-login">Masuk</button>

            <p class="mobile-footer-description">
                Dengan masuk, Anda menyetujui peraturan dan kebijakan privasi
            </p>
        </form>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const loginDropdownToggle = document.getElementById('loginDropdownToggle');
        const loginDropdownContent = document.getElementById('loginDropdownContent');
        const mobileNotification = document.getElementById('mobileNotification');

        // Toggle mobile menu
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });

        // Toggle login dropdown
        loginDropdownToggle.addEventListener('click', (e) => {
            e.preventDefault(); // prevent jump
            loginDropdownContent.classList.toggle('show');
        });

        // Tutup dropdown & menu jika klik di luar
        document.addEventListener('click', (e) => {
            const isClickInsideMenu = mobileMenu.contains(e.target);
            const isMenuToggle = e.target === menuToggle || menuToggle.contains(e.target);
            const isDropdownToggle = e.target === loginDropdownToggle || loginDropdownToggle.contains(e.target);

            if (!isClickInsideMenu && !isMenuToggle) {
                mobileMenu.classList.remove('show');
            }

            if (!isDropdownToggle && !loginDropdownContent.contains(e.target)) {
                loginDropdownContent.classList.remove('show');
            }
        });

        // Show notification if error message exists
        <?php if (isset($message_login_error) || $this->session->flashdata('message_error')) : ?>
            mobileNotification.classList.add('show');
            setTimeout(() => {
                mobileNotification.classList.remove('show');
            }, 5000);
        <?php endif; ?>
    </script>

</body>

</html>