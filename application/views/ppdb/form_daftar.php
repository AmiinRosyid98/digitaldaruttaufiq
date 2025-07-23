<div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-gradient-primary text-white rounded-top-4 py-4">
        <h3 class="mb-0 text-center fw-bold">FORMULIR PENDAFTARAN PPDB</h3>
    </div>
    <div class="card-body p-5">
        <form action="<?= site_url('landing/proses_daftar') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <!-- Section 1: Jalur Pendaftaran -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">1</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Pilihan Jalur Pendaftaran</h5>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="jalur_id" class="form-select <?= form_error('jalur_id') ? 'is-invalid' : '' ?>" id="jalurPendaftaran" required>
                                <option value="">Pilih Jalur Pendaftaran</option>
                                <?php foreach ($jalur as $j): ?>
                                    <option value="<?= $j->id ?>" <?= set_select('jalur_id', $j->id) ?>><?= $j->nama_jalur ?> (Kuota: <?= $j->persentase_kuota ?>%)</option>
                                <?php endforeach; ?>
                            </select>
                            <label for="jalurPendaftaran" class="form-label">Jalur Pendaftaran</label>
                            <div class="invalid-feedback"><?= form_error('jalur_id') ? form_error('jalur_id') : 'Harap pilih jalur pendaftaran' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Biodata Pendaftar -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">2</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Biodata Pendaftar</h5>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="nik" class="form-control <?= form_error('nik') ? 'is-invalid' : '' ?>" id="nik" placeholder="NIK" value="<?= set_value('nik') ?>" required>
                            <label for="nik">NIK</label>
                            <div class="invalid-feedback"><?= form_error('nik') ? form_error('nik') : 'Harap isi NIK' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="no_kk" class="form-control <?= form_error('no_kk') ? 'is-invalid' : '' ?>" id="noKk" placeholder="Nomor KK" value="<?= set_value('no_kk') ?>" required>
                            <label for="noKk">Nomor KK</label>
                            <div class="invalid-feedback"><?= form_error('no_kk') ? form_error('no_kk') : 'Harap isi Nomor KK' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="nisn" class="form-control <?= form_error('nisn') ? 'is-invalid' : '' ?>" id="nisn" placeholder="NISN" value="<?= set_value('nisn') ?>" required>
                            <label for="nisn">NISN</label>
                            <div class="invalid-feedback"><?= form_error('nisn') ? form_error('nisn') : 'Harap isi NISN' ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="nama_lengkap" class="form-control <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" id="namaLengkap" placeholder="Nama Lengkap" value="<?= set_value('nama_lengkap') ?>" required>
                            <label for="namaLengkap">Nama Lengkap</label>
                            <div class="invalid-feedback"><?= form_error('nama_lengkap') ? form_error('nama_lengkap') : 'Harap isi nama lengkap' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="tempat_lahir" class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : '' ?>" id="tempatLahir" placeholder="Tempat Lahir" value="<?= set_value('tempat_lahir') ?>" required>
                            <label for="tempatLahir">Tempat Lahir</label>
                            <div class="invalid-feedback"><?= form_error('tempat_lahir') ? form_error('tempat_lahir') : 'Harap isi tempat lahir' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="date" name="tanggal_lahir" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : '' ?>" id="tanggalLahir" placeholder="Tanggal Lahir" value="<?= set_value('tanggal_lahir') ?>" required>
                            <label for="tanggalLahir">Tanggal Lahir</label>
                            <div class="invalid-feedback"><?= form_error('tanggal_lahir') ? form_error('tanggal_lahir') : 'Harap isi tanggal lahir' ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="jenis_kelamin" class="form-select <?= form_error('jenis_kelamin') ? 'is-invalid' : '' ?>" id="jenisKelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?= set_select('jenis_kelamin', 'L') ?>>Laki-laki</option>
                                <option value="P" <?= set_select('jenis_kelamin', 'P') ?>>Perempuan</option>
                            </select>
                            <label for="jenisKelamin">Jenis Kelamin</label>
                            <div class="invalid-feedback"><?= form_error('jenis_kelamin') ? form_error('jenis_kelamin') : 'Harap pilih jenis kelamin' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="agama" class="form-select <?= form_error('agama') ? 'is-invalid' : '' ?>" id="agama" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" <?= set_select('agama', 'Islam') ?>>Islam</option>
                                <option value="Kristen" <?= set_select('agama', 'Kristen') ?>>Kristen</option>
                                <option value="Katolik" <?= set_select('agama', 'Katolik') ?>>Katolik</option>
                                <option value="Hindu" <?= set_select('agama', 'Hindu') ?>>Hindu</option>
                                <option value="Budha" <?= set_select('agama', 'Budha') ?>>Budha</option>
                                <option value="Lainnya" <?= set_select('agama', 'Lainnya') ?>>Lainnya</option>
                            </select>
                            <label for="agama">Agama</label>
                            <div class="invalid-feedback"><?= form_error('agama') ? form_error('agama') : 'Harap pilih agama' ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="status_ortu" class="form-select <?= form_error('status_ortu') ? 'is-invalid' : '' ?>" id="status_ortu" required>
                                <option value="">Pilih Status Orang Tua</option>
                                <option value="Hidup Semua" <?= set_select('status_ortu', 'Hidup Semua') ?>>Hidup Semua</option>
                                <option value="Yatim" <?= set_select('status_ortu', 'Yatim') ?>>Yatim</option>
                                <option value="Piatu" <?= set_select('status_ortu', 'Piatu') ?>>Piatu</option>
                                <option value="Yatim Piatu" <?= set_select('status_ortu', 'Yatim Piatu') ?>>Yatim Piatu</option>
                            </select>
                            <label for="status_ortu">Status Orang Tua</label>
                            <div class="invalid-feedback"><?= form_error('status_ortu') ? form_error('status_ortu') : 'Harap pilih status orang tua' ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="anakke" class="form-control <?= form_error('anakke') ? 'is-invalid' : '' ?>" id="anakke" placeholder="Anak Ke-" value="<?= set_value('anakke') ?>" required>
                            <label for="anakke">Anak Ke-berapa</label>
                            <div class="invalid-feedback"><?= form_error('anakke') ? form_error('anakke') : 'Harap isi anak ke-' ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="jumlah_saudara" class="form-control <?= form_error('jumlah_saudara') ? 'is-invalid' : '' ?>" id="jumlah_saudara" placeholder="Jumlah Saudara" value="<?= set_value('jumlah_saudara') ?>" required>
                            <label for="jumlah_saudara">Jumlah Saudara</label>
                            <div class="invalid-feedback"><?= form_error('jumlah_saudara') ? form_error('jumlah_saudara') : 'Harap isi Jumlah Saudara' ?></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Section 3: Alamat -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">3</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Alamat</h5>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="alamat" class="form-control <?= form_error('alamat') ? 'is-invalid' : '' ?>" id="alamat" placeholder="Alamat" style="height: 100px" required><?= set_value('alamat') ?></textarea>
                            <label for="alamat">Alamat Lengkap</label>
                            <div class="invalid-feedback"><?= form_error('alamat') ? form_error('alamat') : 'Harap isi alamat lengkap' ?></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" name="rt" class="form-control <?= form_error('rt') ? 'is-invalid' : '' ?>" id="rt" placeholder="RT" value="<?= set_value('rt') ?>" required>
                            <label for="rt">RT</label>
                            <div class="invalid-feedback"><?= form_error('rt') ? form_error('rt') : 'Harap isi RT' ?></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" name="rw" class="form-control <?= form_error('rw') ? 'is-invalid' : '' ?>" id="rw" placeholder="RW" value="<?= set_value('rw') ?>" required>
                            <label for="rw">RW</label>
                            <div class="invalid-feedback"><?= form_error('rw') ? form_error('rw') : 'Harap isi RW' ?></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" name="kelurahan" class="form-control <?= form_error('kelurahan') ? 'is-invalid' : '' ?>" id="kelurahan" placeholder="Kelurahan/Desa" value="<?= set_value('kelurahan') ?>" required>
                            <label for="kelurahan">Kelurahan/Desa</label>
                            <div class="invalid-feedback"><?= form_error('kelurahan') ? form_error('kelurahan') : 'Harap isi kelurahan/desa' ?></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" name="kecamatan" class="form-control <?= form_error('kecamatan') ? 'is-invalid' : '' ?>" id="kecamatan" placeholder="Kecamatan" value="<?= set_value('kecamatan') ?>" required>
                            <label for="kecamatan">Kecamatan</label>
                            <div class="invalid-feedback"><?= form_error('kecamatan') ? form_error('kecamatan') : 'Harap isi kecamatan' ?></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="kabupaten" class="form-control <?= form_error('kabupaten') ? 'is-invalid' : '' ?>" id="kabupaten" placeholder="kabupaten" value="<?= set_value('kabupaten') ?>" required>
                            <label for="kabupaten">Kabupaten</label>
                            <div class="invalid-feedback"><?= form_error('kabupaten') ? form_error('kabupaten') : 'Harap isi kabupaten' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Data Orang Tua -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">4</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Data Orang Tua</h5>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="nama_ayah" class="form-control <?= form_error('nama_ayah') ? 'is-invalid' : '' ?>" id="namaAyah" placeholder="Nama Ayah" value="<?= set_value('nama_ayah') ?>" required>
                            <label for="namaAyah">Nama Ayah</label>
                            <div class="invalid-feedback"><?= form_error('nama_ayah') ? form_error('nama_ayah') : 'Harap isi nama ayah' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="pekerjaan_ayah" class="form-control <?= form_error('pekerjaan_ayah') ? 'is-invalid' : '' ?>" id="pekerjaanAyah" placeholder="Pekerjaan Ayah" value="<?= set_value('pekerjaan_ayah') ?>" required>
                            <label for="pekerjaanAyah">Pekerjaan Ayah</label>
                            <div class="invalid-feedback"><?= form_error('pekerjaan_ayah') ? form_error('pekerjaan_ayah') : 'Harap isi pekerjaan ayah' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="pendidikan_ayah" class="form-control <?= form_error('pendidikan_ayah') ? 'is-invalid' : '' ?>" id="pendidikanAyah" placeholder="Pendidikan Ayah" value="<?= set_value('pendidikan_ayah') ?>" required>
                            <label for="pendidikanAyah">Pendidikan Ayah</label>
                            <div class="invalid-feedback"><?= form_error('pendidikan_ayah') ? form_error('pendidikan_ayah') : 'Harap isi pendidikan ayah' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="nama_ibu" class="form-control <?= form_error('nama_ibu') ? 'is-invalid' : '' ?>" id="namaIbu" placeholder="Nama Ibu" value="<?= set_value('nama_ibu') ?>" required>
                            <label for="namaIbu">Nama Ibu</label>
                            <div class="invalid-feedback"><?= form_error('nama_ibu') ? form_error('nama_ibu') : 'Harap isi nama ibu' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="pekerjaan_ibu" class="form-control <?= form_error('pekerjaan_ibu') ? 'is-invalid' : '' ?>" id="pekerjaanIbu" placeholder="Pekerjaan Ibu" value="<?= set_value('pekerjaan_ibu') ?>" required>
                            <label for="pekerjaanIbu">Pekerjaan Ibu</label>
                            <div class="invalid-feedback"><?= form_error('pekerjaan_ibu') ? form_error('pekerjaan_ibu') : 'Harap isi pekerjaan ibu' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="pendidikan_ibu" class="form-control <?= form_error('pendidikan_ibu') ? 'is-invalid' : '' ?>" id="pendidikanIbu" placeholder="Pendidikan Ibu" value="<?= set_value('pendidikan_ibu') ?>" required>
                            <label for="pendidikanIbu">Pendidikan Ibu</label>
                            <div class="invalid-feedback"><?= form_error('pendidikan_ibu') ? form_error('pendidikan_ibu') : 'Harap isi pendidikan ibu' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="telp_ortu" class="form-control <?= form_error('telp_ortu') ? 'is-invalid' : '' ?>" id="telpOrtu" placeholder="Telepon Orang Tua" value="<?= set_value('telp_ortu') ?>" required>
                            <label for="telpOrtu">Telepon Orang Tua</label>
                            <div class="invalid-feedback"><?= form_error('telp_ortu') ? form_error('telp_ortu') : 'Harap isi telepon orang tua' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Data Pendidikan Sebelumnya -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">5</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Data Pendidikan Sebelumnya</h5>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="asal_sekolah" class="form-control <?= form_error('asal_sekolah') ? 'is-invalid' : '' ?>" id="asalSekolah" placeholder="Asal Sekolah" value="<?= set_value('asal_sekolah') ?>" required>
                            <label for="asalSekolah">Asal Sekolah</label>
                            <div class="invalid-feedback"><?= form_error('asal_sekolah') ? form_error('asal_sekolah') : 'Harap isi asal sekolah' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="no_peserta_ujian" class="form-control <?= form_error('no_peserta_ujian') ? 'is-invalid' : '' ?>" id="noPesertaUjian" placeholder="Nomor Peserta Ujian" value="<?= set_value('no_peserta_ujian') ?>" required>
                            <label for="noPesertaUjian">Nomor Peserta Ujian</label>
                            <div class="invalid-feedback"><?= form_error('no_peserta_ujian') ? form_error('no_peserta_ujian') : 'Harap isi nomor peserta ujian' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" step="0.01" name="rata_nilai_ijazah" class="form-control <?= form_error('rata_nilai_ijazah') ? 'is-invalid' : '' ?>" id="rataNilaiRaport" placeholder="Rata-rata Nilai Raport" value="<?= set_value('rata_nilai_ijazah') ?>" required>
                            <label for="rataNilaiRaport">Rata-rata Nilai Ijazah</label>
                            <div class="invalid-feedback"><?= form_error('rata_nilai_ijazah') ? form_error('rata_nilai_ijazah') : 'Harap isi rata-rata nilai Ijazah' ?></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="tahun_lulus" class="form-control <?= form_error('tahun_lulus') ? 'is-invalid' : '' ?>" id="tahunLulus" placeholder="Tahun Lulus" value="<?= set_value('tahun_lulus') ?>" required min="2000" max="<?= date('Y') ?>">
                            <label for="tahunLulus">Tahun Lulus</label>
                            <div class="invalid-feedback"><?= form_error('tahun_lulus') ? form_error('tahun_lulus') : 'Harap isi tahun lulus (2000-' . date('Y') . ')' ?></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="prestasi" class="form-control <?= form_error('prestasi') ? 'is-invalid' : '' ?>" id="prestasi" placeholder="Prestasi Akademik/Non Akademik (opsional)" style="height: 100px"><?= set_value('prestasi') ?></textarea>
                            <label for="prestasi">Prestasi Akademik/Non Akademik (opsional)</label>
                            <div class="invalid-feedback"><?= form_error('prestasi') ?></div>
                            <small class="text-muted">Silakan sebutkan prestasi yang pernah diraih (jika ada), beserta tingkatnya (sekolah/kabupaten/provinsi/nasional)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 6: Upload Dokumen -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <span class="text-white fw-bold">6</span>
                    </div>
                    <h5 class="text-primary mb-0 fw-bold">Upload Foto & Dokumen</h5>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="file" name="foto_siswa" class="form-control <?= form_error('foto_siswa') ? 'is-invalid' : '' ?>" id="fotoSiswa" placeholder="Upload Foto Siswa" required>
                            <label for="fotoSiswa">Upload Foto Siswa</label>
                            <div class="invalid-feedback"><?= form_error('foto_siswa') ? form_error('foto_siswa') : 'Harap upload foto siswa' ?></div>
                            <small class="text-muted">Format: JPG/PNG, Maksimal 2MB</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control,
    .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .form-floating label {
        color: #6c757d;
    }

    .card {
        border: none;
    }

    .card-header {
        padding: 1.5rem;
    }

    .invalid-feedback {
        display: block;
    }
</style>