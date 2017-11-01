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
<form class="form" role="form" action="<?php echo base_url()?>index.php/ppc/saveRewindOnSession" method="post">
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi Rewind
     </div>

     <div class="panel-body">
      <div class = "row">
        <div class="col-lg-6 form-group">
          <label class="control-label col-sm-4">Delivery Time :</label>
          <input class="form-control" id="date" name="deliveryDate" value="<?php if($rewind!="") echo $rewind['delivery_time']; ?>" placeholder="DD/MM/YYYY" type="text" required/>
          <!-- <p id="deliveryTime" name="deliveryTime"></p>
          <input type ="hidden" class="form-control" name="delTimeEng" id="delTimeEng" value="">
          <input type ="hidden" class="form-control" name="delTimeInd" id="delTimeInd" value=""> -->
        </div>
     </div>
     <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <input class="form-control" name="urutanProduksi" value="<?php if($rewind!="") echo $rewind['URUTAN_PRODUKSI']; ?>" placeholder="Urutan Produksi">
          </div>
          <div class="form-group">
            <label>Waste</label>
            <input class="form-control" name="wasteProses" id="wasteProses" value="<?php if($prosesOnBapob!="") echo $prosesOnBapob->WASTE_PROSES; ?>%" placeholder = "waste proses" readonly>
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <select class="form-control" name="chooseMesin" id="namaMesin" readonly>
              <option value="0-0">-- Pilih Mesin --</option>
              <?php 
              foreach($masterMesin as $row){
                if ($row->NAMA_MESIN === "Mesin Rewind") {
                     $selected = 'selected';
                } else {
                     $selected = '';
                }
                echo '<option value="'.$row->ID_MESIN.'-'.$row->KECEPATAN_MESIN.'-'.$row->NAMA_MESIN.'-'.$row->WAKTU_NAIK_MESIN.'-'.$row->WAKTU_PEMANASAN_AIR.'" '.$selected.'>'.$row->NAMA_MESIN.'</option>';
              }

              ?>

            </select>
          </div>
          <div class="form-group">
            <label>Target Produksi</label>
            <input class="form-control" name="targetProduksi" value="<?php if($rewind!="") echo $rewind['KECEPATAN_MESIN']; ?>" readonly>
          </div>
          <input type="hidden" id="hasilDiProsesDemet" value="<?php if($demet!="") echo $demet['HASIL']; ?>"/>

        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label>Hasil</label>
            <input class="form-control" name="hasil" value="<?php if($rewind!="") echo $rewind['HASIL']; ?>" id="hasil" readonly>
        </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <input class="form-control" name="stelBahan" value="<?php if($rewind!="") echo $rewind['STEL_BAHAN']; ?>" id="stelBahan" readonly>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <input class="form-control" name="lamaProses" value="<?php if($rewind!="") echo $rewind['LAMA_PROSES']; ?>" id="lamaProses" readonly>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <input class="form-control" name="totalTime" value="<?php if($rewind!="") echo $rewind['TOTAL_WAKTU']; ?>" id="totalTime" readonly>
          </div>
          <button type="submit" class="btn btn-success">SIMPAN</button>
        </div>
      </div>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
</form>

<script type="text/Javascript">
  var stelPCH;
  var stelBahan;
  var lamaProses;

  var secondsPCH;
  var secondsBahan;
  var secondsProses;
  var totalTime ;

  var d;
  var h;
  var m;
  var s;

  var wasteProses;
  var panjangBahan;
  var jmlPesanan;
  var hasil;

  function test(){
    var e = document.getElementById("namaMesin");
    var strUser = e.options[e.selectedIndex].value;
    var val = strUser.split('-');
    countSpeed(val[1], val[2], val[3], val[4]);
  }

  function countSpeed(val,mesin,waktuNaik,waktuMendidih){

    var targetProduksi = val * 60;
    $('input[name="targetProduksi"]').val(targetProduksi + " Meter/Jam").val();

    wasteProses = "<?php if($prosesOnBapob!="") echo $prosesOnBapob->WASTE_PROSES; ?>";
    panjangBahan = "<?php echo $header['panjangWastePita']; ?>";

    var hasilProsesDemet= parseFloat(document.getElementById("hasilDiProsesDemet").value);

    if(wasteProses != "" || wasteProses >0){
      hasil = hasilProsesDemet-((wasteProses/100)*panjangBahan);
    }else{
      hasil = hasilProsesDemet;
    }
    hasil = Math.round(hasil);
    $('input[name="hasil"]').val(hasil+ " Meter").val();

    var zzz = waktuNaik.replace(",", ".");
    var waktuNaik = parseFloat(zzz);

    stelBahan = ((hasilProsesDemet/6000)*waktuNaik)/24;
    lamaProses = hasilProsesDemet/targetProduksi/24;

    // stelBahan = Math.ceil(stelBahan * 100)/100;
    // lamaProses = Math.ceil(lamaProses * 100)/100;

    secondsBahan = (stelBahan*24)*3600;
    secondsProses = (lamaProses*24)*3600;
    totalTime = secondsBahan + secondsProses;

    var bahanTime = convertToHour(secondsBahan);
    $('input[name="stelBahan"]').val(bahanTime[0]+""+bahanTime[1]+""+bahanTime[2]).val();

    var prosesTime = convertToHour(secondsProses);

    $('input[name="lamaProses"]').val(prosesTime[0]+""+prosesTime[1]+""+prosesTime[2]).val();

    var times = convertToHour(totalTime);

    $('input[name="totalTime"]').val(times[0]+""+times[1]+""+times[2]).val();

    // var cb = document.getElementById('deliveryTime');
    // cb.innerHTML = times[3];
    // $('input[name="delTimeInd"]').val(times[3]).val();
  }

  function convertToHour(time){
    var d;
    var h;
    var m;
    var s;
    var totalTime= Number(time);
    
    d = Math.floor(totalTime / (3600*24));
    h = Math.floor(totalTime / 3600);
    m= Math.floor(totalTime % 3600 / 60);
    s = Math.floor(totalTime% 3600 % 60);

    if(h<10){
      h = "0"+h;
    }
    if(s<10){
      s = "0"+s;
    }
    if(m<10){
      m = "0"+m;
    }

    // var date = new Date(<?php echo strtotime($demet['delivery_time'])*1000;?>);
    // var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
    //   "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    // ];

    // var monthEngNames = ["January", "February", "March", "April", "May", "June",
    //   "July", "August", "September", "October", "Nopember", "December"
    // ];

    // date.setDate(date.getDate() + d);
    // var days = date.getDate();
    // var month = monthNames[date.getMonth()];
    // var monthEng = monthEngNames[date.getMonth()];
    // var year = date.getFullYear();
    // var deliv = days+" "+month+" "+year;
    // var delivEng = days+" "+monthEng+" "+year;

    var result = new Array();
    result[0] = h+":";
    result[1] = m+":";
    result[2] = s;
    // result[3] = deliv;
    // $('input[name="delTimeEng"]').val(delivEng).val();
    return result;
  }
   window.onload = function() {
    test();
  };
</script> 
