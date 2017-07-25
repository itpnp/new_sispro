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
            <form role="form">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Laporan Sensitizing
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                 <thead>
                                    <tr>
                                      <th>NO</th>
                                      <th>Shift</th>
                                      <th>Kode Roll</th>
                                      <th>KK</th>
                                      <th>Hasil Baik</th>
                                      <th>Reject</th>
                                      <th>Tanggal Produksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $nomor=1;
                                    for($i = 0; $i<sizeof($listSensi); $i++)
                                    {
                                    if($nomor%2){
                                      echo "<tr>
                                        <td class='warning'>".$listSensi[$i]->NO_URUT_SENSI."</td>
                                        <td class='warning'>".$listSensi[$i]->SHIFT_SENSI."</td>
                                        <td class='warning'>".$listSensi[$i]->KODE_ROLL."</td>
                                        <td class='warning'>".$listSensi[$i]->NOMOR_KK."</td>
                                        <td class='warning'>".$listSensi[$i]->BAIK_METER."</td>
                                        <td class='warning'>".$listSensi[$i]->REJECT_METER."</td>
                                        <td class='warning'>".$listSensi[$i]->TGL_PRODUKSI."</td>
                                      </tr>";
                                    }else{
                                      echo "<tr>
                                        <td class='info'>".$listSensi[$i]->NO_URUT_SENSI."</td>
                                        <td class='info'>".$listSensi[$i]->SHIFT_SENSI."</td>
                                        <td class='info'>".$listSensi[$i]->KODE_ROLL."</td>
                                        <td class='info'>".$listSensi[$i]->NOMOR_KK."</td>
                                        <td class='info'>".$listSensi[$i]->BAIK_METER."</td>
                                        <td class='info'>".$listSensi[$i]->REJECT_METER."</td>
                                        <td class='info'>".$listSensi[$i]->TGL_PRODUKSI."</td>
                                      </tr>";
                                    }
                                      $nomor++;
                                    }
                                  ?>
                                  </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
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
       window.location.href = "http://192.168.17.102:8080/barcode.webservice/downloadFile/"+fileName;
  }
</script> 



