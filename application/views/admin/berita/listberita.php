<html lang="en">

<head>

    <?php $this->load->view('admin/_partials/head.php') ?>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            margin-right: 5px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
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
            <div class="content-wrapper">
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
                                <h3 class="card-title"><i class="fa-regular fa-newspaper"></i> List Pos Berita </h3>
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#tambahkelasModal">
                                    <i class="fa-solid fa-pencil"></i> Berita
                                </button>
                            </div>
                        </div>
                        <div class="card-body">


                            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Judul Berita</th>
                                        <th>Penulis</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listberita as $index => $berita) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $index + 1; ?></td>
                                            <td class="text-center"><?php echo $berita['judul_berita']; ?></td>
                                            <td class="text-center"><?php echo $berita['penulis_berita']; ?></td>
                                            <td class="text-center"><?php echo date('d-m-Y H:i:s', strtotime($berita['tanggal_berita'])); ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#beritaModal<?php echo $berita['id_berita']; ?>"><i class="fas fa-eye"></i></button>
                                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteBerita(<?php echo $berita['id_berita']; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus Berita">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="beritaModal<?php echo $berita['id_berita']; ?>" tabindex="-1" role="dialog" aria-labelledby="beritaModalLabel<?php echo $berita['id_berita']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="beritaModalLabel<?php echo $berita['id_berita']; ?>"><?php echo $berita['judul_berita']; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card">
                                                            <img src="<?php echo base_url() ?>upload/berita/<?php echo $berita['gambar_berita']; ?>" class="card-img-top" alt="Gambar Berita">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $berita['judul_berita']; ?></h5>
                                                                <p class="card-text"><?php echo htmlspecialchars_decode($berita['isi_berita']); ?></p>
                                                                <p class="card-text"><small class="text-muted">Ditulis oleh <?php echo $berita['penulis_berita']; ?> pada <?php echo date('d-m-Y', strtotime($berita['tanggal_berita'])); ?></small></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

            <!-- Modal Tambah Berita -->
            <div class="modal fade" id="tambahkelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Berita</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: flex; align-items: flex-start;">
                                <div style="flex: 2; margin-right: 20px;">
                                    <form action="<?php echo site_url('admin/berita/simpan_berita'); ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="judul_berita">Judul Berita</label>
                                            <input type="text" class="form-control" id="judul_berita" name="judul_berita" required>
                                            <input type="hidden" class="form-control" id="tanggal_berita" name="tanggal_berita" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                                            <input type="hidden" id="penulis_berita" name="penulis_berita" value="<?php echo $current_user->name ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="isi_berita">Isi Berita</label>
                                            <div id="editor-container" style="height: 300px;"></div>
                                            <textarea id="isi_berita" name="isi_berita" style="display: none;"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="gambar_berita">Upload Gambar</label>
                                            <div id="drop_zone" class="form-control text-center" style="border: 2px dashed #ccc; padding: 20px; cursor: pointer;">
                                                Drag & Drop file here or click to upload
                                            </div>
                                            <input type="file" class="form-control" id="gambar_berita" name="gambar_berita" required style="display: none;">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </form>
                                </div>

                                <div style="flex: 1;">
                                    <!-- Preview Gambar -->
                                    <div id="preview_container" style="margin-top: 20px; text-align: center; border: 1px solid #ccc; padding: 10px;">
                                        <img id="preview_image" src="<?= base_url('/assets/material/placeholderupload.jpg'); ?>" alt="Image Preview" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                        <!-- Ganti 'placeholder.jpg' dengan path gambar placeholder Anda -->
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>








            <?php $this->load->view('admin/_partials/footer.php') ?>



            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    const dropZone = document.getElementById('drop_zone');
                    const fileInput = document.getElementById('gambar_berita');
                    const previewContainer = document.getElementById('preview_container');
                    const previewImage = document.getElementById('preview_image');

                    // Handle dragover and dragleave events
                    dropZone.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.style.borderColor = '#000';
                        dropZone.style.backgroundColor = '#f9f9f9';
                    });

                    dropZone.addEventListener('dragleave', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.style.borderColor = '#ccc';
                        dropZone.style.backgroundColor = '#fff';
                    });

                    // Handle drop event
                    dropZone.addEventListener('drop', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.style.borderColor = '#ccc';
                        dropZone.style.backgroundColor = '#fff';
                        const files = e.dataTransfer.files;
                        if (files.length > 0) {
                            fileInput.files = files; // Assign dropped files to input element
                            displayFileName(files[0].name);
                            showImagePreview(files[0]);
                        }
                    });

                    // Handle click event on drop zone to trigger file input click
                    dropZone.addEventListener('click', () => {
                        fileInput.click();
                    });

                    // Handle file input change event
                    fileInput.addEventListener('change', (e) => {
                        if (fileInput.files.length > 0) {
                            displayFileName(fileInput.files[0].name);
                            showImagePreview(fileInput.files[0]);
                        }
                    });

                    // Function to display file name in drop zone
                    function displayFileName(fileName) {
                        dropZone.textContent = fileName;
                    }

                    // Function to show image preview
                    function showImagePreview(file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>

            <!-- CK EDITOR -->
            <script>
                function deleteBerita(beritaId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Berita ini akan terhapus permanen !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/admin/berita/hapus_berita/'); ?>" + beritaId;
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