<html lang="en">

<head>

    <?php $this->load->view('ptk/_partials/head.php') ?>
</head>

<body>
    <?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $info_message = $this->session->flashdata('info_message');
    ?>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('ptk/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>

            </aside>

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1000px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Jurnal Digital </h3>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#tambahkelasModal">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Kelas</th>
                                                <th>Catat</th>
                                                <th>Jumlah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($jurnalmaster as $index => $jurnal) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td class="text-center"><?php echo $jurnal['nama_kelas']; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-sm open-modal" data-toggle="modal" data-target="#catatjurnal" data-id="<?php echo $jurnal['id']; ?>">
                                                            <i class="fas fa-pen"></i> Catat Jurnal
                                                        </button>
                                                    </td>

                                                    <td class="text-center"><?php echo $jurnal['jumlah_jurnal']; ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-warning btn-sm open-modal" data-toggle="modal" data-target="#modal-detail-<?php echo $jurnal['id']; ?>"><i class="fas fa-eye"></i></a>
                                                        <a class='btn btn-primary btn-sm' href='<?php echo base_url("ptk/jurnalguru/cetak_jurnalguru/" . $jurnal['id']); ?>' target='_blank'><i class='fas fa-print'></i></a>
                                                        <a class="btn btn-danger btn-sm" href="#" onclick="deleteJurnalmaster(<?php echo $jurnal['id']; ?>)"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- Modal untuk menampilkan detail jurnal -->
                                    <?php foreach ($jurnalmaster as $jurnal) : ?>
                                        <div class="modal fade" id="modal-detail-<?php echo $jurnal['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalDetailTitle">Detail Jurnal - <?php echo $jurnal['nama_kelas']; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php if (isset($detailjurnal[$jurnal['id']]) && !empty($detailjurnal[$jurnal['id']])) : ?>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Jam Ke</th>
                                                                        <th>Kompetensi</th>
                                                                        <th>Materi</th>
                                                                        <th>Indikator</th>
                                                                        <th>Pencapaian</th>
                                                                        <th>Absen siswa</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($detailjurnal[$jurnal['id']] as $idx => $detail) : ?>
                                                                        <tr>
                                                                            <td><?php echo $idx + 1; ?></td>
                                                                            <td><?php echo date('d-m-Y', strtotime($detail['tanggal'])); ?></td>
                                                                            <td><?php echo $detail['mulaijamke']; ?> - <?php echo $detail['sampaijamke']; ?></td>
                                                                            <td><?php echo $detail['kompetensi']; ?></td>
                                                                            <td><?php echo $detail['materi']; ?></td>
                                                                            <td><?php echo $detail['indikator']; ?></td>
                                                                            <td>Tuntas</td>
                                                                            <td>Terlampir</td>
                                                                            <td><a class="btn btn-danger btn-sm" href="#" onclick="deleteDetailJurnal(<?php echo $detail['id']; ?>)"><i class="fas fa-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        <?php else : ?>
                                                            <p>Tidak ada data jurnal untuk kelas ini.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="pagination">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ======================================================================================================= -->
                <!-- Modal Jurnal Guru -->
                <div class="modal fade" id="catatjurnal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Catat Jurnal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo site_url('ptk/jurnalguru/simpan_jurnal'); ?>" method="POST">

                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" autocomplete="off" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="mulaijamke">Mulai Jam ke</label>
                                            <input type="number" class="form-control" id="mulaijamke" name="mulaijamke" autocomplete="off" required>
                                            <input type="hidden" class="form-control" id="id" name="id_master" readonly>
                                            <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                        </div>
                                        <div class="col-6">
                                            <label for="sampaijamke">Sampai Jam ke</label>
                                            <input type="number" class="form-control" id="sampaijamke" name="sampaijamke" autocomplete="off" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="kompetensi">Kompetensi Inti / Kompetensi Dasar</label>
                                        <textarea class="form-control" id="kompetensi" name="kompetensi" rows="3" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="materi">Materi</label>
                                        <textarea class="form-control" id="materi" name="materi" rows="3" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="indikator">Indikator</label>
                                        <textarea class="form-control" id="indikator" name="indikator" rows="3" required></textarea>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Master Jurnal -->
                <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Master Jurnal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo site_url('ptk/jurnalguru/simpan_jurnalmaster'); ?>" method="POST" role="form">
                                    <div class="form-group">
                                        <label for="kodeLayanan">Kode Jurnal</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="kodeLayanan" name="kode_master" required readonly>
                                            <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-secondary" id="generateKode">Generate Kode</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="kelas">Kelas</label>
                                                <select class="form-control" id="kelas" name="kelas" required>
                                                    <?php foreach ($kelas as $item_kelas) : ?>
                                                        <option value="<?= $item_kelas['no_kelas']; ?>"><?= $item_kelas['nama_kelas']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>





                <?php $this->load->view('ptk/_partials/footer.php') ?>

                <script>
                    $(document).ready(function() {
                        generateAndSetRandomCode();

                        $('#generateKode').click(function() {
                            generateAndSetRandomCode();
                        });

                        function generateAndSetRandomCode() {
                            var randomCode = generateRandomCode();
                            $('#kodeLayanan').val(randomCode);
                        }

                        function generateRandomCode() {
                            var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                            var codeLength = 8;
                            var randomCode = 'JUR';
                            for (var i = 0; i < codeLength; i++) {
                                randomCode += chars.charAt(Math.floor(Math.random() * chars.length));
                            }
                            return randomCode;
                        }
                    });
                </script>



                <script>
                    //Fungsi Hapus Master Jurnal
                    function deleteJurnalmaster(jurnalmasterId) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Master Jurnal ini akan terhapus permanen !",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?php echo base_url('/ptk/jurnalguru/hapus_jurnalmaster/'); ?>" + jurnalmasterId;
                            }
                        });
                    }
                </script>


                <script>
                    //Fungsi Hapus Detail Jurnal
                    function deleteDetailJurnal(jurnaldetailId) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Jurnal ini akan terhapus permanen !",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?php echo base_url('/ptk/jurnalguru/hapus_jurnaldetail/'); ?>" + jurnaldetailId;
                            }
                        });
                    }
                </script>

                <script>
                    //Fungsi Mengambil ID 
                    $(document).ready(function() {
                        $('.open-modal').click(function() {
                            var id = $(this).data('id');
                            $('#id_input').val(id);
                            $('#id').val(id);
                            var formAction = "<?php echo site_url('ptk/jurnalguru/simpan_jurnal'); ?>";
                            $('#catatjurnal form').attr('action', formAction);
                        });
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