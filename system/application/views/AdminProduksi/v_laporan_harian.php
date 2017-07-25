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
         LAPORAN HARIAN
       </div>
       <div class="panel-body">
        <div class = "row">
          <form role="form" action="<?php echo base_url()?>index.php/AdminProduksi/generateLaporanPerHari" method="post">
          <div class="col-lg-6">
          <div class="form-group">
              <label>Proses Produksi :</label>
              <select class="form-control" name="proses">
                <option value="EMBOSS">EMBOSS</option>
                <option value="DEMET">DEMET</option>
                <option value="REWIND">REWIND</option>
                <option value="SENSI">SENSI</option>
                <option value="BELAH">BELAH</option>
              </select>
            </div>
            <div class="form-group">
              <div class="form-group">
              <label>Tanggal Produksi</label>
              <input class="form-control" id="date" name="tanggalProduksi" placeholder="DD/MM/YYYY" type="text" required/>
            </div>
            </div>
            <button type="submit" class=" form-control btn btn-success ">Pilih</button>
        </div>
        </form>
      </div>
    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>
