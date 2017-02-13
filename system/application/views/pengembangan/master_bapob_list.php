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
								
							</tr>
						</thead>
						<tbody>
							<?php
							
							$nomor=1;
							foreach($result as $t)
							{
								if($nomor%2){
									echo "<tr>
									<td class='warning'>".$nomor."</td>
									<td class='warning'>".$t->NAMA_BAHAN."</td>
									<td class='warning'>".$t->NOMOR_BAPOB."</td>
									<td class='warning'>".$t->TANGGAL_DIBUAT."</td>
									<td class='warning'>".$t->JML_PESANAN."</td>
									</tr>";
								}else{
									echo "<tr>
									<td class='warning'>".$nomor."</td>
									<td class='warning'>".$t->NAMA_BAHAN."</td>
									<td class='warning'>".$t->NOMOR_BAPOB."</td>
									<td class='warning'>".$t->TANGGAL_DIBUAT."</td>
									<td class='warning'>".$t->JML_PESANAN."</td>
									
									</tr>";
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