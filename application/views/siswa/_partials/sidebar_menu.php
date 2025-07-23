<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo base_url() ?>siswa/dashboard" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('dashboard') ?>">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>siswa/elearning" class="nav-link <?php if ($this->uri->segment(2) == "elearning") {
                                                                                    echo "active";
                                                                                } ?>" href="<?= base_url('elearning') ?>">
                <i class="fas fa-chalkboard-teacher nav-icon text-success"></i>
                <p>
                    E-Learning
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>siswa/absensi" class="nav-link <?php if ($this->uri->segment(2) == "absensi") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('absensi') ?>">
                <i class="fas fa-wifi nav-icon text-success"></i>
                <p>
                    Absen Online
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>siswa/ebook" class="nav-link <?php if ($this->uri->segment(2) == "ebook") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('ebook') ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    E-Book
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>siswa/tagihan" class="nav-link <?php if ($this->uri->segment(2) == "tagihan") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('tagihan') ?>">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                    Pembayaran Tagihan
                </p>
            </a>
        </li>


        <!--
    <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "profile" || $this->uri->segment(2) == "profile") ? "open" : ""; ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-microchip"></i>
        <p>
            Pengaturan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?php echo base_url() ?>siswa/profile" class="nav-link <?php echo ($this->uri->segment(2) == "profile") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon text-primary"></i>
                    <p>Sistem</p>
                </a>
            </li>
        </ul>
    </li>-->




        <li class="nav-item">
            <a href="<?php echo base_url() ?>Auth/logout_siswa" class="nav-link">
                <i class="nav-icon fas fa-solid fa-power-off"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>