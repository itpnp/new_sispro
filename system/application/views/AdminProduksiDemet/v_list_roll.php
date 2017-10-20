<noscript>
  <div class="alert alert-block span10">
    <h4 class="alert-heading">Warning!</h4>
    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
  </div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Saldo</h1>
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
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nomor=1;
                        foreach($listRoll as $row)
                        {
                            if($nomor%2){
                              echo "<tr>
                                <td class='warning'>".$nomor."</td>
                                <td class='warning'>".$row->KODE_ROLL."</td>
                                <td class='warning'>".$row->TOTAL_BAHAN."</td>
                              </tr>";
                            }else{
                              echo "<tr>
                                <td class='info'>".$nomor."</td>
                                <td class='info'>".$row->KODE_ROLL."</td>
                                <td class='info'>".$row->TOTAL_BAHAN."</td>
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




