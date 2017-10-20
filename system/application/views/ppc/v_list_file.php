<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Daftar Kartu Kerja Mesin</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          List File
        </div>
        <div class="panel-body">
          <div class = "row">
            <form role="form" action="<?php echo base_url()?>index.php/ppc/saveHeaderKK" method="post">
              <p class='notification'><?php $this->session->flashdata('existingFile'); ?></p>
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>NAMA FILE</th>
                          <th>DOWNLOAD</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        for($i = 0; $i<$jumlah; $i++)
                        {
                        if($nomor%2){
                          echo "<tr>
                            <td class='warning'>".$nomor."</td>
                            <td class='warning'>".$listFile[$i]."</td>
                            <td class='warning'><button type='button' class='btn btn-danger' onclick='cetak(\"$listFile[$i]\")'>Download</button></td>
                          </tr>";
                        }else{
                          echo "<tr>
                            <td class='info'>".$nomor."</td>
                            <td class='info'>".$listFile[$i]."</td>
                            <td class='info'><button type='button' class='btn btn-danger' onclick='cetak(\"$listFile[$i]\")'>Download</button></td>
                          </tr>";
                        }
                          $nomor++;
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </form>
          </div>
        </div>
			</div>
		</div>
  </div>
</div>

<script type="text/Javascript">

  function cetak(fileName){
       fileName = fileName.replace(".","@");
       // console.log(fileName);
       window.location.href = "http://192.168.17.42:8080/barcode.webservice/downloadFile/"+fileName;
       // window.location.href = "http://192.168.17.102:8080/barcode.webservice/downloadFile/"+fileName;
  }
</script> 



