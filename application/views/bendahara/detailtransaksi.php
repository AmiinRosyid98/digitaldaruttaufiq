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
                            <h3 class="card-title"><i class="fa-solid fa-file-invoice"></i> Detail Transaksi </h3>
                        </div>
                        </div>
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Pembayaran</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Jumlah Pembayaran</th>
                                        <th>Tgl Pembayaran</th>
                                        <th>Status</th>
                                        <th>Batalkan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historypembayaran as $index => $historypembayaran): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td class="text-center"><?php echo $historypembayaran['nis']; ?></td>
                                        <td><?php echo $historypembayaran['nama_siswa']; ?></td>
                                        <td class="text-center"><?php echo $historypembayaran['nama_kelas']; ?></td>
                                        <td class="text-center"><?php echo $historypembayaran['nama_pos']; ?></td>
                                        <td class="text-center"><?php echo $historypembayaran['tahun_pelajaran']; ?></td>
                                        <td class="text-center">Rp <?php echo number_format($historypembayaran['jumlah_pembayaran'], 0, ',', '.'); ?></td>   
                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($historypembayaran['tanggal_pembayaran'])); ?></td>
                                        <td class="text-center">
                                            <?php
                                            $status_text = ($historypembayaran['statuspembayaran'] == 1) ? 'Terkonfirmasi' : 'Pending';
                                            $status_class = ($historypembayaran['statuspembayaran'] == 1) ? 'success' : 'warning';
                                            ?>
                                            <span class="badge bg-<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                        </td>                     
                                        <td class="text-center"><a class="btn btn-danger btn-sm" href="#" onclick="deletepembayaran(<?php echo $historypembayaran['id']; ?>)"><i class="fas fa-trash"></i></a></td>
      
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
                                    <input type="text" class="form-control" id="editNamaPos" name="editNamaPos"  oninput="this.value = this.value.toUpperCase()" required>
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


    <script> //Fungsi Hapus TARIF PEMBAYARAN
        function deletepembayaran(pembayaranId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Batalkan Pembayaran ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('/bendahara/detailtransaksi/hapus_pembayaran/'); ?>" + pembayaranId; 
                }
            });
        }
    </script>

    <script> //Fungsi Edit POS KEUANGAN
        function editPos(posId) {  
            $.ajax({
                url: 'get_poskeuangan',
                type: 'GET',
                data: { pos_id: posId },
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





    <script> //Fungsi Hapus POS Keuangan
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

    <?php if($success_message): ?>
        showToast('success', '<?php echo $success_message; ?>');
    <?php endif; ?>

    <?php if($info_message): ?>
        showToast('info', '<?php echo $info_message; ?>');
    <?php endif; ?>

    <?php if($error_message): ?>
        showToast('error', '<?php echo $error_message; ?>');
    <?php endif; ?>

</script>


