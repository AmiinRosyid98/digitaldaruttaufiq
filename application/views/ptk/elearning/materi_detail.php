<html lang="en">

<head>
    <?php $this->load->view('ptk/_partials/head.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $info_message = $this->session->flashdata('info_message');
    ?>

    <div class="wrapper">

        <?php $this->load->view('ptk/_partials/navbar.php') ?>

        <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>
            <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>
        </aside>

        <div class="content-wrapper" style="min-height: 1000px;">
            <div class="content-header">
                <div class="container-fluid">
                    <h4 class="mb-2">Detail Materi</h4>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($materi->judul_materi) ?></h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Kelas:</strong> <?= htmlspecialchars($materi->nama_kelas) ?> | <strong>Mapel:</strong> <?= htmlspecialchars($materi->nama_mapel) ?></p>
                            <p><strong>Tanggal dibuat:</strong> <?= date('d M Y', strtotime($materi->tanggal_dibuat)) ?></p>
                            <p><strong>Deskripsi: </strong><?= nl2br(htmlspecialchars($materi->deskripsi)) ?></p>

                            <?php if (!empty($materi->file_materi)) : ?>
                                <hr>
                                <p><strong>Lampiran File:</strong></p>
                                <a href="<?= base_url('upload/materi/' . $materi->file_materi) ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-file-download"></i> Unduh File
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($materi->link_google_drive)) : ?>
                                <hr>
                                <p><strong>Preview Google Drive:</strong></p>
                                <!-- Tombol untuk buka modal -->
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#previewGoogleDriveModal">
                                    <i class="fas fa-eye"></i> Preview
                                </button>

                                <!-- Modal Preview Google Drive -->
                                <div class="modal fade" id="previewGoogleDriveModal" tabindex="-1" role="dialog" aria-labelledby="previewGoogleDriveLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 90vw;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewGoogleDriveLabel">Preview Google Drive - <?= htmlspecialchars($materi->judul_materi) ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="height: 80vh;">
                                                <iframe src="<?= htmlspecialchars($materi->link_google_drive) ?>" frameborder="0" style="width: 100%; height: 100%;" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="card mt-3">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-tasks"></i> Tugas Terkait</span>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalTambahTugas">
                                <i class="fas fa-plus-circle"></i> Tambah Tugas
                            </button>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($tugas)) : ?>
                                <ul class="list-group mb-3">
                                    <?php foreach ($tugas as $t) : ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <strong><?= $t->judul_tugas ?></strong><br>
                                                Deadline: <?= date('d M Y', strtotime($t->tanggal_deadline)) ?><br>
                                                <?= $t->deskripsi ?>
                                                <?php if ($t->lampiran) : ?>
                                                    <br><a href="<?= base_url('upload/tugas/' . $t->lampiran) ?>" target="_blank">Lihat / Download Lampiran</a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="d-flex flex-column align-items-end">
                                                <a href="#" class="btn btn-sm btn-danger mb-1 btn-hapus-tugas" data-id="<?= $t->id_tugas ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>

                                                <!-- Tombol Modal Lihat Pengumpulan -->
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalSiswaMengerjakan<?= $t->id_tugas ?>">
                                                    <i class="fas fa-users"></i>
                                                </button>
                                            </div>
                                        </li>


                                        <!-- Modal Siswa Mengerjakan -->
                                        <div class="modal fade" id="modalSiswaMengerjakan<?= $t->id_tugas ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabelSiswa<?= $t->id_tugas ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title" id="modalLabelSiswa<?= $t->id_tugas ?>">Siswa yang Mengumpulkan - <?= htmlspecialchars($t->judul_tugas) ?></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No Absen</th>
                                                                    <th>Nama Siswa</th>
                                                                    <?php if (strtolower($t->jenis_tugas) == 'pg') : ?>
                                                                        <th class="text-center">Nilai PG</th>
                                                                    <?php else : ?>
                                                                        <th>File</th>
                                                                        <th>Jawaban</th>
                                                                        <th>Status</th>
                                                                        <th>Nilai</th>
                                                                        <th>Beri Nilai</th>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $pengumpulan = array_filter($siswa_mengerjakan, function ($item) use ($t) {
                                                                    return $item->id_tugas == $t->id_tugas;
                                                                });
                                                                ?>
                                                                <?php if (!empty($pengumpulan)) : ?>
                                                                    <?php foreach ($pengumpulan as $s) : ?>
                                                                        <tr>
                                                                            <td class="text-center"><?= htmlspecialchars($s->no_absen) ?></td>
                                                                            <td><?= htmlspecialchars($s->nama_siswa) ?></td>

                                                                            <?php if (strtolower($t->jenis_tugas) == 'pg') : ?>
                                                                                <td class="text-center">
                                                                                    <?= isset($t->nilai_pg[$s->id_siswa]) ? $t->nilai_pg[$s->id_siswa] . '' : '0' ?>
                                                                                </td>
                                                                            <?php else : ?>
                                                                                <td>
                                                                                    <?php if ($s->file_jawaban) : ?>
                                                                                        <a href="<?= base_url('upload/jawaban/' . $s->file_jawaban) ?>" target="_blank" class="btn btn-sm btn-success">
                                                                                            <i class="fas fa-download"></i> Lihat
                                                                                        </a>
                                                                                    <?php else : ?>
                                                                                        <span class="text-muted">-</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if (!empty($s->isi_jawaban)) : ?>
                                                                                        <!-- Tombol untuk membuka modal -->
                                                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalJawaban_<?= $s->id_siswa ?>">
                                                                                            <i class="fas fa-eye"></i> Lihat Jawaban
                                                                                        </button>
                                                                                    <?php else : ?>
                                                                                        <span class="text-muted">-</span>
                                                                                    <?php endif; ?>
                                                                                </td>

                                                                                <td>
                                                                                    <?php if (!empty($s->tanggal_upload)) : ?>
                                                                                        <?= date('d M Y H:i', strtotime($s->tanggal_upload)) ?>
                                                                                    <?php else : ?>
                                                                                        <span class="text-muted">-</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td class="text-center kolom-nilai">
                                                                                    <?php if (isset($s->nilai_essay) && $s->nilai_essay !== null) : ?>
                                                                                        <strong><?= $s->nilai_essay ?></strong>
                                                                                    <?php else : ?>
                                                                                        <em>-</em>
                                                                                    <?php endif; ?>
                                                                                </td>

                                                                                <td>
                                                                                    <?php if (!empty($s->file_jawaban) || !empty($s->isi_jawaban)) : ?>
                                                                                        <form action="<?= base_url('ptk/materi/beri_nilai_essay') ?>" method="post" class="form-nilai-essay">
                                                                                            <input type="hidden" name="id_tugas" value="<?= $t->id_tugas ?>">
                                                                                            <input type="hidden" name="id_siswa" value="<?= $s->id_siswa ?>">
                                                                                            <div class="input-group input-group-sm">
                                                                                                <input type="number" name="nilai_essay" class="form-control input-nilai" value="<?= htmlspecialchars($s->nilai_essay ?? '') ?>" placeholder="0-100" min="0" max="100" required>
                                                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                                                                                            </div>
                                                                                        </form>
                                                                                        <div class="text-success small mt-1 status-nilai" style="display: none;"></div>

                                                                                    <?php else : ?>
                                                                                        <span class="text-muted">-</span>
                                                                                    <?php endif; ?>
                                                                                </td>

                                                                            <?php endif; ?>
                                                                        </tr>

                                                                        <?php if (!empty($s->isi_jawaban)) : ?>
                                                                            <div class="modal fade" id="modalJawaban_<?= $s->id_siswa ?>" tabindex="-1" role="dialog" aria-labelledby="modalJawabanLabel_<?= $s->id_siswa ?>" aria-hidden="true">
                                                                                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header bg-primary text-white">
                                                                                            <h5 class="modal-title" id="modalJawabanLabel_<?= $s->id_siswa ?>">Jawaban Tertulis - <?= htmlspecialchars($s->nama_siswa) ?></h5>
                                                                                        </div>

                                                                                        <div class="modal-body" style="white-space: pre-wrap;">
                                                                                            <?= nl2br(htmlspecialchars($s->isi_jawaban)) ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="<?= strtolower($t->jenis_tugas) == 'pg' ? '3' : '4' ?>" class="text-center text-muted">Belum ada siswa yang mengumpulkan tugas ini.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p>Tidak ada tugas untuk materi ini.</p>
                            <?php endif; ?>

                        </div>




                        <!-- Modal Tambah Tugas -->
                        <div class="modal fade" id="modalTambahTugas" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Tambah Tugas Baru</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="<?= base_url('ptk/materi/simpan_tugas') ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <!-- Bagian informasi dasar tugas -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Judul Tugas</label>
                                                        <input type="text" name="judul_tugas" class="form-control" required>
                                                        <input type="hidden" name="id_materi" value="<?= $materi->id_materi ?>">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Jenis Tugas</label>
                                                        <select name="jenis_tugas" class="form-control select2" id="jenisTugas" required>
                                                            <option value="">Pilih Jenis Tugas</option>
                                                            <option value="Essay">Essay</option>
                                                            <option value="PG">Pilihan Ganda</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tampilan dinamis berdasarkan jenis tugas -->
                                            <div id="dynamicFields">
                                                <!-- Konten akan diisi oleh JavaScript -->
                                            </div>

                                            <!-- Bagian deadline dan lampiran -->
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Tanggal Deadline</label>
                                                        <input type="datetime-local" name="tanggal_deadline" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Lampiran (opsional)</label>
                                                        <div class="custom-file">
                                                            <input type="file" name="lampiran" class="custom-file-input" id="customFile">
                                                            <label class="custom-file-label" for="customFile">Pilih file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Tugas</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <?php $this->load->view('ptk/_partials/footer.php') ?>
    </div>
    <script>
        $(document).ready(function() {
            $('.form-nilai-essay').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var statusBox = form.next('.status-nilai');
                var nilaiInput = form.find('input[name="nilai_essay"]').val();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        try {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                // Tampilkan status berhasil
                                statusBox
                                    .text('Disimpan ✅')
                                    .removeClass('text-danger')
                                    .addClass('text-success')
                                    .fadeIn()
                                    .delay(2000)
                                    .fadeOut();

                                // Update nilai di kolom sebelumnya (td.kolom-nilai)
                                form.closest('tr').find('.kolom-nilai')
                                    .html('<strong>' + nilaiInput + '</strong>');
                            } else {
                                statusBox
                                    .text('Gagal menyimpan ❌')
                                    .removeClass('text-success')
                                    .addClass('text-danger')
                                    .fadeIn()
                                    .delay(2000)
                                    .fadeOut();
                            }
                        } catch (e) {
                            console.error('Invalid JSON:', response);
                        }
                    },
                    error: function() {
                        statusBox
                            .text('Terjadi kesalahan saat menyimpan ❌')
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .fadeIn()
                            .delay(2000)
                            .fadeOut();
                    }
                });
            });
        });
    </script>



    <script>
        // Template untuk soal Essay
        const essayTemplate = `
    <div class="form-group">
        <label class="font-weight-bold">Deskripsi Tugas</label>
        <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan instruksi tugas disini..."></textarea>
    </div>
`;

        // Template untuk soal Pilihan Ganda
        const pgTemplate = `
    <div id="soalPGContainer">
        <div class="card mb-3 soal-item">
            <div class="card-header bg-light">
                <h6 class="mb-0">Soal Pilihan Ganda #1</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Pertanyaan</label>
                    <textarea name="soal_pg[]" class="form-control" rows="3" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jawaban A</label>
                            <input type="text" name="jawaban_a[]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jawaban B</label>
                            <input type="text" name="jawaban_b[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jawaban C</label>
                            <input type="text" name="jawaban_c[]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jawaban D</label>
                            <input type="text" name="jawaban_d[]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jawaban Benar</label>
                    <select name="jawaban_benar[]" class="form-control" required>
                        <option value="">Pilih Jawaban Benar</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-sm btn-danger btn-remove-soal" style="display:none;">
                    <i class="fas fa-trash"></i> Hapus Soal
                </button>
            </div>
        </div>
        <button type="button" class="btn btn-success mb-3" id="btnTambahSoal">
            <i class="fas fa-plus"></i> Tambah Soal
        </button>
    </div>
`;

        // Event handler untuk perubahan jenis tugas
        document.getElementById('jenisTugas').addEventListener('change', function() {
            const dynamicFields = document.getElementById('dynamicFields');

            if (this.value === 'Essay') {
                dynamicFields.innerHTML = essayTemplate;
            } else if (this.value === 'PG') {
                dynamicFields.innerHTML = pgTemplate;
                initPGFunctionality();
            } else {
                dynamicFields.innerHTML = '<div class="alert alert-info">Pilih jenis tugas terlebih dahulu</div>';
            }
        });

        // Fungsi untuk inisialisasi fungsi PG
        function initPGFunctionality() {
            let soalCounter = 1;

            // Tambah soal baru
            document.getElementById('btnTambahSoal').addEventListener('click', function() {
                soalCounter++;
                const container = document.getElementById('soalPGContainer');
                const newSoal = container.querySelector('.soal-item').cloneNode(true);

                // Update nomor soal
                newSoal.querySelector('.card-header h6').textContent = `Soal Pilihan Ganda #${soalCounter}`;

                // Kosongkan input
                const inputs = newSoal.querySelectorAll('input, textarea, select');
                inputs.forEach(input => input.value = '');

                // Tampilkan tombol hapus
                newSoal.querySelector('.btn-remove-soal').style.display = 'block';

                // Sisipkan sebelum tombol tambah
                container.insertBefore(newSoal, this);
            });

            // Hapus soal
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-soal')) {
                    if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                        e.target.closest('.soal-item').remove();
                        // Update nomor soal
                        updateSoalNumbers();
                    }
                }
            });

            function updateSoalNumbers() {
                const soalItems = document.querySelectorAll('.soal-item');
                soalItems.forEach((item, index) => {
                    item.querySelector('.card-header h6').textContent = `Soal Pilihan Ganda #${index + 1}`;
                    // Sembunyikan tombol hapus untuk soal pertama
                    if (index === 0) {
                        item.querySelector('.btn-remove-soal').style.display = 'none';
                    }
                });
                soalCounter = soalItems.length;
            }
        }
    </script>

    <!-- Script Notifikasi Toast -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-hapus-tugas');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const idTugas = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Yakin ingin menghapus tugas ini?',
                        text: "Semua Data yang dihapus termasuk nilai siswa di tugas ini tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect ke url hapus tugas
                            window.location.href = "<?= base_url('ptk/materi/hapus_tugas/') ?>" + idTugas;
                        }
                    });
                });
            });
        });
    </script>