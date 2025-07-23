<html lang="en">

<head>
    <?php $this->load->view('siswa/_partials/head.php') ?>
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blink {
            animation: blink 3s infinite;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php $this->load->view('siswa/_partials/navbar.php') ?>
        <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
            <?php $this->load->view('siswa/_partials/sidebar_information.php') ?>
            <?php $this->load->view('siswa/_partials/sidebar_menu.php') ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1200px;">
            <div class="content">
                <div class="card m-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa-solid fa-book-open-reader"></i> Tugas</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><?= nl2br(htmlspecialchars($tugas['deskripsi'])) ?></p>
                        <p>Deadline: <strong><?= date('d M Y', strtotime($tugas['tanggal_deadline'])) ?></strong></p>

                        <?php if (!empty($tugas['lampiran'])): ?>
                            <p>Lampiran:
                                <a href="<?= base_url('upload/tugas/' . $tugas['lampiran']) ?>" target="_blank">
                                    <?= $tugas['lampiran'] ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('message') ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($tugas['jenis_tugas'] === 'pg'): ?>
                            <h5>Soal Pilihan Ganda</h5>

                            <?php if (!empty($soal_pg)): ?>
                                <?php if ($sudah_terkirim): ?>
                                    <!-- Tampilan hasil setelah mengerjakan -->
                                    <div class="alert alert-info">
                                        <h5>Hasil Nilai Anda</h5>
                                        <p>
                                            Jawaban benar: <?= $jawaban_benar ?> dari <?= $total_soal ?> soal<br>
                                            Nilai: <?= number_format($nilai, 2) ?>
                                        </p>
                                    </div>

                                    <?php foreach ($soal_pg as $index => $soal): ?>
                                        <div class="mb-4 p-3 border rounded">
                                            <label class="form-label fw-bold"><?= "Soal " . ($index + 1) . ": " . htmlspecialchars($soal['soal']) ?></label>

                                            <?php
                                            $jawaban_siswa = $jawaban_pg[$soal['id_soal']] ?? null;
                                            $is_benar = ($jawaban_siswa === $soal['jawaban_benar']);
                                            ?>

                                            <?php foreach (['A', 'B', 'C', 'D'] as $huruf): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" disabled
                                                        <?= ($jawaban_siswa === $huruf) ? 'checked' : '' ?>>
                                                    <label class="form-check-label 
                                <?= ($jawaban_siswa === $huruf) ? ($is_benar ? 'text-success fw-bold' : 'text-danger fw-bold') : '' ?>
                                <?= ($soal['jawaban_benar'] === $huruf) ? 'text-decoration-underline' : '' ?>">
                                                        <?= $huruf . '. ' . htmlspecialchars($soal['jawaban_' . strtolower($huruf)]) ?>
                                                        <?= ($soal['jawaban_benar'] === $huruf) ? ' (Kunci Jawaban)' : '' ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>

                                            <div class="mt-2">
                                                <?php if ($jawaban_siswa): ?>
                                                    <span class="badge bg-<?= $is_benar ? 'success' : 'danger' ?>">
                                                        Jawaban Anda: <?= $jawaban_siswa ?>
                                                        (<?= $is_benar ? 'Benar' : 'Salah' ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Anda tidak menjawab soal ini</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <!-- Form untuk mengerjakan soal satu per satu -->
                                    <form id="quizForm" action="<?= base_url('siswa/elearning/simpan_jawaban') ?>" method="post">
                                        <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">

                                        <!-- Progress indicator -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Progress:</span>
                                                <span><span id="currentQuestion">1</span>/<?= count($soal_pg) ?></span>
                                            </div>
                                            <div class="progress">
                                                <div id="progressBar" class="progress-bar" role="progressbar"
                                                    style="width: <?= 100 / count($soal_pg) ?>%"></div>
                                            </div>
                                        </div>

                                        <!-- Soal akan ditampilkan satu per satu di sini -->
                                        <?php foreach ($soal_pg as $index => $soal): ?>
                                            <div class="question-container mb-4 p-3 border rounded <?= $index === 0 ? '' : 'd-none' ?>"
                                                id="question-<?= $index ?>">
                                                <label class="form-label fw-bold"><?= "Soal " . ($index + 1) . ": " . htmlspecialchars($soal['soal']) ?></label>

                                                <?php foreach (['A', 'B', 'C', 'D'] as $huruf): ?>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban_<?= $soal['id_soal'] ?>"
                                                            value="<?= $huruf ?>"
                                                            id="soal_<?= $index ?>_<?= $huruf ?>"
                                                            <?= (isset($jawaban_pg[$soal['id_soal']]) && $jawaban_pg[$soal['id_soal']] === $huruf) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="soal_<?= $index ?>_<?= $huruf ?>">
                                                            <?= $huruf . '. ' . htmlspecialchars($soal['jawaban_' . strtolower($huruf)]) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Navigation buttons -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Sebelumnya</button>
                                            <button type="button" class="btn btn-primary" id="nextBtn">Berikutnya</button>
                                            <button type="submit" class="btn btn-success d-none" id="submitBtn">Kirim Jawaban</button>
                                        </div>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const questions = document.querySelectorAll('.question-container');
                                            const prevBtn = document.getElementById('prevBtn');
                                            const nextBtn = document.getElementById('nextBtn');
                                            const submitBtn = document.getElementById('submitBtn');
                                            const currentQuestionEl = document.getElementById('currentQuestion');
                                            const progressBar = document.getElementById('progressBar');

                                            let currentQuestion = 0;
                                            const totalQuestions = questions.length;

                                            // Update navigation buttons
                                            function updateButtons() {
                                                prevBtn.disabled = currentQuestion === 0;

                                                if (currentQuestion === totalQuestions - 1) {
                                                    nextBtn.classList.add('d-none');
                                                    submitBtn.classList.remove('d-none');
                                                } else {
                                                    nextBtn.classList.remove('d-none');
                                                    submitBtn.classList.add('d-none');
                                                }

                                                currentQuestionEl.textContent = currentQuestion + 1;
                                                progressBar.style.width = `${((currentQuestion + 1) / totalQuestions) * 100}%`;
                                            }

                                            // Show current question
                                            function showQuestion(index) {
                                                questions.forEach((question, i) => {
                                                    question.classList.toggle('d-none', i !== index);
                                                });
                                                updateButtons();
                                            }

                                            // Next button click
                                            nextBtn.addEventListener('click', function() {
                                                if (currentQuestion < totalQuestions - 1) {
                                                    currentQuestion++;
                                                    showQuestion(currentQuestion);
                                                }
                                            });

                                            // Previous button click
                                            prevBtn.addEventListener('click', function() {
                                                if (currentQuestion > 0) {
                                                    currentQuestion--;
                                                    showQuestion(currentQuestion);
                                                }
                                            });

                                            // Initialize
                                            showQuestion(0);
                                        });
                                    </script>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Soal pilihan ganda tidak tersedia.</p>
                            <?php endif; ?>
                        <?php elseif ($tugas['jenis_tugas'] === 'essay'): ?>
                            <h5>Upload Jawaban</h5>
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                            <?php endif; ?>

                            <?php if ($sudah_terkirim): ?>
                                <div class="alert alert-info">
                                    Jawaban Anda sudah terkirim dan tidak dapat diubah lagi.
                                    <?php if ($jawaban): ?>
                                        <br><small style="color: yellow;" class="text-bold">Tanggal Upload: <?= date('d-m-Y H:i:s', strtotime($jawaban['tanggal_upload'])) ?></small>
                                    <?php endif; ?>
                                </div>

                                <?php if ($jawaban): ?>
                                    <p>Jawaban yang sudah diupload:
                                        <a href="<?= base_url('upload/jawaban/' . $jawaban['file_jawaban']) ?>" target="_blank">
                                            <?= $jawaban['file_jawaban'] ?>
                                        </a>
                                    </p>
                                    <p><strong>Penilaian Guru:</strong>
                                        <?php if (!is_null($jawaban['nilai_essay'])): ?>
                                            <span class="badge bg-success"><?= $jawaban['nilai_essay'] ?></span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <blink>Sedang dikoreksi guru</blink>
                                            </span>
                                        <?php endif; ?>
                                    </p> <?php endif; ?>
                            <?php else: ?>
                                <form action="<?= base_url('siswa/elearning/upload_jawaban') ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">

                                    <!-- Textarea untuk menulis jawaban langsung -->
                                    <div class="mb-3">
                                        <label for="isi_jawaban" class="form-label">Tulis Jawaban Anda (opsional)</label>
                                        <textarea name="isi_jawaban" id="isi_jawaban" class="form-control" rows="6" placeholder="Tulis jawaban essay di sini jika tidak ingin upload file..."></textarea>
                                    </div>

                                    <!-- Upload file (opsional) -->
                                    <div class="mb-3">
                                        <label for="file_jawaban" class="form-label">Upload File Jawaban (opsional)</label>
                                        <input type="file" name="file_jawaban" class="form-control">
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Kirim Jawaban
                                    </button>
                                </form>

                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('siswa/_partials/footer.php') ?>

    </div>