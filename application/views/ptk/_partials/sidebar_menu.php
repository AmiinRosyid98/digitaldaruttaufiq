<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/dashboard" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('dashboard') ?>">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <!--
        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/kehadiransiswa" class="nav-link <?php if ($this->uri->segment(2) == "kehadiransiswa") {
                                                                                        echo "active";
                                                                                    } ?>" href="<?= base_url('kehadiransiswa') ?>">
                <i class="nav-icon fas fa-bell-concierge"></i>
                <p>
                    Kehadiran Siswa
                </p>
            </a>
        </li> -->

        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/Materi" class="nav-link <?php if ($this->uri->segment(2) == "Materi") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('Materi') ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Tugas & Materi
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/Jadwal_kbm" class="nav-link <?php if ($this->uri->segment(2) == "Jadwal_kbm") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('Jadwal_kbm') ?>">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                    Jadwal KBM
                </p>
            </a>
        </li>



        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/buku" class="nav-link <?php if ($this->uri->segment(2) == "buku") {
                                                                            echo "active";
                                                                        } ?>" href="<?= base_url('buku') ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Buku Digital
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/jurnalguru" class="nav-link <?php if ($this->uri->segment(2) == "jurnalguru") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('jurnalguru') ?>">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>
                    Jurnal Guru
                </p>
            </a>
        </li>
        <?php 
            $current_user = $this->Auth_ptk->current_user();
            $cekwali = $this->db->select('*')
                            ->from('kelas')
                            ->where('id_guru', $current_user->id_guru)->get();
            if($cekwali->num_rows() > 0){
        ?>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>ptk/raport" class="nav-link <?php if ($this->uri->segment(2) == "raport") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('raport') ?>">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>
                    Raport
                </p>
            </a>
        </li>
        <?php } ?>

        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "filearsip" || $this->uri->segment(2) == "filearsip") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-folder-tree"></i>
                <p>
                    Arsip File
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>ptk/filearsip/dokumen" class="nav-link <?php echo ($this->uri->segment(3) == "dokumen") ? "active" : ""; ?>">
                        <i class="fas fa-folder-open nav-icon text-warning"></i>
                        <p>Dokumen</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>Auth/logout_ptk" class="nav-link">
                <i class="nav-icon fas fa-solid fa-power-off"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>