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
            <div class="content-wrapper" style="min-height: 900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">

                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header ">
                                        <h5 class="card-title"><i class="fas far fa-home mr-1"></i> Setting Payment Gateway</h5>
                                    </div>
                                    <form action="<?php echo site_url('admin/sistem/settingpaymentgateway'); ?>" method="POST">
                                        <div class="card-body">
                                            <style>
                                                /* Gaya kustom untuk input agar hanya memiliki garis bawah */
                                                
                                            </style>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="npsn" class="font-weight-normal">Link Tripay</label>
                                                    <input type="hidden" class="form-control" name="id" value="<?php echo isset($profilsekolah['id']) ? $profilsekolah['id'] : ''; ?>">
                                                    <input type="text" id="npsn" class="form-control" name="tripay_link" value="<?php echo isset($profilsekolah['tripay_link']) ? $profilsekolah['tripay_link'] : ''; ?>">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="npsn" class="font-weight-normal">API Key</label>
                                                    <input type="text" id="npsn" class="form-control" name="tripay_api_key" value="<?php echo isset($profilsekolah['tripay_api_key']) ? $profilsekolah['tripay_api_key'] : ''; ?>">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="npsn" class="font-weight-normal">Private Key</label>
                                                    <input type="text" id="npsn" class="form-control" name="tripay_private_key" value="<?php echo isset($profilsekolah['tripay_private_key']) ? $profilsekolah['tripay_private_key'] : ''; ?>">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="npsn" class="font-weight-normal">Merchant ID</label>
                                                    <input type="text" id="npsn" class="form-control" name="tripay_merchant_id" value="<?php echo isset($profilsekolah['tripay_merchant_id']) ? $profilsekolah['tripay_merchant_id'] : ''; ?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================================================================================= -->



            <?php $this->load->view('admin/_partials/footer.php') ?>

            <?php if ($this->session->flashdata('toast_message')) : ?>
                <script>
                    $(document).ready(function() {
                        toastr.success('<?php echo $this->session->flashdata('toast_message'); ?>');
                    });
                </script>
            <?php endif; ?>