<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Daftar Roll</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          Pilih Kode Roll
        </div>
        <div class="panel-body">
          <div class = "row">
          <form role="form" action="<?php echo base_url()?>index.php/AdminProduksiRewind/pilihBahanDariDemet" method="post">

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
                  <div class="form-group">
                    <label>Bahan</label>
                    <select class="form-control" name="chooseBahan" id="namaBahan">
                      <option value="0-0">-- Pilih Bahan --</option>
                      <?php 
                      foreach($masterBahan as $row){
                        if ($row->NAMA_BAHAN === $header['NAMA_BAHAN_BAKU']) {
                         $selected = 'selected';
                       } else {
                         $selected = '';
                       }
                       echo '<option value="'.$row->KODE_BAHAN.'@'.$row->NAMA_BAHAN.'@'.$row->LEBAR.'@'.$row->GSM.'@'.$row->PANJANG.'"'.$selected.'>'.$row->NAMA_BAHAN.'</option>';
                     }
                     ?>
                   </select>
                  </div>
                  <button type="submit" class=" form-control btn btn-success ">PILIH</button>

                </div>
            </form>
          </div>
        </div>
			</div>
		</div>
  </div>
</div>