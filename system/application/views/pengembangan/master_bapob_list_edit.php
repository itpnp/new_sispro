<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Home</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading">
				List Data BAPOB
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Jenis Foil</th>
								<th>Nomor BAPOB</th>
								<th>Tanggal Pembuatan BAPOB</th>
								<th>Jumlah Pesanan</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							$nomor=1;
							foreach($result as $t)
							{
							$status_lock=$t->STATUS_LOCK; 
								if($nomor%2){
									echo "<tr>
									<td class='warning'>".$nomor."</td>
									<td class='warning'>".$t->NAMA_BAHAN."</td>
									<td class='warning'>".$t->NOMOR_BAPOB."</td>
									<td class='warning'>".$t->TANGGAL_DIBUAT."</td>
									<td class='warning'>".$t->JML_PESANAN."</td>";
									if($status_lock =='0') {
									echo	"<td class='warning'>
										    <a class='btn btn-info'  href='".base_url()."index.php/pengembangan/updateDataBapob/".$t->ID_BAPOB."' title='Edit'>
											Edit
										</a>
									</td>";
									}
								   echo "</tr>";
								}else{
									echo "<tr>
									<td class='warning'>".$nomor."</td>
									<td class='warning'>".$t->NAMA_BAHAN."</td>
									<td class='warning'>".$t->NOMOR_BAPOB."</td>
									<td class='warning'>".$t->TANGGAL_DIBUAT."</td>
									<td class='warning'>".$t->JML_PESANAN."</td>";
									if($status_lock =='0') {
									echo	"<td class='warning'>
										    <a class='btn btn-info'  href='".base_url()."index.php/pengembangan/updateDataBapob/".$t->ID_BAPOB."' title='Edit'>
											Edit
										</a>
									</td>";
									}
								   echo "</tr>";
								}
								
								$nomor++;
							}
							?>
						</tbody>
					</table>
				
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>