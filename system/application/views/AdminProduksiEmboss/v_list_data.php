<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Hasil Produksi</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
          <div class = "row">
            <form role="form">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Laporan Emboss
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Kode Roll</th>
                                        <th>KK</th>
                                        <th>Baik Emboss</th>
                                        <th>Rusak Emboss</th>
                                        <th>Reject</th>
                                        <th>Selisih Bahan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nomor=1;
                                    for($i = 0; $i<sizeof($listEmboss); $i++)
                                    {
                                      if($listEmboss[$i]->SELISIH_BAHAN == null){
                                        $listEmboss[$i]->SELISIH_BAHAN = 0;
                                      }
                                    if($nomor%2){

                                      echo "<tr>
                                        <td class='warning'>".$listEmboss[$i]->NO_URUT_EMBOSS."</td>
                                        <td class='warning'>".$listEmboss[$i]->TGL_PRODUKSI."</td>
                                        <td class='warning'>".$listEmboss[$i]->SHIFT_EMBOSS."</td>
                                        <td class='warning'>".$listEmboss[$i]->KODE_ROLL."</td>
                                        <td class='warning'>".$listEmboss[$i]->NOMOR_KK."</td>
                                        <td class='warning'>".$listEmboss[$i]->BAIK_METER."</td>
                                        <td class='warning'>".$listEmboss[$i]->RETUR_METER."</td>
                                        <td class='warning'>".$listEmboss[$i]->REJECT_METER."</td>
                                        <td class='warning'>".$listEmboss[$i]->SELISIH_BAHAN."</td>
                                        <td class='warning'><a href = 'editLaporan/".$listEmboss[$i]->NO_URUT_EMBOSS."'>EDIT</a></td>
                                        </tr>";
                                    }else{
                                      echo "<tr>
                                        <td class='info'>".$listEmboss[$i]->NO_URUT_EMBOSS."</td>
                                        <td class='info'>".$listEmboss[$i]->TGL_PRODUKSI."</td>
                                        <td class='info'>".$listEmboss[$i]->SHIFT_EMBOSS."</td>
                                        <td class='info'>".$listEmboss[$i]->KODE_ROLL."</td>
                                        <td class='info'>".$listEmboss[$i]->NOMOR_KK."</td>
                                        <td class='info'>".$listEmboss[$i]->BAIK_METER."</td>
                                        <td class='info'>".$listEmboss[$i]->RETUR_METER."</td>
                                        <td class='info'>".$listEmboss[$i]->REJECT_METER."</td>
                                        <td class='info'>".$listEmboss[$i]->SELISIH_BAHAN."</td>
                                        <td class='info'><a href = 'editLaporan/".$listEmboss[$i]->NO_URUT_EMBOSS."'>EDIT</a></td>
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

<script type="text/Javascript">

  function cetak(fileName){
       fileName = fileName.replace(".","@");
       // console.log(fileName);
       window.location.href = "http://192.168.17.102:8080/barcode.webservice/downloadFile/"+fileName;
  }
</script> 



