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
 <form class="form" role="form" action="<?php echo base_url()?>index.php/AdminProduksiEmboss/cetakLaporan" method="post">
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
              <label>Start Date:</label>
              <input class="form-control" id="date" name="startDate"  onChange="bulanAngka()" placeholder="DD/MM/YYYY" type="text"/>
            </div>
            <div class="form-group">
              <label>Kartu Kerja</label>
              <select class="form-control" name="chooseKK" id="nomorKK">
                <option value="0-0">-- Pilih KK --</option>
                <?php 
                foreach($masterKK as $row){
                 echo '<option value="'.$row->NOMOR_KK.'@'.$row->DELIVERY_TIME.'@'.$row->KODE_BAHAN.'">'.$row->NOMOR_KK.'</option>';
                }
               ?>
               </select>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button type="submit" class=" form-control btn btn-success ">GENERATE</button>
              </div>
            </div>
            </div>
            <div class="col-lg-6">
            <br>
              <br>
                <div class="form-group">
                  <label>End Date :</label>
                  <input class="form-control" id="date2" name="endDate" placeholder="DD/MM/YYYY" type="text"/>
                </div>
            </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->

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