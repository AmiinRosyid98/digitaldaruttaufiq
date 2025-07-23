<html lang="en">
   <head>
      <?php $this->load->view('siswa/_partials/head.php') ?>
      <style>
         @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
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
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
               
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Data Tagihan Siswa </h3>
                        </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped ">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Tagihan</th>
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Telah Dibayar</th>
                                        <th>Sisa Tagihan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pembayaran as $index => $pembayaran): ?>
                                        <?php 
                                            $sisa_tagihan = $pembayaran['jumlah_tarif'] - $pembayaran['jumlah_pembayaran']; 
                                            $warna_baris = ($sisa_tagihan > 0) ? 'background-color: #ffcccc;' : '';
                                        ?>

                                    <tr class="text-center" style="<?php echo $warna_baris; ?>">
                                        <td><?php echo $index + 1; ?></td>
                                        <td class="text-left"><strong><?php echo $pembayaran['nama_siswa']; ?></strong><br>
                                            NIS : <?php echo $pembayaran['nis']; ?> 
                                        </td>
                                        <td><?php echo $pembayaran['nama_pos']; ?></td>
                                        <td><?php echo $pembayaran['nama_kelas']; ?></td>
                                        <td><?php echo $pembayaran['tahun_pelajaran']; ?></td>
                                        <td class="text-bold">Rp. <?php echo number_format($pembayaran['jumlah_tarif']); ?></td>
                                        <td>Rp. <?php echo number_format($pembayaran['jumlah_pembayaran']); ?></td>
                                        <td class="text-center">
                                            <?php 
                                            echo 'Rp ' . number_format($sisa_tagihan, 0, ',', '.');
                                            ?>
                                        </td>  


                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <div class="pagination">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
         

         <!-- ======================================================================================================= -->
         
         
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById('Chartkandang').getContext('2d');
                    var Chartkandang = new Chart(ctx, {
                        type: 'doughnut', // Mengubah tipe chart menjadi pie
                        data: {
                            labels: [
                                <?php foreach ($kandang_chart as $kandang): ?>
                                    "<?php echo $kandang['nama_kandang']; ?>",
                                <?php endforeach; ?>
                            ],
                            datasets: [{
                                label: 'Jumlah Ayam',
                                data: [
                                    <?php foreach ($kandang_chart as $kandang): ?>
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


            <script>//grafik performa menghitung pendapatan butir telur harian 
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







         <!-- ======================================================================================================= -->
         <!-- Footer -->
         <?php $this->load->view('siswa/_partials/footer.php') ?>

