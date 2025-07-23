<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/head.php') ?>
</head>

<body>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('admin/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('admin/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>

            </aside>

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 800px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-8">

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Profile</h3>
                                    </div>

                                    <form action="<?php echo site_url('admin/profile/updatedataprofile'); ?>" method="POST">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-6">
                                                    <label>Nama</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo $current_user->id; ?>">
                                                    <input type="text" class="form-control" name="name" value="<?php echo $current_user->name; ?>">
                                                </div>

                                                <div class="col-6">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username" value="<?php echo $current_user->username; ?>" readonly>
                                                </div>

                                                <div class="col-6">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $current_user->email; ?>">
                                                </div>

                                                <div class="col-6">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" name="password" value="">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success toastrDefaultInfo">Simpan</button>
                                        </div>
                                    </form>
                                </div>

                            </div>


                            <div class="col-lg-4">

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title">Foto Profile</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Tampilkan foto profil -->
                                                <?php if ($current_user->avatar) : ?>
                                                    <img src="<?php echo base_url('assets/admin/profile/' . $current_user->avatar); ?>" alt="Avatar Pengguna" class="rounded-circle shadow-lg" style="width: 140px; height: 140px;">
                                                <?php else : ?>

                                                    <p>Avatar tidak tersedia</p>
                                                <?php endif; ?>


                                                <!-- Tampilkan pesan sukses atau error -->
                                                <?php if ($this->session->flashdata('success')) : ?>
                                                    <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
                                                <?php elseif ($this->session->flashdata('error')) : ?>
                                                    <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <!-- Form unggah foto profil -->
                                        <?php echo form_open_multipart('admin/profile/update_avatar', 'class="d-flex justify-content-between align-items-start"'); ?>
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

            <!-- ======================================================================================================= -->



            <?php $this->load->view('admin/_partials/footer.php') ?>