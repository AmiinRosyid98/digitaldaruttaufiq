<html lang="en">
<head>
    <?php $this->load->view('member/_partials/head.php') ?>
</head>

<body>
    
    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed" style="height: auto;">
       
            <!-- Navbar -->
            <?php $this->load->view('member/_partials/navbar.php') ?>
            <!-- /.navbar -->

    
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $perusahaan['menu_active'] ?? ''; ?>" style="background-color: <?php echo $perusahaan['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('member/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('member/_partials/sidebar_menu.php') ?>
                
            </aside>
            
<!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1350.84px;">

                <section class="content-header">
                    <div class="container-fluid">
                       
                    </div>
                </section>


                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                  
                                    <div class="card-body">
                                                
                                        <div class="row">
                                            <div class="col-lg-9">
                                                
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Informasi Profile</h3>
                                                    </div>

                                                    <form action="<?php echo site_url('member/profile/update'); ?>" method="POST">
                                                        <div class="card-body">
                                                            <p><code>Data Informasi Pengguna</code></p>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                <label>Nama </label>
                                                                    <input type="hidden" class="form-control" name="id" value="<?php echo $current_user->id; ?>">
                                                                    <input type="hidden" class="form-control" name="username" value="<?php echo $current_user->username; ?>">
                                                                    <input type="hidden" class="form-control" name="email" value="<?php echo $current_user->email; ?>">
                                                                    <input type="text" class="form-control" name="name" value="<?php echo $current_user->name; ?>">
                                                                </div>

                                                                <div class="col-6">
                                                                <label>No WA</label>
                                                                    <input type="text" class="form-control" name="notelp" value="<?php echo $current_user->notelp; ?>">
                                                                </div>
                                                                
                                                                <div class="col-6">
                                                                <label>Password</label>
                                                                    <input type="text" class="form-control" name="password" value="">
                                                                </div>

                                                                <div class="col-6">
                                                                <label>Nama Farm</label>
                                                                    <input type="text" class="form-control" name="nama_lembaga" value="<?php echo $current_user->nama_lembaga; ?>">
                                                                </div> 
                                                            </div>
                                                            <hr>

                                                            

                                                            <p><code>Informasi Alamat</code></p>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label>Alamat</label>
                                                                        <input type="text" class="form-control" name="alamat" value="<?php echo $current_user->alamat; ?>">
                                                                    </div>

                                                                    <div class="col-4">
                                                                    <label>Provinsi</label>
                                                                        <input type="text" class="form-control" name="provinsi" value="<?php echo $current_user->provinsi; ?>">
                                                                    </div>

                                                                    <div class="col-4">
                                                                    <label>Kabupaten</label>
                                                                        <input type="text" class="form-control" name="kabupaten" value="<?php echo $current_user->kabupaten; ?>">
                                                                    </div>

                                                                    <div class="col-4">
                                                                    <label>Kecamatan</label>
                                                                        <input type="text" class="form-control" name="kecamatan" value="<?php echo $current_user->kecamatan; ?>">
                                                                    </div>
                                                                </div>
                                                            <hr>

                                                            

                                        
                                                            <p><code>Pengaturan Pakan</code></p>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                <label>Jagung</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="jagung" placeholder="Jagung" value="<?php echo $current_user->jagung; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                <label>Konsentrat</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="konsentrat" placeholder="Konsentrat" value="<?php echo $current_user->konsentrat; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                <label>Dedak</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="dedak" placeholder="Dedak" value="<?php echo $current_user->dedak; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                <label>Takaran Pakan Per Ekor</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="takaran_pakan" placeholder="Takaran Pakan" value="<?php echo $current_user->takaran_pakan; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">Gram</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            <p><code>Pengaturan Harga Pakan & Telur</code></p>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label>Harga Jagung</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="kg_jagung" placeholder="Harga Jagung" value="<?php echo $current_user->kg_jagung; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">/Kg</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label>Harga Konsentrat</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="kg_konsentrat" placeholder="Harga Konsentrat" value="<?php echo $current_user->kg_konsentrat; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">/Kg</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label>Harga Dedak</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="kg_dedak" placeholder="Harga Dedak" value="<?php echo $current_user->kg_dedak; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">/Kg</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label>Harga Jual Telur</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" name="harga_jual" placeholder="Harga Jual Telur" value="<?php echo $current_user->harga_jual; ?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">/Kg</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn toastrDefaultInfo" style="background-color: #c10000; color: #ffffff;">Perbaharui</button>
                                                        </div>
                                                    </form>
                                                </div>
                                        
                                            </div>


                                            <div class="col-lg-3">
                                                
                                                <div class="card card-info">
                                                <div class="card-header">
                                                        <h3 class="card-title">Foto Profile</h3>
                                                    </div> 
                                                    
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- Tampilkan foto profil -->
                                                                <?php if ($current_user->avatar): ?>
                                                                    <img src="<?php echo base_url('assets/member/profile/' . $current_user->avatar); ?>" alt="Avatar Pengguna" class="rounded-circle shadow-lg" style="width: 140px; height: 140px;">
                                                                <?php else: ?>

                                                                    <p>Avatar tidak tersedia</p>
                                                                <?php endif; ?>

                                                            
                                                                <!-- Tampilkan pesan sukses atau error -->
                                                                <?php if ($this->session->flashdata('success')): ?>
                                                                    <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
                                                                <?php elseif ($this->session->flashdata('error')): ?>
                                                                    <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <!-- Form unggah foto profil -->
                                                        <?php echo form_open_multipart('member/profile/update_avatar', 'class="d-flex justify-content-between align-items-start"'); ?>
                                                            <div class="form-group" style="margin-bottom: 0;">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                                                    <label class="custom-file-label" for="avatar">Pilih Foto</label>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary align-self-end" style="height: 100%;">Upload</button>
                                                        <?php echo form_close(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                              
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>




<!-- ======================================================================================================= -->



<?php $this->load->view('member/_partials/footer.php') ?>

        