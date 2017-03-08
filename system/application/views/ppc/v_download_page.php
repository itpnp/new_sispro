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
              <div class="col-sm-8">
              <p id="asas" name="asas">Downloading File...</p>
            </div>
            </div>
           
        </div>
      </div>

    </div><!--end of Panel Body-->
  </div><!-- end of panel-->
</div>
</div>

<script type="text/javascript">
  function cetak(){
    var fileName = "<?php echo $header;?>";
      fileName = fileName.replace(/\//g,"-");
      window.location.href = "http://192.168.17.102:8083/barcode.webservice/convert/"+fileName;
  }

  window.onload = function() {
    cetak();
  };

</script>