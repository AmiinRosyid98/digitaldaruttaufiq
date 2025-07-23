<html lang="en">
<head>
    
    <?php $this->load->view('admin/_partials/head.php') ?>
    <style>
        .list-group-item.active {
            background-color: #dc3545; /* Ganti dengan warna yang Anda inginkan */
            color: #fff; /* Warna teks untuk tombol yang aktif */
            border-color: #dc3545; /* Warna border untuk tombol yang aktif */
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
            
<!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1990px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid"></div>
                </div>
                <!-- isi content -->
                <div class="content">
            
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="perpage" class="col-sm-0 col-form-label">Tampilkan</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="perpage">
                                                        <option value="10">10</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row mb-2">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="siswa-table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th><input type="checkbox" id="select-all"></th>
                                                    <th>NIS</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Kelas</th>
                                                    <th>Nomor Absen</th>
                                                    <th>Tahun Angkatan</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                <tr id="no-data-row" style="display:none;">
                                                    <td colspan="8" class="text-center">Tidak ada data yang tersedia</td>
                                                </tr>
                                            </thead>
                                            <tbody id="siswa-data">
                                                <!-- Isi siswa akan ditampilkan di sini -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="pagination-container mt-4">
                                        <ul class="pagination justify-content-center" id="pagination"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="card" style="background-image: url('<?php echo base_url('assets/hero_rectangle_3.png'); ?>'); background-size: 100% 100%;">
                                <div class="card-body">
                                    <!-- Tambahkan dropdown untuk memilih status kelulusan baru -->
                                    <div class="form-group">
                                        <label for="new_status">Edit Kelulusan Siswa</label>
                                        <select class="form-control" id="new_status">
                                            <option value="0">Aktif Belajar</option>
                                            <option value="1">Lulus</option>
                                            <option value="2">Tidak Lulus</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Tambahkan tombol untuk memperbarui status kelulusan -->
                                    <button class="btn btn-dark btn-block" id="update-status" disabled>Update Status Kelulusan</button>
                                </div>
                            </div>

                            <div class="card" style="background-image: url('<?php echo base_url('assets/desktopHeroFreeTabletBAV2.png'); ?>'); background-size: 100% 100%;">
                                <div class="card-body">
                                    <!-- Tambahkan dropdown untuk memilih status kelulusan baru -->
                                    <div class="form-group">
                                        <label for="tahun_angkatan" class="col-sm-0 col-form-label">Filter Tahun Angkatan</label>
                                        <select class="form-control" id="tahun_angkatan">
                                            <option value="">Tahun Angkatan</option>
                                            <?php foreach ($tahunangkatan as $tahun): ?>
                                                <option value="<?php echo $tahun['tahun']; ?>"><?php echo $tahun['tahun']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- Tambahkan daftar kelas -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Data Rombongan Belajar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group text-center">
                                        <div class="row">
                                            <?php foreach ($kelas as $k): ?>
                                                <?php 
                                                    // Mengecek apakah kelas memiliki data siswa atau tidak
                                                    $class_color = $this->Kelulusan_Model->count_siswa_by_kelas($k['no_kelas']) > 0 ? 'bg-success' : 'bg-danger'; 
                                                ?>
                                                <div class="col-md-4 mb-1">
                                                    <button type="button" class="list-group-item list-group-item-action kelas font-weight-bold text-white <?php echo $class_color; ?>" data-id="<?php echo $k['no_kelas']; ?>">
                                                        <?php echo $k['nama_kelas']; ?>
                                                    </button>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<!-- ======================================================================================================= -->








<?php $this->load->view('admin/_partials/footer.php') ?>

<script>
$(document).ready(function() {
    var currentPage = 1; // Halaman saat ini
    var totalPages = 1; // Jumlah total halaman

    // Fungsi untuk mendapatkan data siswa berdasarkan halaman
    function getDataByPage(page) {
        var kelasId = $(".kelas.active").data("id");
        var perPage = $("#perpage").val(); // Ambil nilai dari dropdown
        var tahunAngkatan = $("#tahun_angkatan").val(); // Ambil nilai tahun angkatan dari dropdown

        $.ajax({
            url: "<?php echo base_url('admin/kelulusan/get_siswa_by_kelas'); ?>/" + kelasId + "?page=" + page + "&perpage=" + perPage + "&tahun_angkatan=" + tahunAngkatan,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.data.length > 0) {
                    var tableContent = "";
                    function formatDate(dateString) {
                        var date = new Date(dateString);
                        if (!isNaN(date.getTime())) {
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            var formattedDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;
                            return formattedDate;
                        } else {
                            return '';
                        }
                    }

                    $.each(response.data, function(index, siswa) {
                        var formattedTanggalLahir = siswa.tanggallahir ? formatDate(siswa.tanggallahir) : '';
                        var statusKelulusan = siswa.status_kelulusan == 1 ? "Lulus" : "Tidak Lulus";
                        var backgroundClass = siswa.status_kelulusan == 1 ? "bg-success" : "bg-danger";
                        var namaKelas = siswa.nama_kelas ? siswa.nama_kelas : '';
                        tableContent += "<tr class='" + backgroundClass + "'><td class='text-center'><input type='checkbox' name='siswa_checkbox' value='" + siswa.id_siswa + "'></td><td class='text-center'>" + siswa.nis + "</td><td>" + siswa.nama_siswa + "</td><td class='text-center'>" + siswa.nama_kelas + "</td><td class='text-center'>" + siswa.no_absen + "</td><td class='text-center'>" + siswa.tahun_angkatan +  "</td><td class='text-center'>" + statusKelulusan + "</td>" +
                            "<td class='text-center'>" +
                            "<a class='btn btn-warning btn-sm' href='<?php echo base_url('admin/siswa/cetak_suratketeranganlulus/'); ?>" + siswa.id_siswa + "' target='_blank'><i class='fas fa-print'></i></a>" +
                            "</td></tr>";
                    });

                    $("#siswa-data").html(tableContent);
                    currentPage = response.current_page;
                    totalPages = response.total_pages;
                    updatePagination();
                } else {
                    $("#siswa-data").html("<tr><td colspan='8' class='text-center'>Tidak ada data yang tersedia</td></tr>");
                    $("#pagination").html("");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Fungsi untuk memperbarui pagination
    function updatePagination() {
        var paginationHtml = "";
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHtml += "<li class='page-item active'><button class='page-link'>" + i + "</button></li>";
            } else {
                paginationHtml += "<li class='page-item'><button class='page-link'>" + i + "</button></li>";
            }
        }
        $("#pagination").html(paginationHtml);
    }

    // Tangani klik pada tombol kelas
    $(".kelas").click(function() {
        $(".kelas").removeClass("active");
        $(this).addClass("active");
        getDataByPage(1); // Ambil data untuk halaman pertama setiap kali tombol kelas diklik
    });

    // Tangani klik pada halaman pagination
    $(document).on("click", "#pagination .page-item", function() {
        var page = $(this).text();
        getDataByPage(page);
    });

    // Tangani perubahan dropdown perpage
    $(document).on("change", "#perpage", function() {
        getDataByPage(1); // Ambil data untuk halaman pertama setiap kali nilai dropdown diubah
    });

    // Tangani perubahan dropdown tahun angkatan
    $(document).on("change", "#tahun_angkatan", function() {
        getDataByPage(1); // Ambil data untuk halaman pertama setiap kali nilai dropdown diubah
    });

    $(document).on('change', '#select-all', function(){
        $('input[name="siswa_checkbox"]').prop('checked', $(this).prop('checked'));
    });

    $(document).on("change", "#tahun_angkatan", function() {
    getDataByYear(); // Panggil fungsi untuk mendapatkan data siswa berdasarkan tahun angkatan yang dipilih
});
});


</script>


<script>// Fungsi filter siswa lulus berdasarkan tahun angkatan
    function getDataByYear() {
    var kelasId = $(".kelas.active").data("id"); // Ambil ID kelas yang dipilih
    var tahunAngkatan = $("#tahun_angkatan").val(); // Ambil tahun angkatan yang dipilih dari dropdown

    $.ajax({
        url: "<?php echo base_url('admin/kelulusan/get_siswa_by_kelas'); ?>/" + kelasId + "?tahun_angkatan=" + tahunAngkatan,
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Perbarui tabel dengan data siswa yang diperoleh dari server
            if (response.data.length > 0) {
                // kode untuk memperbarui tabel
            } else {
                // kode untuk menampilkan pesan jika tidak ada data
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

</script>


<script>
    $(document).ready(function() {
        // Ketika nilai dropdown status kelulusan berubah
        $("#new_status").change(function() {
            // Aktifkan tombol update jika nilai dropdown telah dipilih
            if ($(this).val() !== "") {
                $("#update-status").prop("disabled", false);
            } else {
                // Nonaktifkan tombol update jika tidak ada nilai yang dipilih
                $("#update-status").prop("disabled", true);
            }
        });

        // Fungsi untuk mengupdate status kelulusan siswa yang dipilih
        $("#update-status").click(function() {
            var selectedSiswa = []; // Array untuk menyimpan ID siswa yang dipilih
            var newStatus = $("#new_status").val(); // Ambil status kelulusan baru yang dipilih

            // Loop melalui semua checkbox siswa dan tambahkan ke dalam array jika dicentang
            $("input[name='siswa_checkbox']:checked").each(function() {
                selectedSiswa.push($(this).val());
            });

            // Kirim data siswa yang dipilih beserta status kelulusan baru yang ingin di-update ke server
            $.ajax({
                url: "<?php echo base_url('admin/kelulusan/update_status_kelulusan'); ?>",
                type: "POST",
                data: {
                    siswa_ids: selectedSiswa, // ID siswa yang dipilih
                    new_status: newStatus // Status kelulusan baru yang ingin di-update
                },
                dataType: "json",
                success: function(response) {
                    // Tampilkan pesan sukses atau gagal sesuai respons dari server
                    if (response.success) {
                        // Menampilkan jumlah data yang diupdate pada toast
                        var count = response.updated_count;
                        toastr.success('Berhasil mengupdate ' + count + ' status kelulusan siswa.');
                        // Refresh halaman setelah update selesai
                        location.reload();
                    } else {
                        // Tampilkan notifikasi gagal
                        toastr.error('Gagal mengupdate status kelulusan siswa.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Tampilkan notifikasi toast gagal karena kesalahan dalam koneksi Ajax
                    toastr.error('Terjadi kesalahan saat memperbarui status kelulusan siswa.');
                }
            });
        });
    });
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






