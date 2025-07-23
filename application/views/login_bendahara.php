<!DOCTYPE html>
<?php
$profil_array = $profil->result_array();
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php foreach ($profil_array as $row) : ?><?php echo $row['nama_lembaga']; ?><?php endforeach; ?> - ADMINISTRATOR</title>
  <link rel="alternate icon" type="image/png" href="<?php echo base_url() ?>/assets/web/<?php foreach ($profil_array as $row) : ?><?php echo $row['logo']; ?><?php endforeach; ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/c67daa5af8.js" crossorigin="anonymous"></script>
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.excode.my.id/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr Alert -->
  <link rel="stylesheet" href="https://cdn.excode.my.id/assets/admin/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.excode.my.id/assets/admin/css/adminlte.min.css">

  <!-- Custom styles -->
  <style>
    .btn-custom {
      background-color: #0D485B;
      color: #ECECEC;
      transition: background-color 0.3s, color 0.3s;
    }

    .btn-custom:hover {
      background-color: #0D9354;
      color: #FFFFFF;
    }

    .btn-beranda {
      background-color: #E95703;
      color: #ECECEC;
      transition: background-color 0.3s, color 0.3s;
    }

    .btn-beranda:hover {
      background-color: #0D9354;
      color: #FFFFFF;
    }

    .bg-custom {
      background-image: linear-gradient(to bottom, #05729E, #0A5D7E);
      height: 100vh;
      /* Set tinggi elemen sesuai tinggi viewport */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .bg-white {
      background-color: #ffffff;
      height: 100vh;
      /* Set tinggi elemen sesuai tinggi viewport */
    }

    .logo {
      width: 40px;
      height: auto;
    }

    /* Styles for toast card */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
    }

    s .toast {
      max-width: 350px;
      background-color: #ffffff;
      /* Ubah warna latar belakang menjadi biru */
      color: #000000;
      /* Ubah warna teks menjadi putih */
    }

    .toast-header {
      background-color: #E57900;
      /* Ubah warna latar belakang header menjadi biru tua */
      color: #fff;
      /* Ubah warna teks header menjadi putih */
      border-bottom: none;
      /* Hilangkan border bawah pada header */
    }

    .label {
      width: 100px;
      /* Atur lebar label sesuai kebutuhan */
      text-align: right;
      /* Posisikan teks label ke kanan */
      margin-right: 0px;
      /* Berikan margin kanan agar ada ruang antara label dan input */
    }
  </style>
</head>










<body class="hold-transition login-page">

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 bg-custom position-relative">
        <h2 class="text-center mt-3 position-absolute" style="top: 20px; left: 20px; color: white; font-size: 20px;">
          <img src="<?php echo base_url() ?>assets/web/<?php echo $row['logo']; ?>" alt="Logo" style="height: 50px; margin-right: 10px;">
          <strong style="color:#ffffff">
            <?php foreach ($profil_array as $row) : ?>
              <?php echo $row['nama_lembaga']; ?>
            <?php endforeach; ?>
          </strong>
        </h2>

        <img src="https://cdn.excode.my.id/assets/banner-image.png" class="img-fluid mt-3 ml-3" alt="Image" style="width: 700px; height: auto;">
      </div>

      <div class="col-md-6 bg-white d-flex align-items-center justify-content-center position-relative">
        <img src="https://cdn.excode.my.id/assets/web/logo-kit.png" class="logo position-absolute" style="top: 20px; right: 20px; width:80px;" alt="Logo">
        <div class="w-100 col-md-8">
          <p class="text-left" style="color:#087990"><u><strong style="font-size: 50px;">Login</strong></u><span class="text-left text-2xl" style="color:#3F6F81"><strong style="font-size: 25px;">BENDAHARA</strong></span></p>

          <form action="loginbendahara" method="post">
            <div class="container">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="background-color: #064c73; color: #ECECEC;"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= set_value('username') ?>">
                <input type="hidden" name="role" class="form-control" value="bendahara">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="background-color: #064c73; color: #ECECEC;"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Password" value="<?= set_value('password') ?>">
              </div>

              <div class="row justify-content-center">
                <div class="col-md-3">
                  <button type="submit" class="btn btn-block btn-custom">
                    Sign In
                  </button>
                </div>
                <div class="col-md-3">
                  <a href="<?php echo base_url(); ?>" class="btn btn-block btn-beranda">
                    ke Beranda
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>






  <!-- jQuery -->
  <script src="https://cdn.excode.my.id/assets/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://cdn.excode.my.id/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Toastr -->
  <script src="https://cdn.excode.my.id/assets/admin/plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdn.excode.my.id/assets/admin/js/adminlte.min.js"></script>

  <!-- Toast Script -->
  <script>
    // Fungsi untuk menampilkan toast
    function showToast(type, message) {
      var toast = `
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <i class="fas fa-exclamation-circle"></i> <!-- Ikon Font Awesome error -->
          <strong class="mr-auto">&nbsp;Informasi</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          ${message}
        </div>
      </div>
    `;

      // Masukkan toast ke dalam halaman
      $(toast).appendTo('.toast-container').toast({
        delay: 3000
      }).toast('show');
    }

    // Panggil fungsi showToast untuk menampilkan toast
    $(document).ready(function() {
      // Tampilkan pesan kesalahan jika ada
      <?php if ($this->session->flashdata('message_login_error')) : ?>
        showToast('error', '<?= $this->session->flashdata('message_login_error') ?>');
      <?php endif; ?>
    });
  </script>

  <!-- Toast Container -->
  <div class="toast-container"></div>

</body>

</html>