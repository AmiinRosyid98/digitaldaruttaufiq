<html lang="en">

<head>

    <?php $this->load->view('admin/_partials/head.php') ?>
    <style>
        .list-group-item.active {
            background-color: #dc3545;
            /* Ganti dengan warna yang Anda inginkan */
            color: #fff;
            /* Warna teks untuk tombol yang aktif */
            border-color: #dc3545;
            /* Warna border untuk tombol yang aktif */
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
                                                    <th>Absen</th>
                                                    <th>Tempat</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Tahun Angkatan</th>
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

                            <!-- Tambahkan daftar kelas -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Pilih Data Rombongan Belajar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group text-center">
                                        <div class="row">
                                            <?php foreach ($kelas as $k) : ?>
                                                <?php
                                                // Mengecek apakah kelas memiliki data siswa atau tidak
                                                $class_color = $this->Rombel_Model->count_siswa_by_kelas($k['no_kelas']) > 0 ? 'bg-success' : 'bg-danger';
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

                            <div class="card" style="background-image: url('<?php echo base_url('assets/png_hak2s1_5879.png'); ?>'); background-size: 100%;">
                                <div class="card-body ">
                                    <div class="form-group">
                                        <label for="new_kelas_id">Naikkan Ke Kelas</label>
                                        <select class="form-control" id="new_kelas_id">
                                            <!-- Isi dropdown dengan opsi kelas -->
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?php echo $k['no_kelas']; ?>"><?php echo $k['nama_kelas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Tambahkan tombol untuk memperbarui kelas (nonaktif secara default) -->
                                    <button class="btn btn-success btn-block" id="update-kelas" disabled>Update Kelas</button>
                                </div>
                            </div>

                            <div class="card" style="background-image: url('<?php echo base_url('assets/hero_rectangle_3.png'); ?>'); background-size: 100% 100%;">
                                <div class="card-body">
                                    <!-- Tambahkan dropdown untuk memilih status kelulusan baru -->
                                    <div class="form-group">
                                        <label for="new_status">Ubah Status Siswa</label>
                                        <select class="form-control" id="new_status">
                                            <option value="0">Aktif Belajar</option>
                                            <option value="1">Lulus</option>
                                            <option value="2">Tidak Lulus</option>
                                        </select>
                                    </div>

                                    <!-- Tambahkan tombol untuk memperbarui status kelulusan -->
                                    <button class="btn btn-info btn-block" id="update-status" disabled>Update Status Kelulusan</button>
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

                        $.ajax({
                            url: "<?php echo base_url('admin/rombel/get_siswa_by_kelas'); ?>/" + kelasId + "?page=" + page + "&perpage=" + perPage,
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
                                        tableContent += "<tr><td class='text-center'><input type='checkbox' name='siswa_checkbox' value='" + siswa.id_siswa + "'></td><td>" + siswa.nis + "</td><td>" + siswa.nama_siswa + "</td><td class='text-center'>" + siswa.nama_kelas + "</td><td class='text-center'>" + siswa.no_absen + "</td><td class='text-center'>" + siswa.tempatlahir + "</td><td class='text-center'>" + formattedTanggalLahir + "</td><td class='text-center'>" + siswa.tahun_angkatan + "</td>" +
                                            "<td class='text-center'>" +
                                            "<a class='btn btn-primary btn-sm' href='" + "<?php echo base_url('admin/siswa/detailsiswa/'); ?>" + siswa.id_siswa + "'><i class='fas fa-user-graduate'></i></a>" +
                                            "</td></tr>";
                                    });

                                    $("#siswa-data").html(tableContent);
                                    currentPage = response.current_page;
                                    totalPages = response.total_pages;
                                    updatePagination();
                                } else {
                                    // Jika tidak ada data yang tersedia, tampilkan pesan informasi
                                    $("#siswa-data").html("<tr><td colspan='9' class='text-center'>Tidak ada data yang tersedia</td></tr>");
                                    $("#pagination").html(""); // Kosongkan pagination
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

                    $(document).on('change', '#select-all', function() {
                        $('input[name="siswa_checkbox"]').prop('checked', $(this).prop('checked'));
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    // Fungsi untuk mengupdate kode_kelas siswa yang dipilih
                    $("#update-kelas").click(function() {
                        var selectedSiswa = []; // Array untuk menyimpan ID siswa yang dipilih
                        var newKelasId = $("#new_kelas_id").val(); // Ambil ID kelas baru yang dipilih

                        // Loop melalui semua checkbox siswa dan tambahkan ke dalam array jika dicentang
                        $("input[name='siswa_checkbox']:checked").each(function() {
                            selectedSiswa.push($(this).val());
                        });

                        // Kirim data siswa yang dipilih beserta kelas baru yang ingin di-update ke server
                        $.ajax({
                            url: "<?php echo base_url('admin/rombel/update_kode_kelas'); ?>",
                            type: "POST",
                            data: {
                                siswa_ids: selectedSiswa, // ID siswa yang dipilih
                                new_kelas_id: newKelasId // ID kelas baru yang ingin di-update
                            },
                            dataType: "json",
                            success: function(response) {
                                // Tampilkan pesan sukses atau gagal sesuai respons dari server
                                if (response.success) {
                                    // Menampilkan jumlah data yang diupdate pada toast
                                    var count = response.updated_count;
                                    toastr.success('Berhasil mengupdate ' + count + ' data siswa.');
                                    // Refresh halaman setelah update selesai
                                    location.reload();
                                } else {
                                    // Tampilkan notifikasi gagal
                                    toastr.error('Gagal mengupdate kelas siswa.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                // Tampilkan notifikasi toast gagal karena kesalahan dalam koneksi Ajax
                                toastr.error('Terjadi kesalahan saat memperbarui kelas siswa.');
                            }
                        });
                    });
                });
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
                            url: "<?php echo base_url('admin/rombel/update_status_kelulusan'); ?>",
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
                $(document).ready(function() {
                    // Fungsi untuk memperbarui status tombol "Update Kelas" berdasarkan pilihan kelas baru
                    $("#new_kelas_id").change(function() {
                        var selectedKelas = $(this).val(); // Ambil nilai kelas yang dipilih
                        if (selectedKelas) {
                            $("#update-kelas").prop("disabled", false); // Aktifkan tombol jika kelas dipilih
                        } else {
                            $("#update-kelas").prop("disabled", true); // Nonaktifkan tombol jika tidak ada kelas yang dipilih
                        }
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