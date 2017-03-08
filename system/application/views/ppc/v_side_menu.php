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
                        <i class="fa fa-bar-chart-o fa-fw"></i> Master BAPOB <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="morris.html">Default BAPOB</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/ppc/showDataMesin">lihat Setting Mesin</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/ppc/showDataFormula">lihat Setting Formula</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Master KK <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a >Buat KK Baru <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/createHeaderKK">Data KK</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/addProsesEmboss">Proses Emboss</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/addProsesDemet">Proses Demet</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/addProsesRewind">Proses Rewind</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/addProsesSensi">Proses Sensi</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>index.php/ppc/addProsesBelah">Proses Belah Dan Sortir</a>
                                        </li>
                                    </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url()?>index.php/ppc/viewListKK">Kartu Kerja Mesin</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
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