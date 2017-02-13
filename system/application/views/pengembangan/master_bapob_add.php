<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
             <h1 class="page-header">Buat BAPOB Baru</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                 <div class="panel-heading">
                     Buat  Master BAPOB Baru
                 </div>
                 
                 <div class="panel-body">
                 	<div class = "row">
                 		<div class="col-lg-6">
                 			<form role="form" action="<?php echo base_url()?>index.php/pengembangan/saveDataBapob" method="post">
                 				 <div class="form-group">
                                            <label>Pilih Jenis Foil</label>
                                            <select class="form-control" name="kodeBahan">
                                            <?php 
                                            	foreach($jenisFoil as $row)
                                            	{
                                            		echo '<option value="'.$row->KODE_BAHAN.'">'.$row->NAMA_BAHAN.'</option>';
                                            	}
												
												?>
                                               
                                            </select>
                                </div>
                                <div class="form-group">
                                	<label>Nomor Registrasi BAPOB</label>
                                    <input class="form-control" name="nomorBapob" placeholder="Nomor BAPOB">
                                </div>
                               <div class="form-group">
                                	<label>Tanggal Pembuatan BAPOB</label>
                                    <input class="form-control" id="date" name="tanggalProses" placeholder="DD/MM/YYY" type="text"/>
                                </div>
                                <div class="form-group">
                                	<label>Jumlah Pesanan</label>
                                    <input class="form-control" name="jmlPesanan" placeholder="Pesanan">
                                </div>
                                
                                <button type="submit" class="btn btn-default">SIMPAN</button>
								<button type="cancel" class="btn btn-default">BATAL</button>
                 			</form>
                 		</div>
                 		
                 	</div>
                 </div>

			</div>
		</div>
    </div>
</div>

	<!-- <div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div> -->