	<div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Laporan Produksi <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url()?>index.php/AdminProduksiSensitizing/chooseData">Buat Laporan Produksi Sensitizing</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/AdminProduksiSensitizing/mutasiBarang">Mutasi Sensitizing</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/AdminProduksiSensitizing/listData">Hasil Produksi Sensitizing</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/AdminProduksiSensitizing/reportPage">Print Hasil Produksi</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
    </div>
</div>
</div>

</nav>

</div> 
			<!-- end: Main Menu-->