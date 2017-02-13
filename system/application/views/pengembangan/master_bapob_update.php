<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
             <h1 class="page-header">Master BAPOB</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                 <div class="panel-heading">
                     Master BAPOB
                 </div>
                 
                 <div class="panel-body">
                 	<div class = "row">
                 		<div class="col-lg-6">
                 			<form role="form" action="<?php echo base_url()?>index.php/pengembangan/saveUpdateDataBapob" method="post">
                            <?php
                                foreach($mesin ->result_array() as $d){
                                    $ps=array();
                                    $idMesin=$d["ID_MESIN"];
                                    $namaMesin=$d["NAMA_MESIN"];
                                    $kecepatanMesin = $d["KECEPATAN_MESIN"];
                                    $lamaPersiapan = $d["KECEPATAN_MESIN"];
                                    $wasteStel = $d["WASTE_STEL"];
                                    $wasteProses= $d["WASTE_PROSES"];

                                }
                            ?>
                                <input type="hidden" name="idMesin" value="<?php echo $idMesin;?>" />
                 				<div class="form-group">
                                    <label>Nama Mesin</label>
                                    <input class="form-control" name="namaMesin" value="<?php echo $namaMesin; ?>" >
                                </div>
                                <div class="form-group">
                                	<label>Kecepatan Mesin</label>
                                    <input class="form-control" name="kecepatanMesin" value="<?php echo $kecepatanMesin; ?>">
                                </div>
                                <div class="form-group">
                                	<label>Lama Persiapan</label>
                                    <input class="form-control" name="lamaPersiapan" value="<?php echo $lamaPersiapan; ?>" >
                                </div>
                                <div class="form-group">
                                	<label>Waste Stel</label>
                                    <input class="form-control" name="wasteStel" value="<?php echo $wasteStel; ?>">
                                </div>
                                <div class="form-group">
                                	<label>Waste Proses</label>
                                    <input class="form-control" name="wasteProses" value="<?php echo $wasteProses; ?>">
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