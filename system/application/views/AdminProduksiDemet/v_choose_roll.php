<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Roll</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          Kode Roll Dari Mutasi Emboss
        </div>
        <div class="panel-body">
          <div class = "row">
                <div class="col-lg-12">
                <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('error'); ?>
                            </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('success'); ?>
                            </div>
                <?php endif; ?>
                  <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>KODE ROLL</th>
                          <th>METER</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        foreach($roll as $row)
                        {
                          if($row->TOTAL_BAHAN > 0){
                            if($nomor%2){
                              // $newCode = str_replace("/", "_",$row->KODE_ROLL);
                              echo "<tr>
                                <td class='warning'>".$nomor."</td>
                                <td class='warning'>".$row->KODE_ROLL."</td>
                                <td class='warning'>".$row->TOTAL_BAHAN."</td>
                                <td class='warning'><a href = 'addLaporanDemet/$row->KODE_ROLL@$row->NO_MUTASI@$row->TOTAL_BAHAN'>PILIH</a></td>
                              </tr>";
                              // <td class='warning'><a href = 'addLaporanDemet/$newCode@$row->ID_MUTASI@$row->TOTAL_BAHAN@$row->ID_ROLL@$row->ID_MUTASI'>PILIH</a></td>
                            }else{
                              // $newCode = str_replace("/", "_",$row->KODE_ROLL);
                              echo "<tr>
                                <td class='info'>".$nomor."</td>
                                <td class='info'>".$row->KODE_ROLL."</td>
                                <td class='info'>".$row->TOTAL_BAHAN."</td>
                                <td class='info'><a href = 'addLaporanDemet/$row->KODE_ROLL@$row->NO_MUTASI@$row->TOTAL_BAHAN'>PILIH</a></td>
                              </tr>";
                              // <td class='info'><a href = 'addLaporanDemet/$newCode@$row->ID_MUTASI@$row->TOTAL_BAHAN@$row->ID_ROLL'>PILIH</a></td>
                            }
                            $nomor++;
                          }
                          
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



