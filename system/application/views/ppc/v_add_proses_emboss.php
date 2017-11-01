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
<form class="form" role="form" action="<?php echo base_url()?>index.php/ppc/saveEmbossOnSession" method="post">
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
          <input class="form-control" id="date" name="deliveryDate" value="<?php if($emboss!="") echo $emboss['delivery_time']; ?>" placeholder="DD/MM/YYYY" type="text" required/>
        </div>
     </div>
      <div class = "row">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Urutan Produksi</label>
            <input class="form-control" name="urutanProduksi" value="<?php if($emboss!="") echo $emboss['URUTAN_PRODUKSI']; ?>" placeholder="Urutan Produksi" required>
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
                if ($row->NAMA_MESIN === "Mesin Emboss") {
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
            <input class="form-control" name="targetProduksi" value="<?php if($emboss!="") echo $emboss['KECEPATAN_MESIN']; ?>" readonly>
          </div>
          <div class="form-group">
            <label>Formula</label>
            <input class="form-control" name="formula" value="<?php if($header!="") echo "PCH ".$header['MACAM']; ?>" id="formula" required readonly>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Hasil</label>
            <input class="form-control" name="hasil" value="<?php if($emboss!="") echo $emboss['HASIL']; ?>" id="hasil" readonly>
          </div>
          <div class="form-group">
            <label>Stel PCH</label>
            <input class="form-control" name="stelPCH" value="<?php if($emboss!="") echo $emboss['STEL_PCH']; ?>" id="stelPCH" readonly>
          </div>
          <div class="form-group">
            <label>Stel Bahan</label>
            <input class="form-control" name="stelBahan" value="<?php if($emboss!="") echo $emboss['STEL_BAHAN']; ?>" id="stelBahan" readonly>
          </div>
          <div class="form-group">
            <label>Lama Proses</label>
            <input class="form-control" name="lamaProses" value="<?php if($emboss!="") echo $emboss['LAMA_PROSES']; ?>" id="lamaProses" readonly>
          </div>
          <div class="form-group">
            <label>Total Waktu</label>
            <input class="form-control" name="totalTime" value="<?php if($emboss!="") echo $emboss['TOTAL_WAKTU']; ?>" id="totalTime" readonly>
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

    wasteProses = "<?php if($prosesOnBapob!="") echo $prosesOnBapob->WASTE_PROSES; ?>";
    panjangBahan = "<?php echo $header['panjangWasteBelah']; ?>";
    panjangBahanKonversi= "<?php echo $header['bahan_konversi']; ?>";
    var seri = "<?php echo $header['seri']; ?>";

    if(seri == "Seri MMEA"){
      if(wasteProses != "" || wasteProses >0){
        hasil = panjangBahan-((wasteProses/100)*panjangBahan);
      }else{
        hasil = panjangBahan;
      }
    }else{
      if(wasteProses != "" || wasteProses >0){
      hasil = panjangBahanKonversi-((wasteProses/100)*panjangBahanKonversi);
      }else{
        hasil = panjangBahanKonversi;
      }
    }
    // console.log(seri);
    hasil = Math.round(hasil);
    $('input[name="hasil"]').val(hasil+ " Meter").val();

    stelPCH = hasil/6000/24;

    var zzz = waktuNaik.replace(",", ".");
    var waktuNaik = parseFloat(zzz);
    stelBahan = hasil/6000/24*waktuNaik;
    lamaProses = hasil/targetProduksi/24;

    secondsPCH = (stelPCH*24)*3600;
    secondsBahan = (stelBahan*24)*3600;
    secondsProses = (lamaProses*24)*3600;
    totalTime = secondsPCH + secondsBahan + secondsProses;

    var pchTime = convertToHour(secondsPCH);
    $('input[name="stelPCH"]').val(pchTime[0]+""+pchTime[1]+""+pchTime[2]).val();

    var bahanTime = convertToHour(secondsBahan);
    $('input[name="stelBahan"]').val(bahanTime[0]+""+bahanTime[1]+""+bahanTime[2]).val();

    var prosesTime = convertToHour(secondsProses);

    $('input[name="lamaProses"]').val(prosesTime[0]+""+prosesTime[1]+""+prosesTime[2]).val();

    var times = convertToHour(totalTime);

    $('input[name="totalTime"]').val(times[0]+""+times[1]+""+times[2]).val();


  }

  function convertToHour(time){
    var h;
    var m;
    var s;
    var d;
    var totalTime= Number(time);

    d = Math.floor(totalTime / (3600*24));
    h = Math.floor(totalTime / 3600);
    m= Math.floor(totalTime % 3600 / 60);
    s = Math.floor(totalTime% 3600 % 60);

    var result = new Array();
    if(h<10){
      h = "0"+h;
    }
    if(s<10){
      s = "0"+s;
    }
    if(m<10){
      m = "0"+m;
    }

    // Apply each element to the Date function
    // var date = new Date(<?php echo strtotime($header['TGL_PROSES_MESIN'])*1000;?>);
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
