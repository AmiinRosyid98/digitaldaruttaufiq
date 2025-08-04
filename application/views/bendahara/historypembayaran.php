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
            <div class="content-wrapper" style="min-height: 1100px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">

                    </div>
                </div>
                <!-- isi content -->
                <div class="content">

                    <div class="card">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-10">
                                        <h3 class="card-title"><i class="fa-solid fa-file-invoice"></i> Data Rekap History Pembayaran</h3>
                                    </div>
                                    <div class="col-2 text-right">
                                        <!-- Tempat Kosong -->
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12 text-right">
                                        <!-- Dropdown untuk memilih kelas -->
                                        <form class="form-inline" action="<?php echo site_url('bendahara/historypembayaran/'); ?>" method="get">
                                            <div class="col-lg-3">
                                                 <div class="form-group mb-2">
                                                    <select name="kelas" class="form-control" style="width:100%">
                                                        <?php foreach ($kelas as $row) : ?>
                                                            <option value="<?php echo $row['no_kelas']; ?>" <?= isset($_GET['kelas']) ? ($_GET['kelas'] == $row['no_kelas']) ? "selected" : "" : "" ?> ><?php echo $row['nama_kelas']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group mb-2 ">
                                                    <select name="poskeuangan" class="form-control" style="width:100%">
                                                        <?php foreach ($poskeuangan as $row) : ?>
                                                            <option value="<?php echo $row['id_pos']; ?>" <?= isset($_GET['poskeuangan']) ? ($_GET['poskeuangan'] == $row['id_pos']) ? "selected" : "" : "" ?> ><?php echo $row['nama_pos']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group mb-2 ">
                                                    <select name="tahunpelajaran" class="form-control" style="width:100%">
                                                        <?php foreach ($tahunpelajaran as $row) : ?>
                                                            <option value="<?php echo $row['id_tahunpelajaran']; ?>" <?= isset($_GET['tahunpelajaran']) ? ($_GET['tahunpelajaran'] == $row['id_tahunpelajaran']) ? "selected" : "" : "" ?>><?php echo $row['tahun_pelajaran']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left; padding-bottom: 9px;">
                                                <button type="submit" class="btn btn-sm btn-primary " style="padding: 7px 15px;">
                                                    <i class="fa-solid fa-filter"></i> Filter
                                                </button>
                                                <?php if ($queryString != "") { ?>
                                                <a href="<?php echo base_url(); ?>bendahara/historypembayaran/cetak_laporankeuangan_by_kelas?<?= $queryString ?>"><button type="button" class="btn btn-sm btn-danger ml-2" style="padding: 7px 15px;">
                                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                                </button></a>
                                                <?php } ?>
                                            </div>
                                            
                                            
                                            
                                            
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Telah Dibayar</th>
                                        <th>Sisa Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historypembayaran as $index => $history) : ?>
                                        <?php
                                        // Menghitung sisa tagihan
                                        $sisa_tagihan    = $history['jumlah_tarif'] - $history['jumlah_pembayaran'];
                                        // Menentukan warna baris berdasarkan sisa tagihan
                                        $warna_baris = ($sisa_tagihan > 0) ? 'background-color: #ffcccc;' : '';
                                        ?>
                                        <tr style="<?php echo $warna_baris; ?>">
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $history['tahun_pelajaran']; ?></td>
                                            <td class="text-center"><?php echo $history['nis']; ?></td>
                                            <td><?php echo $history['nama_siswa']; ?></td>
                                            <td class="text-center"><?php echo $history['nama_kelas']; ?></td>
                                            <td class="text-center" style="font-weight: bold;"><?php echo $history['nama_pos']; ?></td>
                                            <td class="text-center" style="font-weight: bold;"><?php echo number_format($history['jumlah_tarif']); ?></td>
                                            <td class="text-center">Rp <?php echo number_format($history['jumlah_pembayaran'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <?php
                                                // Menampilkan sisa tagihan
                                                echo 'Rp ' . number_format($sisa_tagihan, 0, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total :</th>
                                        <th class="text-center">Rp <?php echo number_format($jumlah_tarif, 0, ',', '.'); ?></th>
                                        <th class="text-center">Rp <?php echo number_format($jumlah_pembayaran, 0, ',', '.'); ?></th>
                                        <th class="text-center">Rp <?php echo number_format($sisa_total_tagihan, 0, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>

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

            <!-- Modal Tambah Kelas -->
            <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah POS Keuangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('bendahara/datakeuangan/simpan_poskeuangan'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="nama_pos">Nama POS Keuangan</label>
                                    <input type="text" class="form-control" id="nama_pos" placeholder="SPP" name="nama_pos" oninput="this.value = this.value.toUpperCase()" required>
                                </div>

                                <div class="form-group">
                                    <label for="ket_pos">kETERANGAN</label>
                                    <input type="text" class="form-control" id="ket_pos" placeholder="Sumbangan Pembinaan Pendidikan" name="ket_pos" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Kelas -->
            <div class="modal fade" id="editPosModal" tabindex="-1" role="dialog" aria-labelledby="editKelasModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKelasModalLabel">Edit POS Keuangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editPosForm">
                            <div class="modal-body">
                                <input type="hidden" id="editPosId" name="editPosId">
                                <div class="form-group">
                                    <label for="editNamaPos">Nama Pos</label>
                                    <input type="text" class="form-control" id="editNamaPos" name="editNamaPos" oninput="this.value = this.value.toUpperCase()" required>
                                </div>

                                <div class="form-group">
                                    <label for="editKeterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="editKeterangan" name="editKeterangan" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>









            <?php $this->load->view('bendahara/_partials/footer.php') ?>




            <script>
                //Fungsi Edit POS KEUANGAN
                function editPos(posId) {
                    $.ajax({
                        url: 'get_poskeuangan',
                        type: 'GET',
                        data: {
                            pos_id: posId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#editPosId').val(response.poskeuangan.id_pos);
                            $('#editNamaPos').val(response.poskeuangan.nama_pos);
                            $('#editKeterangan').val(response.poskeuangan.ket_pos);
                            $('#editPosModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data.');
                        }
                    });
                }


                $(document).ready(function() {
                    $('#editPosForm').submit(function(event) {
                        event.preventDefault();

                        $.ajax({
                            url: 'update_poskeuangan',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#editPosModal').modal('hide');
                                    showToast('success', 'Data POS Keuangan berhasil diperbarui.');
                                    location.reload();
                                } else {
                                    showToast('error', 'Gagal menyimpan perubahan.');
                                }
                            },
                            error: function() {
                                showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                            }
                        });
                    });
                });

                function showToast(type, message) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr[type](message);
                }
            </script>





            <script>
                //Fungsi Hapus POS Keuangan
                function deletePos(posId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "POS Keuangan ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/bendahara/datakeuangan/hapus_poskeuangan/'); ?>" + posId;
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