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
          <i class="fa fa-question-circle pull-right"></i>
          Header - Kartu Kerja
        </div>
        <div class="panel-body">
          <div class = "row">
            <form role="form" action="<?php echo base_url()?>index.php/ppc/saveHeaderKK" method="post">
              <p class='notification'><?php $this->session->flashdata('success'); ?></p>
              <div class="col-lg-6">
                <?php if($this->session->flashdata('warning')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('warning'); ?>
                        </div>
                <?php endif; ?>
                <div class="form-group">
                  <label>Tahun Desain</label>
                  <div class="form-group">
                      <select class="form-control" name="tahunDesain" id = 'tahunDesain' onChange="chooseKKAndBapob()">
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
                </div>
                <div class="form-group">
                  <label>No. KK</label>
                    <input class="form-control" name="noKK" id="noKK" onBlur="UrlExists()" placeholder="No KK" readonly>
                </div>
                <div class="form-group">
                  <label>No. BAPOB</label>
                  <input class="form-control" name="noBapob" id="noBapob" placeholder="No. BAPOB" readonly>
                </div>
                  <div class="form-group">
                    <label>Tanggal Proses Mesin</label>
                    <input class="form-control" id="date" name="tanggalProses" value="<?php if($header!="") echo $header['TGL_PROSES_MESIN']; ?>" placeholder="DD/MM/YYYY" type="text" required/>
                  </div>
                  <div class="form-group">
                    <label>Macam</label>
                    <div class="form-group">
                      <div class="col-sm-6">
                      <input class="form-control" name="macam" id="macam" value="<?php if($header!="") echo $header['MACAM']; ?>" readonly>
                      </div>
                      <div class="col-sm-6">
                        <select class="form-control" name="seri" id="seri">
                          <option value="Seri I">Seri I</option>
                          <option value="Seri II/III">Seri II/III</option>
                          <option value="Seri MMEA">Seri MMEA</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="form-group">
                    <label>Bahan</label>
                    <select class="form-control" name="chooseBahan" id="chooseBahan" required>
                      <option value="">-- Pilih Bahan --</option>

                      <!-- <?php 
                      foreach($masterBahan as $row){
                        if ($row->NAMA_BAHAN === $header['NAMA_BAHAN_BAKU']) {
                         $selected = 'selected';
                       } else {
                         $selected = '';
                       }
                       echo '<option value="'.$row->KODE_BAHAN.'@'.$row->NAMA_BAHAN.'@'.$row->LEBAR.'@'.$row->GSM.'@'.$row->PANJANG.'"'.$selected.'>'.$row->NAMA_BAHAN.'</option>';
                     }

                     ?> -->

                   </select>
                 </div>
                 <div class="form-group">
                  <label>Jumlah Pesanan</label>
                  <div class="form-group input-group">
                    <input class="form-control" name="jumlahPesanan" id="jumlahPesanan" value="<?php if($header!="") echo $header['JML_PESANAN']; ?>" placeholder="Jumlah Pesanan" onBlur=count() required>
                    <span class="input-group-addon">Meter</span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Jumlah Pesanan (Konversi)</label>
                  <div class="form-group input-group">
                    <input class="form-control" name="jumlahPesananKonversi" id="jumlahPesananKonversi" value="<?php if($header!="") echo $header['JML_PESANAN_KONVERSI']; ?>" placeholder="Jumlah Pesanan Konversi" readonly>
                    <span class="input-group-addon">Meter</span>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Panjang Bahan</label>
                  <div class="form-group input-group">
                    <input class="form-control" name="panjangBahan" id="panjangBahan" value="<?php if($header!="") echo $header['PANJANG_BAHAN']; ?>" placeholder="Panjang Bahan" onBlur=count() readonly>
                    <span class="input-group-addon">Meter</span>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label>Konversi Roll</label>
                  <div class="form-group input-group">
                    <input class="form-control" name="konversiRoll" id="konversiRoll" value="<?php if($header!="") echo $header['konversi_roll']; ?>" placeholder="jumlah roll" onBlur=count() readonly>
                    <span class="input-group-addon">Roll</span>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label>Bahan (Konversi)</label>
                  <div class="form-group input-group">
                    <input class="form-control" name="bahanKonversi" id="bahanKonversi" value="<?php if($header!="") echo $header['bahan_konversi']; ?>" placeholder="Bahan Konversi" onBlur=count() readonly>
                    <span class="input-group-addon">Meter</span>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label>Waste PET</label>
                  <div class="form-group">
                    <div class="col-sm-3">
                      <input class="form-control col-sm-2" name="percentWasteBelah" id = "percentWasteBelah" placeholder="Waste Belah" readonly>
                    </div>
                    <div class="col-sm-6 form-group input-group">
                      <input class="form-control col-sm-2" name="jumlahWasteBelah" placeholder="Waste Belah" value="<?php if($header!="") echo $header['panjangWasteBelah']; ?>" readonly>
                      <span class="input-group-addon">Meter</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Waste Pita</label>
                  <div class="form-group">
                    <div class="col-sm-3">
                      <input class="form-control col-sm-2" name="percentWastePita" id = "percentWastePita"  readonly>
                    </div>
                    <div class="col-sm-6 form-group input-group">
                      <input class="form-control col-sm-2"  name="jumlahWastePita" id="jumlahWastePita" value="<?php if($header!="") echo $header['panjangWastePita']; ?>" placeholder="Waste Pita" readonly>
                      <span class="input-group-addon">Meter</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Waste Perekatan</label>
                  <div class="form-group">
                    <div class="col-sm-3">
                      <input class="form-control col-sm-2" name="percentWastePerekatan" id = "percentWastePerekatan" placeholder="Waste Perekatan" readonly>
                    </div>
                    <div class="col-sm-6 form-group input-group">
                      <input class="form-control col-sm-2"  name="jumlahWastePerekatan" id="jumlahWastePerekatan" value="<?php if($header!="") echo $header['panjangWastePerekatan']; ?>" placeholder="Waste Perekatan" readonly>
                      <span class="input-group-addon">Meter</span>
                    </div>
                  </div>
                </div>
                
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
    var e = document.getElementById("seri");
    var seri = e.options[e.selectedIndex].value;
    var dataBapob = document.getElementById("noBapob").value;
    var kkAndBapob = <?php echo json_encode($kkAndBapob); ?>;
    for(var i=0; i<kkAndBapob.length;i++){
      if(dataBapob == kkAndBapob[i][2]){
        percentWastePerekatan = kkAndBapob[i][3];
        percentWastePita      = kkAndBapob[i][4];
        percentWasteBelah     = kkAndBapob[i][5];
        break;
      }
    }


    if(seri == "Seri MMEA"){
      
      panjangWastePerekatan = parseFloat(document.getElementById("jumlahPesanan").value) + ((parseFloat(percentWastePerekatan)/100)*parseFloat(document.getElementById("jumlahPesanan").value) );
      panjangWastePita = panjangWastePerekatan + ((parseFloat(percentWastePita)/100)*parseFloat(panjangWastePerekatan));
      panjangWasteBelah = panjangWastePita + ((parseFloat(percentWasteBelah)/100)*parseFloat(panjangWastePita));
      $('input[name="jumlahWasteBelah"]').val(numberWithCommas(panjangWasteBelah.toFixed(3))).val();
      $('input[name="jumlahWastePerekatan"]').val(numberWithCommas(panjangWastePerekatan.toFixed(3))).val();
      $('input[name="jumlahWastePita"]').val(numberWithCommas(panjangWastePita.toFixed(3))).val();
      $('input[name="panjangBahan"]').val(numberWithCommas(panjangWasteBelah.toFixed(3))).val();
      $('input[name="konversiRoll"]').val("-").val();
      $('input[name="bahanKonversi"]').val("-").val();
      $('input[name="jumlahPesananKonversi"]').val(document.getElementById("jumlahPesanan").value).val();
      $('input[name="percentWasteBelah"]').val(percentWasteBelah+"%").val();

    }else{
      panjangWastePerekatan = parseFloat(document.getElementById("jumlahPesanan").value) + ((parseFloat(percentWastePerekatan)/100)*parseFloat(document.getElementById("jumlahPesanan").value) );
      panjangWastePita = panjangWastePerekatan + ((parseFloat(percentWastePita)/100)*parseFloat(panjangWastePerekatan));
      panjangWasteBelah = panjangWastePita + ((parseFloat(percentWasteBelah)/100)*parseFloat(panjangWastePita));
      panjangWasteBelahLama = panjangWasteBelah;

      $('input[name="jumlahWasteBelah"]').val(numberWithCommas(panjangWasteBelah)).val();
      $('input[name="jumlahWastePerekatan"]').val(numberWithCommas(panjangWastePerekatan)).val();
      $('input[name="jumlahWastePita"]').val(numberWithCommas(panjangWastePita)).val();
      $('input[name="panjangBahan"]').val(numberWithCommas(panjangWasteBelah.toFixed(3))).val();
      
      jmlRoll = Math.round(panjangWasteBelah/6000);
      $('input[name="konversiRoll"]').val(jmlRoll).val();
      bahanKonversi = jmlRoll * 6000;
      $('input[name="bahanKonversi"]').val(numberWithCommas(bahanKonversi)).val();
      percentBahanKonversi = (bahanKonversi - panjangWastePita)/panjangWastePita;

      if(percentBahanKonversi<(percentWasteBelah/100) ){
        percentBahanKonversi = (percentBahanKonversi*100).toFixed(3);
        $('input[name="percentWasteBelah"]').val(percentBahanKonversi+"%").val();
        panjangWasteBelah = panjangWastePita + ((parseFloat(percentBahanKonversi)/100)*parseFloat(panjangWastePita));
        $('input[name="jumlahWasteBelah"]').val(numberWithCommas(Math.round(panjangWasteBelah))).val();
        $('input[name="jumlahPesananKonversi"]').val(numberWithCommas(document.getElementById("jumlahPesanan").value)).val();

      }else if(percentBahanKonversi>(percentWasteBelah/100) ){
        panjangWasteBelah = bahanKonversi;
        $('input[name="jumlahWasteBelah"]').val(numberWithCommas(panjangWasteBelah.toFixed(3))).val();
        panjangWastePita = panjangWasteBelah/(1+(parseFloat(percentWasteBelah)/100));
        $('input[name="jumlahWastePita"]').val(numberWithCommas(panjangWastePita.toFixed(3))).val();
        panjangWastePerekatan = panjangWastePita/(1+(parseFloat(percentWastePita)/100));
        jmlPesananKonversi = panjangWastePerekatan/(1+(parseFloat(percentWastePerekatan)/100));
        $('input[name="jumlahWastePerekatan"]').val(numberWithCommas(panjangWastePerekatan.toFixed(3))).val();
        $('input[name="jumlahPesananKonversi"]').val(numberWithCommas((jmlPesananKonversi).toFixed(3))).val();
        $('input[name="panjangBahan"]').val(numberWithCommas(panjangWasteBelahLama)).val();
        $('input[name="percentWasteBelah"]').val(percentWasteBelah+"%").val();
      }
    }
}

