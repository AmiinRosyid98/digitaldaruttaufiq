<html lang="en">

<head>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <?php $this->load->view('ptk/_partials/head.php') ?>

   <style>
      :root {
         --primary-color: #3498db;
         --secondary-color: #2c3e50;
         --accent-color: #e74c3c;
         --light-color: #ecf0f1;
         --dark-color: #2c3e50;
      }

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

      .card {
         border-radius: 10px;
         box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
         transition: transform 0.3s ease;
         margin-bottom: 20px;
         border: none;
      }

      .card:hover {
         transform: translateY(-5px);
      }


      .card-header {
         border-radius: 10px 10px 0 0 !important;
         color: white;
      }

      .info-box {
         border-radius: 8px;
         overflow: hidden;
      }

      .info-box-content {
         padding: 15px;
      }

      .accordion-button {
         color: #ffffff;
         background-color: var(--primary-color);
         border-color: var(--primary-color);
         font-weight: 500;
      }

      .accordion-button:focus,
      .accordion-button:hover {
         color: #ffffff;
         background-color: var(--secondary-color);
         border-color: var(--secondary-color);
      }

      .accordion-button.collapsed {
         color: var(--dark-color);
         background-color: var(--light-color);
         border-color: var(--light-color);
      }

      .accordion-button.collapsed:focus,
      .accordion-button.collapsed:hover {
         color: var(--dark-color);
         background-color: #e2e6ea;
         border-color: #dae0e5;
      }

      .kelas-btn {
         font-size: calc(0.5rem + 0.5vw);
         /* Ukuran font menyesuaikan lebar layar */
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
      }

      .kelas-btn:hover {
         transform: scale(1.03);
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .sidebar-dark-primary {
         background-color: var(--secondary-color);
      }

      .carousel-item img {
         border-radius: 8px;
         object-fit: cover;
         height: 450px;
         /* Tinggi tetap 400px sesuai permintaan */
         width: 100%;
         display: block;
         /* Memastikan gambar ditampilkan sebagai block element */
      }

      .qrcode-container {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         padding: 15px;
         background: white;
         border-radius: 8px;
         box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }

      .quick-access {
         display: grid;
         grid-template-columns: repeat(2, 1fr);
         gap: 10px;
         margin-top: 15px;
      }

      .quick-access-btn {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         padding: 10px;
         background: white;
         border-radius: 8px;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
         transition: all 0.3s ease;
         text-align: center;
         height: 100%;
      }

      .quick-access-btn:hover {
         background: var(--light-color);
         transform: translateY(-3px);
      }

      .quick-access-btn i {
         font-size: 24px;
         margin-bottom: 8px;
         color: var(--primary-color);
      }

      .profile-summary {
         display: flex;
         align-items: center;
         padding: 15px;
         background: white;
         border-radius: 8px;
      }

      .profile-icon {
         font-size: 40px;
         margin-right: 15px;
         color: var(--primary-color);
      }

      .mapel-item {
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 10px 15px;
         margin-bottom: 8px;
         background: white;
         border-radius: 6px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
         transition: all 0.2s ease;
      }

      .mapel-item:hover {
         background: #f8f9fa;
         transform: translateX(5px);
      }

      .badge-mapel {
         background-color: var(--primary-color);
         color: white;
         border-radius: 50%;
         width: 30px;
         height: 30px;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .announcement-badge {
         position: absolute;
         top: -5px;
         right: -5px;
         background-color: var(--accent-color);
         color: white;
         border-radius: 50%;
         width: 20px;
         height: 20px;
         font-size: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .time-date-widget {
         color: white;
         border-radius: 8px;
         padding: 15px;
         text-align: center;
         margin-bottom: 15px;
      }

      .current-time {
         font-size: 28px;
         font-weight: bold;
      }

      .current-date {
         font-size: 16px;
         opacity: 0.9;
      }
   </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
   <div class="wrapper">
      <?php $this->load->view('ptk/_partials/navbar.php') ?>

      <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
         <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>
         <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>
      </aside>

      <!-- Content Wrapper -->
      <div class="content-wrapper" style="min-height: 1200px;">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-3">
                  <!-- Profile and QR Code Section -->
                  <div class="col-lg-8">
                     <div class="card">
                        <div class="card-header" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                           <h3 class="card-title"><i class="fas fa-images mr-2"></i>Galeri Sekolah</h3>
                        </div>
                        <div class="card-body p-0">
                           <div id="schoolCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                              <div class="carousel-inner">
                                 <div class="carousel-item active">
                                    <img src="https://cdn.excode.my.id/assets/slide/slide1.jpg" class="d-block w-100">
                                 </div>
                                 <div class="carousel-item">
                                    <img src="https://cdn.excode.my.id/assets/slide/slide2.png" class="d-block w-100">
                                 </div>
                                 <div class="carousel-item">
                                    <img src="https://cdn.excode.my.id/assets/slide/slide3.png" class="d-block w-100">
                                 </div>
                              </div>
                              <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Previous</span>
                              </button>
                              <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Next</span>
                              </button>
                           </div>
                        </div>
                     </div>

                  </div>

                  <!-- Class and Time Widget Section -->
                  <div class="col-lg-4">
                     <div class="time-date-widget" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                        <div class="current-time" id="current-time"></div>
                        <div class="current-date" id="current-date"></div>
                     </div>

                     <div class="card">
                        <div class="card-header" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                           <h3 class="card-title"><i class="fas fa-chalkboard mr-2"></i>Kelas Mengajar</h3>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <?php foreach ($kelas as $k) : ?>
                                 <?php $class_color = $this->Ptk->count_siswa_by_kelas($k['no_kelas']) > 0 ? 'bg-success' : 'bg-secondary'; ?>
                                 <div class="col-6 col-md-6 mb-2">
                                    <button type="button" class="btn btn-block kelas-btn text-white <?php echo $class_color; ?> kelas" data-id="<?php echo $k['no_kelas']; ?>">
                                       <?php echo $k['nama_kelas']; ?>
                                    </button>
                                 </div>
                              <?php endforeach; ?>
                           </div>
                        </div>
                     </div>


                  </div>
               </div>

               <!-- Main Content Row -->
               <div class="row">
                  <!-- Carousel and Announcement Section -->
                  <div class="col-lg-5">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-8">
                                 <div class="profile-summary">
                                    <div class="profile-icon">
                                       <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div>
                                       <h4 class="mb-1"><?php echo $dataguru['nama_ptk']; ?></h4>
                                       <p class="mb-1 text-muted">NIP: <?php echo $dataguru['nip']; ?></p>
                                       <span class="badge bg-success">Aktif</span>
                                       <div class="mt-2">
                                          <small class="text-muted"><i class="fas fa-database mr-1"></i> Data tersimpan dalam database</small>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="qrcode-container position-relative">
                                    <?php if (!empty($dataguru['qrcode_ptk'])) : ?>
                                       <img src="<?php echo base_url($dataguru['qrcode_ptk']); ?>" style="width: 120px; height: 120px;" id="qrcode_<?php echo $dataguru['id_guru']; ?>" />
                                    <?php else : ?>
                                       <img src="https://cdn.excode.my.id/assets/material/placeholderupload.jpg" style="width: 120px; height: 120px;" id="qrcode_<?php echo $dataguru['id_guru']; ?>" />
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-danger mt-2" onclick="generateQR(<?php echo $dataguru['id_guru']; ?>)">
                                       <i class="fas fa-qrcode mr-1"></i> Generate QR
                                    </button>
                                 </div>
                              </div>
                           </div>

                           <!-- Quick Access Buttons -->
                           <div class="quick-access">
                              <a href="#" class="quick-access-btn">
                                 <i class="fas fa-calendar-alt"></i>
                                 <span>Jadwal Mengajar</span>
                              </a>
                              <a href="<?php echo base_url('ptk/filearsip/banksoal/'); ?>" class="quick-access-btn">
                                 <i class="fas fa-clipboard-check"></i>
                                 <span>Bank Soal</span>
                              </a>
                              <a href="<?php echo base_url('ptk/buku/'); ?>" class="quick-access-btn">
                                 <i class="fas fa-book"></i>
                                 <span>E-Book</span>
                              </a>
                              <a href="<?php echo base_url('ptk/Materi/'); ?>" class="quick-access-btn">
                                 <i class="fas fa-tasks"></i>
                                 <span>Materi</span>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Announcement Section -->
                  <div class="col-lg-3">
                     <div class="card">
                        <div class="card-header position-relative" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                           <h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>Pengumuman</h3>
                           <span class="announcement-badge">3</span>
                        </div>
                        <div class="card-body">
                           <div class="accordion" id="announcementAccordion">
                              <div class="accordion-item border-0 mb-2">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       <i class="fas fa-info-circle mr-2"></i> Panduan SMARTSCHOOL
                                    </button>
                                 </h2>
                                 <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#announcementAccordion">
                                    <div class="accordion-body py-2 small">
                                       <strong>SMARTSCHOOL</strong> Adalah aplikasi maajemen sekolah ayng dikembangkan untuk semua jenjang sekolah,serta untuk mempermudah proses belajar mengajar di sekolah anda.kami terus berusaha mengembangkan fitur terbaru supaya aplikasi ini dapat sempurna.
                                    </div>
                                 </div>
                              </div>

                              <div class="accordion-item border-0 mb-2">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#kehadiransiswa" aria-expanded="false" aria-controls="kehadiransiswa">
                                       <i class="fas fa-user-check mr-2"></i> Kehadiran Siswa
                                    </button>
                                 </h2>
                                 <div id="kehadiransiswa" class="accordion-collapse collapse" data-bs-parent="#announcementAccordion">
                                    <div class="accordion-body py-2 small">
                                       Setiap Guru Bisa Melihat daftar hadir siswanya berdasarkan kelas yang diajar
                                    </div>
                                 </div>
                              </div>

                              <div class="accordion-item border-0 mb-2">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#bukudigital" aria-expanded="false" aria-controls="bukudigital">
                                       <i class="fas fa-book-open mr-2"></i> Buku Digital
                                    </button>
                                 </h2>
                                 <div id="bukudigital" class="accordion-collapse collapse" data-bs-parent="#announcementAccordion">
                                    <div class="accordion-body py-2 small">
                                       Setiap PTK bisa melakukan upload bahan ajar / buku elektronik ke kelas masing-masing untuk di akses oleh para siswa
                                    </div>
                                 </div>
                              </div>

                              <div class="accordion-item border-0">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                       <i class="fas fa-question-circle mr-2"></i> Panduan Penggunaan
                                    </button>
                                 </h2>
                                 <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#announcementAccordion">
                                    <div class="accordion-body py-2 small">
                                       <strong>SMARTSCHOOL</strong> dirancang untuk memudahkan pembelajaran secara digital, baik berupa pengelolaan pengadministrasian lembaga sampai dengan media pembelajaran berbasis online
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Subjects Section -->
                  <div class="col-lg-4">
                     <div class="card">
                        <div class="card-header" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                           <h3 class="card-title"><i class="fas fa-history mr-2"></i>Aktivitas Terakhir</h3>
                        </div>
                        <div class="card-body">
                           <div class="activity-item d-flex mb-2">
                              <div class="activity-icon mr-2 text-primary">
                                 <i class="fas fa-sign-in-alt"></i>
                              </div>
                              <div class="activity-content small">
                                 <div>Login ke sistem</div>
                                 <small class="text-muted">Baru saja</small>
                              </div>
                           </div>
                           <div class="activity-item d-flex mb-2">
                              <div class="activity-icon mr-2 text-success">
                                 <i class="fas fa-check-circle"></i>
                              </div>
                              <div class="activity-content small">
                                 <div>mengakses Dashboard</div>
                                 <small class="text-muted">Beberapa detik yang lalu</small>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="card">
                        <div class="card-header" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                           <h3 class="card-title"><i class="fas fa-book mr-2"></i>Mata Pelajaran</h3>
                        </div>
                        <div class="card-body">
                           <?php if (!empty($mapel)) : ?>
                              <?php foreach ($mapel as $m) : ?>
                                 <div class="mapel-item">
                                    <span><?php echo $m['nama_mapel']; ?></span>
                                    <span class="badge-mapel">
                                       <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                 </div>
                              <?php endforeach; ?>
                           <?php else : ?>
                              <div class="text-center py-3 text-muted">
                                 <i class="fas fa-book-open fa-2x mb-2"></i>
                                 <p>Belum ada mata pelajaran</p>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>

                     <!-- Recent Activity Widget -->

                  </div>
               </div>
            </div>
         </div>
      </div>

      <script>
         // Function untuk generate QR Code menggunakan AJAX
         function generateQR(id_guru) {
            $.ajax({
               url: '<?php echo base_url('ptk/dashboard/generate_qr_code/'); ?>' + id_guru,
               type: 'GET',
               dataType: 'json',
               success: function(response) {
                  if (response.success) {
                     $('#qrcode_' + id_guru).attr('src', response.qr_code_path);
                     showToast('success', 'QR Code berhasil di-generate');
                  } else {
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
            toastr.options = {
               positionClass: 'toast-top-right',
               progressBar: true,
               timeOut: 3000
            };
            toastr[type](message);
         }

         // Update real-time clock
         function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString();
            const dateStr = now.toLocaleDateString('id-ID', {
               weekday: 'long',
               year: 'numeric',
               month: 'long',
               day: 'numeric'
            });

            document.getElementById('current-time').textContent = timeStr;
            document.getElementById('current-date').textContent = dateStr;
         }

         // Update clock every second
         setInterval(updateClock, 1000);
         updateClock(); // Initial call
      </script>

      <!-- Footer -->
      <?php $this->load->view('ptk/_partials/footer.php') ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>