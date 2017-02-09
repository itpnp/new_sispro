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
 <form class="form-horizontal" role="form" action="<?php echo base_url()?>index.php/ppc/saveEmbossOnSession" method="post">
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
                <input type="text" class="form-control" id="email" value="<?php echo $header['NO_KK']; ?>" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">No. BAPOB:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="email" value="<?php echo $bapob->NOMOR_BAPOB; ?>" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Tanggal Proses:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="email" value="<?php echo $header['TGL_PROSES_MESIN']; ?>"  disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Macam:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="email" value="<?php if($header!="") echo $header['MACAM']; ?>"  disabled>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-6">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-sm-4">Jumlah Pesanan</label>
              <div class="col-sm-8">
                <input class="form-control" name="jmlPesanan" id="jmlPesanan" value="<?php echo $header['JML_PESANAN']; ?>" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Waste Proses</label>
              <div class="col-sm-8">
                <input class="form-control" name="wasteProses"  value="<?php echo $header['JUMLAH_WASTE_PROSES']; ?>" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Panjang Bahan:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="panjangBahan" value="<?php echo $header['PANJANG_BAHAN']; ?>"  disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4">Nama Bahan:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="bahan" value="<?php echo $header['NAMA_BAHAN_BAKU']; ?>"  disabled>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
<form class="form" role="form" action="<?php echo base_url()?>index.php/ppc/saveSensiOnSession" method="post">
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
     <div class="panel-heading">
       Proses Produksi Sensitizing
     </div>

     <div class="panel-body">
      <div class = "row">

        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <input class="form-control" name="urutanProduksi" value="<?php if($sensi!="") echo $sensi['URUTAN_PRODUKSI']; ?>" placeholder="Urutan Produksi">
          </div>
          <div class="form-group">
            <label>Waste</label>
            <input class="form-control" name="wasteProses" id="wasteProses" value="<?php if($sensi!="") echo $sensi['WASTE_PROSES']; ?>" placeholder = "waste proses" onblur="test()">
          </div>
          <div class="form-group">
            <label>Mesin</label>
            <select class="form-control" name="chooseMesin" id="namaMesin" readonly>
              <option value="0-0">-- Pilih Mesin --</option>
              <?php 
              foreach($masterMesin as $row){
                if ($row->NAMA_MESIN === "Mesin Sensitizing") {
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
            <input class="form-control" name="targetProduksi" value="<?php if($sensi!="") echo $sensi['KECEPATAN_MESIN']; ?>" readonly>
          </div>
          <div class="form-group">
            <label>Stel Silinder</label>
            <input class="form-control" name="stelSilinder" value="<?php if($sensi!="") echo $sensi['STEL_SILINDER']; ?>" id="stelSilinder" readonly>
        </div>
          <input type="hidden" id="hasilDiProsesRewind" value="<?php if($rewind!="") echo $rewind['HASIL']; ?>"/>

        </div>
        <div class="col-lg-6">
          <div class="form-group">
              <label>Hasil</label>
              <input class="form-control" name="hasil" value="<?php if($sensi!="") echo $sensi['HASIL']; ?>" id="hasil" readonly>
          </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <input class="form-control" name="stelBahan" value="<?php if($sensi!="") echo $sensi['STEL_BAHAN']; ?>" id="stelBahan" readonly>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <input class="form-control" name="lamaProses" value="<?php if($sensi!="") echo $sensi['LAMA_PROSES']; ?>" id="lamaProses" readonly>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <input class="form-control" name="totalTime" value="<?php if($sensi!="") echo $sensi['TOTAL_WAKTU']; ?>" id="totalTime" readonly>
          </div>
          <button type="submit" class="btn btn-success">SIMPAN</button>
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

    wasteProses = document.getElementById("wasteProses").value;
    panjangBahan = document.getElementById("panjangBahan").value;
    jmlPesanan = document.getElementById("jmlPesanan").value;

    var hasilProsesRewind= parseInt(document.getElementById("hasilDiProsesRewind").value);

    if(wasteProses != "" || wasteProses >0){
      hasil = hasilProsesRewind-((wasteProses/100)*jmlPesanan);
    }else{
      hasil = hasilProsesRewind;
    }
    $('input[name="hasil"]').val(hasil+ " Meter").val();


    var zzz = waktuNaik.replace(",", ".");
    var waktuNaik = parseFloat(zzz);

    zzz = waktuMendidih.replace(",",".");
    var waktuMendidih = parseFloat(zzz);

    var shift = (targetProduksi*17)/6000;
  
    stelBahan = (((hasilProsesRewind/6000)*waktuNaik) + ((hasilProsesRewind/6000)/shift*waktuMendidih))/24;
    lamaProses =  hasilProsesRewind/targetProduksi/24;


    // stelBahan = Math.ceil(stelBahan * 100)/100;
    // lamaProses = Math.ceil(lamaProses * 100)/100;

    secondsBahan = (stelBahan*24)*3600;
    secondsProses = (lamaProses*24)*3600;
    totalTime = secondsBahan + secondsProses;
;

    var bahanTime = convertToHour(secondsBahan);
    $('input[name="stelBahan"]').val(bahanTime[0]+""+bahanTime[1]+""+bahanTime[2]).val();
    $('input[name="stelSilinder"]').val("01:00:00").val();
    var prosesTime = convertToHour(secondsProses);
    $('input[name="lamaProses"]').val(prosesTime[0]+""+prosesTime[1]+""+prosesTime[2]).val();

    var times = convertToHour(totalTime);
    $('input[name="totalTime"]').val(times[0]+""+times[1]+""+times[2]).val();

  }

  function convertToHour(time){
    var h;
    var m;
    var s;
    var totalTime= Number(time);

    h = Math.floor(totalTime / 3600);
    m= Math.floor(totalTime % 3600 / 60);
    s = Math.floor(totalTime% 3600 % 60);

    // var hDisplay = h > 0 ? h + (h == 1 ? " hour" : " jam ") : "";
    // var mDisplay = m > 0 ? m + (m == 1 ? " minute " : " menit ") : "";
    // var sDisplay = s > 0 ? s + (s == 1 ? " second" : " detik ") : "";

    var result = new Array();

    result[0] = h+":";
    result[1] = m+":";
    result[2] = s;

    return result;

  }
</script> 
