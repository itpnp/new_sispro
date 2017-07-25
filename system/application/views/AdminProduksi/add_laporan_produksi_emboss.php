<noscript>
  <div class="alert alert-block span10">
    <h4 class="alert-heading">Warning!</h4>
    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
  </div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
     <h1 class="page-header">LAPORAN PRODUKSI</h1>
   </div>
   <!-- /.col-lg-12 -->
 </div>
 <!-- /.row -->
 <form class="form" role="form" action="<?php echo base_url()?>index.php/AdminProduksiEmboss/saveLaporanEmboss" method="post">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-green">
       <div class="panel-heading">
         <h4>Laporan Produksi Emboss</h4>
       </div>
       <div class="panel-body">
        <div class = "row">
          <div class="col-lg-6">
          <br>
          <br>
          <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('error'); ?>
                        </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('success'); ?>
                        </div>
            <?php endif; ?>
            <div class="form-group">
              <label>Tanggal Bon Emboss:</label>
              <input class="form-control" id="date" name="tanggalProses"  onChange="bulanAngka()" placeholder="DD/MM/YYYY" type="text" required/>
            </div>
            <!-- <div class="form-group">
              <label>Bulan:</label>
              <input class="form-control" name="bulan" id="bulan" placeholder="Bulan" readonly="">
            </div> -->
            <div class="form-group">
              <label>Mesin Emboss:</label>
              <select class="form-control" name="mesinEmboss">
                <option value="Mesin 1">Mesin 1</option>
                <option value="Mesin 2">Mesin 2</option>
              </select>
            </div>
            <div class="form-group">
              <label>Shift:</label>
              <select class="form-control" name="shift">
                <option value="A">Shift A</option>
                <option value="B">Shift B</option>
              </select>
            </div>
            <div class="form-group">
              <label>Kode Roll</label>
              <input class="form-control" name="kodeRoll" id="kodeRoll" value="<?php echo $kode_roll; ?>" readonly>
            </div>
            <div class="form-group">
              <label>Kartu Kerja</label>
              <select class="form-control" name="chooseKK" id="nomorKK" required>
                <option value="0-0">-- Pilih KK --</option>
                <?php 
                foreach($master_kk as $row){
                 echo '<option value="'.$row->NOMOR_KK.'@'.$row->DELIVERY_TIME.'@'.$row->KODE_BAHAN.'">'.$row->NOMOR_KK.'</option>';
                }
               ?>
               </select>
            </div>
            <div class="form-group">
              <label>Nomor Bon Emboss</label>
              <input class="form-control" name="nomorBon" id="nomorBon">
            </div>
            
        </div>
        <div class="col-lg-6">
        <br>
          <br>
            <div class="form-group">
              <label>Tanggal Produksi</label>
              <input class="form-control" id="date" name="tanggalMutasi" placeholder="DD/MM/YYYY" type="text" required/>
            </div>
            <div class="form-group">
              <label>Total Bahan:</label>
              <input class="form-control" name="totalBahan" value="<?php echo $totalBahan; ?>" id="totalBahan" onBlur = "numberWithCommas('totalBahan')" readonly>
            </div>
            <!-- <div class="form-group">
              <label>Nomor Mutasi</label>
              <input class="form-control" name="nomorMutasi" id="nomorMutasi">
            </div> -->
            <!-- <div class="form-group">
              <label>Total Bahan:</label>
              <input class="form-control" name="totalBahan" id="totalBahan" placeholder="Total Bahan" onBlur = "numberWithCommas('totalBahan')" required>
            </div> -->
            <div class="form-group">
              <label>Baik Emboss:</label>
              <input class="form-control" name="hasilBaik" id="hasilBaik" placeholder="Hasil Baik" onBlur = "numberWithCommas('hasilBaik')" required>
            </div>
            <div class="form-group">
              <label>Rusak Emboss:</label>
              <input class="form-control" name="hasilRusak" id="hasilRusak" placeholder="Hasil Rusak" onBlur = "numberWithCommas('hasilRusak')" required>
            </div>
            <!-- <div class="form-group">
              <label>Retur:</label>
              <input class="form-control" name="returMeter" id="returMeter" placeholder="Retur" onBlur = "numberWithCommas('returMeter')" required>
            </div> -->
            <div class="form-group">
              <label>Reject:</label>
              <input class="form-control" name="hasilReject" id="hasilReject" placeholder="Reject" onBlur = "numberWithCommas('hasilReject')" required>
            </div>
            <!-- <div class="form-group">
              <label>Kurang Bahan:</label>
              <input class="form-control" name="kurangBahan" id="kurangBahan" placeholder="kurangBahan" onBlur = "numberWithCommas('kurangBahan')" required>
            </div> -->
            <!-- <div class="form-group">
              <label>Sisa Baik:</label>
              <input class="form-control" name="sisaBaik" id="sisaBaik" placeholder="Sisa Baik" onBlur = "numberWithCommas('sisaBaik')" required>
            </div> -->
        </div>
      </div>

    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<div class="row">
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Jam Produksi</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start JP</label>
            <input type = "time" class="form-control" name="startTimeProduksi" id="time">

          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish JP</label>
            <input type = "time" class="form-control" name="endTimeProduksi" id="time">
          </div>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Jam Persiapan</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start A</label>
            <input type = "time" class="form-control" name="startTimePersiapan" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish A</label>
            <input type = "time" class="form-control" name="endTimePersiapan" id="time">
          </div>
        </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Jam Trouble Produksi</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start B</label>
            <input type = "time" class="form-control" name="startTimeTroubleProduksi" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish B</label>
            <input type = "time" class="form-control" name="endTimeTroubleProduksi" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div> <!-- end of panel -->
