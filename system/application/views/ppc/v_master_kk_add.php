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
                                    <div class="form-group">
                                       <div class="col-sm-3">
                                        <input class="form-control" name="macam" value="<?php if($header!="") echo $header['MACAM']; ?>" placeholder="Macam">
                                      </div>
                                      <div class="col-sm-4">
                                        <select class="form-control" name="tahun">
                                          <option value="2015">2015</option>
                                          <option value="2016">2016</option>
                                          <option value="2017">2017</option>
                                          <option value="2018">2018</option>
                                          <option value="2019">2019</option>
                                          <option value="2020">2020</option>
                                          <option value="2021">2021</option>
                                          <option value="2022">2022</option>
                                          <option value="2023">2023</option>
                                          <option value="2024">2024</option>
                                          <option value="2025">2025</option>
                                        </select>
                                      </div>
                                      <div class="col-sm-4">
                                        <select class="form-control" name="seri">
                                          <option value="Seri I">Seri I</option>
                                          <option value="Seri II">Seri II</option>
                                          <option value="Seri III">Seri III</option>
                                          <option value="Seri MMEA">Seri MMEA</option>
                                        </select>
                                      </div>
                                    </div>
                                      
                                </div>
                                <br>
                                <!-- <div class="form-group">
                                <label>Macam</label>
                                <input class="form-control" name="macam" value="<?php if($header!="") echo $header['MACAM']; ?>" placeholder="Macam">
                              </div> -->
                              <div class="form-group">
                              <label>Bahan</label>
                              <select class="form-control" name="chooseBahan" id="namaMesin">
                                <option value="0-0">-- Pilih Bahan --</option>
                                <?php 
                                foreach($masterBahan as $row){
                                  if ($row->NAMA_BAHAN === $header['NAMA_BAHAN_BAKU']) {
                                       $selected = 'selected';
                                  } else {
                                       $selected = '';
                                  }
                                  echo '<option value="'.$row->KODE_BAHAN.'@'.$row->NAMA_BAHAN.'@'.$row->LEBAR.'@'.$row->GSM.'@'.$row->PANJANG.'"'.$selected.'>'.$row->NAMA_BAHAN.'</option>';
                                }

                                ?>

                              </select>
                            </div>
                                
                 		</div>
                        <div class="col-lg-6">
                            
                            <div class="form-group">
                                <label>Jumlah Pesanan</label>
                                <div class="form-group input-group">
                                  <input class="form-control" name="jumlahPesanan" id="jumlahPesanan" value="<?php if($header!="") echo $header['JML_PESANAN']; ?>" placeholder="Jumlah Pesanan" onBlur=count()>
                                  <span class="input-group-addon">Meter</span>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label>Waste Perekatan</label>
                                  <div class="form-group">
                                    <div class="col-sm-3">
                                      <input class="form-control col-sm-2" value="<?php if($bapob!="") echo $bapob->WASTE_PEREKATAN; ?>%" name="percentWastePerekatan" id = "percentWastePerekatan" placeholder="Waste Perekatan" readonly>
                                    </div>
                                    <div class="col-sm-6 form-group input-group">
                                      <input class="form-control col-sm-2"  name="jumlahWastePerekatan" id="jumlahWastePerekatan" value="<?php if($header!="") echo $header['panjangWastePerekatan']; ?>" placeholder="Waste Perekatan" readonly>
                                    <span class="input-group-addon">Meter</span>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label>Waste Pita</label>
                                  <div class="form-group">
                                    <div class="col-sm-3">
                                      <input class="form-control col-sm-2" value="<?php if($bapob!="") echo $bapob->WASTE_PITA; ?>%" name="percentWastePita" id = "percentWastePita"  readonly>
                                    </div>
                                    <div class="col-sm-6 form-group input-group">
                                      <input class="form-control col-sm-2"  name="jumlahWastePita" id="jumlahWastePita" value="<?php if($header!="") echo number_format($header['panjangWastePita']); ?>" placeholder="Waste Pita" readonly>
                                      <span class="input-group-addon">Meter</span>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label>Waste Belah</label>
                                  <div class="form-group">
                                    <div class="col-sm-3">
                                      <input class="form-control col-sm-2" value="<?php if($bapob!="") echo $bapob->WASTE_BELAH; ?>%" name="percentWasteBelah" placeholder="Waste Belah" readonly>
                                    </div>
                                    <div class="col-sm-6 form-group input-group">
                                      <input class="form-control col-sm-2" name="jumlahWasteBelah" placeholder="Waste Belah" value="<?php if($header!="") echo $header['panjangWasteBelah']; ?>" readonly>
                                    <span class="input-group-addon">Meter</span>
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
  var percentWastePerekatan;
  var percentWastePita;
  var percentWasteBelah;

  function count(){

    percentWastePerekatan = "<?php if($bapob!="") echo $bapob->WASTE_PEREKATAN; ?>";
    percentWastePita      = "<?php if($bapob!="") echo $bapob->WASTE_PITA; ?>";
    percentWasteBelah     = "<?php if($bapob!="") echo $bapob->WASTE_BELAH; ?>";

    panjangWastePerekatan = parseFloat(document.getElementById("jumlahPesanan").value) + ((parseFloat(percentWastePerekatan)/100)*parseFloat(document.getElementById("jumlahPesanan").value) );

    panjangWastePita = panjangWastePerekatan + ((parseFloat(percentWastePita)/100)*parseFloat(panjangWastePerekatan));

    panjangWasteBelah = panjangWastePita + ((parseFloat(percentWasteBelah)/100)*parseFloat(panjangWastePita));

  $('input[name="jumlahWasteBelah"]').val(panjangWasteBelah).val();
  $('input[name="jumlahWastePerekatan"]').val(panjangWastePerekatan).val();
  $('input[name="jumlahWastePita"]').val(panjangWastePita).val();
  }

</script> 



