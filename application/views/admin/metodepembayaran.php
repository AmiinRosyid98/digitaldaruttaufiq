<html lang="en">

<head>

    <?php $this->load->view('admin/_partials/head.php') ?>
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

            <!-- ======================================================================================================= -->
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
                                    <li class="breadcrumb-item active">Metode Pembayaran</li>
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
                                <h3 class="card-title">Data Metode Pembayaran </h3>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahmapelModal">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Nama Metode</th>
                                        <th>Nama Kode</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($metode as $index => $datametode) : ?>
                                        <tr>
                                            <td class="text-center" ><?php echo $index + 1; ?></td>
                                            <td class="text-center"  style="font-weight: normal;">
                                                <img src="<?= base_url() ?>upload/payment/<?php echo $datametode['logo']; ?>" alt="Logo <?php echo $datametode['nama']; ?>" class="bank-logo" style="width: 70px;">

                                                </td>
                                            <td class="text-left"  style="font-weight: normal;">
                                                <?php echo $datametode['nama']; ?>
                                                <br>
                                                <small>Pembayaran: Rp. <?php echo number_format($datametode['min'], 0, ',', '.'); ?> - Rp. <?php echo number_format($datametode['max'], 0, ',', '.'); ?></small><br>
                                                <small>Biaya admin :  Rp. <?php 
                                                    if (strpos($datametode['biayaadmin'], '%') !== false){
                                                        echo $datametode['biayaadmin'];
                                                    } else {
                                                        echo number_format($datametode['biayaadmin'], 0, ',', '.');
                                                    }
                                                 ?></small>
                                                </td>
                                            <td class="text-center"  style="font-weight: normal;"><?php echo $datametode['kode']; ?></td>
                                            <td class="text-center"  style="font-weight: normal;"><?php echo $datametode['kategori']; ?></td>
                                            <td class="text-center"  style="font-weight: normal;"><?php 
                                                if($datametode['status'] == "Aktif") {
                                                    echo '<label class="badge bg-success" style="font-size: 14px; width:80px">Aktif</label>';
                                                } else {
                                                    echo '<label class="badge bg-danger" style="font-size: 14px; width:80px">Tidak Aktif</label>';
                                                } ?></td>
                                            <td class="text-center" >
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteMetode(<?php echo $datametode['id']; ?>)"><i class="fas fa-trash"></i></a>
                                                <a class="btn btn-success btn-sm" href="#" onclick="editMetode(<?php echo $datametode['id']; ?>)"><i class="fas fa-edit"></i></a>

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

            <!-- ======================================================================================================= -->

            <!-- Modal Tambah Mapel -->
            <div class="modal fade" id="tambahmapelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Metode</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo site_url('admin/masterdata/simpan_metode'); ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kelompok_mapel">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                            
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kelompok_mapel">Kode</label>
                                            <input type="text" class="form-control" id="kode" name="kode" required>
                                            
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="kelompok_mapel">Kategori</label>
                                    <select class="form-control" id="id_kategori" name="id_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori as $key) {
                                        ?>
                                        <option value="<?= $key['id'] ?>"><?= $key['kategori'] ?></option>

                                        <?php 
                                        } ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Minimal Transaksi</label>
                                            <input type="number" class="form-control" id="min" name="min" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Maksimal Transaksi</label>
                                            <input type="number" class="form-control" id="max" name="max" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Biaya Admin</label>
                                            <input type="text" class="form-control" id="biayaadmin" name="biayaadmin" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Aktif" selected>Aktif</option>
                                                <option value="TidakAktif">Tidak Aktif</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kelompok_mapel">Logo</label><br>
                                    <input type="file" name="logo" id="logo">
                                    
                                </div>


                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Mapel -->
            <div class="modal fade" id="editMapelModal" tabindex="-1" role="dialog" aria-labelledby="editMapelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMapelModalLabel">Edit Mapel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editMapelForm" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" id="editMetodeId" name="editMetodeId">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kelompok_mapel">Nama</label>
                                            <input type="text" class="form-control" id="editNama" name="editNama" required>
                                            
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kelompok_mapel">Kode</label>
                                            <input type="text" class="form-control" id="editKode" name="editKode" required>
                                            
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="kelompok_mapel">Kategori</label>
                                    <select class="form-control" id="editId_kategori" name="editId_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori as $key) {
                                        ?>
                                        <option value="<?= $key['id'] ?>"><?= $key['kategori'] ?></option>

                                        <?php 
                                        } ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Minimal Transaksi</label>
                                            <input type="number" class="form-control" id="editMin" name="editMin" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Maksimal Transaksi</label>
                                            <input type="number" class="form-control" id="editMax" name="editMax" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Biaya Admin</label>
                                            <input type="text" class="form-control" id="editBiayaadmin" name="editBiayaadmin" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nourut_mapel">Status</label>
                                            <select class="form-control" id="editStatus" name="editStatus" required>
                                                <option value="Aktif" selected>Aktif</option>
                                                <option value="TidakAktif">Tidak Aktif</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <img src="#" id="editLogo" style="width:150px">
                                </div>

                                <div class="form-group">
                                    <label for="kelompok_mapel">Logo</label><br>
                                    <input type="file" name="editlogo" id="editlogo">
                                    
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









            <?php $this->load->view('admin/_partials/footer.php') ?>

            <script>
                //Fungsi Edit Mapel
                function editMetode(mapelId) {
                    $.ajax({
                        url: 'get_metode',
                        type: 'GET',
                        data: {
                            metodeid: mapelId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#editMetodeId').val(response.metode.id);
                            $('#editNama').val(response.metode.nama);
                            $('#editKode').val(response.metode.kode);
                            $('#editId_kategori').val(response.metode.id_kategori);
                            $('#editMin').val(response.metode.min);
                            $('#editMax').val(response.metode.max);
                            $('#editBiayaadmin').val(response.metode.biayaadmin);
                            $('#editStatus').val(response.metode.status);
                            $('#editLogo').attr("src", "<?= base_url() ?>upload/payment/"+response.metode.logo);
                            $('#editMapelModal').modal('show');
                        },
                        error: function() {
                            alert('Gagal memuat data Metode.');
                        }
                    });
                }


                $(document).ready(function() {
                    $('#editMapelForm').submit(function(event) {
                        event.preventDefault();

                        var form = $('#editMapelForm')[0]; // ambil DOM asli
                        var formData = new FormData(form); // ini akan otomatis ambil semua input, termasuk file

                        $.ajax({
                            url: 'update_metode',
                            type: 'POST',
                            data: formData,
                            processData: false, // penting
                            contentType: false, // penting
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#editMapelModal').modal('hide');
                                    showToast('success', 'Data Metode berhasil diperbarui.');
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
                //Fungsi Hapus Tingkat
                function deleteMetode(mapelId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Metode ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/masterdata/hapus_metode/'); ?>" + mapelId;
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