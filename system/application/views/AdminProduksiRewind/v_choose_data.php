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
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>NO MUTASI DEMET</th>
                          <th>KODE ROLL</th>
                          <th>TOTAL BAHAN</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        foreach($dataBahan as $row)
                        {
                        // $newCode = str_replace("/", "_",$row->KODE_ROLL);
                        // $totalBahan = $row->BAIK_METER;
                        // $noUrutDemet = $row->NO_URUT_DEMET;
                        if($nomor%2){
                          echo "<tr>
                            <td class='warning'>".$nomor."</td>
                            <td class='warning'>".$row->NO_MUTASI."</td>
                            <td class='warning'>".$row->KODE_ROLL."</td>
                            <td class='warning'>".$row->TOTAL_BAHAN."</td>
                            <td class='warning'><a href = 'formLaporanRewind/$row->KODE_ROLL@$row->NO_MUTASI@$row->TOTAL_BAHAN'>PILIH</a></td>
                          </tr>";
                        }else{
                          echo "<tr>
                            <td class='info'>".$nomor."</td>
                            <td class='info'>".$row->NO_MUTASI."</td>
                            <td class='info'>".$row->KODE_ROLL."</td>
                            <td class='info'>".$row->TOTAL_BAHAN."</td>
                            <td class='info'><a href = 'formLaporanRewind/$row->KODE_ROLL@$row->NO_MUTASI@$row->TOTAL_BAHAN'>PILIH</a></td>
                          </tr>";
                        }
                          $nomor++;
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
          </div>
        </div>
			</div>
		</div>
  </div>
</div>




