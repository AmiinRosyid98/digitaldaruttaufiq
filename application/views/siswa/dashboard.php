<html lang="en">

<head>
   <?php $this->load->view('siswa/_partials/head.php') ?>
   <style>
      @keyframes blink {
         0% {
            opacity: 1;
         }

         50% {
            opacity: 0;
         }

         100% {
            opacity: 1;
         }
      }

      .blink {
         animation: blink 3s infinite;
      }
   </style>
</head>

<body>

   <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
      <div class="wrapper">
         <?php $this->load->view('siswa/_partials/navbar.php') ?>
         <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
            <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
         </aside>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper" style="min-height: 1200px;">
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <marquee behavior="scroll" direction="left" scrollamount="4">
                                 <p class="card-text">
                                    Halo, Selamat datang di dashboard SmartSchool, tempat di mana kamu dapat mengeksplorasi dunia pendidikan dengan lebih menyenangkan dan interaktif. Di sini, kamu dapat melihat jadwal pelajaran, tugas yang harus diselesaikan, informasi tentang kegiatan sekolah, dan masih banyak lagi.
                                 </p>
                              </marquee>
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                     <div class="col-lg-9">
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch">
                                    <div class="info-box bg-info flex-fill">
                                       <span class="info-box-icon elevation-5" style="color: #ffffff;"><i class="fas fa-user-graduate"></i></span>
                                       <div class="info-box-content elevation-4" style="background-color: #FFFFFF; color: #000000;">
                                          <span class="info-box-text font-weight-bold">Peserta Didik</span>
                                          <span class="info-box-number"><?php echo $datasiswa['nama_siswa']; ?></span>
                                          Kelas: <?php echo $datasiswa['nama_kelas']; ?>
                                          <span class="info-box-text">Data masuk ke dalam database</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch">
                                    <div class="info-box bg-info flex-fill d-flex align-items-center justify-content-between">
                                       <a class="btn btn-danger mr-3" href="#" onclick="generateQR(<?php echo $datasiswa['id_siswa']; ?>)"><i class="fas fa-qrcode"></i> Generate QR</a>
                                       <div class="info-box-content elevation-4" style="background-color: #FFFFFF; color: #000000; display: flex; flex-direction: column; align-items: center;">
                                          <span class="info-box-text font-weight-bold">QR CODE</span>
                                          <?php if (!empty($datasiswa['qrcode_siswa'])) : ?>
                                             <img src="<?php echo base_url($datasiswa['qrcode_siswa']); ?>" style="max-width: 100px; height: auto;" id="qrcode_<?php echo $datasiswa['id_siswa']; ?>" />
                                          <?php else : ?>
                                             <img src="https://cdn.excode.my.id/assets/material/placeholderupload.jpg" style="max-width: 100px; height: auto;" id="qrcode_<?php echo $datasiswa['id_siswa']; ?>" />
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                     <!--
                     <div class="col-lg-3">
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-12 col-sm-6 col-md-12">
                                    <div class="info-box bg-info">
                                       <span class="info-box-icon elevation-3 bg-warning" style="color: #ffffff;"><i class="fas fa-dollar fa-sm"></i></span>
                                       <div class="info-box-content elevation-4" style="background-color: #FFFFFF; color: #000000;">
                                          <span class="info-box-text font-weight-bold ">Saldo : Rp.<?php echo $datasiswa['saldo_siswa']; ?></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-6 col-md-12">
                                    <div class="info-box bg-warning">
                                       <div class="info-box-content elevation-4" style="background-color: #FFFFFF; color: #000000;">
                                          <span class="info-box-text font-weight-bold ">Riwayat Transaksi E-Kantin</span>
                                          <span>Generation Data</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>-->
                  </div>
               </div>
            </div>
            <!-- isi content -->
            <div class="content">
               <div class="container-fluid">

                  <div class="row">
                     <div class="col-lg-7">

                        <div class="card">










                        </div>











                     </div>



                  </div>
               </div>



            </div>
         </div>
      </div>





      <script>
         document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('Chartkandang').getContext('2d');
            var Chartkandang = new Chart(ctx, {
               type: 'doughnut', // Mengubah tipe chart menjadi pie
               data: {
                  labels: [
                     <?php foreach ($kandang_chart as $kandang) : ?> "<?php echo $kandang['nama_kandang']; ?>",
                     <?php endforeach; ?>
                  ],
                  datasets: [{
                     label: 'Jumlah Ayam',
                     data: [
                        <?php foreach ($kandang_chart as $kandang) : ?>
                           <?php echo $kandang['jumlah_ayam']; ?>,
                        <?php endforeach; ?>
                     ],
                     backgroundColor: [
                        'rgb(238, 0, 123)',
                        'rgb(4, 117, 135)',
                        'rgb(238, 141, 0)',
                        'rgb(7, 126, 105)'


                        // Tambahkan warna lain jika diperlukan
                     ],

                     borderColor: [
                        'rgb(238, 0, 123)',
                        'rgb(4, 117, 135)',
                        'rgb(238, 141, 0)',
                        'rgb(7, 126, 105)'
                        // Tambahkan warna lain jika diperlukan
                     ],
                     borderWidth: 1
                  }]
               },
               options: {
                  responsive: true,
                  maintainAspectRatio: false, // Untuk memungkinkan perubahan aspek rasio
                  scales: {
                     yAxes: [{
                        ticks: {
                           beginAtZero: true
                        }
                     }]
                  }
               }
            });
         });
      </script>


      <script>
         //grafik performa menghitung pendapatan butir telur harian 
         // Ambil data dari PHP dan konversi ke JavaScript
         var grafik_tanggal = <?php echo json_encode($grafik_tanggal); ?>;
         var grafik_jumlah_butir_telur = <?php echo json_encode($grafik_jumlah_butir_telur); ?>;

         // Buat grafik dengan Chart.js
         var ctx = document.getElementById('grafikButirTelur').getContext('2d');
         var myChart = new Chart(ctx, {
            type: 'line',
            data: {
               labels: grafik_tanggal,
               datasets: [{
                  label: 'Jumlah Butir Telur',
                  data: grafik_jumlah_butir_telur,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
               }]
            },
            options: {
               scales: {
                  yAxes: [{
                     ticks: {
                        beginAtZero: true
                     }
                  }]
               }
            }
         });
      </script>


      <script>
         // Function untuk generate QR Code menggunakan AJAX
         function generateQR(id_siswa) {
            $.ajax({
               url: '<?php echo base_url('siswa/dashboard/generate_qr_code/'); ?>' + id_siswa,
               type: 'GET',
               dataType: 'json', // Tambahkan dataType: 'json' untuk menerima respons JSON
               success: function(response) {
                  if (response.success) {
                     // Tampilkan QR Code di tempat yang diinginkan
                     $('#qrcode_' + id_siswa).attr('src', response.qr_code_path);
                     // Tampilkan toast berhasil
                     showToast('success', 'QR Code berhasil di-generate');
                  } else {
                     // Tampilkan pesan error
                     showToast('error', response.message);
                  }
               },
               error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  showToast('error', 'Gagal meng-generate QR Code');
               }
            });
         }

         // Function untuk menampilkan toast messages
         function showToast(type, message) {
            toastr.options.positionClass = 'toast-top-right';
            toastr[type](message);
         }
      </script>



      <!-- ======================================================================================================= -->
      <!-- Footer -->
      <?php $this->load->view('siswa/_partials/footer.php') ?>