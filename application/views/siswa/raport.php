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
         <div class="content-wrapper" >
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Raport </h3>
                                        
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 " style="margin: 0;">Nama Siswa</label>
                                            <div class="col-sm-10">
                                                <?= $current_user->nama_siswa ;  ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 " style="margin: 0;">Kelas Sekarang</label>
                                            <div class="col-sm-10">
                                                <?= $kelas->kode_tingkat ;  ?> / <?= $kelas->nama_kelas ;  ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Kelas</th>
                                                <th>Tingkatan</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Semester 1</th>
                                                <th>Semester 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no=0;
                                                foreach ($raport as $itemraport) : ?>
                                                <tr>
                                                    <?php $no++; ?>
                                                    <td class="text-center"><?= $no ?></td>
                                                    <td class="text-left margin: 10;"><?php echo $itemraport['nama_kelas']; ?></td>
                                                    <td class="text-left margin: 10;"><?php echo $itemraport['kode_tingkat']; ?></td>
                                                    <td class="text-left margin: 10;"><?php echo $itemraport['tahunajaran']; ?></td>
                                                    <td class="text-center margin: 10;">
                                                        <?php 
                                                            $cek_raport_1 = $this->db->select("*")
                                                                                ->from("raport")
                                                                                ->where("id_siswa", $current_user->id_siswa)
                                                                                ->where("id_tahunajaran", $itemraport['id_tahunajaran'])
                                                                                ->where("id_kelas", $itemraport['id_kelas'])
                                                                                ->where("semester", "1")
                                                                                ->order_by("id_raport","DESC")
                                                                                ->limit(1)
                                                                                ->get()
                                                                                ;
                                                        if($cek_raport_1->num_rows() > 0){
                                                            $result = $cek_raport_1->row();
                                                            if($result->file == "Ya"){

                                                                $file = base_url('upload/dokumen/') . $result->url_path;
                                                            } else{
                                                                $file = $result->link;

                                                            }
                                                        ?>
                                                            <a class="btn btn-success btn-sm" href="<?= $file ?>" target="_blank" ><i class="fas fa-download"></i> Raport</a>
                                                        <?php } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center margin: 10;">
                                                        <?php 
                                                            $cek_raport_1 = $this->db->select("*")
                                                                                ->from("raport")
                                                                                ->where("id_siswa", $current_user->id_siswa)
                                                                                ->where("id_tahunajaran", $itemraport['id_tahunajaran'])
                                                                                ->where("id_kelas", $itemraport['id_kelas'])
                                                                                ->where("semester", "2")
                                                                                ->order_by("id_raport","DESC")
                                                                                ->limit(1)
                                                                                ->get()
                                                                                ;
                                                        if($cek_raport_1->num_rows() > 0){
                                                            $result = $cek_raport_1->row();
                                                            if($result->file == "Ya"){

                                                                $file = base_url('upload/dokumen/') . $result->url_path;
                                                            } else{
                                                                $file = $result->link;

                                                            }
                                                        ?>
                                                            <a class="btn btn-success btn-sm" href="<?= $file ?>" target="_blank" ><i class="fas fa-download"></i> Raport</a>
                                                        <?php } else {
                                                            echo "-";
                                                        }
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
               </div>
            </div>
         </div>
      </div>





      <!-- ======================================================================================================= -->
      <!-- Footer -->
      <?php $this->load->view('siswa/_partials/footer.php') ?>