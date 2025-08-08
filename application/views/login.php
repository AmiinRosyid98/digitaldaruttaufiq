<!DOCTYPE html>
<html lang="id">
<?php foreach ($data_site as $res) { ?> <?php } ?>
<?php foreach ($versi as $version) { ?> <?php } ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $res->nama_lembaga; ?> - SISMA</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter (default) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Favicons -->
    <link rel="icon" href="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>assets/web/<?php echo $res->logo; ?>">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Ensure full viewport height and a subtle background */
            min-height: 100vh;
            background-color: #f0f2f5; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add some padding around the container */
            box-sizing: border-box;
        }

        /* Custom styles for the checkbox to match the image */
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid #fff; /* White border for checkbox */
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            background-color: transparent; /* Transparent background */
        }

        input[type="checkbox"]:checked {
            background-color: #FFC200; /* Yellow background when checked */
            border-color: #FFC200; /* Yellow border when checked */
        }

        input[type="checkbox"]:checked::after {
            content: '✓'; /* Checkmark symbol */
            color: #000; /* Black checkmark */
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            line-height: 1;
        }
    </style>
    <style>
        .link-card {
            /* Bootstrap classes */
            text-decoration: none;  /* Removes underline from link */
            text-align: center;     /* Centers text content */
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); /* shadow-sm */
            padding: 1rem;          /* p-3 */
            border-radius: 7px;    /* rounded-3 */
            background-color: white;/* bg-white */
            transition: all 0.2s ease-in-out; /* transition */
            display: block;
            width: 17%;         /* Makes the link fill its container */
            cursor: pointer !important;
            color: #6c757d !important
        }
        .link-card.active {
            background-color: #FFC200;
            color: #000 !important;
            border:1px solid #0b5758
        }

        .link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .logo-img {
            height: 20px;
            object-fit: contain;
            filter: grayscale(0.2);
            transition: filter 0.3s ease;
        }

        .link-card:hover .logo-img {
            filter: none;
        }
        .mt-2 {
        margin-top: 0.5rem !important;  /* 8px */
        }

        .d-flex {
        display: flex !important;
        }

        .flex-wrap {
        flex-wrap: wrap !important;
        }

        .gap-3 {
        gap: 15px !important;  /* 16px */
        }

        .justify-content-start {
        justify-content: flex-start !important;
        }

        .align-items-start {
        align-items: flex-start !important;
        }

        /* Image styles */
        .img-fluid {
            max-width: 100%;       /* Makes image responsive */
            height: auto;          /* Maintains aspect ratio */
            margin-bottom: 0.5rem; /* mb-2 */
        }

        /* Text div styles */
        .{
            color: #6c757d !important; /* Bootstrap's muted text color */
        }

        .fw-bold {
            font-weight: 700 !important; /* Makes text bold */
        }

        /* Inline style */
        [style*="font-size: 10px"] {
            font-size: 10px !important; /* Overrides other font-size declarations */
        }
        .jenis{
            font-size: 10px !important;
        }
        @media (max-width: 768px) {
            .gap-3 {
            gap: 10px !important;  /* 16px */
            }
            .link-card {
                font-size: 10px !important;
                padding-left: 1px !important;         /* Makes the link fill its container */
                padding-right: 1px !important;         /* Makes the link fill its container */
            }
            .jenis{
                font-size: 8px !important;
            }
        }
    </style>
