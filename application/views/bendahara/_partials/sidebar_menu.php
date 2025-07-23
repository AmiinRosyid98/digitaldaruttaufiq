<nav class="mt-2" style="color: #000000;">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?php echo base_url() ?>bendahara/dashboard" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") {
                                                                                        echo "active";
                                                                                    } ?>" href="<?= base_url('dashboard') ?>">
                <i class="nav-icon fas fa-landmark"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>



        <li class="nav-item menu-<?php echo ($this->uri->segment(2) == "datakeuangan" || $this->uri->segment(2) == "datakeuangan") ? "open" : ""; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-microchip"></i>
                <p>
                    Data Keuangan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bendahara/datakeuangan/poskeuangan" class="nav-link <?php echo ($this->uri->segment(3) == "poskeuangan") ? "active" : ""; ?>">
                        <i class="fas fa-hand-holding-dollar nav-icon text-warning"></i>
                        <p>Pos Keuangan</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bendahara/datakeuangan/jenispembayaran" class="nav-link <?php echo ($this->uri->segment(3) == "jenispembayaran") ? "active" : ""; ?>">
                        <i class="fas fa-vault nav-icon text-warning"></i>
                        <p>Jenis Pembayaran</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>bendahara/datakeuangan/tarifpembayaran" class="nav-link <?php echo ($this->uri->segment(3) == "tarifpembayaran") ? "active" : ""; ?>">
                        <i class="fas fa-money-check-dollar nav-icon text-warning"></i>
                        <p>Tarif Pembayaran</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url() ?>bendahara/pembayaransiswa" class="nav-link <?php if ($this->uri->segment(2) == "pembayaransiswa") {
                                                                                            echo "active";
                                                                                        } ?>" href="<?= base_url('pembayaransiswa') ?>">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>
                    Transaksi
                </p>
            </a>
        </li>



        <li class="nav-item">
            <a href="<?php echo base_url() ?>bendahara/historypembayaran" class="nav-link <?php if ($this->uri->segment(2) == "historypembayaran") {
                                                                                                echo "active";
                                                                                            } ?>" href="<?= base_url('historypembayaran') ?>">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>
                    Data Pembayaran
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="<?php echo base_url() ?>bendahara/detailtransaksi" class="nav-link <?php if ($this->uri->segment(2) == "detailtransaksi") {
                                                                                            echo "active";
                                                                                        } ?>" href="<?= base_url('detailtransaksi') ?>">
                <i class="nav-icon fas fa-clock-rotate-left"></i>
                <p>
                    Detail Pembayaran
                </p>
            </a>
        </li>
        </li>



        <li class="nav-item">
            <a href="<?php echo base_url() ?>Auth/logout_bendahara" class="nav-link">
                <i class="nav-icon fas fa-solid fa-power-off"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>
</div>