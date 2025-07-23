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

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('admin/_partials/navbar.php') ?>
            <!-- /.navbar -->

    
            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $perusahaan['menu_active'] ?? ''; ?>" style="background-color: <?php echo $perusahaan['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('admin/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('admin/_partials/sidebar_menu.php') ?>
                
            </aside>
            
<!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Layanan</li>
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
                            <h3 class="card-title">Data Layanan </h3>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahlayananModal">
                                Tambah Layanan
                            </button>
                        </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Paket</th>
                                        <th>Durasi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($premium as $index => $premium): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td class="text-center"><?php echo $premium['name']; ?></td>
                                        <td class="text-center">
                                            <?php
                                                $durasi_premium = $premium['durasi_premium'];
                                                if ($durasi_premium == 1) {
                                                    $durasi_premium = 'PAKET 1';
                                                } elseif ($durasi_premium == 2) {
                                                    $durasi_premium = 'PAKET 2';
                                                } elseif ($durasi_premium == 3) {
                                                    $durasi_premium = 'PAKET 3';
                                                }
                                                echo $durasi_premium;
                                            ?>
                                        </td>
                                        <td class="text-center"><?php echo $premium['durasi_premium']; ?> Bulan</td>
                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($premium['tanggal_premium'])); ?></td>
                                        <td class="text-center">
                                            <?php
                                                $status_premium = $premium['status'];
                                                $class = ($status_premium == 0) ? 'badge badge-danger' : 'badge badge-success';
                                                $text = ($status_premium == 0) ? 'Menunggu Pembayaran' : 'Aktif';
                                                echo '<span class="' . $class . '">' . $text . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-danger btn-sm" href="#" onclick="deletePremium(<?php echo $premium['id_premium']; ?>)"><i class="fas fa-trash"></i></a>
                                            <a class="btn btn-success btn-sm" href="#" onclick="editPremium(<?php echo $premium['id_premium']; ?>)"><i class="fas fa-edit"></i></a>

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

            <!-- Modal Tambah Layanan -->
            <div class="modal fade" id="tambahLayananModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulir untuk menambah Layanan -->
                            <form action="<?php echo site_url('admin/premium/simpan_premium'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="kodeLayanan">Kode Layanan:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kodeLayanan" name="kode_layanan" required  >
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary" id="generateKode">Generate Kode</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_layanan">Nama Layanan:</label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Paket Premium -->
            <div class="modal fade" id="editLayananModal" tabindex="-1" role="dialog" aria-labelledby="editLayananModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLayananModalLabel">Konfirmasi Status Premium</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editPremiumForm">
                            <div class="modal-body">
                                <input type="hidden" id="editPremiumId" name="editPremiumId">

                                <div class="form-group">
                                    <label for="editStatusPremium">Status</label>
                                    <select class="form-control" id="editStatusPremium" name="editStatusPremium" required>
                                        <option value="0">Menunggu Pembayaran</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="editTanggalPremium">Tanggal</label>
                                    <input type="date" class="form-control" id="editTanggalPremium" name="editTanggalPremium" required>
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


   

            <script>
function editPremium(premiumId) {  // Function untuk mengisi data pada modal edit
    $.ajax({
        url: 'premium/get_premium',
        type: 'GET',
        data: { premium_id: premiumId },
        dataType: 'json',
        success: function(response) {
            $('#editPremiumId').val(response.premium.id_premium);
            $('#editStatusPremium').val(response.premium.status);
            $('#editTanggalPremium').val(response.premium.tanggal_premium);
            $('#editStatusPremium').val(response.premium.dibaca);
            $('#editLayananModal').modal('show'); // Tampilkan modal edit
        },
        error: function() {
            alert('Gagal memuat data layanan.');
        }
    });
}

$('#editPremiumForm').submit(function(event) {  // Function untuk menangani submit form edit
    event.preventDefault(); // Mencegah form submit secara default
    $.ajax({
        url: 'premium/update_premium', // URL untuk mengirim data
        type: 'POST',
        data: $(this).serialize(), // Mengambil data dari form
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#editLayananModal').modal('hide'); // Sembunyikan modal edit
                alert('Premium berhasil diperbarui.'); // Tampilkan pesan sukses
                location.reload(); // Muat ulang halaman untuk menampilkan data yang diperbarui
            } else {
                alert('Tidak ada perubahan.'); // Tampilkan pesan gagal
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan perubahan.'); // Tampilkan pesan error
        }
    });
});

// Fungsi untuk menampilkan toast
function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }


</script>




<script>
    function deletePremium(premiumId) {
   Swal.fire({
       title: 'Apakah Anda yakin?',
       text: "Pengguna ini akan terhapus permanen !",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#d33',
       cancelButtonColor: '#3085d6',
       confirmButtonText: 'Ya, hapus!',
       cancelButtonText: 'Batal'
   }).then((result) => {
       if (result.isConfirmed) {
           window.location.href = "<?php echo base_url('/admin/premium/hapus_premium/'); ?>" + premiumId; // Redirect ke URL hapus_member jika pengguna menyetujui
       }
   });
}
</script>




<?php $this->load->view('admin/_partials/footer.php') ?>



<script>
    // Function to show toast messages
    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }

    // Show success toast if success message exists
    <?php if($success_message): ?>
        showToast('success', '<?php echo $success_message; ?>');
    <?php endif; ?>

        // Show success toast if success message exists
        <?php if($info_message): ?>
        showToast('info', '<?php echo $info_message; ?>');
    <?php endif; ?>

    // Show error toast if error message exists
    <?php if($error_message): ?>
        showToast('error', '<?php echo $error_message; ?>');
    <?php endif; ?>

</script>


