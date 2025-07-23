<html lang="en">

<head>

    <?php $this->load->view('bendahara/_partials/head.php') ?>
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
            <?php $this->load->view('bendahara/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('bendahara/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('bendahara/_partials/sidebar_menu.php') ?>

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
                                <h3 class="card-title"><i class="fa-solid fa-magnifying-glass-dollar"></i> Data Jenis Pembayaran </h3>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkelasModal">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>POS</th>
                                        <th>Tipe</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>Tarif Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jenispembayaran as $index => $jenispembayaran) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $jenispembayaran['nama_pos']; ?></td>
                                            <td class="text-center"><?php echo $jenispembayaran['nama_tipepembayaran']; ?></td>
                                            <td class="text-center"><?php echo $jenispembayaran['tahun_pelajaran']; ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm open-modal" data-toggle="modal" data-target="#tambahTarifpembayaran" data-id_jenispembayaran="<?php echo $jenispembayaran['id_jenispembayaran']; ?>">Setting Tarif Pembayaran</button>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteJenispembayaran(<?php echo $jenispembayaran['id_jenispembayaran']; ?>)"><i class="fas fa-trash"></i></a>
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

        <!-- ======================================================================================================= -->

        <!-- Modal Tambah Jenis Pembayaran -->
        <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Jenis Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo site_url('bendahara/datakeuangan/simpan_jenispembayaran'); ?>" method="POST">
                            <div class="form-group">
                                <label for="kode_pos">POS</label>
                                <select class="form-control" id="kode_pos" name="kode_pos" required>
                                    <option value="">Pilih POS</option>
                                    <?php foreach ($pos as $item_tingkat) : ?>
                                        <option value="<?php echo $item_tingkat['id_pos']; ?>"><?php echo $item_tingkat['nama_pos']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kode_tahunpelajaran">Tahun Pelajaran</label>
                                <select class="form-control" id="kode_tahunpelajaran" name="kode_tahunpelajaran" required>
                                    <option value="">Pilih Tahun Ajaran</option>
                                    <?php foreach ($tahunpelajaran as $item_tingkat) : ?>
                                        <option value="<?php echo $item_tingkat['id_tahunpelajaran']; ?>"><?php echo $item_tingkat['tahun_pelajaran']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tipe_pembayaran">Tipe Pembayaran</label>
                                <select class="form-control" id="tipe_pembayaran" name="tipe_pembayaran" required>
                                    <option value="">Pilh Tipe Pembayaran</option>
                                    <?php foreach ($tipepembayaran as $item_tingkat) : ?>
                                        <option value="<?php echo $item_tingkat['id_tipepembayaran']; ?>"><?php echo $item_tingkat['nama_tipepembayaran']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Tarif -->
        <div class="modal fade" id="tambahTarifpembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tarif Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo site_url('bendahara/datakeuangan/simpan_tarifpembayaran'); ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="kode_pembayaran" name="kode_pembayaran" readonly>
                            </div>

                            <div class="form-group">
                                <label for="jumlah_tarif">Nominal Tagihan Per siswa</label>
                                <input type="text" class="form-control" id="jumlah_tarif" name="jumlah_tarif" placeholder="1.000.000" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="kode_kelas"><span class="badge bg-primary" style="font-size: 13px;">Untuk Kelas</span></label>
                                <div class="row">
                                    <?php foreach ($kelas as $item_kelas) : ?>
                                        <div class="col-auto mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="kode_kelas_<?php echo $item_kelas['no_kelas']; ?>" name="kode_kelas[]" value="<?php echo $item_kelas['no_kelas']; ?>" onclick="checkMinimumOneCheckbox()">
                                                <label class="form-check-label ml-2" for="kode_kelas_<?php echo $item_kelas['no_kelas']; ?>" style="width: 50px;"><?php echo $item_kelas['nama_kelas']; ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <span id="error-message" style="color: red;"></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>









        <?php $this->load->view('bendahara/_partials/footer.php') ?>

        <script>
            $(document).ready(function() {
                // Format rupiah saat diketikkan
                $('#jumlah_tarif').on('keyup', function() {
                    // Mengambil nilai input
                    var nilai = $(this).val();
                    // Menghapus semua karakter kecuali digit
                    nilai = nilai.replace(/\D/g, '');
                    // Format nilai sebagai rupiah
                    var format_rupiah = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(nilai);
                    // Tampilkan kembali nilai yang sudah diformat
                    $(this).val(format_rupiah);
                });
            });
        </script>







        <script>
            //Fungsi Mengambil ID id_jenispembayaran
            $(document).ready(function() {
                $('.open-modal').click(function() {
                    var id_jenispembayaran = $(this).data('id_jenispembayaran');
                    $('#id_jenispembayaran_input').val(id_jenispembayaran);
                    $('#kode_pembayaran').val(id_jenispembayaran);
                    var formAction = "<?php echo site_url('bendahara/datakeuangan/simpan_tarifpembayaran'); ?>";
                    $('#tambahTarifpembayaran form').attr('action', formAction);
                });
            });
        </script>



        <script>
            //Fungsi Hapus POS Keuangan
            function deleteJenispembayaran(jenispembayaranId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Jenis Pembayaran ini akan terhapus permanen !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo base_url('/bendahara/datakeuangan/hapus_jenispembayaran/'); ?>" + jenispembayaranId;
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