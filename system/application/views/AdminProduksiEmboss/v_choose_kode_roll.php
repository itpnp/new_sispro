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
              <p class='notification'><?php $this->session->flashdata('existingFile'); ?></p>
                <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>KODE BAHAN</th>
                          <th>KODE ROLL</th>
                          <th>METER DATANG</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        foreach($list_kode_roll as $row)
                        {
                        if($nomor%2){
                          echo "<tr>
                            <td class='warning'>".$nomor."</td>
                            <td class='warning'>".$row->KODE_BAHAN."</td>
                            <td class='warning'>".$row->KODE_ROLL."</td>
                            <td class='warning'>".$row->METER_DATANG."</td>
                            <td class='warning'><a href = 'addProduksiEmboss/$row->KODE_ROLL@$row->METER_DATANG@$row->ID_ROLL'>PILIH</a></td>
                          </tr>";
                        }else{
                          echo "<tr>
                            <td class='info'>".$nomor."</td>
                            <td class='info'>".$row->KODE_BAHAN."</td>
                            <td class='info'>".$row->KODE_ROLL."</td>
                            <td class='info'>".$row->METER_DATANG."</td>
                            <td class='info'><a href = 'addProduksiEmboss/$row->KODE_ROLL@$row->METER_DATANG@$row->ID_ROLL'>PILIH</a></td>
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

<script type="text/Javascript">

  function cetak(kodeBahan){

  }
</script> 



