<noscript>
  <div class="alert alert-block span10">
    <h4 class="alert-heading">Warning!</h4>
    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
  </div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
     <h1 class="page-header">NERACA</h1>
   </div>
   <!-- /.col-lg-12 -->
 </div>
 <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
       <div class="panel-heading">
         BELAH
       </div>
       <div class="panel-body">
        <div class = "row">
          <form role="form" action="<?php echo base_url()?>index.php/AdminProduksiNeraca/generateNeracaBelah" method="post">
          <div class="col-lg-6">
            <div class="form-group">
              <label>BULAN</label>
              <select class="form-control" name="bulan">
                <option value="01">JANUARI</option>
                <option value="02">FEBRUARI</option>
                <option value="03">MARET</option>
                <option value="04">APRIL</option>
                <option value="05">MEI</option>
                <option value="06">JUNI</option>
                <option value="07">JULI</option>
                <option value="08">AGUSTUS</option>
                <option value="09">SEPTEMBER</option>
                <option value="10">OKTOBER</option>
                <option value="11">NOVEMBER</option>
                <option value="12">DESEMBER</option>
              </select>
            </div>
            <div class="form-group">
              <label>TAHUN</label>
              <select class="form-control" name="tahun">
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
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
