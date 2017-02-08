<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
             <h1 class="page-header">Master Formula</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                 <div class="panel-heading">
                     Master Formula
                 </div>
                 
                 <div class="panel-body">
                 	<div class = "row">
                 		<form role="form" action="<?php echo base_url()?>index.php/MasterFormula/saveData" method="post">
                            <div class="col-lg-6">
                            <div class="form-group">
                                    <label>Id Formula</label>
                                    <input class="form-control" name="idFormula" placeholder="Id Formula">
                                    
                                </div>
                 				<div class="form-group">
                                    <label>Nama Formula</label>
                                    <input class="form-control" name="namaFormula" placeholder="Nama Formula">
                                    
                                </div>
                                <div class="form-group">
                                            <label>Pilih Mesin</label>
                                            <select class="form-control" name="mesin">
                                            <?php 
                                                foreach($masterMesin as $row)
                                                {
                                                    echo '<option value="'.$row->ID_MESIN.'">'.$row->NAMA_MESIN.'</option>';
                                                }
                                                
                                                ?>
                                               
                                            </select>
                                </div>
                                <div class="form-group">
                                	<label>Viscositas</label>
                                    <input class="form-control" name="viscositas" placeholder="Viscositas">
                                </div>
                                
                 			
                 		 </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                                    <label>Solid Contain</label>
                                    <input class="form-control" name="solidContain" placeholder="Solid Contain">
                                </div>
                                <div class="form-group">
                                    <label>Gramature</label>
                                    <input class="form-control" name="gramature" placeholder="Gramature">
                                </div>
                                <div class="form-group">
                                    <label>Berat</label>
                                    <input class="form-control" name="berat" placeholder="Berat">
                                </div>
                                <div class="form-group">
                                    <label>Suhu</label>
                                    <input class="form-control" name="suhu" placeholder="Suhu">
                                </div>
                                <button type="submit" class="btn btn-default">Submit Button</button>
                         </div>
                 		</form>
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