</div>
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Jam Trouble Mesin</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start C</label>
            <input type = "time" class="form-control" name="startTimeTroubleMesin" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish C</label>
            <input type = "time" class="form-control" name="endTimeTroubleMesin" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div> <!-- end of panel -->
</div>
</div>
  <div class="row">
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Tunggu Bahan - Medium</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start D</label>
            <input type = "time" class="form-control" name="startTimeTungguBahan" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish D</label>
            <input type = "time" class="form-control" name="endTimeTungguBahan" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div><!-- end of panel -->
</div>
<div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Tunggu Core</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start E</label>
            <input type = "time" class="form-control" name="startTimeTungguCore" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish E</label>
            <input type = "time" class="form-control" name="endTimeTungguCore" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div><!-- end of panel -->
</div> 
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Jam Ganti Silinder - Seri</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start F</label>
            <input type = "time" class="form-control" name="startTimeGantiSilinder" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish F</label>
            <input type = "time" class="form-control" name="endTimeGantiSilinder" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div> <!-- end of panel -->
</div>
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Force Major</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start G</label>
            <input type = "time" class="form-control" name="startTimeForceMajor" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish G</label>
            <input type = "time" class="form-control" name="endTimeForceMajor" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div> <!-- end of panel -->
</div>
  <div class="col-lg-3">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h5>Lain - Lain</h5>
     </div>
     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Start H</label>
            <input type = "time" class="form-control" name="startTimelain" id="time">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Finish H</label>
            <input type = "time" class="form-control" name="endTimelain" id="time">
          </div>
        </div>
      </div>
    </div><!-- end of Panel Body -->
  </div> <!-- end of panel -->
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <button type="submit" class=" form-control btn btn-success ">SIMPAN</button>
  </div>
</div>
</form>
<script type="text/Javascript">

  function bulanAngka(){
  var tanggal = document.getElementById("date").value;
    if(tanggal.indexOf('Januari') > -1){
      $('input[name="bulan"]').val("01").val();
    }else if(tanggal.indexOf('Februari') > -1){
      $('input[name="bulan"]').val("02").val();
    }else if(tanggal.indexOf('Maret') > -1){
      $('input[name="bulan"]').val("03").val();
    }else if(tanggal.indexOf('April') > -1){
      $('input[name="bulan"]').val("04").val();
    }else if(tanggal.indexOf('Mei') > -1){
      $('input[name="bulan"]').val("05").val();
    }else if(tanggal.indexOf('Juni') > -1){
      $('input[name="bulan"]').val("06").val();
    }else if(tanggal.indexOf('Juli') > -1){
      $('input[name="bulan"]').val("07").val();
    }else if(tanggal.indexOf('Agustus') > -1){
      $('input[name="bulan"]').val("08").val();
    }else if(tanggal.indexOf('September') > -1){
      $('input[name="bulan"]').val("09").val();
    }else if(tanggal.indexOf('Oktober') > -1){
      $('input[name="bulan"]').val("10").val();
    }else if(tanggal.indexOf('November') > -1){
      $('input[name="bulan"]').val("11").val();
    }else if(tanggal.indexOf('Desember') > -1){
      $('input[name="bulan"]').val("12").val();
    }
  }

  function numberWithCommas(name) {
    var numb = document.getElementById(""+name).value
    var result = numb.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('input[name="'+name+'"]').val(result).val();
  }
 
</script>