function checkWasteBelah(){
  var dataBapob = document.getElementById("noBapob").value;
  var kkAndBapob = <?php echo json_encode($kkAndBapob); ?>;
  var wasteBapob = null;
  for(var i=0; i<kkAndBapob.length;i++){
    if(dataBapob == kkAndBapob[i][2]){
      wasteBapob = kkAndBapob[i][5];
      break;
    }
  }
  
  var wasteKonversi = "<?php if($header!="") echo $header['percent_belah_konversi']; ?>";

  if(wasteKonversi > 0){
    if(wasteBapob != wasteKonversi){
      if(wasteKonversi>wasteBapob){
        $('input[name="percentWasteBelah"]').val(wasteBapob+"%").val();
      }else{
        $('input[name="percentWasteBelah"]').val(wasteKonversi+"%").val();
      }
    }
  }

}
function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function chooseKKAndBapob() {
    var opt = document.getElementById("tahunDesain");
    var tahunDesain = opt.options[opt.selectedIndex].value;
    var data = <?php echo json_encode($kkAndBapob); ?>;
    var kk = document.getElementById("noKK");
    var bapob = document.getElementById("noBapob");
    var percentWasteBelah = document.getElementById("percentWasteBelah");
    var percentWastePita = document.getElementById("percentWastePita");
    var percentWastePerekatan = document.getElementById("percentWastePerekatan");
    var macam = document.getElementById("macam");
    macam.value = "BCRI TAHUN "+tahunDesain;
    // console.log(data.length);
    for(var i=0; i<data.length; i++){
      if(data[i][0]==tahunDesain){
        kk.value = data[i][1];
        bapob.value = data[i][2];
        percentWastePerekatan.value = data[i][3]+"%";
        percentWastePita.value = data[i][4]+"%";
        percentWasteBelah.value = data[i][5]+"%";
      }
    }
    var dataBahan = <?php echo json_encode($masterBahan); ?>;
    var f = document.getElementById("chooseBahan");
    f.options.length = 0;
    var firstRow = document.createElement('option');
    firstRow.value = "";
    firstRow.innerHTML = "-- Pilih Bahan --";
    f.appendChild(firstRow);
    for (var i = 0; i<dataBahan.length; i++){
      if(dataBahan[i][0]==tahunDesain){
        var opt = document.createElement('option');
        opt.value = dataBahan[i][1]+"@"+dataBahan[i][2]+"@"+dataBahan[i][3]+"@"+dataBahan[i][4]+"@"+dataBahan[i][5];
        opt.innerHTML = dataBahan[i][2];
        f.appendChild(opt);
      }
    }
}

 window.onload = function() {
  chooseKKAndBapob();
  checkWasteBelah();
};

</script> 



