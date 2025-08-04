<nav class="mt-2" style="color: #000000;">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/dashboard" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('dashboard') ?>">
                <i class="nav-icon fas fa-landmark"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>


        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "masterdata" || $this->uri->segment(2) == "masterdata") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-microchip"></i>
                <p>
                    Master Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/tahunangkatan" class="nav-link <?php echo ($this->uri->segment(3) == "tahunangkatan") ? "active" : ""; ?>">
                        <i class="fas fa-calendar nav-icon text-warning"></i>
                        <p>Tahun Angkatan</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/tahunpelajaran" class="nav-link <?php echo ($this->uri->segment(3) == "tahunpelajaran") ? "active" : ""; ?>">
                        <i class="fas fa-calendar-check nav-icon text-warning"></i>
                        <p>Tahun Ajaran</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/tingkat" class="nav-link <?php echo ($this->uri->segment(3) == "tingkat") ? "active" : ""; ?>">
                        <i class="fas fa-chart-column nav-icon text-warning"></i>
                        <p>Data Tingkat</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/kelas" class="nav-link <?php echo ($this->uri->segment(3) == "kelas") ? "active" : ""; ?>">
                        <i class="fas fa-school nav-icon text-warning"></i>
                        <p>Data Kelas</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/mapel" class="nav-link <?php echo ($this->uri->segment(3) == "mapel") ? "active" : ""; ?>">
                        <i class="fas fa-book-open nav-icon text-warning"></i>
                        <p>Data Mapel</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/masterdata/metodepembayaran" class="nav-link <?php echo ($this->uri->segment(3) == "metodepembayaran") ? "active" : ""; ?>">
                        <i class="fas fa-book-open nav-icon text-warning"></i>
                        <p>Metode Pembayaran</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/sistem/updatesistem" class="nav-link <?php if ($this->uri->segment(3) == "updatesistem") {
                                                                                            echo "active";
                                                                                        } ?>">
                <i class="fa fa-school nav-icon"></i>
                <p>
                    Kelembagaan
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/ptk" class="nav-link <?php if ($this->uri->segment(2) == "ptk") {
                                                                            echo "active";
                                                                        } ?>" href="<?= base_url('ptk') ?>">
                <i class="nav-icon fas fa-chalkboard-user"></i>
                <p>
                    Data PTK
                </p>
            </a>
        </li>




        <li class="nav-item <?php echo ($this->uri->segment(2) == "siswa" || $this->uri->segment(2) == "alumni") ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link <?php echo ($this->uri->segment(2) == "siswa" || $this->uri->segment(2) == "alumni") ? "active" : ""; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Data Siswa
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url('admin/siswa'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == "siswa") ? "active" : ""; ?>">
                        <i class="fas fa-user-graduate nav-icon text-warning"></i>
                        <p>Siswa Aktif</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('admin/alumni'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == "alumni") ? "active" : ""; ?>">
                        <i class="fas fa-user-check nav-icon text-warning"></i>
                        <p>Alumni</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/rombel" class="nav-link <?php if ($this->uri->segment(2) == "rombel") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('rombel') ?>">
                <i class="nav-icon fas fa-elevator"></i>
                <p>
                    Data Rombel
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/arsipguru" class="nav-link <?php if ($this->uri->segment(2) == "arsipguru") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('arsipguru') ?>">
                <i class="nav-icon fas fa-folder-tree"></i>
                <p>
                    E-Dokumen
                </p>
            </a>
        </li>






        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/ebook" class="nav-link <?php if ($this->uri->segment(2) == "ebook") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('ebook') ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    E-Book Digital
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/linkdinamis" class="nav-link <?php if ($this->uri->segment(2) == "linkdinamis") {
                                                                                    echo "active";
                                                                                } ?>">
                <i class="nav-icon fas fa-link"></i>
                <p>
                    Link Dinamis
                </p>
            </a>
        </li>

        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "kelulusan" || $this->uri->segment(2) == "kelulusan") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-trophy"></i>
                <p>
                    Kelulusan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/kelulusan/datakelulusan" class="nav-link <?php echo ($this->uri->segment(3) == "datakelulusan") ? "active" : ""; ?>">
                        <i class="fas fa-user-graduate nav-icon text-warning"></i>
                        <p>Data Kelulusan</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/kelulusan/settingskl" class="nav-link <?php echo ($this->uri->segment(3) == "settingskl") ? "active" : ""; ?>">
                        <i class="fas fa-envelope-open-text nav-icon text-warning"></i>
                        <p>Setting SKL</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "absensi" || $this->uri->segment(2) == "absensi") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bell"></i>
                <p>
                    Absensi
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/absensi/manual" class="nav-link <?php echo ($this->uri->segment(3) == "manual") ? "active" : ""; ?>">
                        <i class="fas fa-marker nav-icon text-warning"></i>
                        <p>Absensi Manual</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>QrAbsensi" target="_blank" class="nav-link ">
                        <i class="fas fa-qrcode nav-icon text-success"></i>
                        <p>Absensi Siswa QR</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>QrAbsensiGuru" target="_blank" class="nav-link ">
                        <i class="fas fa-qrcode nav-icon text-success"></i>
                        <p>Absensi Guru QR</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/absensi/rekapsiswa" class="nav-link <?php echo ($this->uri->segment(3) == "rekapsiswa") ? "active" : ""; ?>">
                        <i class="fas fa-print nav-icon text-default"></i>
                        <p>Rekap Absensi Siswa</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/absensi/izinsiswa" class="nav-link <?php echo ($this->uri->segment(3) == "izinsiswa") ? "active" : ""; ?>">
                        <i class="fas fa-pen-to-square nav-icon text-danger"></i>
                        <p>Izin Siswa</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/absensi/settingabsen" class="nav-link <?php echo ($this->uri->segment(3) == "settingabsen") ? "active" : ""; ?>">
                        <i class="fas fa-list-check nav-icon text-warning"></i>
                        <p>Setting absensi</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "rekapabsensiguru" || $this->uri->segment(2) == "rekapabsensiguru") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-print"></i>
                <p>
                    Rekap Absensi Guru
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/rekapabsensiguru/rekapharianguru" class="nav-link <?php echo ($this->uri->segment(3) == "rekapharianguru") ? "active" : ""; ?>">
                        <i class="fas fa-print nav-icon text-danger"></i>
                        <p>Rekap Harian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/rekapabsensiguru/rekapbulanguru" class="nav-link <?php echo ($this->uri->segment(3) == "rekapbulanguru") ? "active" : ""; ?>">
                        <i class="fas fa-print nav-icon text-danger"></i>
                        <p>Rekap Bulanan</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "rekapabsensisiswa" || $this->uri->segment(2) == "rekapabsensisiswa") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-print"></i>
                <p>
                    Rekap Absensi Siswa
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/rekapabsensisiswa/rekaphariansiswa" class="nav-link <?php echo ($this->uri->segment(3) == "rekaphariansiswa") ? "active" : ""; ?>">
                        <i class="fas fa-print nav-icon text-danger"></i>
                        <p>Rekap Harian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/rekapabsensisiswa/rekapbulansiswa" class="nav-link <?php echo ($this->uri->segment(3) == "rekapbulansiswa") ? "active" : ""; ?>">
                        <i class="fas fa-print nav-icon text-danger"></i>
                        <p>Rekap Bulanan</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "berita" || $this->uri->segment(2) == "berita") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-newspaper"></i>
                <p>
                    Berita
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/berita/listberita" class="nav-link <?php echo ($this->uri->segment(3) == "listberita") ? "active" : ""; ?>">
                        <i class="fas fa-bars nav-icon text-warning"></i>
                        <p>Daftar Berita</p>
                    </a>
                </li>
            </ul>
        </li>




        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "ppdb" || $this->uri->segment(2) == "ppdb") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-ticket"></i>
                <p>
                    PPDB
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/ppdb/settingppdb" class="nav-link <?php echo ($this->uri->segment(3) == "settingppdb") ? "active" : ""; ?>">
                        <i class="fas fa-cog nav-icon text-warning"></i>
                        <p>Setting PPDB</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin/ppdb/pendaftaran" class="nav-link <?php echo ($this->uri->segment(3) == "pendaftaran") ? "active" : ""; ?>">
                        <i class="fas fa-clipboard nav-icon text-warning"></i>
                        <p>Pendaftaran</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/sistem/settingpaymentgateway" class="nav-link <?php if ($this->uri->segment(3) == "settingpaymentgateway") {
                                                                                            echo "active";
                                                                                        } ?>">
                <i class="fa fa-gear nav-icon"></i>
                <p>
                    Setting Payment
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>admin/manajemenpengguna" class="nav-link <?php if ($this->uri->segment(2) == "manajemenpengguna") {
                                                                                            echo "active";
                                                                                        } ?>">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                    User Pengguna
                </p>
            </a>
        </li>



        <li class="nav-item">
            <a href="<?php echo base_url() ?>Auth/logout_admin" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>
</div>