<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
             <h1 class="page-header">Buat KK Baru</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                 <div class="panel-heading">
                     Header - KK
                 </div>
                 
                 <div class="panel-body">
                 	<div class = "row">
                    <form role="form" action="<?php echo base_url()?>index.php/ppc/saveHeaderKK" method="post">
                    <p class='notification'><?php $this->session->flashdata('success'); ?></p>
                 		<div class="col-lg-6">
                 				<div class="form-group">
                                    <label>No. KK</label>
                                    <input class="form-control" name="noKK" value="<?php if($header!="") echo $header['NO_KK']; ?>" placeholder="No KK">
                                    
                                </div>
                                <div class="form-group">
                                	<label>No. BAPOB</label>
                                    <input class="form-control" name="noBapob" value="<?php if($bapob!="") echo $bapob->NOMOR_BAPOB; ?>" placeholder="No. BAPOB" disabled>
                                </div>
                                <div class="form-group">
                                	<label>Tanggal Proses Mesin</label>
                                    <input class="form-control" id="date" name="tanggalProses" value="<?php if($header!="") echo $header['TGL_PROSES_MESIN']; ?>" placeholder="DD/MM/YYYY" type="text"/>
                                </div>
                                <div class="form-group">
                                <label>Macam</label>
                                <input class="form-control" name="macam" value="<?php if($header!="") echo $header['MACAM']; ?>" placeholder="Macam">
                              </div>
                              <div class="form-group">
                              <label>Bahan</label>
                              <select class="form-control" name="chooseBahan" id="namaMesin">
                                <option value="0-0">-- Pilih Bahan --</option>
                                <?php 
                                foreach($masterBahan as $row){
                                  echo '<option value="'.$row->KODE_BAHAN.'@'.$row->NAMA_BAHAN.'@'.$row->LEBAR.'@'.$row->GSM.'@'.$row->PANJANG.'">'.$row->NAMA_BAHAN.'</option>';
                                }

                                ?>

                              </select>
                            </div>
                                
                 		</div>
                        <div class="col-lg-6">
                            
                            <div class="form-group">
                                <label>Jumlah Pesanan</label>
                                <input class="form-control" name="jumlahPesanan" id="jumlahPesanan" value="<?php if($header!="") echo $header['JML_PESANAN']; ?>" placeholder="Jumlah Pesanan" onBlur=count()>
                            </div>
                            <div class="form-group">
                                <label>Waste Belah</label>
                                  <div class="form-group">
                                    <div class="col-sm-3">
                                      <input class="form-control col-sm-2" value="<?php if($bapob!="") echo $bapob->WASTE_BELAH; ?>%" name="percentWasteBelah" placeholder="Waste Belah" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                      <input class="form-control col-sm-2" name="jumlahWasteBelah" placeholder="Waste Belah" readonly>
                                    </div>
                                  </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label>Waste Perekatan</label>
                                  <div class="form-group">
                                    <div class="col-sm-3">
                                      <input class="form-control col-sm-2" value="<?php if($bapob!="") echo $bapob->WASTE_PEREKATAN; ?>%" name="percentWastePerekatan" id = "percentWastePerekatan" placeholder="Waste Perekatan" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                      <input class="form-control col-sm-2"  name="jumlahWastePerekatan" id="jumlahWastePerekatan" placeholder="Waste Perekatan" readonly>
                                    </div>
                                  </div>
                            </div>
                           <br>
                           <br>
                            <div class="form-group">
                            <button type="submit" class=" form-control btn btn-success ">SIMPAN</button>
                            </div>
                        </div>
                 	</form>
                 	</div>
                 </div>
			</div>
		</div>
    </div>
</div>

<script type="text/Javascript">
  var panjangWastePerekatan;
  var panjangWastePita;
  var panjangWasteBelah;

  function count(){

    percentWasteBelah = "<?php if($bapob!="") echo $bapob->WASTE_BELAH; ?>";

    panjangWasteBelah = parseFloat(document.getElementById("jumlahPesanan").value) + ((document.getElementById("jumlahPesanan").value)*(percentWasteBelah/100));

    panjangWastePerekatan = parseFloat(document.getElementById("jumlahPesanan").value) / 1.09;

    panjangWastePerekatan = Math.ceil(panjangWastePerekatan * 100)/100

  $('input[name="jumlahWasteBelah"]').val(panjangWasteBelah +" Meter").val();
  $('input[name="jumlahWastePerekatan"]').val(panjangWastePerekatan +" Meter").val();

  }
</script> 



