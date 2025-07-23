<nav class="mt-2" style="color: #000000;">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?php echo base_url() ?>bk/dashboard" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") {
                                                                                echo "active";
                                                                            } ?>" href="<?= base_url('dashboard') ?>">
                <i class="nav-icon fas fa-landmark"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>



        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "epoin" || $this->uri->segment(2) == "epoin") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-people-arrows"></i>
                <p>
                    E-POIN
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bk/epoin/jenispelanggaran" class="nav-link <?php echo ($this->uri->segment(3) == "jenispelanggaran") ? "active" : ""; ?>">
                        <i class="fas fa-user-shield nav-icon text-warning"></i>
                        <p>Jenis Pelanggaran</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bk/epoin/pelanggaran" class="nav-link <?php echo ($this->uri->segment(3) == "pelanggaran") ? "active" : ""; ?>">
                        <i class="fas fa-user-pen nav-icon text-warning"></i>
                        <p>Catat Pelanggaran</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bk/epoin/datasiswa" class="nav-link <?php echo ($this->uri->segment(3) == "datasiswa") ? "active" : ""; ?>">
                        <i class="fas fa-user-nurse nav-icon text-warning"></i>
                        <p>Total Poin</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="<?php echo base_url() ?>Auth/logout_bk" class="nav-link">
                <i class="nav-icon fas fa-solid fa-power-off"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>
</div>