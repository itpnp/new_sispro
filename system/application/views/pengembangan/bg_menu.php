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
						<?php
            if($menubapob != null){
              foreach($menubapob as $t)
              {
               $jml_bapob=$t->JUMLAH;
              }
            foreach($menuprosesbapob as $d)
              {
               $jml_proses=$d->JUMLAH;
              } 
            }
						
						?>	
                        <li>
                            <a href="<?php echo base_url()?>index.php/pengembangan"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="fa fa-bar-chart-o fa-fw"></i> MASTER<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
							 <li>
                                    <a href="#"> BAPOB<span class="fa arrow"></span></a> 
								   <ul class="nav nav-third-level">
								     <?php
									 if($jml_bapob < 1)
									 {
									 ?>
									 <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/addNewBapob">Buat Master BAPOB Baru</a>
                                     </li>
									  <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataBapobEdit">Lihat Data Master BAPOB</a>
                                     </li>
									 <?php
									 }
									 else if($jml_bapob >= 1)
									 {
									 ?>
									  <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataBapobEdit">Lihat Data Master BAPOB</a>
                                     </li>
									 <?php
									 }
									 ?>
									</ul> 
								 </li>
                                <li>
                                    <a href="#"> MESIN<span class="fa arrow"></span></a> 
								   <ul class="nav nav-third-level">
								   <li>   
									  <a href="<?php echo base_url()?>index.php/pengembangan/addDataMesin">Tambah Data Setting Mesin Baru</a>
								    </li>  
									<li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataMesin">Lihat Data Setting Mesin</a>
                                    </li>
									<li>
                                       <a href="#">SILINDER MESIN</a>
									    <ul class="nav nav-fourth-level">
                                         <li>   
									     <a href="<?php echo base_url()?>index.php/pengembangan/addDataMesin">Tambah Silinder Mesin Baru</a>
                                         </li>
								       </ul> 
                                    </li>
                                  </ul>
 								 </li>  
                                <li>
                                    <a href="#"> FORMULA<span class="fa arrow"></span></a> 
								   <ul class="nav nav-third-level">
								     <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/addDataFormula">Tambah Data Formula baru</a>
                                     </li>
								      <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataFormula">Lihat Data Setting Formula</a>
                                      </li>
									</ul> 
								 </li>
								<li>
                                    <a href="#"> PROSES PRODUKSI<span class="fa arrow"></span></a> 
								   <ul class="nav nav-third-level">
								     <?php
									 if($jml_proses < 1)
									 {
									 ?>
									 <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/addDataFormula">Tambah Data Proses Produksi Baru</a>
                                     </li>
								      <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataFormula">Lihat Data Proses Produksi</a>
                                      </li>
									  <?php
									  }
									 else if($jml_proses >= 1)
									 {
									 ?>
								      <li>
                                       <a href="<?php echo base_url()?>index.php/pengembangan/showDataFormula">Lihat Data Proses Produksi</a>
                                      </li>
									  <?php
									  }
									  ?> 
									</ul> 
								 </li>
                               </ul>
                           </li>
                        
                         <li>
                            <a href="#">
                            <i class="fa fa-bar-chart-o fa-fw"></i> LAPORAN<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url()?>index.php/pengembangan/addDataMesin">Cetak Form BAPOB</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
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

	<!-- <div class="container-fluid-full">
		<div class="row-fluid"> -->

			<!-- start: Main Menu -->
			<!-- <div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo base_url()?>index.php/admin">
                        <i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li><a href="<?php echo base_url()?>index.php/admin/katobat">
                        <i class="icon-list"></i><span class="hidden-tablet"> Kategori Obat</span></a></li>
                        <li><a href="<?php echo base_url()?>index.php/admin/cekobat">
                        <i class="icon-eye-open"></i><span class="hidden-tablet"> Stok Obat</span></a></li>
						<li><a href="<?php echo base_url()?>index.php/admin/transaksi">
                        <i class="icon-eye-open"></i><span class="hidden-tablet"> Transaksi Obat</span></a></li>
                        <li><a href="<?php echo base_url()?>index.php/admin/transaksiobat">
                        <i class="icon-list"></i><span class="hidden-tablet"> Data Transaksi Obat</span></a></li>
						<li><a href="<?php echo base_url()?>index.php/admin/akses">
                        <i class="icon-group"></i><span class="hidden-tablet"> Data User</span></a></li>
                        

                        	<ul>
                        		<li>
                        		<a href="<?php echo base_url()?>index.php/admin/laporan">
		                        <i class="icon-group"></i><span class="hidden-tablet"> Test</span></a>
		                        </li>
                        	</ul>

                        <i class="icon-file-alt"></i><span class="hidden-tablet"> Laporan</span></a></li>
                        <li><a href="<?php echo base_url()?>index.php/admin/laporantransaksi">
                        <i class="icon-file-alt"></i><span class="hidden-tablet"> Laporan Transaksi</span></a></li>
					</ul>
				</div>
			</div>-->
			   </nav>

    </div> 
			<!-- end: Main Menu-->