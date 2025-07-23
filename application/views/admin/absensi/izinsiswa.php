<html lang="en">

<head>

    <?php $this->load->view('admin/_partials/head.php') ?>
    <style>
        .modal {
            z-index: 1050;
            /* Z-index modal */
        }

        .ui-autocomplete {
            position: absolute;
            /* Pastikan posisi absolut untuk kontrol yang lebih baik */
            background-color: #ffffff;
            /* Warna latar belakang putih */
            border: 1px solid #ced4da;
            /* Garis tepi dengan warna abu-abu untuk memberi kontras */
            padding: 5px;
            /* Padding untuk memberi ruang di sekitar teks */
            max-height: 250px;
            /* Batas maksimum tinggi autocomplete */
            overflow-y: auto;
            /* Aktifkan scroll vertikal jika lebih dari tinggi maksimum */
            z-index: 1060;
            /* Tetapkan z-index tinggi untuk menampilkan di atas modal */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Efek bayangan untuk tampilan dimensi */
        }

        .ui-autocomplete .ui-menu-item {
            padding: 8px 12px;
            /* Padding untuk elemen menu dalam autocomplete */
            cursor: pointer;
            /* Tambahkan kursor pointer untuk indikasi interaktif */
        }

        .ui-autocomplete .ui-menu-item:hover {
            background-color: #f0f0f0;
            /* Warna latar belakang saat hover */
        }
    </style>
</head>

<body>
    <?php
    // Ambil pesan flash success
    $success_message = $this->session->flashdata('success_message');
    // Ambil pesan flash error
    $error_message = $this->session->flashdata('error_message');
    // Ambil pesan flash info
    $info_message = $this->session->flashdata('info_message');
    ?>

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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                                    <li class="breadcrumb-item active">Izin Siswa</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Data Izin Siswa </h3>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addpelanggaran">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($izinabsensi as $index => $absensimanual) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $absensimanual['nama_siswa']; ?></td>
                                            <td class="text-center"><?php echo $absensimanual['nama_kelas']; ?></td>
                                            <td class="text-center"><?php echo $absensimanual['absen']; ?></td>
                                            <td class="text-center"><?php echo $absensimanual['timestamp']; ?></td>

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
            <!-- Modal Tambah Izin Siswa -->
            <div class="modal fade" id="addpelanggaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Keterangan Izin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/absensi/simpan_izinsiswa'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>
                                    <input type="text" class="form-control" id="nama_siswa" placeholder="Cari Nama Siswa" name="nama_siswa" required>
                                    <input type="hidden" id="id_siswa" name="id_siswa"> <!-- Hidden input untuk menyimpan ID siswa -->
                                </div>
                                <div class="form-group">
                                    <label for="timestamp">Tanggal</label>
                                    <input type="datetime-local" class="form-control" id="timestamp" name="timestamp" required>
                                </div>
                                <div class="form-group">
                                    <label for="absen">Keterangan Izin</label>
                                    <select class="form-control" id="absen" name="absen" required>
                                        <!-- Add your <option> elements here -->
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <?php $this->load->view('admin/_partials/footer.php') ?>
            <script>
                $(document).ready(function() {
                    $("#nama_siswa").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "<?php echo site_url('admin/absensi/cari_siswa'); ?>",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function(data) {
                                    response(data); // Menampilkan hasil pencarian sebagai dropdown autocomplete
                                }
                            });
                        },
                        minLength: 2, // Minimal karakter sebelum pencarian dimulai
                        select: function(event, ui) {
                            $("#id_siswa").val(ui.item.id); // Set nilai input hidden id_siswa dengan ID siswa yang dipilih
                        }
                    });

                    // Fungsi untuk mengatur z-index autocomplete lebih tinggi dari modal
                    $(".ui-autocomplete").css("z-index", 1060);
                });
            </script>

            <script>
                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }

                <?php if ($success_message) : ?>
                    showToast('success', '<?php echo $success_message; ?>');
                <?php endif; ?>

                <?php if ($info_message) : ?>
                    showToast('info', '<?php echo $info_message; ?>');
                <?php endif; ?>

                <?php if ($error_message) : ?>
                    showToast('error', '<?php echo $error_message; ?>');
                <?php endif; ?>
            </script>