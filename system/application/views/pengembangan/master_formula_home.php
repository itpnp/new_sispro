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
				Setting Formula
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Id FORMULA</th>
								<th>Nama Formula</th>
								<th>Nama Mesin</th>
								<th>Viscositas</th>
								<th>Solid Contain</th>
								<th>Gramature</th>
								<th>Berat</th>
								<th>Suhu</th>
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
									<td class='warning'>".$t->ID_FORMULA."</td>
									<td class='warning'>".$t->NAMA_FORMULA."</td>
									<td class='warning'></td>
									<td class='warning'>".$t->VISCOSITAS."</td>
									<td class='warning'>".$t->SOLID_CONTAIN."</td>
									<td class='warning'>".$t->GRAMATURE."</td>
									<td class='warning'>".$t->BERAT."</td>
									<td class='warning'>".$t->SUHU."</td>
									
									</tr>";
								}else{
									echo "<tr>
									<td class='info'>".$nomor."</td>
									<td class='info'>".$t->ID_FORMULA."</td>
									<td class='info'>".$t->NAMA_FORMULA."</td>
									<td class='info'></td>
									<td class='info'>".$t->VISCOSITAS."</td>
									<td class='info'>".$t->SOLID_CONTAIN."</td>
									<td class='info'>".$t->GRAMATURE."</td>
									<td class='info'>".$t->BERAT."</td>
									<td class='info'>".$t->SUHU."</td>
									
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