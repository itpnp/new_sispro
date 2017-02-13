<noscript>
	<div class="alert alert-block span10">
		<h4 class="alert-heading">Warning!</h4>
		<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
	</div>
</noscript>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Data Setting Mesin</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading">
				Tabel Setting Mesin
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Mesin</th>
								<th>Nama Proses</th>
								<th>Kecepatan Mesin</th>
								<th>Lama Persiapan</th>
								<th>Waktu Naik Mesin</th>
								<th>Waktu Pemanasan Air</th>
								<th>Waste Proses</th>
								<th>Waktu Stel Silinder</th>
								<th>Waktu Stel Silinder 2</th>
								<th>Waktu Stel Silinder 3</th>
							    <th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							$nomor=1;
							foreach($result as $t)
							{
							 // $waktu_naik_mesin =  floatval($t->WAKTU_NAIK_MESIN);
							 // $waktu_pemanasan_air = floatval($t->WAKTU_PEMANASAN_AIR);
							 $waktu_naik_mesin=number_format(floatval($t->WAKTU_NAIK_MESIN),2,",",".");
							 $waktu_pemanasan_air=number_format(floatval($t->WAKTU_PEMANASAN_AIR),2,",",".");
								if($nomor%2){
									echo "<tr>
									<td class='warning'>".$nomor."</td>
									<td class='warning'>".$t->NAMA_MESIN."</td>
									<td class='warning'>".$t->KECEPATAN_MESIN."</td>
									<td class='warning'>".$t->LAMA_PERSIAPAN."</td>
									<td class='warning'>".$waktu_naik_mesin."</td>
									<td class='warning'>".$waktu_pemanasan_air."</td>
									<td class='warning'>".$t->WASTE_PROSES."</td>
									<td class='warning'>".$t->STEL_SILINDER."</td>
									<td class='warning'>".$t->STEL_SILINDER_2."</td>
									<td class='warning'>".$t->STEL_SILINDER_3."</td>
									</tr>";
								}else{
									echo "<tr>
									<td class='info'>".$nomor."</td>
									<td class='info'>".$t->NAMA_MESIN."</td>
									<td class='info'>".$t->KECEPATAN_MESIN."</td>
									<td class='info'>".$t->LAMA_PERSIAPAN."</td>
									<td class='warning'>".$waktu_naik_mesin."</td>
									<td class='warning'>".$waktu_pemanasan_air."</td>
									<td class='info'>".$t->WASTE_PROSES."</td>
									<td class='warning'>".$t->STEL_SILINDER."</td>
									<td class='warning'>".$t->STEL_SILINDER_2."</td>
									<td class='warning'>".$t->STEL_SILINDER_3."</td>
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