</head>
<body class="antialiased">
    <div class="flex w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">
        <!-- Left Panel (Login Form) -->
        <div class="relative flex-1 p-8 bg-[#006A6D] text-white flex flex-col justify-between rounded-l-2xl lg:w-2/5 md:w-full sm:w-full">
            <!-- Top section: Logo and Back to home -->
            <div class="flex justify-between items-center mb-10">
                <!-- Logo placeholder -->
                <div class="w-10 h-10 bg-[#FFC200] rounded-lg"></div>
                <a href="<?= base_url('/') ?>" class="text-white text-sm font-medium hover:underline">Kembali ke halaman utama</a>
            </div>

            <!-- Main login content -->
            <div class="flex-grow flex flex-col justify-center">
                <h1 class="text-3xl font-bold mb-2" style="text-align: center;margin-bottom: 15px;">LOGIN</h1>

                <span class="text-white text-sm font-medium hover:underline">Login sebagai :</span>

                <div class="mt-2 mb-2 d-flex flex-wrap gap-3 justify-content-start align-items-start">
                    <div href=""
                        target="_blank"
                        class="link-card text-decoration-none text-center shadow-sm p-3 px-1 rounded-3 bg-white transition active"
                        title="" value="admin">
                        <i class="fas fa-user-cog mb-2"></i>
                        <div class="fw-bold jenis" >
                            Operator
                        </div>
                    </div>
                    <div href=""
                        target="_blank"
                        class="link-card text-decoration-none text-center shadow-sm p-3 px-1 rounded-3 bg-white transition"
                        title="" value="bk">
                        <i class="fas fa-hands-helping mb-2"></i>
                        <div class="fw-bold jenis" >
                            BK
                        </div>
                    </div>
                    <div href=""
                        target="_blank"
                        class="link-card text-decoration-none text-center shadow-sm p-3 px-1 rounded-3 bg-white transition"
                        title="" value="guru">
                        <i class="fas fa-chalkboard-teacher mb-2"></i>
                        <div class="fw-bold jenis" >
                            Guru
                        </div>
                    </div>
                    <div href=""
                        target="_blank"
                        class="link-card text-decoration-none text-center shadow-sm p-3 px-1 rounded-3 bg-white transition"
                        title="" value="bendahara">
                        <i class="fas fa-money-bill-wave mb-2"></i> 
                        <div class="fw-bold jenis" >
                            Bendahara
                        </div>
                    </div>
                    <div href=""
                        target="_blank"
                        class="link-card text-decoration-none text-center shadow-sm p-3 px-1 rounded-3 bg-white transition"
                        title="" value="siswa">
                        <i class="fas fa-user-graduate mb-2"></i> 
                        <div class="fw-bold jenis" >
                            Siswa
                        </div>
                    </div>
                </div>

                <form id="loginForm" class="space-y-4">
                    <div>
                        <input type="text" id="username" placeholder="Username" class="w-full p-3 rounded-xl bg-[#005456] text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#FFC200]">
                    </div>
                    <div class="relative">
                        <input type="password" id="password" placeholder="Password" class="w-full p-3 pr-10 rounded-xl bg-[#005456] text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#FFC200]">
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-300 hover:text-white focus:outline-none" id="togglePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const togglePassword = document.querySelector('#togglePassword');
                            const password = document.querySelector('#password');

                            togglePassword.addEventListener('click', function() {
                                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                                password.setAttribute('type', type);
                                
                                const icon = this.querySelector('svg');
                                if (type === 'password') {
                                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                                } else {
                                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.88l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                                }
                            });
                        });
                    </script>
                    <input type="hidden" name="role" class="role" value="admin">

                    

                    <!-- <div class="flex justify-between items-center text-sm hhkhkh">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="form-checkbox text-[#FFC200] rounded-md focus:ring-[#FFC200]">
                            <span>Remember Me</span>
                        </label>
                        <a href="#" class="text-[#FFC200] hover:underline">Forgot Password</a>
                    </div> -->

                    <button type="submit" class="w-full py-3 bg-[#FFC200] text-black font-semibold rounded-xl shadow-lg hover:bg-yellow-400 transition duration-300 ease-in-out">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                </form>

                <!-- <div class="text-center mt-6 text-sm">
                    Not a member yet? <a href="#" class="text-[#FFC200] font-semibold hover:underline">Register Now</a>
                </div> -->
            </div>

            <!-- Decorative icons (simplified) -->
            <div class="absolute bottom-8 left-8 text-white text-opacity-30 text-xl space-y-3 hidden md:block">
                <!-- Star icon -->
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.92 8.725c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path></svg>
                <!-- Leaf icon -->
                <svg class="w-5 h-5 ml-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.414-1.414L9 11.071l-.707.707a1 1 0 001.414 1.414l.707-.707 1.768 1.768z" clip-rule="evenodd"></path></svg>
            </div>

            <!-- Footer copyright -->
            <div class="text-sm opacity-70 mt-10">
                © 2022 All rights reserved
            </div>
        </div>

        <!-- Right Panel (Visual/Image) dsds -->
        <div class="relative flex-1 bg-gray-300 hidden lg:block rounded-r-2xl">
            <!-- <img src="https://placehold.co/1000x800/A0D9B1/006A6D?text=See+your+child's+progress" alt="Child playing" class="w-full h-full object-cover rounded-r-2xl"> -->
            <img src="<?= base_url('assets/landingnew/login.png') ?>" alt="Child playing" class="w-full h-full object-cover rounded-r-2xl">
            <!-- Overlay with text and navigation dots -->
            <!-- <div class="absolute inset-0 bg-[#006A6D] bg-opacity-40 flex flex-col justify-end items-center p-8 rounded-r-2xl">
                <h2 class="text-white text-3xl font-bold mb-6 text-center">See your child's progress</h2>
                <div class="flex space-x-3">
                    <span class="w-3 h-3 bg-white rounded-full opacity-70"></span>
                    <span class="w-3 h-3 bg-white rounded-full"></span> <!-- Active dot --
                    <span class="w-3 h-3 bg-white rounded-full opacity-70"></span>
                </div>
            </div> -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
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
            "hideMethod": "fadeOut"
        };
        $(document).ready(function() {
            $('.link-card').click(function() {
                $('.link-card').removeClass('active');
                $(this).addClass('active');
                var role = $(this).attr('value');
                $('.role').val(role);
            });

            $('#loginForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var formData = {
                username: $('#username').val(),
                password: $('#password').val(),
                role: $('.role').val()
                };

                // Show loading state
                $('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i> Memproses...');
                $('button[type="submit"]').prop('disabled', true);

                // AJAX request
                $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>auth/dologin',
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
                    $('button[type="submit"]').html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
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
                    $('button[type="submit"]').html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
                    $('button[type="submit"]').prop('disabled', false);
                }
                });
            });
        });
    </script>
</body>
</html>
