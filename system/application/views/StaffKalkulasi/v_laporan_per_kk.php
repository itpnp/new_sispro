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
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
       <div class="panel-heading">
         Pilih Nomor KK
       </div>
       <div class="panel-body">
        <div class = "row">
          <form role="form" action="<?php echo base_url()?>index.php/StaffKalkulasi/generateLaporanPerKK" method="post">
          <div class="col-lg-6">
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
            <button type="submit" class=" form-control btn btn-success ">Pilih</button>
        </div>
        </form>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
