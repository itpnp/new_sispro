<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
     <h1 class="page-header">Buat Kartu Kerja Baru</h1>
   </div>
   <!-- /.col-lg-12 -->
 </div>
 <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
       <div class="panel-heading">
         Header
       </div>
       <div class="panel-body">
        <div class = "row">
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label col-sm-4">No. KK:</label>
              <div class="col-sm-8">
              <p class="form-control" id="asas" name="asas"><?php echo $header['NO_KK']; ?></p>
                <input type="hidden" class="form-control" id="fileName" value="<?php echo $header['NO_KK']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">No. BAPOB:</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $bapob->NOMOR_BAPOB; ?></p>
                <!-- <input type="text" class="form-control" id="noBapob" value="<?php echo $bapob->NOMOR_BAPOB; ?>" disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Tanggal Proses:</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $header['TGL_PROSES_MESIN']; ?></p>
                <!-- <input type="text" class="form-control" id="tanggalProses" value="<?php echo $header['TGL_PROSES_MESIN']; ?>"  disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Macam:</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php if($header!="") echo $header['MACAM']." ".$header['tahun']; ?></p>
                <!-- <input type="text" class="form-control" id="macam" value="<?php if($header!="") echo $header['MACAM']; ?>"  disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Jumlah Pesanan</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $header['JML_PESANAN']; ?> Meter</p>

               <!--  <input class="form-control" name="jmlPesanan" id="jmlPesanan" value="<?php echo $header['JML_PESANAN']; ?> Meter" disabled> -->
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label col-sm-4">Jumlah Pesanan (Konversi)</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $header['JML_PESANAN_KONVERSI']; ?> Meter</p>

               <!--  <input class="form-control" name="jmlPesanan" id="jmlPesanan" value="<?php echo $header['JML_PESANAN']; ?> Meter" disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Waste Belah</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $header['percent_belah_konversi']; ?>%</p>
                <!-- <input class="form-control" name="wasteProses"  value="<?php if($bapob!="") echo $bapob->WASTE_BELAH; ?>%" disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Panjang Bahan:</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php echo $header['PANJANG_BAHAN']; ?> Meter</p>
              <!-- <p class="form-control" id="noKK" name="noKK"><?php echo number_format($header['bahan_konversi']); ?> Meter</p> -->
               <!--  <input type="text" class="form-control" id="panjangBahan" value="<?php echo $header['panjangWasteBelah']; ?> Meter"  disabled> -->
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Panjang Bahan (Konversi) :</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK">
                <?php  
                  if($header['bahan_konversi'] !== "-"){
                    echo number_format($header['bahan_konversi']);
                  }else{
                    echo $header['bahan_konversi'];
                   } ?> Meter</p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Nama Bahan:</label>
              <div class="col-sm-8">
              <p class="form-control" id="noKK" name="noKK"><?php if($header!="") echo $header['NAMA_BAHAN_BAKU']; ?></p>
                <!-- <input type="text" class="form-control" id="bahan" value="<?php if($header!="") echo $header['NAMA_BAHAN_BAKU']; ?>"  disabled> -->
              </div>
            </div>
        </div>
      </div>

    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi EMBOSS
     </div>
     <div class="panel-body">
     <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <p id="deliveryTime" name="deliveryTime"><?php if($emboss!="") echo $emboss['delivery_time']; ?></p>
        </div>
     </div>
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['URUTAN_PRODUKSI']; ?></p>
          </div>
          <div class="form-group">
            <label>Waste</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['WASTE_PROSES']; ?>%</p>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <p class="form-control" id="noKK" name="noKK">Mesin Emboss</p>

          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['KECEPATAN_MESIN']; ?></p>
          </div>
          <div class="form-group">
            <label>Formula</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['FORMULA']; ?></p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Hasil</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['HASIL']; ?></p>
          </div>
          <div class="form-group">
            <label>Stel PCH</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['STEL_PCH']; ?></p>
          </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['STEL_BAHAN']; ?></p>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['LAMA_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($emboss!="") echo $emboss['TOTAL_WAKTU']; ?></p>
          </div>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi DEMET
     </div>

     <div class="panel-body">
     <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <p id="deliveryTime" name="deliveryTime"><?php if($demet!="") echo $demet['delivery_time']; ?></p>
        </div>
     </div>
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['URUTAN_PRODUKSI']; ?></p>
          </div>
          <div class="form-group">
            <label>Waste</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['WASTE_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <p class="form-control" id="noKK" name="noKK">Mesin Demet</p>
          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['KECEPATAN_MESIN']; ?></p>
          </div>
          <input type="hidden" id="hasilDiProsesEmboss" value="<?php if($emboss!="") echo $emboss['HASIL']; ?>"/>

        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label>Hasil</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['HASIL']; ?></p>
        </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['STEL_BAHAN']; ?></p>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['LAMA_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($demet!="") echo $demet['TOTAL_WAKTU']; ?></p>
          </div>
        </div>
      </div>

    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi Rewind
     </div>
     <div class="panel-body">
      <div class = "row">
      <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <p id="deliveryTime" name="deliveryTime"><?php if($rewind!="") echo $rewind['delivery_time']; ?></p>
        </div>
     </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['URUTAN_PRODUKSI']; ?></p>
          </div>
          <div class="form-group">
            <label>Waste</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['WASTE_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <p class="form-control" id="noKK" name="noKK">Mesin Rewind</p>
          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['KECEPATAN_MESIN']; ?></p>
          </div>
          <input type="hidden" id="hasilDiProsesDemet" value="<?php if($demet!="") echo $demet['HASIL']; ?>"/>

        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label>Hasil</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['HASIL']; ?></p>
        </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['STEL_BAHAN']; ?></p>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['LAMA_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($rewind!="") echo $rewind['TOTAL_WAKTU']; ?></p>
          </div>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi Sensitizing
     </div>

     <div class="panel-body">
      <div class = "row">
        <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <p id="deliveryTime" name="deliveryTime"><?php if($sensi!="") echo $sensi['delivery_time']; ?></p>
        </div>
     </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['URUTAN_PRODUKSI']; ?></p>
          </div>
          <div class="form-group">
            <label>Waste</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['WASTE_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <p class="form-control" id="noKK" name="noKK">Mesin Sensitizing</p>
          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['KECEPATAN_MESIN']; ?></p>
          </div>
          <div class="form-group">
            <label>Stel Silinder</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['STEL_SILINDER']; ?></p>
        </div>
          <input type="hidden" id="hasilDiProsesRewind" value="<?php if($rewind!="") echo $rewind['HASIL']; ?>"/>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
              <label>Hasil</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['HASIL']; ?></p>
          </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['STEL_BAHAN']; ?></p>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['LAMA_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($sensi!="") echo $sensi['TOTAL_WAKTU']; ?></p>
          </div>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel Sensi-->
</div>
</div>
 <form class="form" role="form" action="<?php echo base_url()?>index.php/ppc/saveAllData" method="post">
 <div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi Belah Dan Sortir
     </div>

     <div class="panel-body">
      <div class = "row">
        <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <p id="deliveryTime" name="deliveryTime"><?php if($belah!="") echo $belah['delivery_time']; ?></p>
        </div>
     </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['URUTAN_PRODUKSI']; ?></p>
          </div>
          <div class="form-group">
            <label>Waste</label>
            <p class="form-control" id="wasteProses" name="noKK"><?php if($belah!="") echo $belah['WASTE_PROSES']; ?>%</p>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <p class="form-control" id="noKK" name="noKK">Mesin Belah</p>

          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['KECEPATAN_MESIN']; ?></p>
          </div>
          <input type="hidden" id="hasilDiProsesSensi" value="<?php if($sensi!="") echo $sensi['HASIL']; ?>"/>

        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label>Hasil</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['HASIL']; ?></p>
        </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['STEL_BAHAN']; ?></p>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['LAMA_PROSES']; ?></p>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <p class="form-control" id="noKK" name="noKK"><?php if($belah!="") echo $belah['TOTAL_WAKTU']; ?></p>
          </div>
          <button type="submit" class="btn btn-success">Cetak KK</button>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
</form>
