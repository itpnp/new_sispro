<noscript>
    <div class="alert alert-block span10">
        <h4 class="alert-heading">Warning!</h4>
        <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
    </div>
</noscript>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">PPC - Setting Mesin</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading">
               Setting Mesin
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Mesin</th>
                                <th>Nama Mesin</th>
                                <th>Nama Proses</th>
                                <th>Kecepatan Mesin</th>
                                <th>Lama Persiapan</th>
                                <th>Waste Stel</th>
                                <th>Waste Proses</th>
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
                                    <td class='warning'>".$t->ID_MESIN."</td>
                                    <td class='warning'>".$t->NAMA_MESIN."</td>
                                    <td class='warning'>".$t->ID_MASTER_PROSES."</td>
                                    <td class='warning'>".$t->KECEPATAN_MESIN."</td>
                                    <td class='warning'>".$t->LAMA_PERSIAPAN."</td>
                                    <td class='warning'>".$t->WASTE_STEL."</td>
                                    <td class='warning'>".$t->WASTE_PROSES."</td>
                                    </tr>";
                                }else{
                                    echo "<tr>
                                    <td class='info'>".$nomor."</td>
                                    <td class='info'>".$t->ID_MESIN."</td>
                                    <td class='info'>".$t->NAMA_MESIN."</td>
                                    <td class='info'>".$t->ID_MASTER_PROSES."</td>
                                    <td class='info'>".$t->KECEPATAN_MESIN."</td>
                                    <td class='info'>".$t->LAMA_PERSIAPAN."</td>
                                    <td class='info'>".$t->WASTE_STEL."</td>
                                    <td class='info'>".$t->WASTE_PROSES."</td>
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