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
         MUTASI BAHAN
       </div>
       <div class="panel-body">
        <div class = "row">
          <form role="form" action="<?php echo base_url()?>index.php/AdminProduksiEmboss/saveMutasi" method="post">
          <div class="col-lg-6">
            <div class="form-group">
              <div class="form-group">
                  <label>Kode Roll</label>
                  <input class="form-control" name="kodeRollBaru" value = "<?php if($kodeRollBaru!="") echo $kodeRollBaru; ?>" readonly>
              </div> 
              <div class="form-group">
                  <label>Total Bahan Dimutasi</label>
                  <input class="form-control" name="hasilBaik" value = "<?php if($hasilBaik!="") echo $hasilBaik; ?>" readonly>
              </div> 
              <div class="form-group">
                  <label>Nomor Mutasi</label>
                  <input class="form-control" name="noMutasi" id="noMutasi">
              </div>              
              <div class="form-group">
                <label>Tanggal Mutasi</label>
                <input class="form-control" id="date" name="tanggalMutasi" placeholder="DD/MM/YYYY" type="text" required/>
              </div>
              <input type="hidden" name="idRoll" value="<?php if($idRoll!="") echo $idRoll; ?>" />
            </div>
            <button type="submit" class=" form-control btn btn-success ">SIMPAN</button>
        </div>
        </form>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
