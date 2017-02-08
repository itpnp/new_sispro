<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
             <h1 class="page-header">Master Mesin</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                 <div class="panel-heading">
                     Master Mesin
                 </div>
                 
                 <div class="panel-body">
                 	<div class = "row">
                 		<div class="col-lg-6">
                 			<form role="form" action="<?php echo base_url()?>index.php/MasterMesin/saveData" method="post">
                 				<div class="form-group">
                                    <label>Nama Mesin</label>
                                    <input class="form-control" name="namaMesin" placeholder="Nama Mesin">
                                    
                                </div>
                                <div class="form-group">
                                	<label>Kecepatan Mesin</label>
                                    <input class="form-control" name="kecepatanMesin" placeholder="Kecepatan Mesin">
                                </div>
                                <div class="form-group">
                                	<label>Lama Persiapan</label>
                                    <input class="form-control" name="lamaPersiapan" placeholder="lama Persiapan">
                                </div>
                                <div class="form-group">
                                	<label>Waste Stel</label>
                                    <input class="form-control" name="wasteStel" placeholder="Waste Stel">
                                </div>
                                <div class="form-group">
                                	<label>Waste Proses</label>
                                    <input class="form-control" name="wasteProses" placeholder="Waste Stel">
                                </div>
                                <div class="form-group">
                                            <label>Pilih Master Proses</label>
                                            <select class="form-control" name="proses">
                                            <?php 
                                            	foreach($masterProses as $row)
                                            	{
                                            		echo '<option value="'.$row->ID_PROSES.'">'.$row->NAMA_PROSES.'</option>';
                                            	}
												
												?>
                                               
                                            </select>
                                </div>
                                <button type="submit" class="btn btn-default">Submit Button</button>
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