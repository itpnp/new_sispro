<?php

class AdminProduksi extends Controller {
	function AdminProduksi()
	{
		parent::Controller();
		session_start();
		ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
		$this->load->model('Master_mesin_model');
		$this->load->model('Master_formula_model');
		$this->load->model('Master_mesin_model');
		$this->load->model('Master_bapob_model');
		$this->load->model('Master_bahan_model');
		$this->load->model('Master_proses_model');
		$this->load->model('Master_proses_bapob_model');
		$this->load->model('Master_kk_model');
		$this->load->model('Master_terima_foil_model');
		$this->load->model('Master_laporan_emboss_model');
		$this->load->model('Master_detail_emboss_model');
		$this->load->model('Master_detail_demet_model');
		$this->load->model('Master_detail_rewind_model');
		$this->load->model('Master_detail_sensi_model');
		$this->load->model('Master_detail_belah_model');
		$this->load->model('Master_mutasi_emboss');
		
	}

	function index(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMINPROD"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksi/v_header',$data);
				$this->load->view('AdminProduksi/v_sidebar',$data);
				$this->load->view('AdminProduksi/v_home',$data);
				$this->load->view('AdminProduksi/v_footer',$data);
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function laporanPerKK(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["masterKK"] = $this->Master_kk_model->getDataKK();
			if($data["status"]=="ADMINPROD"){
				$this->load->view('AdminProduksi/v_header',$data);
				$this->load->view('AdminProduksi/v_sidebar',$data);
				$this->load->view('AdminProduksi/v_laporan_per_kk',$data);
				$this->load->view('AdminProduksi/v_footer',$data);
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function laporanHarian(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMINPROD"){
				$this->load->view('AdminProduksi/v_header',$data);
				$this->load->view('AdminProduksi/v_sidebar',$data);
				$this->load->view('AdminProduksi/v_laporan_harian',$data);
				$this->load->view('AdminProduksi/v_footer',$data);
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

function generateLaporanPerKK(){
	$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
	$time = time();
	$data = array();
	$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
	if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
		$data["masterKK"] = $this->Master_kk_model->getDataKK();
		if($data["status"]=="ADMINPROD"){
			$nomorKK = $this->input->post('chooseKK');
			if($nomorKK=="0-0"){
				redirect("AdminProduksi/laporanPerKK/");
			}
			//load librarynya terlebih dahulu
			//jika digunakan terus menerus lebih baik load ini ditaruh di auto load
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
			// set default font size
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
			require_once APPPATH.'libraries\dompdf\dompdf_config.inc.php';
			$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
			$rendererLibraryPath = APPPATH.'libraries\dompdf';
			if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
				die(
				'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
				EOL .
				'at the top of this script as appropriate for your directory structure'
				);
			}
			// create the writer
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
			// writer already created the first sheet for us, let's get it
			$objSheet = $objPHPExcel->getActiveSheet();
			// rename the sheet
			$objSheet->setTitle('Monitoring Hasil - Emboss');
			$nomorKK = explode("@", $nomorKK);
			$nomorKK = $nomorKK[0];
			$dataEmboss = $this->Master_detail_emboss_model->laporanPerKK($nomorKK);
			$dataDemet = $this->Master_detail_demet_model->laporanPerKK($nomorKK);
			$dataSensi = $this->Master_detail_sensi_model->laporanPerKK($nomorKK);
			$dataRewind = $this->Master_detail_rewind_model->laporanPerKK($nomorKK);

			if(sizeof($dataEmboss)>0){
				$this->generateEmbossPerKK($dataEmboss, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			}
			// exit();
			if(sizeof($dataDemet)>0){
				$this->generateDemetPerKK($dataDemet, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			}
			if(sizeof($dataSensi)>0){
				$this->generateSensiPerKK($dataSensi, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			}
			if(sizeof($dataRewind)>0){
				$this->generateRewindPerKK($dataRewind, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			}

			$filename = "TEST LAPORAN PRODUKSI PER KK";
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
			header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
			$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");

		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Login dulu donk...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function generateLaporanPerHari(){
	$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
	$time = time();
	$data = array();
	$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
	if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
		$data["masterKK"] = $this->Master_kk_model->getDataKK();
		if($data["status"]=="ADMINPROD"){
			$tanggal = $this->input->post('tanggalProduksi');
			$proses = $this->input->post('proses');
			
			//load librarynya terlebih dahulu
			//jika digunakan terus menerus lebih baik load ini ditaruh di auto load
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
			// set default font size
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
			require_once APPPATH.'libraries\dompdf\dompdf_config.inc.php';
			$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
			$rendererLibraryPath = APPPATH.'libraries\dompdf';
			if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
				die(
				'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
				EOL .
				'at the top of this script as appropriate for your directory structure'
				);
			}
			// create the writer
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
			// writer already created the first sheet for us, let's get it
			$objSheet = $objPHPExcel->getActiveSheet();
			// rename the sheet
			$objSheet->setTitle('LAPORAN HARIAN');

			if($proses == 'EMBOSS'){
				$data = $this->Master_detail_emboss_model->findByDate($tanggal);
			}else if($proses == 'DEMET'){
				$data = $this->Master_detail_demet_model->findByDate($tanggal);
			}else if($proses == 'REWIND'){
				$data = $this->Master_detail_rewind_model->findByDate($tanggal);
			}else if($proses == 'SENSI'){
				$data = $this->Master_detail_sensi_model->findByDate($tanggal);
			}else if($proses == 'BELAH'){
				$data = $this->Master_detail_belah_model->findByDate($tanggal);
			}
			
			if(sizeof($data)>0){
				$this->generateLaporanHarian($proses,$data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			}

			$filename = "TEST LAPORAN PRODUKSI HARIAN";
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
			header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
			$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");

		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Login dulu donk...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function generateEmbossPerKK($data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('E1')->setValue('No. KK');
    	$objSheet->getStyle('E1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('E2')->setValue('Macam');
    	$objSheet->getStyle('E2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('E3')->setValue('Mesin');
    	$objSheet->getStyle('E3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('E4')->setValue('Bahan Baku ');
    	$objSheet->getStyle('E4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('E5')->setValue('Hasil');
    	$objSheet->getStyle('E5')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_emboss_model->groupByKodeRoll($nomorKK);
    	$totalBahanDariGudang = 0;
    	foreach ($dataRoll as $roll) {
    		$totalBahanDariGudang = $totalBahanDariGudang + $this->Master_terima_foil_model->findByKodeRoll($roll->KODE_ROLL)->METER_DATANG;
    	}

    	$dataKK = $this->Master_kk_model->findByNumber($nomorKK);
    	$kodeBahan = null;
    	foreach ($dataKK as $row) {
    		$kodeBahan = $row->KODE_BAHAN;
    		break;
    	}
    	$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
    	$seri = null;
    	$desain = null;
    	foreach ($dataBahan as $row) {
    		$seri = $row->SERI;
    		$desain = $row->DESAIN;
    		break;
    	}


    	$objSheet->getCell('F1')->setValue($nomorKK);
    	$objSheet->getStyle('F1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('F2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('F2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('F3')->setValue("Mesin Emboss");
    	$objSheet->getStyle('F3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('F4')->setValue($totalBahanDariGudang);
    	$objSheet->getStyle('F4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('G4')->setValue("Meter");
    	$objSheet->getStyle('G4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('G5')->setValue("Meter");
    	$objSheet->getStyle('G5')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('F4')->getNumberFormat()->setFormatCode('#,##');

    	$rowHeader = 8;
		// write header
		$objSheet->getCell('A'.$rowHeader)->setValue('TANGGAL');
		$objSheet->getCell('B'.$rowHeader)->setValue('MSN Emboss');
		$objSheet->getCell('C'.$rowHeader)->setValue('SHIFT');
		$objSheet->getCell('D'.$rowHeader)->setValue('KODE ROLL');
		$objSheet->getCell('E'.$rowHeader)->setValue('TOTAL BAHAN');
		$objSheet->getCell('F'.$rowHeader)->setValue('BAIK EMBOSS');
		$objSheet->getCell('G'.$rowHeader)->setValue('RUSAK EMBOSS');
		$objSheet->getCell('H'.$rowHeader)->setValue('REJECT');
		$objSheet->getCell('I'.$rowHeader)->setValue('KURANG BAHAN');
		$objSheet->getCell('J'.$rowHeader)->setValue('SISA BAIK');
		$objSheet->getCell('K'.$rowHeader)->setValue('PCH');
		$objSheet->getCell('L'.$rowHeader)->setValue('JAM PRODUKSI');
		$objSheet->getCell('M'.$rowHeader)->setValue('A');
		$objSheet->getCell('N'.$rowHeader)->setValue('B');
		$objSheet->getCell('O'.$rowHeader)->setValue('C');
		$objSheet->getCell('P'.$rowHeader)->setValue('D');
		$objSheet->getCell('Q'.$rowHeader)->setValue('E');
		$objSheet->getCell('R'.$rowHeader)->setValue('F');
		$objSheet->getCell('S'.$rowHeader)->setValue('G');
		$objSheet->getCell('T'.$rowHeader)->setValue('H');
		$objSheet->getCell('U'.$rowHeader)->setValue('TOTAL JAM');


		$columnIndex = array();
		$columnIndex[0] = "A";
		$columnIndex[1] = "B";
		$columnIndex[2] = "C";
		$columnIndex[3] = "D";
		$columnIndex[4] = "E";
		$columnIndex[5] = "F";
		$columnIndex[6] = "G";
		$columnIndex[7] = "H";
		$columnIndex[8] = "I";
		$columnIndex[9] = "J";
		$columnIndex[10] = "K";
		$columnIndex[11] = "L";
		$columnIndex[12] = "M";
		$columnIndex[13] = "N";
		$columnIndex[14] = "O";
		$columnIndex[15] = "P";
		$columnIndex[16] = "Q";
		$columnIndex[17] = "R";
		$columnIndex[18] = "S";
		$columnIndex[19] = "T";
		$columnIndex[20] = "U";
		
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getStyle($columnIndex[$i].'8')->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_EMBOSS;
			$array[2] = $row->SHIFT_EMBOSS;
			$array[3] = $row->KODE_ROLL;
			$array[4] = $row->TOTAL_BAHAN;
			$array[5] = $row->BAIK_METER;
			$array[6] = $row->RETUR_METER;
			$array[7] = $row->REJECT_METER;
			$array[8] = "EMPTY";
			$array[9] = $row->SISA_BAIK;
			$array[10] = "-";
			$array[11] = $row->JAM_PROSES;
			$array[12] = $row->A;
			$array[13] = $row->B;
			$array[14] = $row->C;
			$array[15] = $row->D;
			$array[16] = $row->E;
			$array[17] = $row->F;
			$array[18] = $row->G;
			$array[19] = $row->H;
			$array[20] = "";
			// echo $row->KODE_ROLL;
			// echo "<br>";
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				if($i>10){
					$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue('=('.round(str_replace(",",".",$array[$i]), 0, PHP_ROUND_HALF_UP).'/86400)');
					$objPHPExcel->getActiveSheet()
					->getStyle($columnIndex[$i].''.$rowIndex)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				}
			}
			$rowIndex++;
		}
		$objSheet->getCell('F5')->setValue('=SUM(F'.$startIndex.':F'.$rowIndex.')');
    	$objSheet->getStyle('F5')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('F5')->getNumberFormat()->setFormatCode('#,##');
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}

    }

function generateDemetPerKK($data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('AC1')->setValue('No. KK');
    	$objSheet->getStyle('AC1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC2')->setValue('Macam');
    	$objSheet->getStyle('AC2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC3')->setValue('Mesin');
    	$objSheet->getStyle('AC3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC4')->setValue('Hasil');
    	$objSheet->getStyle('AC4')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_demet_model->groupByKodeRoll($nomorKK);
    	
    	$dataKK = $this->Master_kk_model->findByNumber($nomorKK);
    	$kodeBahan = null;
    	foreach ($dataKK as $row) {
    		$kodeBahan = $row->KODE_BAHAN;
    		break;
    	}

    	$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
    	$seri = null;
    	$desain = null;
    	foreach ($dataBahan as $row) {
    		$seri = $row->SERI;
    		$desain = $row->DESAIN;
    		break;
    	}


    	$objSheet->getCell('AD1')->setValue($nomorKK);
    	$objSheet->getStyle('AD1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AD2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('AD2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AD3')->setValue("Mesin Demet");
    	$objSheet->getStyle('AD3')->getFont()->setBold(true)->setSize(11);
    	
    	$objSheet->getCell('AE4')->setValue("Meter");
    	$objSheet->getStyle('AE4')->getFont()->setBold(true)->setSize(11);

    	$rowHeader = 8;
		// write header
		$objSheet->getCell('W'.$rowHeader)->setValue('TANGGAL');
		$objSheet->getCell('X'.$rowHeader)->setValue('MSN Demet');
		$objSheet->getCell('Y'.$rowHeader)->setValue('SHIFT');
		$objSheet->getCell('Z'.$rowHeader)->setValue('KODE ROLL');
		$objSheet->getCell('AA'.$rowHeader)->setValue('TOTAL BAHAN');
		$objSheet->getCell('AB'.$rowHeader)->setValue('BAIK DEMET');
		$objSheet->getCell('AC'.$rowHeader)->setValue('RUSAK DEMET');
		$objSheet->getCell('AD'.$rowHeader)->setValue('REJECT');
		$objSheet->getCell('AE'.$rowHeader)->setValue('KURANG BAHAN');
		$objSheet->getCell('AF'.$rowHeader)->setValue('SISA BAIK');
		$objSheet->getCell('AG'.$rowHeader)->setValue('GENERAL WHITE');
		$objSheet->getCell('AH'.$rowHeader)->setValue('PIGMENT RED');
		$objSheet->getCell('AI'.$rowHeader)->setValue('PIGMENT UV 151');
		$objSheet->getCell('AJ'.$rowHeader)->setValue('TOLUOL');
		$objSheet->getCell('AK'.$rowHeader)->setValue('.....');
		$objSheet->getCell('AL'.$rowHeader)->setValue('.....');
		$objSheet->getCell('AM'.$rowHeader)->setValue('JAM PRODUKSI');
		$objSheet->getCell('AN'.$rowHeader)->setValue('A');
		$objSheet->getCell('AO'.$rowHeader)->setValue('B');
		$objSheet->getCell('AP'.$rowHeader)->setValue('C');
		$objSheet->getCell('AQ'.$rowHeader)->setValue('D');
		$objSheet->getCell('AR'.$rowHeader)->setValue('E');
		$objSheet->getCell('AS'.$rowHeader)->setValue('F');
		$objSheet->getCell('AT'.$rowHeader)->setValue('G');
		$objSheet->getCell('AU'.$rowHeader)->setValue('H');
		$objSheet->getCell('AV'.$rowHeader)->setValue('TOTAL JAM');


		$columnIndex = array();
		$columnIndex[0] = "W";
		$columnIndex[1] = "X";
		$columnIndex[2] = "Y";
		$columnIndex[3] = "Z";
		$columnIndex[4] = "AA";
		$columnIndex[5] = "AB";
		$columnIndex[6] = "AC";
		$columnIndex[7] = "AD";
		$columnIndex[8] = "AE";
		$columnIndex[9] = "AF";
		$columnIndex[10] = "AG";
		$columnIndex[11] = "AH";
		$columnIndex[12] = "AI";
		$columnIndex[13] = "AJ";
		$columnIndex[14] = "AK";
		$columnIndex[15] = "AL";
		$columnIndex[16] = "AM";
		$columnIndex[17] = "AN";
		$columnIndex[18] = "AO";
		$columnIndex[19] = "AP";
		$columnIndex[20] = "AQ";
		$columnIndex[21] = "AR";
		$columnIndex[22] = "AS";
		$columnIndex[23] = "AT";
		$columnIndex[24] = "AU";
		$columnIndex[25] = "AV";
		
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getStyle($columnIndex[$i].'8')->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].'8')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_DEMET;
			$array[2] = $row->SHIFT_DEMET;
			$array[3] = $row->KODE_ROLL;
			$array[4] = $row->TOTAL_BAHAN;
			$array[5] = $row->BAIK_METER;
			$array[6] = $row->WASTE_METER;
			$array[7] = $row->REJECT_METER;
			$array[8] = "EMPTY";
			$array[9] = $row->SISA_BAIK;
			$array[10] = "-";
			$array[11] = "-";
			$array[12] = "-";
			$array[13] = "-";
			$array[14] = "-";
			$array[15] = "-";
			$array[16] = $row->JAM_PROSES;
			$array[17] = $row->A;
			$array[18] = $row->B;
			$array[19] = $row->C;
			$array[20] = $row->D;
			$array[21] = $row->E;
			$array[22] = $row->F;
			$array[23] = $row->G;
			$array[24] = $row->H;
			$array[25] = "";
			// echo $row->KODE_ROLL;
			// echo "<br>";
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				if($i>15){
					$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue('=('.round(str_replace(",",".",$array[$i]), 0, PHP_ROUND_HALF_UP).'/86400)');
					$objPHPExcel->getActiveSheet()
					->getStyle($columnIndex[$i].''.$rowIndex)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				}
			}
			$rowIndex++;
		}
		$objSheet->getCell('AD4')->setValue('=SUM(AB'.$startIndex.':AB'.$rowIndex.')');
    	$objSheet->getStyle('AD4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('AD4')->getNumberFormat()->setFormatCode('#,##');
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}

    }


function generateSensiPerKK($data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('BE1')->setValue('No. KK');
    	$objSheet->getStyle('BE1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE2')->setValue('Macam');
    	$objSheet->getStyle('BE2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE3')->setValue('Mesin');
    	$objSheet->getStyle('BE3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE4')->setValue('Hasil');
    	$objSheet->getStyle('BE4')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_sensi_model->groupByKodeRoll($nomorKK);
    	
    	$dataKK = $this->Master_kk_model->findByNumber($nomorKK);
    	$kodeBahan = null;
    	foreach ($dataKK as $row) {
    		$kodeBahan = $row->KODE_BAHAN;
    		break;
    	}

    	$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
    	$seri = null;
    	$desain = null;
    	foreach ($dataBahan as $row) {
    		$seri = $row->SERI;
    		$desain = $row->DESAIN;
    		break;
    	}


    	$objSheet->getCell('BF1')->setValue($nomorKK);
    	$objSheet->getStyle('BF1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BF2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('BF2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BF3')->setValue("Mesin Sensi");
    	$objSheet->getStyle('BF3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BG4')->setValue("Meter");
    	$objSheet->getStyle('BG4')->getFont()->setBold(true)->setSize(11);

    	$rowHeader = 8;
		// write header
		$columnIndex = array();
		$columnIndex[0] = "AX";
		$columnIndex[1] = "AY";
		$columnIndex[2] = "AZ";
		$columnIndex[3] = "BA";
		$columnIndex[4] = "BB";
		$columnIndex[5] = "BC";
		$columnIndex[6] = "BD";
		$columnIndex[7] = "BE";
		$columnIndex[8] = "BF";
		$columnIndex[9] = "BG";
		$columnIndex[10] = "BH";
		$columnIndex[11] = "BI";
		$columnIndex[12] = "BJ";
		$columnIndex[13] = "BK";
		$columnIndex[14] = "BL";
		$columnIndex[15] = "BM";
		$columnIndex[16] = "BN";
		$columnIndex[17] = "BO";
		$columnIndex[18] = "BP";
		$columnIndex[19] = "BQ";
		$columnIndex[20] = "BR";
		$columnIndex[21] = "BS";
		$columnIndex[22] = "BT";
		$columnIndex[23] = "BU";
		$columnIndex[24] = "BV";
		$columnIndex[25] = "BW";
		$columnIndex[26] = "BX";

		$columnTitle = array();
		$columnTitle[0] = "TANGGAL";
		$columnTitle[1] = "MSN Sensi";
		$columnTitle[2] = "SHIFT";
		$columnTitle[3] = "KODE ROLL";
		$columnTitle[4] = "TOTAL BAHAN";
		$columnTitle[5] = "BAIK SENSI";
		$columnTitle[6] = "RUSAK DEMET";
		$columnTitle[7] = "REJECT";
		$columnTitle[8] = "KURANG BAHAN";
		$columnTitle[9] = "SISA BAIK";
		$columnTitle[10] = "GENERAL WHITE";
		$columnTitle[11] = "PIGMENT SPN BLACK";
		$columnTitle[12] = "MEDIUM LC 65";
		$columnTitle[13] = "READIBLE";
		$columnTitle[14] = "TOLUOL";
		$columnTitle[15] = ".....";
		$columnTitle[16] = ".....";
		$columnTitle[17] = "JAM PRODUKSI";
		$columnTitle[18] = "A";
		$columnTitle[19] = "B";
		$columnTitle[20] = "C";
		$columnTitle[21] = "D";
		$columnTitle[22] = "E";
		$columnTitle[23] = "F";
		$columnTitle[24] = "G";
		$columnTitle[25] = "H";
		$columnTitle[26] = "TOTAL JAM";

		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_SENSI;
			$array[2] = $row->SHIFT_SENSI;
			$array[3] = $row->KODE_ROLL;
			$array[4] = $row->TOTAL_BAHAN;
			$array[5] = $row->BAIK_METER;
			$array[6] = $row->WASTE_METER;
			$array[7] = $row->REJECT_METER;
			$array[8] = "EMPTY";
			$array[9] = $row->SISA_BAIK;
			$array[10] = "-";
			$array[11] = "-";
			$array[12] = "-";
			$array[13] = "-";
			$array[14] = "-";
			$array[15] = "-";
			$array[16] = "-";
			$array[17] = $row->JAM_PROSES;
			$array[18] = $row->A;
			$array[19] = $row->B;
			$array[20] = $row->C;
			$array[21] = $row->D;
			$array[22] = $row->E;
			$array[23] = $row->F;
			$array[24] = $row->G;
			$array[25] = $row->H;
			$array[26] = "";
			// echo $row->KODE_ROLL;
			// echo "<br>";
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				if($i>16){
					$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue('=('.round(str_replace(",",".",$array[$i]), 0, PHP_ROUND_HALF_UP).'/86400)');
					$objPHPExcel->getActiveSheet()
					->getStyle($columnIndex[$i].''.$rowIndex)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				}
			}
			$rowIndex++;
		}
		$objSheet->getCell('BF4')->setValue('=SUM(BC'.$startIndex.':BC'.$rowIndex.')');
    	$objSheet->getStyle('BF4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('BF4')->getNumberFormat()->setFormatCode('#,##');
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}

    }

    function generateRewindPerKK($data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('CG1')->setValue('No. KK');
    	$objSheet->getStyle('CG1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG2')->setValue('Macam');
    	$objSheet->getStyle('CG2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG3')->setValue('Mesin');
    	$objSheet->getStyle('CG3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG4')->setValue('Hasil');
    	$objSheet->getStyle('CG4')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_rewind_model->groupByKodeRoll($nomorKK);
    	
    	$dataKK = $this->Master_kk_model->findByNumber($nomorKK);
    	$kodeBahan = null;
    	foreach ($dataKK as $row) {
    		$kodeBahan = $row->KODE_BAHAN;
    		break;
    	}

    	$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
    	$seri = null;
    	$desain = null;
    	foreach ($dataBahan as $row) {
    		$seri = $row->SERI;
    		$desain = $row->DESAIN;
    		break;
    	}


    	$objSheet->getCell('CH1')->setValue($nomorKK);
    	$objSheet->getStyle('CH1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CH2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('CH2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CH3')->setValue("Mesin Rewind");
    	$objSheet->getStyle('CH3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CI4')->setValue("Meter");
    	$objSheet->getStyle('CI4')->getFont()->setBold(true)->setSize(11);

    	$rowHeader = 8;
		// write header
		$columnIndex = array();
		$columnIndex[0] = "BZ";
		$columnIndex[1] = "CA";
		$columnIndex[2] = "CB";
		$columnIndex[3] = "CC";
		$columnIndex[4] = "CD";
		$columnIndex[5] = "CE";
		$columnIndex[6] = "CF";
		$columnIndex[7] = "CG";
		$columnIndex[8] = "CG";
		$columnIndex[9] = "CH";
		$columnIndex[10] = "CI";
		$columnIndex[11] = "CJ";
		$columnIndex[12] = "CK";
		$columnIndex[13] = "CL";
		$columnIndex[14] = "CM";
		$columnIndex[15] = "CN";
		$columnIndex[16] = "CO";
		$columnIndex[17] = "CP";
		$columnIndex[18] = "CQ";
		$columnIndex[19] = "CR";

		$columnTitle = array();
		$columnTitle[0] = "TANGGAL";
		$columnTitle[1] = "MSN Rewind";
		$columnTitle[2] = "SHIFT";
		$columnTitle[3] = "KODE ROLL";
		$columnTitle[4] = "TOTAL BAHAN";
		$columnTitle[5] = "BAIK REWIND";
		$columnTitle[6] = "RUSAK REWIND";
		$columnTitle[7] = "REJECT";
		$columnTitle[8] = "KURANG BAHAN";
		$columnTitle[9] = "SISA BAIK";
		$columnTitle[10] = "JAM PRODUKSI";
		$columnTitle[11] = "A";
		$columnTitle[12] = "B";
		$columnTitle[13] = "C";
		$columnTitle[14] = "D";
		$columnTitle[15] = "E";
		$columnTitle[16] = "F";
		$columnTitle[17] = "G";
		$columnTitle[18] = "H";
		$columnTitle[19] = "TOTAL JAM";

		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_REWIND;
			$array[2] = $row->SHIFT_REWIND;
			$array[3] = $row->KODE_ROLL;
			$array[4] = $row->TOTAL_BAHAN;
			$array[5] = $row->BAIK_METER;
			$array[6] = $row->WASTE_METER;
			$array[7] = $row->REJECT_METER;
			$array[8] = "EMPTY";
			$array[9] = $row->SISA_BAIK;
			$array[10] = $row->JAM_PROSES;
			$array[11] = $row->A;
			$array[12] = $row->B;
			$array[13] = $row->C;
			$array[14] = $row->D;
			$array[15] = $row->E;
			$array[16] = $row->F;
			$array[17] = $row->G;
			$array[18] = $row->H;
			$array[19] = "";
			// echo $row->KODE_ROLL;
			// echo "<br>";
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				if($i>9){
					$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue('=('.round(str_replace(",",".",$array[$i]), 0, PHP_ROUND_HALF_UP).'/86400)');
					$objPHPExcel->getActiveSheet()
					->getStyle($columnIndex[$i].''.$rowIndex)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				}
			}
			$rowIndex++;
		}
		$objSheet->getCell('CH4')->setValue('=SUM(CE'.$startIndex.':CE'.$rowIndex.')');
    	$objSheet->getStyle('CH4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('CH4')->getNumberFormat()->setFormatCode('#,##');
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}

    }

function generateBelahPerKK($data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('CG1')->setValue('No. KK');
    	$objSheet->getStyle('CG1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG2')->setValue('Macam');
    	$objSheet->getStyle('CG2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG3')->setValue('Mesin');
    	$objSheet->getStyle('CG3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG4')->setValue('Hasil');
    	$objSheet->getStyle('CG4')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_rewind_model->groupByKodeRoll($nomorKK);
    	
    	$dataKK = $this->Master_kk_model->findByNumber($nomorKK);
    	$kodeBahan = null;
    	foreach ($dataKK as $row) {
    		$kodeBahan = $row->KODE_BAHAN;
    		break;
    	}

    	$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
    	$seri = null;
    	$desain = null;
    	foreach ($dataBahan as $row) {
    		$seri = $row->SERI;
    		$desain = $row->DESAIN;
    		break;
    	}


    	$objSheet->getCell('CH1')->setValue($nomorKK);
    	$objSheet->getStyle('CH1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CH2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('CH2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CH3')->setValue("Mesin Rewind");
    	$objSheet->getStyle('CH3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CI4')->setValue("Meter");
    	$objSheet->getStyle('CI4')->getFont()->setBold(true)->setSize(11);

    	$rowHeader = 8;
		// write header
		$columnIndex = array();
		$columnIndex[0] = "BZ";
		$columnIndex[1] = "CA";
		$columnIndex[2] = "CB";
		$columnIndex[3] = "CC";
		$columnIndex[4] = "CD";
		$columnIndex[5] = "CE";
		$columnIndex[6] = "CF";
		$columnIndex[7] = "CG";
		$columnIndex[8] = "CG";
		$columnIndex[9] = "CH";
		$columnIndex[10] = "CI";
		$columnIndex[11] = "CJ";
		$columnIndex[12] = "CK";
		$columnIndex[13] = "CL";
		$columnIndex[14] = "CM";
		$columnIndex[15] = "CN";
		$columnIndex[16] = "CO";
		$columnIndex[17] = "CP";
		$columnIndex[18] = "CQ";
		$columnIndex[19] = "CR";

		$columnTitle = array();
		$columnTitle[0] = "TANGGAL";
		$columnTitle[1] = "MSN Rewind";
		$columnTitle[2] = "SHIFT";
		$columnTitle[3] = "KODE ROLL";
		$columnTitle[4] = "TOTAL BAHAN";
		$columnTitle[5] = "BAIK REWIND";
		$columnTitle[6] = "RUSAK REWIND";
		$columnTitle[7] = "REJECT";
		$columnTitle[8] = "KURANG BAHAN";
		$columnTitle[9] = "SISA BAIK";
		$columnTitle[10] = "JAM PRODUKSI";
		$columnTitle[11] = "A";
		$columnTitle[12] = "B";
		$columnTitle[13] = "C";
		$columnTitle[14] = "D";
		$columnTitle[15] = "E";
		$columnTitle[16] = "F";
		$columnTitle[17] = "G";
		$columnTitle[18] = "H";
		$columnTitle[19] = "TOTAL JAM";

		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_REWIND;
			$array[2] = $row->SHIFT_REWIND;
			$array[3] = $row->KODE_ROLL;
			$array[4] = $row->TOTAL_BAHAN;
			$array[5] = $row->BAIK_METER;
			$array[6] = $row->WASTE_METER;
			$array[7] = $row->REJECT_METER;
			$array[8] = "EMPTY";
			$array[9] = $row->SISA_BAIK;
			$array[10] = $row->JAM_PROSES;
			$array[11] = $row->A;
			$array[12] = $row->B;
			$array[13] = $row->C;
			$array[14] = $row->D;
			$array[15] = $row->E;
			$array[16] = $row->F;
			$array[17] = $row->G;
			$array[18] = $row->H;
			$array[19] = "";
			// echo $row->KODE_ROLL;
			// echo "<br>";
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				if($i>9){
					$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue('=('.round(str_replace(",",".",$array[$i]), 0, PHP_ROUND_HALF_UP).'/86400)');
					$objPHPExcel->getActiveSheet()
					->getStyle($columnIndex[$i].''.$rowIndex)
					->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				}
			}
			$rowIndex++;
		}
		$objSheet->getCell('CH4')->setValue('=SUM(CE'.$startIndex.':CE'.$rowIndex.')');
    	$objSheet->getStyle('CH4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('CH4')->getNumberFormat()->setFormatCode('#,##');
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}

    }
function generateLaporanHarian($proses,$data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet)
    {
		// let's bold and size the header font and write the header
		// as you can see, we can specify a range of cells, like here: cells from A1 to A4
		// write header
		$objSheet->getStyle('D5:AX5')->getFont()->setBold(true)->setSize(11);
		$objSheet->getStyle('D5:AX5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->mergeCells('A5:A6');
		$objSheet->getStyle('A5:A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getCell('A5')->setValue('NO');
		$objSheet->mergeCells('B5:B6');
		$objSheet->getStyle('B5:B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('B5:B6')->getAlignment()->setWrapText(true);
		$objSheet->getCell('B5')->setValue('KODE PROSES');
		$objSheet->mergeCells('D5:M5');
		$objSheet->getCell('D5')->setValue($proses);
		$objSheet->mergeCells('O5:R5');
		$objSheet->getCell('O5')->setValue('JAM PRODUKSI');
		$objSheet->mergeCells('S5:V5');
		$objSheet->getCell('S5')->setValue('PERSIAPAN');
		$objSheet->mergeCells('W5:Z5');
		$objSheet->getCell('W5')->setValue('TROUBLE PRODUKSI');
		$objSheet->mergeCells('AA5:AD5');
		$objSheet->getCell('AA5')->setValue('TROUBLE MESIN');
		$objSheet->mergeCells('AE5:AH5');
		$objSheet->getCell('AE5')->setValue('TUNGGU BAHAN - MEDIUM');
		$objSheet->mergeCells('AI5:AL5');
		$objSheet->getCell('AI5')->setValue('TUNGGU CORE');
		$objSheet->mergeCells('AM5:AP5');
		$objSheet->getCell('AM5')->setValue('GANTI SILINDER - SERI');
		$objSheet->mergeCells('AQ5:AT5');
		$objSheet->getCell('AQ5')->setValue('FORCE MAJOR');
		$objSheet->mergeCells('AU5:AX5');
		$objSheet->getCell('AU5')->setValue('LAIN - LAIN');

		$columnTitle = array();
		$columnTitle[0] = "NO";
		$columnTitle[1] = "KODE PROSES";
		$columnTitle[2] = "BULAN";
		$columnTitle[3] = "TANGGAL";
		$columnTitle[4] = "KK";
		$columnTitle[5] = "MSN ".$proses;
		$columnTitle[6] = "SHIFT";
		$columnTitle[7] = "KODE ROLL";
		$columnTitle[8] = "TOTAL BAHAN";
		$columnTitle[9] = "BAIK ".$proses;
		$columnTitle[10] = "RUSAK ".$proses;
		$columnTitle[11] = "REJECT";
		$columnTitle[12] = "KURANG BAHAN";
		$columnTitle[13] = "SISA BAIK";
		$columnTitle[14] = "Start JP";
		$columnTitle[15] = "S/D";
		$columnTitle[16] = "Finish JP";
		$columnTitle[17] = "SUM JP";
		$columnTitle[18] = "Start A";
		$columnTitle[19] = "S/D";
		$columnTitle[20] = "Finish A";
		$columnTitle[21] = "Sum JP";
		$columnTitle[22] = "Start B";
		$columnTitle[23] = "S/D";
		$columnTitle[24] = "Finish B";
		$columnTitle[25] = "Sum B";
		$columnTitle[26] = "Start C";
		$columnTitle[27] = "S/D";
		$columnTitle[28] = "Finish C";
		$columnTitle[29] = "Sum C";
		$columnTitle[30] = "Start D";
		$columnTitle[31] = "S/D";
		$columnTitle[32] = "Finish D";
		$columnTitle[33] = "Sum D";
		$columnTitle[34] = "Start E";
		$columnTitle[35] = "S/D";
		$columnTitle[36] = "Finish E";
		$columnTitle[37] = "Sum E";
		$columnTitle[38] = "Start F";
		$columnTitle[39] = "S/D";
		$columnTitle[40] = "Finish F";
		$columnTitle[41] = "Sum F";
		$columnTitle[42] = "Start G";
		$columnTitle[43] = "S/D";
		$columnTitle[44] = "Finish G";
		$columnTitle[45] = "Sum G";
		$columnTitle[46] = "Start H";
		$columnTitle[47] = "S/D";
		$columnTitle[48] = "Finish H";
		$columnTitle[49] = "Sum H";
		$columnIndex = array();
		$columnIndex[0] = "A";
		$columnIndex[1] = "B";
		$columnIndex[2] = "C";
		$columnIndex[3] = "D";
		$columnIndex[4] = "E";
		$columnIndex[5] = "F";
		$columnIndex[6] = "G";
		$columnIndex[7] = "H";
		$columnIndex[8] = "I";
		$columnIndex[9] = "J";
		$columnIndex[10] = "K";
		$columnIndex[11] = "L";
		$columnIndex[12] = "M";
		$columnIndex[13] = "N";
		$columnIndex[14] = "O";
		$columnIndex[15] = "P";
		$columnIndex[16] = "Q";
		$columnIndex[17] = "R";
		$columnIndex[18] = "S";
		$columnIndex[19] = "T";
		$columnIndex[20] = "U";
		$columnIndex[21] = "V";
		$columnIndex[22] = "W";
		$columnIndex[23] = "X";
		$columnIndex[24] = "Y";
		$columnIndex[25] = "Z";
		$columnIndex[26] = "AA";
		$columnIndex[27] = "AB";
		$columnIndex[28] = "AC";
		$columnIndex[29] = "AD";
		$columnIndex[30] = "AE";
		$columnIndex[31] = "AF";
		$columnIndex[32] = "AG";
		$columnIndex[33] = "AH";
		$columnIndex[34] = "AI";
		$columnIndex[35] = "AJ";
		$columnIndex[36] = "AK";
		$columnIndex[37] = "AL";
		$columnIndex[38] = "AM";
		$columnIndex[39] = "AN";
		$columnIndex[40] = "AO";
		$columnIndex[41] = "AP";
		$columnIndex[42] = "AQ";
		$columnIndex[43] = "AR";
		$columnIndex[44] = "AS";
		$columnIndex[45] = "AT";
		$columnIndex[46] = "AU";
		$columnIndex[47] = "AV";
		$columnIndex[48] = "AW";
		$columnIndex[49] = "AX";
		for($i = 0; $i < count($columnIndex); $i++){
		$objSheet->getCell($columnIndex[$i].'6')->setValue($columnTitle[$i]);
		$objSheet->getStyle($columnIndex[$i].'6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'6')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'5')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'7')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'7')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].'7')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		$rowIndex = 8;
		$array = array();
		foreach($data as $row){
		// echo $row->KODE_ROLL;
		$array[0] = "-";
		$array[1] = "II";
		$stamp = strtotime($row->TGL_PRODUKSI);
		$array[2] = date("m",$stamp);
		$array[3] = $row->TGL_PRODUKSI;
		$array[4] = $row->NOMOR_KK;
		$array[7] = $row->KODE_ROLL;
		$array[8] = $row->TOTAL_BAHAN;
		$array[9] = $row->BAIK_METER;
		if($proses == 'EMBOSS'){
			$array[10] = "0";
			$array[5] = $row->MESIN_EMBOSS;
			$array[6] = $row->SHIFT_EMBOSS;
		}else if($proses == 'DEMET'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_DEMET;
			$array[6] = $row->SHIFT_DEMET;
		}else if($proses == 'REWIND'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_REWIND;
			$array[6] = $row->SHIFT_REWIND;
		}else if($proses == 'SENSI'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_SENSI;
			$array[6] = $row->SHIFT_SENSI;
		}else if($proses == 'BELAH'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_BELAH;
			$array[6] = $row->SHIFT_BELAH;
		}
		$array[11] = $row->REJECT_METER;
		$array[12] = "EMPTY";
		$array[13] = $row->SISA_BAIK;
		$array[14] = $row->START_JAM_PRODUKSI;
		$array[15] = "s/d";
		$array[16] = $row->FINISH_JAM_PRODUKSI;
		$array[18] = $row->START_JAM_PERSIAPAN;
		$array[19] = "s/d";
		$array[20] = $row->FINISH_JAM_PERSIAPAN;
		$array[22] = $row->START_JAM_TROUBLE_PRODUKSI;
		$array[23] = "s/d";
		$array[24] = $row->FINISH_JAM_TROUBLE_PRODUKSI;
		$array[26] = $row->START_JAM_TROUBLE_MESIN;
		$array[27] = "s/d";
		$array[28] = $row->FINISH_JAM_TROUBLE_MESIN;
		$array[30] = $row->START_JAM_TUNGGU_BAHAN;
		$array[31] = "s/d";
		$array[32] = $row->FINISH_JAM_TUNGGU_BAHAN;
		$array[34] = $row->START_JAM_TUNGGU_CORE;
		$array[35] = "s/d";
		$array[36] = $row->FINISH_JAM_TUNGGU_CORE;
		$array[38] = $row->START_JAM_GANTI_SILINDER_SERI;
		$array[39] = "s/d";
		$array[40] = $row->FINISH_JAM_GANTI_SILINDER_SERI;
		$array[42] = $row->START_JAM_FORCE_MAJOR;
		$array[43] = "s/d";
		$array[44] = $row->FINISH_JAM_FORCE_MAJOR;
		$array[46] = $row->START_JAM_LAIN_LAIN;
		$array[47] = "s/d";
		$array[48] = $row->START_JAM_LAIN_LAIN;
		for($i=0;$i<count($columnIndex);$i++){
		$array[17] = '=sum(Q'.$rowIndex.'- O'.$rowIndex.')';
		$array[21] = '=sum(U'.$rowIndex.'- S'.$rowIndex.')';
		$array[25] = '=sum(Y'.$rowIndex.'- W'.$rowIndex.')';
		$array[29] = '=sum(AC'.$rowIndex.'- AA'.$rowIndex.')';
		$array[33] = '=sum(AE'.$rowIndex.'- AG'.$rowIndex.')';
		$array[37] = '=sum(AK'.$rowIndex.'- AI'.$rowIndex.')';
		$array[41] = '=sum(AO'.$rowIndex.'- AM'.$rowIndex.')';
		$array[45] = '=sum(AS'.$rowIndex.'- AQ'.$rowIndex.')';
		$array[49] = '=sum(AW'.$rowIndex.'- AU'.$rowIndex.')';
		if($i>13){
			$objPHPExcel->getActiveSheet()
			->getStyle($columnIndex[$i].''.$rowIndex)
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
		}
		$objSheet->getCell($columnIndex[$i].''.$rowIndex)->setValue($array[$i]);
		$objSheet->getStyle($columnIndex[$i].''.$rowIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].''.$rowIndex)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].''.$rowIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objSheet->getStyle($columnIndex[$i].''.$rowIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}

		$rowIndex++;
		}
		// exit();
	}
}
