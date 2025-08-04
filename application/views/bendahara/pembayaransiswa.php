<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('bendahara/_partials/head.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <?php
    // Ambil pesan flash success
    $success_message = $this->session->flashdata('success_message');
    // Ambil pesan flash error
    $error_message = $this->session->flashdata('error_message');
    // Ambil pesan flash info
    $info_message = $this->session->flashdata('info_message');
    ?>

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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1800px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <form method="GET" action="<?= site_url('bendahara/pembayaransiswa') ?>" id="filterForm" class="form-inline">
                                        <div class="form-group mr-md-2">
                                            <label for="tahunpelajaranSelect" class="mr-2"></label>
                                            <select class="form-control" name="tahunpelajaran" id="tahunpelajaranSelect">
                                                <option value="">Tahun ajaran</option>
                                                <?php foreach ($tahunpelajaran as $tahunpelajaran_item) : ?>
                                                    <option value="<?= $tahunpelajaran_item['id_tahunpelajaran'] ?>" <?= ($selected_tahunpelajaran == $tahunpelajaran_item['id_tahunpelajaran']) ? 'selected' : '' ?>>
                                                        <?= $tahunpelajaran_item['tahun_pelajaran'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <label for="kelasSelect" class="mr-2"></label>
                                            <select class="form-control" name="kelas" id="kelasSelect">
                                                <option value="">Semua Kelas</option>
                                                <?php foreach ($kelas as $kelas_item) : ?>
                                                    <option value="<?= $kelas_item['no_kelas'] ?>" <?= ($selected_kelas == $kelas_item['no_kelas']) ? 'selected' : '' ?>>
                                                        <?= $kelas_item['nama_kelas'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <label for="posKeuanganSelect" class="mr-2"></label>
                                            <select class="form-control" name="poskeuangan" id="posKeuanganSelect">
                                                <option value="">Semua Pos</option>
                                                <?php foreach ($poskeuangan as $pos_item) : ?>
                                                    <option value="<?= $pos_item['id_pos'] ?>" <?= ($selected_poskeuangan == $pos_item['id_pos']) ? 'selected' : '' ?>>
                                                        <?= $pos_item['nama_pos'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </form>
                                </div><!--
                                <div class="col-md-6 text-right mt-3 mt-md-0">
                                    <form method="GET" action="<?= site_url('bendahara/pembayaransiswa') ?>" id="nisForm" class="form-inline justify-content-end" autocomplete="off">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nis" id="nis2" value="<?= $selected_nis ?>" placeholder="Masukkan NIS">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger" name="action" value="cari_nis">Cari NIS</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Isi content -->
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa-solid fa-money-check-dollar"></i> Detail Data Transaksi Pembayaran </h3>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan data siswa hanya jika sudah ada filter kelas dipilih -->
                        <?php if (!empty($selected_kelas) || !empty($selected_nis)) : ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>POS Tagihan</th>
                                        <th>Nominal Dibayar</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>Catat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($siswa)) : ?>
                                        <?php foreach ($siswa as $index => $siswa_item) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td class="text-center"><?= $siswa_item['nis'] ?></td>
                                                <td><?= $siswa_item['nama_siswa'] ?></td>
                                                <td class="text-center" style="font-weight: bold;">
                                                    <button type="button" class="btn btn-primary btn-sm position-relative">
                                                        <?= !empty($siswa_item['jumlah_tarif']) ? 'Rp ' . number_format($siswa_item['jumlah_tarif'], 0, ',', '.') : 'Tidak terdapat tagihan' ?>
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                            <span class="visually-hidden"><?= !empty($siswa_item['nama_pos']) ? ($siswa_item['nama_pos']) : 'Nihil' ?></span>
                                                        </span>
                                                    </button><br>
                                                    <span style="font-weight: normal;">Tipe : <?= $siswa_item['nama_tipepembayaran'] ?> </span>
                                                </td>
                                                <td class="text-center">Rp. <?= number_format((int) $siswa_item['total_bayar'], 0, ',', '.') ?><br>
                                                    <?php if ((int)$siswa_item['total_bayar'] <= 0) { ?>
                                                        <span class=" translate-middle badge rounded-pill bg-secondary"><i class="fas fa-circle-exclamation"></i>&nbsp;Belum Bayar</span>
                                                    <?php } else if ((int)$siswa_item['total_bayar'] > 0)  { ?>
                                                        <?php if ((int)$siswa_item['total_bayar'] < (int)$siswa_item['jumlah_tarif']) {?>
                                                            <span class=" translate-middle badge rounded-pill bg-warning"><i class="fas fa-hourglass-half"></i>&nbsp;Dibayar Sebagian</span>
                                                        <?php } else { ?>
                                                            <span class=" translate-middle badge rounded-pill bg-success"><i class="fas fa-circle-check"></i>&nbsp;Lunas</span>
                                                            
                                                        <?php } // sdsds ?>

                                                    <?php } else { ?>
                                                    <?php }  ?>
                                                </td>
                                                <td class="text-center"><?= $siswa_item['tahun_pelajaran'] ?></td>
                                                <td class="text-center">
                                                    <?php if ((int)$siswa_item['total_bayar'] < $siswa_item['jumlah_tarif']): ?>
                                                        <button class="btn btn-success btn-sm open-modal" data-toggle="modal" data-target="#tambahPembayaran" data-id_siswa="<?php echo $siswa_item['id_siswa']; ?>" data-id_tipepembayaran="<?php echo $siswa_item['id_tipepembayaran']; ?>" data-id_pos="<?php echo $siswa_item['id_pos']; ?>"  data-nama_siswa="<?php echo $siswa_item['nama_siswa']; ?>" data-nama_pos="<?php echo $siswa_item['nama_pos']; ?>" data-id_pembayaran="<?php echo $siswa_item['id_pembayaran']; ?>" data-jumlah_tarif="<?php echo $siswa_item['jumlah_tarif']; ?>" data-kode_tahunpelajaran="<?php echo $siswa_item['kode_tahunpelajaran']; ?>" data-kode_kelas="<?php echo $siswa_item['kode_kelas']; ?>" data-tahun_pelajaran="<?php echo $siswa_item['tahun_pelajaran']; ?>" data-nama_kelas="<?php echo $siswa_item['nama_kelas']; ?>"
                                                        data-tagihan = "<?= ((int)$siswa_item['jumlah_tarif'] - (int) $siswa_item['total_bayar']) ?>"
                                                            >Catat Pembayaran</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-dark btn-sm" disabled>Catat Pembayaran</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8">Data siswa tidak ditemukan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <div class="pagination">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <div class="pagination">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
        <!-- Form untuk mencatat pembayaran -->
        <div class="modal fade" id="tambahPembayaran" tabindex="-1" role="dialog" aria-labelledby="tambahPembayaranLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="<?= site_url('bendahara/pembayaransiswa/simpan_pembayaran') ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPembayaranLabel">Catat Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" readonly>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="id_siswa" name="id_siswa" required>
                                <input type="hidden" class="form-control" id="id_tipepembayaran" name="id_tipepembayaran" required>
                                <input type="hidden" class="form-control" id="id_pos" name="id_pos" required>
                                <input type="hidden" class="form-control" id="id_pembayaran" name="id_pembayaran" required>
                                <input type="hidden" class="form-control" id="jumlah_tarif" name="jumlah_tarif" required>
                                <input type="hidden" class="form-control" id="statuspembayaran" name="statuspembayaran" value="1" required>
                                <input type="hidden"  class="form-control" id="kode_tahunpelajaran" name="kode_tahunpelajaran" required>
                                <input type="hidden" class="form-control" id="kode_kelas" name="kode_kelas" required>
                                

                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nama_pos">Pembayaran Untuk</label>
                                    <input type="text" class="form-control" id="nama_pos" name="nama_pos" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nama_kelas">Kelas</label>
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tahun_pelajaran">Tahun Ajaran</label>
                                    <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" required readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                                <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-simpan">Simpan Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <?php $this->load->view('bendahara/_partials/footer.php') ?>

        <!-- Scripts -->
        <script>

            $('.btn-simpan').click(function(e){
                // e.preventDefault();
                let val = $('#jumlah_pembayaran').val()
                let tagihan = $(this).attr("tagihan");
                let angka = parseInt(
                  val.replace(/[^\d]/g, '') // Hapus semua karakter selain angka
                );
                if(parseInt(angka) > parseInt(tagihan)) {
                    showToast('error', 'Maksimal tagihannya adalah = '+tagihan);
                    return false //sdsds
                }
            })
            // Fungsi Mengambil ID id_jenispembayaran
            $(document).ready(function() {
                $('.open-modal').click(function() {
                    var id_siswa            = $(this).data('id_siswa');
                    var id_tipepembayaran   = $(this).data('id_tipepembayaran');
                    var id_pos              = $(this).data('id_pos');
                    var nama_siswa          = $(this).data('nama_siswa');
                    var nama_pos            = $(this).data('nama_pos');
                    var id_pembayaran       = $(this).data('id_pembayaran');
                    var jumlah_tarif        = $(this).data('jumlah_tarif');
                    var kode_tahunpelajaran = $(this).data('kode_tahunpelajaran');
                    var kode_kelas          = $(this).data('kode_kelas');
                    var tahun_pelajaran     = $(this).data('tahun_pelajaran');
                    var nama_kelas          = $(this).data('nama_kelas');
                    var tagihan          = $(this).data('tagihan');
                    $('#id_siswa').val(id_siswa);
                    $('#id_tipepembayaran').val(id_tipepembayaran);
                    $('#id_pos').val(id_pos);
                    $('#nama_siswa').val(nama_siswa);
                    $('#nama_pos').val(nama_pos);
                    $('#id_pembayaran').val(id_pembayaran);
                    $('#jumlah_tarif').val(jumlah_tarif);
                    $('#kode_tahunpelajaran').val(kode_tahunpelajaran);
                    $('#kode_kelas').val(kode_kelas);
                    $('#tahun_pelajaran').val(tahun_pelajaran);
                    $('#nama_kelas').val(nama_kelas);
                    $('.btn-simpan').attr("tagihan", tagihan)
                    var formAction = "<?php echo site_url('bendahara/datakeuangan/simpan_tarifpembayaran'); ?>";
                    $('#tambahTarifpembayaran form').attr('action', formAction);
                });
            });

            // Fungsi untuk modal tambah pembayaran
            $('#tambahPembayaran').on('show.bs.modal', function(event) {
                var button              = $(event.relatedTarget); // Tombol yang memicu modal
                var id_siswa            = button.data('id_siswa');
                var id_tipepembayaran   = button.data('id_tipepembayaran');
                var id_pos              = button.data('id_pos');
                var nama_siswa          = button.data('nama_siswa');
                var nama_pos            = button.data('nama_pos');
                var id_pembayaran       = button.data('id_pembayaran');
                var jumlah_tarif        = button.data('jumlah_tarif');
                var kode_tahunpelajaran = button.data('kode_tahunpelajaran');
                var kode_kelas          = button.data('kode_kelas');
                var tahun_pelajaran     = button.data('tahun_pelajaran');

                // Memasukkan nilai ke dalam input di dalam modal
                $(this).find('.modal-body #id_siswa').val(id_siswa);
                $(this).find('.modal-body #id_tipepembayaran').val(id_tipepembayaran);
                $(this).find('.modal-body #id_pos').val(id_pos);
                $(this).find('.modal-body #nama_siswa').val(nama_siswa);
                $(this).find('.modal-body #nama_pos').val(nama_pos);
                $(this).find('.modal-body #id_pembayaran').val(id_pembayaran);
                $(this).find('.modal-body #jumlah_tarif').val(jumlah_tarif);
                $(this).find('.modal-body #kode_tahunpelajaran').val(kode_tahunpelajaran);
                $(this).find('.modal-body #kode_kelas').val(kode_kelas);
                $(this).find('.modal-body #tahun_pelajaran').val(tahun_pelajaran);
            });

            // Fungsi form Search NIS
            $(document).ready(function() {
                $('#nis').on('input', function() {
                    submitForm();
                });

                $('#filterForm').submit(function(event) {
                    event.preventDefault();
                    submitForm();
                });

                function submitForm() {
                    var formData = $('#filterForm').serialize();
                    var actionUrl = $('#filterForm').attr('action');
                    $.get(actionUrl, formData, function(response) {
                        $('#siswaTable').html(response);
                    });
                }
            });
            

            // Format rupiah saat diketikkan
            $(document).ready(function() {
               
                $('#jumlah_pembayaran').on('keyup', function() {
                    var nilai = $(this).val();
                    nilai = nilai.replace(/\D/g, '');
                    var format_rupiah = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(nilai);
                    $(this).val(format_rupiah);
                });
            });

           
            // Fungsi Select Kelas
            document.getElementById('kelasSelect').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            // Fungsi Select Pos Keuangan
            document.getElementById('posKeuanganSelect').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

             // Fungsi Select Pos Keuangan
             document.getElementById('tahunpelajaranSelect').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            // Fungsi Hapus POS Keuangan
            function deleteJenispembayaran(jenispembayaranId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Jenis Pembayaran ini akan terhapus permanen!",
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

            // Fungsi untuk menampilkan pesan flash
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

        
    </div>
</body>

</html>
