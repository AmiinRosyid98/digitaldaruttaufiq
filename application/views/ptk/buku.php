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
            <div class="content-wrapper" style="min-height: 1700px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Buku Digital </h3>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#tambahkelasModal">
                                            Tambah Buku
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Buku</th>
                                                <th>File E-Book</th>
                                                <th>Waktu</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($buku as $index => $buku) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                                    <td class="text-left text-bold margin: 10;"><?php echo $buku['nama_buku']; ?><br>
                                                        <span class="badge badge-info" style="font-size: 15px;"><?php echo $buku['nama_kelas']; ?></span><br><br>
                                                        <span class="badge badge-pill badge-success"><?php echo $buku['nama_ptk']; ?></span>

                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url() ?>upload/filebuku/<?php echo $buku['file_buku']; ?>" target="_blank">
                                                            <img src="https://cdn.excode.my.id/assets/material/pdf.png" class="card-img-top" alt="E-PERPUSTAKAAN Logo" style="width: 100px; height: 100px;">
                                                        </a>
                                                    </td>
                                                    <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($buku['timestamp_buku'])); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-danger btn-sm" href="#" onclick="deleteBuku(<?php echo $buku['id_buku']; ?>)"><i class="fas fa-trash"></i></a>
                                                        <a class="btn btn-success btn-sm" href="#" onclick="editBuku(<?php echo $buku['id_buku']; ?>)"><i class="fas fa-edit"></i></a>
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

                        <div class="col-12 col-md-3">
                            <div class="timeline">
                                <?php foreach ($bukutimeline as $index => $bukutimeline) : ?>
                                    <?php $random_color = '#' . substr(md5(mt_rand()), 0, 3); ?>
                                    <div class="time-label">
                                        <span style="background-color: <?php echo $random_color; ?>; color: white; padding: 2px 5px; border-radius: 3px;">
                                            <?php echo date('d-m-Y', strtotime($bukutimeline['timestamp_buku'])); ?>
                                        </span>
                                    </div>
                                    <div>
                                    </div>
                                    <div>
                                        <i class="fas fa-book bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i><strong><?php echo date('d-m-Y H:i:s', strtotime($bukutimeline['timestamp_buku'])); ?></strong></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo $bukutimeline['nama_ptk']; ?></a> membuat buku digital</h3>
                                            <div class="timeline-body" style="font-size: 14px;">Telah Melakukan Upload Buku Digital Dengan Judul<br><strong style="font-size: 15px;"><?php echo $bukutimeline['nama_buku']; ?></strong></div>
                                            <div class="timeline-footer">
                                                <a class="btn btn-info btn-sm" href="<?php echo base_url() ?>upload/filebuku/<?php echo $bukutimeline['file_buku']; ?>" target="_blank">Lihat File</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                    <!-- ======================================================================================================= -->

                    <!-- Modal Tambah Buku Digital -->
                    <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Buku Digital</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo site_url('ptk/buku/simpan_buku'); ?>" method="POST" enctype="multipart/form-data" enctype="multipart/form-data" role="form" onsubmit="return validateForm()">
                                        <div class="form-group">
                                            <label for="kodeLayanan">Kode Buku</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="kodeLayanan" name="kode_buku" required readonly>
                                                <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $current_user->id_guru ?>">
                                                <input type="hidden" class="form-control" id="timestamp_buku" name="timestamp_buku" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" id="generateKode">Generate Kode</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="nama_buku">Nama Buku / Judul</label>
                                                    <input type="text" class="form-control" id="nama_buku" name="nama_buku" placeholder="Matematika Kelas X" oninput="this.value = this.value.toUpperCase()" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="terbitan">Terbitan</label>
                                                    <input type="text" class="form-control" id="terbitan" name="terbitan" placeholder="Erlangga" oninput="this.value = this.value.toUpperCase()" required>
                                                </div>
                                            </div>
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
                                            <!-- Tambahkan elemen untuk menampilkan pesan kesalahan -->
                                            <span id="error-message" style="color: red;"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="file_buku">File Buku (PDF)</label>
                                            <input type="file" class="form-control-file" id="file_buku" name="file_buku">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Buku Kelas -->
                    <div class="modal fade" id="editBukuModal" tabindex="-1" role="dialog" aria-labelledby="editBukuModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBukuModalLabel">Edit Buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                <form id="editKelasForm">
                                    <div class="modal-body">
                                        <input type="hidden" id="editBukuId" name="editBukuId">
                                        <div class="form-group">
                                            <label for="editKodeBuku">Kode buku</label>
                                            <input type="text" class="form-control" id="editKodeBuku" name="editKodeBuku" required readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="editNamaBuku">Nama Buku / Judul</label>
                                            <input type="text" class="form-control" id="editNamaBuku" name="editNamaBuku" oninput="this.value = this.value.toUpperCase()" required>
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


                    <!-- Modal untuk Cetak PDF Buku Digital -->
                    <div class="modal fade" id="pdfModalBuku" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 50vw; max-height: 100vh;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pdfModalLabel">Buku Digital <span id="Bukudigital"></span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="pdfViewer" src="" width="100%" height="600" style="border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>








                    <?php $this->load->view('ptk/_partials/footer.php') ?>
                    <script>
                        // Fungsi untuk isian form kelas minimal 1 kelas harus di centang
                        function validateForm() {
                            var checkboxes = document.getElementsByName('kode_kelas[]');
                            var checked = false;

                            for (var i = 0; i < checkboxes.length; i++) {
                                if (checkboxes[i].checked) {
                                    checked = true;
                                    break;
                                }
                            }

                            var errorMessageElement = document.getElementById('error-message');
                            if (!checked) {
                                errorMessageElement.textContent = 'Minimal satu kelas harus dipilih.';
                                return false;
                            } else {
                                errorMessageElement.textContent = '';
                                return true;
                            }
                        }
                    </script>
                    <script>
                        //Fungsi Edit Kelas
                        function editBuku(bukuId) {
                            $.ajax({
                                url: 'buku/get_buku',
                                type: 'GET',
                                data: {
                                    buku_id: bukuId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#editBukuId').val(response.buku.id_buku);
                                    $('#editKodeBuku').val(response.buku.kode_buku);
                                    $('#editNamaBuku').val(response.buku.nama_buku);
                                    $('#editBukuModal').modal('show');
                                },
                                error: function() {
                                    alert('Gagal memuat data Buku.');
                                }
                            });
                        }


                        $(document).ready(function() {
                            $('#editKelasForm').submit(function(event) {
                                event.preventDefault();

                                $.ajax({
                                    url: 'buku/update_buku',
                                    type: 'POST',
                                    data: $(this).serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            $('#editBukuModal').modal('hide');
                                            showToast('success', 'Data Kelas berhasil diperbarui.');
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
                        function openPdfModalBuku(pdfUrl, Bukudigital) {
                            $('#pdfViewer').attr('src', pdfUrl);
                            $('#pdfModalBuku').modal('show');
                        }
                    </script>






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
                                var randomCode = 'BOOK-';
                                for (var i = 0; i < codeLength; i++) {
                                    randomCode += chars.charAt(Math.floor(Math.random() * chars.length));
                                }
                                return randomCode;
                            }
                        });
                    </script>



                    <script>
                        //Fungsi Hapus Buku
                        function deleteBuku(bukuId) {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "Buku Digitsl ini akan terhapus permanen !",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?php echo base_url('/ptk/buku/hapus_buku/'); ?>" + bukuId;
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