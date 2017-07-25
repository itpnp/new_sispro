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
              <!-- <p class='notification'><?php $this->session->flashdata('existingFile'); ?></p>/ -->
                <!-- <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>Shift</th>
                          <th>Kode Roll</th>
                          <th>KK</th>
                          <th>Hasil Baik</th>
                          <th>Reject</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        for($i = 0; $i<sizeof($listBelah); $i++)
                        {
                        if($nomor%2){
                          echo "<tr>
                            <td class='warning'>".$listBelah[$i]->NO_URUT_BELAH."</td>
                            <td class='warning'>".$listBelah[$i]->SHIFT_BELAH."</td>
                            <td class='warning'>".$listBelah[$i]->KODE_ROLL."</td>
                            <td class='warning'>".$listBelah[$i]->NOMOR_KK."</td>
                            <td class='warning'>".$listBelah[$i]->BAIK_METER."</td>
                            <td class='warning'>".$listBelah[$i]->REJECT_METER."</td>
                          </tr>";
                        }else{
                          echo "<tr>
                            <td class='info'>".$listBelah[$i]->NO_URUT_BELAH."</td>
                            <td class='info'>".$listBelah[$i]->SHIFT_BELAH."</td>
                            <td class='info'>".$listBelah[$i]->KODE_ROLL."</td>
                            <td class='info'>".$listBelah[$i]->NOMOR_KK."</td>
                            <td class='info'>".$listBelah[$i]->BAIK_METER."</td>
                            <td class='info'>".$listBelah[$i]->REJECT_METER."</td>
                          </tr>";
                        }
                          $nomor++;
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div> -->
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Laporan Belah
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
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $nomor=1;
                                  for($i = 0; $i<sizeof($listBelah); $i++)
                                  {
                                  if($nomor%2){
                                    echo "<tr>
                                      <td class='warning'>".$listBelah[$i]->NO_URUT_BELAH."</td>
                                      <td class='warning'>".$listBelah[$i]->SHIFT_BELAH."</td>
                                      <td class='warning'>".$listBelah[$i]->KODE_ROLL."</td>
                                      <td class='warning'>".$listBelah[$i]->NOMOR_KK."</td>
                                      <td class='warning'>".$listBelah[$i]->BAIK_METER."</td>
                                      <td class='warning'>".$listBelah[$i]->REJECT_METER."</td>
                                    </tr>";
                                  }else{
                                    echo "<tr>
                                      <td class='info'>".$listBelah[$i]->NO_URUT_BELAH."</td>
                                      <td class='info'>".$listBelah[$i]->SHIFT_BELAH."</td>
                                      <td class='info'>".$listBelah[$i]->KODE_ROLL."</td>
                                      <td class='info'>".$listBelah[$i]->NOMOR_KK."</td>
                                      <td class='info'>".$listBelah[$i]->BAIK_METER."</td>
                                      <td class='info'>".$listBelah[$i]->REJECT_METER."</td>
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