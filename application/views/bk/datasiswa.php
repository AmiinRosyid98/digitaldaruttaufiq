<html lang="en">

<head>
    <?php $this->load->view('bk/_partials/head.php') ?>
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
            <?php $this->load->view('bk/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('bk/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('bk/_partials/sidebar_menu.php') ?>

            </aside>

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 900px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">

                    </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title"><i class="fa-solid fa-user-shield"></i> Data Poin Siswa </h3>

                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($poinpelanggaran as $index => $datapoin) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td><?php echo $datapoin['nama_siswa']; ?></td>
                                            <td class="text-center"><?php echo $datapoin['nama_kelas']; ?></td>
                                            <td class="text-center"><?php echo $datapoin['total_poin']; ?></td>
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

            <!-- Modal Tambah Poin Pelanggaran -->
            <div class="modal fade" id="addpelanggaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Poin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('bk/epoin/simpan_pelanggaran'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>
                                    <input type="text" class="form-control" id="nama_siswa" placeholder="Cari Nama Siswa" name="nama_siswa" required>
                                    <input type="hidden" id="id_siswa" name="id_siswa"> <!-- Hidden input untuk menyimpan ID siswa -->
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label for="poin">Poin Pelanggaran</label>
                                    <input type="number" class="form-control" id="poin" placeholder="Masukkan Poin Pelanggaran" name="poin" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pelanggaran">Nama Pelanggaran</label>
                                    <input type="text" class="form-control" id="nama_pelanggaran" placeholder="Masukkan Nama Pelanggaran" name="nama_pelanggaran" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>












            <?php $this->load->view('bk/_partials/footer.php') ?>


            <script>
                $(document).ready(function() {
                    $("#nama_siswa").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "<?php echo site_url('bk/epoin/cari_siswa'); ?>",
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
                //Fungsi Hapus Data Pelanggaran
                function deletePos(pelanggaranId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data Pelanggaran ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/bk/epoin/hapus_pelanggaransiswa/'); ?>" + pelanggaranId;
                        }
                    });
                }
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