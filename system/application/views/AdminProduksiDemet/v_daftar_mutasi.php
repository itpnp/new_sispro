<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Mutasi</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          Daftar Roll
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
                  <form class="form" role="form" action="<?php echo base_url()?>index.php/AdminProduksiDemet/findByRollBeforeMutation" method="post">
                  <div class="col-lg-12">
                    <div class="col-lg-6">
                      <div class="form-group input-group">
                          <input type="text" placeholder="Kode Roll" name="kodeRoll" class="form-control">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                               </button>
                            </span>
                      </div>
                    </div>
                  </div>
                  </form>
                  <form role="form" action="<?php echo base_url()?>index.php/AdminProduksiDemet/formMutasi" method="post">

                  <div class="col-lg-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Mutasi</th>
                          <th>No</th>
                          <th>Kode Roll</th>
                          <th>KK</th>
                          <th>Tgl Produksi</th>
                          <th>Shift</th>
                          <th>Total Bahan</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        foreach($listDemet as $row)
                        {
                        $kk = str_replace("/", "_",$row->NOMOR_KK);
                        if($nomor%2){
                          echo "<tr>
                            <td class='warning'><input type='checkbox' name='$row->NO_URUT_DEMET' value='$row->NO_URUT_DEMET'/></td>
                            <td class='warning'>".$nomor."</td>
                            <td class='warning'>".$row->KODE_ROLL."</td>
                            <td class='warning'>".$row->NOMOR_KK."</td>
                            <td class='warning'>".$row->TGL_PRODUKSI."</td>
                            <td class='warning'>".$row->SHIFT_DEMET."</td>
                            <td class='warning'>".$row->BAIK_METER."</td>
                            </tr>";
                        }else{
                          echo "<tr>
                          <td class='info'><input type='checkbox' name='$row->NO_URUT_DEMET' value='$row->NO_URUT_DEMET'/></td>
                            <td class='info'>".$nomor."</td>
                            <td class='info'>".$row->KODE_ROLL."</td>
                            <td class='info'>".$row->NOMOR_KK."</td>
                            <td class='info'>".$row->TGL_PRODUKSI."</td>
                            <td class='info'>".$row->SHIFT_DEMET."</td>
                            <td class='info'>".$row->BAIK_METER."</td>
                          </tr>";
                        }
                          $nomor++;
                        }
                      ?>
                      </tbody>
                    </table>
                    <button type="submit" class=" form-control btn btn-success ">MUTASI</button>

                  </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
			</div>
		</div>
  </div>
</div>




