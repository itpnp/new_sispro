<?php

class StaffKalkulasi extends Controller {
function StaffKalkulasi()
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
	}

	function index(){
		$this->load->helper('directory');
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$map = directory_map('//192.168.17.102/Test/');
			$max = sizeof($map);
			$listFiles = array();
			$index = 0;
			for($i=0; $i<$max;$i++){
				if(stristr($map[$i], '.pdf') !== FALSE ){
					// $x = str_replace("-", " ",$map[$i]);
					$listFiles[$index] = $map[$i];
					$index++;
				}
			}
			$jumlahFile = sizeof($listFiles);
			$data["listFile"] = $listFiles;
			$data["jumlah"] = $jumlahFile;

			if($data["status"]=="KALKULASI"){
				$this->load->view('StaffKalkulasi/v_header',$data);
				$this->load->view('StaffKalkulasi/v_sidebar',$data);
				$this->load->view('StaffKalkulasi/v_list_file', $data);
				$this->load->view('StaffKalkulasi/v_footer',$data);
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

	function realisasi(){
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
			if($data["status"]=="KALKULASI"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('StaffKalkulasi/v_header',$data);
				$this->load->view('StaffKalkulasi/v_sidebar',$data);
				$this->load->view('StaffKalkulasi/v_realisasi',$data);
				$this->load->view('StaffKalkulasi/v_footer',$data);
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

	function cetakLaporan()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load

        	// $startDate = $this->input->post('startDate');
        	// $endDate = $this->input->post('endDate');

        	// if($startDate != null && $endDate == null){
        	// 	redirect("StaffKalkulasi/realisasi/");
        	// }else if($startDate == null && $endDate != null){
        	// 	redirect("StaffKalkulasi/realisasi/");
        	// }else if($startDate == null && $endDate == null && $nomorKK=="0-0"){
        	// 	redirect("StaffKalkulasi/realisasi/");
        	// }
        	
        	$nomorKK = $this->input->post('chooseKK');
        	$bulan = $this->input->post('bulan');
			$nomorKK = explode("@", $nomorKK);
			$kodeBahan = $nomorKK[2];
			$nomorKK = $nomorKK[0];
			$dataBahan = $this->Master_bahan_model->getBahanFoilByKodeBahan($kodeBahan);
			// echo $kodeBahan;
			// echo "<br>";
			// echo $dataBahan[0]->DESAIN;
			// echo "<br>";
			// echo $dataBahan[0]->SERI;
			// exit();
        	// if($nomorKK!="0-0" && $startDate == null && $endDate == null){
        	// 	$data = $this->Master_detail_belah_model->findByKK($nomorKK);
        	// }else if($nomorKK!="0-0" && $startDate != null && $endDate != null){
        	// 	$data = $this->Master_detail_belah_model->findByDateRangeAndKK($startDate,$endDate,$nomorKK);
        	// }else if($nomorKK=="0-0" && $startDate != null && $endDate != null){
        	// 	$data = $this->Master_detail_belah_model->findByDateRange($startDate,$endDate);
        	// }


        	// if(sizeof($data)==0){

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
				$objSheet->setTitle('Realisasi Produksi');
				// let's bold and size the header font and write the header
				// as you can see, we can specify a range of cells, like here: cells from A1 to A4
				// write header
				$objSheet->getStyle('M1:W1')->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle('M1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('M1:W1');
				$objSheet->getCell('M1')->setValue("Executive Summary Waktu Produksi Hologram Pita Cukai Ukuran 33cm");

				$objSheet->getStyle('N2')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->getCell('N2')->setValue("Nomor KK : ");

				$objSheet->getStyle('O2:R2')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('O2:R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->mergeCells('O2:R2');
				$objSheet->getCell('O2')->setValue($nomorKK);

				$objSheet->getStyle('N3')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->getCell('N3')->setValue("Macam :");

				$objSheet->getStyle('O3:R3')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('O3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->mergeCells('O3:R3');
				$objSheet->getCell('O3')->setValue("BCRI TAHUN ".$dataBahan[0]->DESAIN." SERI ".$dataBahan[0]->SERI);

				$objSheet->getStyle('N4')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->getCell('N4')->setValue("Bahan Baku :");

				$objSheet->getStyle('N5')->getFont()->setBold(true)->setSize(9);
				$objSheet->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objSheet->getCell('N5')->setValue("Panjang Belah (Uk.33) :");

				if($bulan!='0'){
				$objSheet->getStyle('P6:Q6')->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle('P6:Q6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('P6:Q6');
				$objSheet->getCell('P6')->setValue($bulan);
				}

				$objSheet->getStyle('M7:W7')->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle('M7:W7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('M7:W7');
				$objSheet->getStyle('M7:W7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle('M7:W7')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle('M7:W7')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle('M7:W7')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
				$objSheet->getCell('M7')->setValue("Mesin Produksi");

				$rowHeader = array();
				$rowHeader[0] = "Keterangan";
				$rowHeader[1] = "Mesin Emboss";
				$rowHeader[2] = "Mesin Demet";
				$rowHeader[3] = "Mesin Rewind";
				$rowHeader[4] = "Mesin Sensitizing";
				$rowHeader[5] = "Mesin Belah";

				$rowColumnIndex = array();
				$rowColumnIndex[0] = "M";
				$rowColumnIndex[1] = "N";
				$rowColumnIndex[2] = "P";
				$rowColumnIndex[3] = "R";
				$rowColumnIndex[4] = "T";
				$rowColumnIndex[5] = "V";

				$rowRealisasi = array();
				$rowRealisasi[0] = "O";
				$rowRealisasi[1] = "Q";
				$rowRealisasi[2] = "S";
				$rowRealisasi[3] = "U";
				$rowRealisasi[4] = "W";

				$columnData = array();
				$columnData [0] = "M";
				$columnData [1] = "N";
				$columnData [2] = "O";
				$columnData [3] = "P";
				$columnData [4] = "Q";
				$columnData [5] = "R";
				$columnData [6] = "S";
				$columnData [7] = "T";
				$columnData [8] = "U";
				$columnData [9] = "V";
				$columnData [10] = "W";
			
				$rowTitle= array();
				$rowTitle[0] = "Jam Kerja Operator";
				$rowTitle[1] = "Jam Proses";
				$rowTitle[2] = "Jam Persiapan (A)";
				$rowTitle[3] = "Jam Trouble Proses Prod (B)";
				$rowTitle[4] = "Jam Trouble Mesin (C)";
				$rowTitle[5] = "Jam Tunggu Bahan (D)";
				$rowTitle[6] = "Jam Tunggu Core (E)";
				$rowTitle[7] = "Jam Ganti Silinder/Seri/PCH (F)";
				$rowTitle[8] = "Jam Force Major (G)";
				$rowTitle[9] = "Jam Kerja Lain-Lain (H)";
				$rowTitle[10] = "Total Jam Produksi";

				$objSheet->mergeCells('N8:O8');
				$objSheet->mergeCells('P8:Q8');
				$objSheet->mergeCells('R8:S8');
				$objSheet->mergeCells('T8:U8');
				$objSheet->mergeCells('V8:W8');

				for($i = 0; $i<sizeof($rowHeader);$i++){
					$objSheet->getCell($rowColumnIndex[$i].'8')->setValue($rowHeader[$i]);
					$objSheet->getStyle($rowColumnIndex[$i].'8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($rowColumnIndex[$i].'8')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($rowColumnIndex[$i].'8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($rowColumnIndex[$i].'8')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($rowColumnIndex[$i].'8')->getFont()->setBold(true)->setSize(11);

				}

				for($i = 0; $i<sizeof($columnData);$i++){
					$objSheet->getStyle($columnData[$i].'8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'8')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'8')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'9')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'9')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
					$objSheet->getStyle($columnData[$i].'9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
				}

				$objSheet->getCell('N9')->setValue("Planning");
				$objSheet->getCell('O9')->setValue("Realisasi");
				$objSheet->getCell('P9')->setValue("Planning");
				$objSheet->getCell('Q9')->setValue("Realisasi");
				$objSheet->getCell('R9')->setValue("Planning");
				$objSheet->getCell('S9')->setValue("Realisasi");
				$objSheet->getCell('T9')->setValue("Planning");
				$objSheet->getCell('U9')->setValue("Realisasi");
				$objSheet->getCell('V9')->setValue("Planning");
				$objSheet->getCell('W9')->setValue("Realisasi");

				$dataEmboss = $this->Master_detail_emboss_model->countTimeProses($nomorKK,$bulan);
				$dataDemet = $this->Master_detail_demet_model->countTimeProses($nomorKK,$bulan);
				$dataRewind = $this->Master_detail_rewind_model->countTimeProses($nomorKK,$bulan);
				$dataSensitizing = $this->Master_detail_sensi_model->countTimeProses($nomorKK,$bulan);
				$dataBelah = $this->Master_detail_belah_model->countTimeProses($nomorKK,$bulan);

				$index = 10;
				for($i = 0; $i<sizeof($rowTitle);$i++){
					for($j = 0; $j<sizeof($columnData);$j++){
						$objSheet->getCell("M".$index)->setValue($rowTitle[$i]);
						$objSheet->getStyle($columnData[$j].$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
						$objSheet->getStyle($columnData[$j].$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
						if($i == 10){
							$objSheet->getStyle($columnData[$j].$index)->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
							$objSheet->getStyle($columnData[$j].$index)->getFont()->setBold(true)->setSize(11);
							$objSheet->getStyle($columnData[$j].$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
						}
					}
					$index++;
				}
				// echo $dataEmboss[0]->JAM_PROSES;
				// exit();

			$objSheet->getCell('O11')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');

							// ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME6);

			$objSheet->getCell('O12')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O13')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O14')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_TROUBLE_MESIN), 0,PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O15')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O16')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_TUNGGU_CORE), 0,PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O17')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O18')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('O19')->setValue('=('.round(str_replace(",",".",$dataEmboss[0]->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');

			for($i=10;$i<20;$i++){
				if($i>=11){
					$objPHPExcel->getActiveSheet()
							->getStyle('O'.$i)
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				}
			}
			

			$objSheet->getCell('Q11')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q12')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q13')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q14')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_TROUBLE_MESIN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q15')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q16')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_TUNGGU_CORE), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q17')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q18')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('Q19')->setValue('=('.round(str_replace(",",".",$dataDemet[0]->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');

			for($i=10;$i<20;$i++){
				if($i>=11){
					$objPHPExcel->getActiveSheet()
							->getStyle('Q'.$i)
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				}
			}

			$objSheet->getCell('S11')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S12')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S13')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S14')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_TROUBLE_MESIN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S15')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S16')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_TUNGGU_CORE), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S17')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S18')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('S19')->setValue('=('.round(str_replace(",",".",$dataRewind[0]->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');

			for($i=10;$i<20;$i++){
				if($i>=11){
					$objPHPExcel->getActiveSheet()
							->getStyle('S'.$i)
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				}
			}

			$objSheet->getCell('U11')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U12')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U13')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U14')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_TROUBLE_MESIN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U15')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U16')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_TUNGGU_CORE), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U17')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U18')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('U19')->setValue('=('.round(str_replace(",",".",$dataSensitizing[0]->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');

			for($i=10;$i<20;$i++){
				if($i>=11){
					$objPHPExcel->getActiveSheet()
							->getStyle('U'.$i)
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				}
			}

			$objSheet->getCell('W11')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W12')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W13')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W14')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_TROUBLE_MESIN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W15')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W16')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_TUNGGU_CORE), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W17')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W18')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
			$objSheet->getCell('W19')->setValue('=('.round(str_replace(",",".",$dataBelah[0]->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');

			for($i=10;$i<20;$i++){
				if($i>=11){
					$objPHPExcel->getActiveSheet()
							->getStyle('W'.$i)
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				}
			}

			for($i=0;$i<sizeof($rowRealisasi);$i++){
				// echo ('=SUM('.$rowRealisasi[$i].'11:'.$rowRealisasi[$i].'19');
				$objSheet->getStyle($rowRealisasi[$i].'20')->getFont()->setBold(true)->setSize(11);
				$objPHPExcel->getActiveSheet()
							->getStyle($rowRealisasi[$i].'20')
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				$objSheet->getCell($rowRealisasi[$i].'20')->setValue('=SUM('.$rowRealisasi[$i].'11:'.$rowRealisasi[$i].'19)');

				$objSheet->getStyle($rowRealisasi[$i].'10')->getFont()->setBold(true)->setSize(11);
				$objPHPExcel->getActiveSheet()
							->getStyle($rowRealisasi[$i].'10')
							->getNumberFormat()
							->setFormatCode('[h]:mm:ss');
				$objSheet->getCell($rowRealisasi[$i].'10')->setValue('=SUM('.$rowRealisasi[$i].'11:'.$rowRealisasi[$i].'19)');

			}
			// exit();


				// autosize the columns
				// for($j = 0; $j<sizeof($columnData);$j++){
					$objSheet->getColumnDimension('M')->setAutoSize(true);
				// }
		        $filename = "Realisasi";
		        // We'll be outputting an excel file
				header('Content-type: application/vnd.ms-excel');

				// It will be called file.xls
				header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');

				// Write file to the browser
				$objWriter->save('php://output');
		        // $objWriter->save("D://Test/".$filename.".xlsx");

		  //   }else{
		  //   	$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
				// redirect("StaffKalkulasi/realisasi/");
	   //      }

        }
}