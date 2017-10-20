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
			if($data["status"]=="KALKULASI"){
				$this->load->view('StaffKalkulasi/v_header',$data);
				$this->load->view('StaffKalkulasi/v_sidebar',$data);
				$this->load->view('StaffKalkulasi/v_laporan_per_kk',$data);
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
			if($data["status"]=="KALKULASI"){
				$this->load->view('StaffKalkulasi/v_header',$data);
				$this->load->view('StaffKalkulasi/v_sidebar',$data);
				$this->load->view('StaffKalkulasi/v_laporan_harian',$data);
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

	function laporanBulanan(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="KALKULASI"){
				$this->load->view('StaffKalkulasi/v_header',$data);
				$this->load->view('StaffKalkulasi/v_sidebar',$data);
				$this->load->view('StaffKalkulasi/v_laporan_bulanan',$data);
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
		if($data["status"]=="KALKULASI"){
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
			$objSheet->setTitle('Monitoring Hasil');
			$nomorKK = explode("@", $nomorKK);
			$nomorKK = $nomorKK[0];
			$dataEmboss = $this->Master_detail_emboss_model->laporanPerKK($nomorKK);
			$dataDemet = $this->Master_detail_demet_model->laporanPerKK($nomorKK);
			$dataSensi = $this->Master_detail_sensi_model->laporanPerKK($nomorKK);
			$dataRewind = $this->Master_detail_rewind_model->laporanPerKK($nomorKK);
			$dataBelah = $this->Master_detail_belah_model->laporanPerKK($nomorKK);

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

			if(sizeof($dataEmboss)>0){
				$index = $this->generateEmbossPerKK($nomorKK,$seri,$desain,$dataEmboss, $objPHPExcel, $objWriter, $objSheet);
			}
			// exit();
			if(sizeof($dataDemet)>0){
				$this->generateDemetPerKK($nomorKK,$seri,$desain,$dataDemet, $objPHPExcel, $objWriter, $objSheet);
			}
			if(sizeof($dataSensi)>0){
				$this->generateSensiPerKK($nomorKK,$seri,$desain,$dataSensi, $objPHPExcel, $objWriter, $objSheet);
			}
			if(sizeof($dataRewind)>0){
				$this->generateRewindPerKK($nomorKK,$seri,$desain,$dataRewind, $objPHPExcel, $objWriter, $objSheet);
			}
			if(sizeof($dataBelah)>0){
				$this->generateBelahPerKK($nomorKK,$seri,$desain,$dataBelah, $objPHPExcel, $objWriter, $objSheet);
			}
			$this->executiveSummary($index,$nomorKK, $objPHPExcel, $objWriter, $objSheet);

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
		if($data["status"]=="KALKULASI"){
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

function generateEmbossPerKK($nomorKK,$seri,$desain,$data, $objPHPExcel, $objWriter, $objSheet)
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

    	$dataRoll = $this->Master_detail_emboss_model->groupByKodeRoll($nomorKK);
    	$totalBahanDariGudang = 0;
    	foreach ($dataRoll as $roll) {
    		$totalBahanDariGudang = $totalBahanDariGudang + $this->Master_terima_foil_model->findByKodeRoll($roll->KODE_ROLL)->METER_DATANG;
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
		//Border settings
        $borders = array(
	      'borders' => array(
	        'inside'     => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	            'argb' => '00000000'
	          )
	        ),
	        'outline' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	             'argb' => '00000000'
	          )
	        )
	      )
	    );
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getStyle($columnIndex[$i].'8')->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].'8')->applyFromArray($borders);

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
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->applyFromArray($borders);

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
		return $rowIndex;

    }

function generateDemetPerKK($nomorKK,$seri,$desain,$data, $objPHPExcel, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('AC1')->setValue('No. KK');
    	$objSheet->getStyle('AC1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC2')->setValue('Macam');
    	$objSheet->getStyle('AC2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC3')->setValue('Mesin');
    	$objSheet->getStyle('AC3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('AC4')->setValue('Hasil');
    	$objSheet->getStyle('AC4')->getFont()->setBold(true)->setSize(11);

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
		
		$borders = array(
	      'borders' => array(
	        'inside'     => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	            'argb' => '00000000'
	          )
	        ),
	        'outline' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	             'argb' => '00000000'
	          )
	        )
	      )
	    );
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getStyle($columnIndex[$i].'8')->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].'8')->applyFromArray($borders);

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
	
			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->applyFromArray($borders);

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


function generateSensiPerKK($nomorKK,$seri,$desain,$data, $objPHPExcel, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('BE1')->setValue('No. KK');
    	$objSheet->getStyle('BE1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE2')->setValue('Macam');
    	$objSheet->getStyle('BE2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE3')->setValue('Mesin');
    	$objSheet->getStyle('BE3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('BE4')->setValue('Hasil');
    	$objSheet->getStyle('BE4')->getFont()->setBold(true)->setSize(11);

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
		$borders = array(
	      'borders' => array(
	        'inside'     => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	            'argb' => '00000000'
	          )
	        ),
	        'outline' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	             'argb' => '00000000'
	          )
	        )
	      )
	    );
		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->applyFromArray($borders);

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

			for($i = 0; $i < count($columnIndex); $i++){
				$objSheet->getCell($columnIndex[$i].$rowIndex)->setValue($array[$i]);
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->applyFromArray($borders);

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

    function generateRewindPerKK($nomorKK,$seri,$desain,$data, $objPHPExcel, $objWriter, $objSheet)
    {	

    	$objSheet->getCell('CG1')->setValue('No. KK');
    	$objSheet->getStyle('CG1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG2')->setValue('Macam');
    	$objSheet->getStyle('CG2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG3')->setValue('Mesin');
    	$objSheet->getStyle('CG3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CG4')->setValue('Hasil');
    	$objSheet->getStyle('CG4')->getFont()->setBold(true)->setSize(11);

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
		$borders = array(
	      'borders' => array(
	        'inside'     => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	            'argb' => '00000000'
	          )
	        ),
	        'outline' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	             'argb' => '00000000'
	          )
	        )
	      )
	    );

		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->applyFromArray($borders);

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
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->applyFromArray($borders);

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

function generateBelahPerKK($nomorKK,$seri,$desain,$data, $objPHPExcel, $objWriter, $objSheet)
    {	
    	$objSheet->getCell('CZ1')->setValue('No. KK');
    	$objSheet->getStyle('CZ1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CZ2')->setValue('Macam');
    	$objSheet->getStyle('CZ2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CZ3')->setValue('Mesin');
    	$objSheet->getStyle('CZ3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('CZ4')->setValue('Hasil');
    	$objSheet->getStyle('CZ4')->getFont()->setBold(true)->setSize(11);

    	$nomorKK = null;
    	foreach ($data as $row) {
    		$nomorKK = $row->NOMOR_KK;
    		break;
    	}

    	$dataRoll = $this->Master_detail_belah_model->groupByKodeRoll($nomorKK);
    	
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


    	$objSheet->getCell('DA1')->setValue($nomorKK);
    	$objSheet->getStyle('DA1')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('DA2')->setValue("BCRI TAHUN ".$desain." Seri ".$seri);
    	$objSheet->getStyle('DA2')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('DA3')->setValue("Mesin Belah");
    	$objSheet->getStyle('DA3')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getCell('DB4')->setValue("Meter");
    	$objSheet->getStyle('DB4')->getFont()->setBold(true)->setSize(11);

    	$rowHeader = 8;
		// write header
		$columnIndex = array();
		$columnIndex[0] = "CT";
		$columnIndex[1] = "CU";
		$columnIndex[2] = "CV";
		$columnIndex[3] = "CW";
		$columnIndex[4] = "CX";
		$columnIndex[5] = "CY";
		$columnIndex[6] = "CZ";
		$columnIndex[7] = "DA";
		$columnIndex[8] = "DB";
		$columnIndex[9] = "DC";
		$columnIndex[10] = "DD";
		$columnIndex[11] = "DE";
		$columnIndex[12] = "DF";
		$columnIndex[13] = "DG";
		$columnIndex[14] = "DH";
		$columnIndex[15] = "DI";
		$columnIndex[16] = "DJ";
		$columnIndex[17] = "DK";
		$columnIndex[18] = "DL";
		$columnIndex[19] = "DM";

		$columnTitle = array();
		$columnTitle[0] = "TANGGAL";
		$columnTitle[1] = "MSN BELAH";
		$columnTitle[2] = "SHIFT";
		$columnTitle[3] = "KODE ROLL";
		$columnTitle[4] = "TOTAL BAHAN";
		$columnTitle[5] = "BAIK BELAH";
		$columnTitle[6] = "RUSAK BELAH";
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
		$borders = array(
	      'borders' => array(
	        'inside'     => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	            'argb' => '00000000'
	          )
	        ),
	        'outline' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array(
	             'argb' => '00000000'
	          )
	        )
	      )
	    );

		for($i = 0; $i < count($columnIndex); $i++){
			$objSheet->getCell($columnIndex[$i].''.$rowHeader)->setValue($columnTitle[$i]);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($columnIndex[$i].''.$rowHeader)->applyFromArray($borders);

		}

		$rowIndex = 9;
		$startIndex = $rowIndex;
		$array = array();
		foreach($data as $row){
			$array[0] = $row->TGL_PRODUKSI;
			$array[1] = $row->MESIN_BELAH;
			$array[2] = $row->SHIFT_BELAH;
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
				$objSheet->getStyle($columnIndex[$i].$rowIndex)->applyFromArray($borders);

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
		$objSheet->getCell('DA4')->setValue('=SUM(CY'.$startIndex.':CY'.$rowIndex.')');
    	$objSheet->getStyle('DA4')->getFont()->setBold(true)->setSize(11);
    	$objSheet->getStyle('DA4')->getNumberFormat()->setFormatCode('#,##');
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
		$columnTitle[12] = "SELISIH BAHAN";
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
			$array[12] = $row->SELISIH_BAHAN;
		}else if($proses == 'DEMET'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_DEMET;
			$array[6] = $row->SHIFT_DEMET;
			$array[12] = "-";
		}else if($proses == 'REWIND'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_REWIND;
			$array[6] = $row->SHIFT_REWIND;
			$array[12] = "-";
		}else if($proses == 'SENSI'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_SENSI;
			$array[6] = $row->SHIFT_SENSI;
			$array[12] = "-";
		}else if($proses == 'BELAH'){
			$array[10] = $row->WASTE_METER;
			$array[5] = $row->MESIN_BELAH;
			$array[6] = $row->SHIFT_BELAH;
			$array[12] = "-";
		}
		$array[11] = $row->REJECT_METER;

		$array[13] = $row->SISA_BAIK;
		if(date("H:i",strtotime($row->START_JAM_PRODUKSI)) == date("H:i",strtotime($row->FINISH_JAM_PRODUKSI))){
			$array[14] = "0";
			$array[15] = "s/d";
			$array[16] = "0";
		}else{
			$array[14] = date("H:i",strtotime($row->START_JAM_PRODUKSI));
			$array[15] = "s/d";
			$array[16] = date("H:i",strtotime($row->FINISH_JAM_PRODUKSI));
		}
		if($array[18] = date("H:i",strtotime($row->START_JAM_PERSIAPAN))==date("H:i",strtotime($row->FINISH_JAM_PERSIAPAN))){
			$array[18] = "0";
			$array[19] = "s/d";
			$array[20] = "0";
		}else{
			$array[18] = date("H:i",strtotime($row->START_JAM_PERSIAPAN));
			$array[19] = "s/d";
			$array[20] = date("H:i",strtotime($row->FINISH_JAM_PERSIAPAN));
		}
		if(date("H:i",strtotime($row->START_JAM_TROUBLE_PRODUKSI))==date("H:i",strtotime($row->FINISH_JAM_TROUBLE_PRODUKSI))){
			$array[22] = "0";
			$array[23] = "s/d";
			$array[24] = "0";
		}else{
			$array[22] = date("H:i",strtotime($row->START_JAM_TROUBLE_PRODUKSI));
			$array[23] = "s/d";
			$array[24] = date("H:i",strtotime($row->FINISH_JAM_TROUBLE_PRODUKSI));
		}
		if(date("H:i",strtotime($row->START_JAM_TROUBLE_MESIN)) == date("H:i",strtotime($row->FINISH_JAM_TROUBLE_MESIN))){
			$array[26] = "0";
			$array[27] = "s/d";
			$array[28] = "0";
		}else{
			$array[26] = date("H:i",strtotime($row->START_JAM_TROUBLE_MESIN));
			$array[27] = "s/d";
			$array[28] = date("H:i",strtotime($row->FINISH_JAM_TROUBLE_MESIN));
		}
		if(date("H:i",strtotime($row->START_JAM_TUNGGU_BAHAN))==date("H:i",strtotime($row->FINISH_JAM_TUNGGU_BAHAN))){
			$array[30] = "0";
			$array[31] = "s/d";
			$array[32] = "0";
		}else{
			$array[30] = date("H:i",strtotime($row->START_JAM_TUNGGU_BAHAN));
			$array[31] = "s/d";
			$array[32] = date("H:i",strtotime($row->FINISH_JAM_TUNGGU_BAHAN));
		}
		
		if(date("H:i",strtotime($row->START_JAM_TUNGGU_CORE)) == date("H:i",strtotime($row->FINISH_JAM_TUNGGU_CORE))){
			$array[34] = "0";
			$array[35] = "s/d";
			$array[36] = "0";
		}else{
			$array[34] = date("H:i",strtotime($row->START_JAM_TUNGGU_CORE));
			$array[35] = "s/d";
			$array[36] = date("H:i",strtotime($row->FINISH_JAM_TUNGGU_CORE));
		}
		if(date("H:i",strtotime($row->START_JAM_GANTI_SILINDER_SERI)) == date("H:i",strtotime($row->FINISH_JAM_GANTI_SILINDER_SERI))){
			$array[38] = "0";
			$array[39] = "s/d";
			$array[40] = "0";
		}else{
			$array[38] = date("H:i",strtotime($row->START_JAM_GANTI_SILINDER_SERI));
			$array[39] = "s/d";
			$array[40] = date("H:i",strtotime($row->FINISH_JAM_GANTI_SILINDER_SERI));
		}
		if(date("H:i",strtotime($row->START_JAM_FORCE_MAJOR)) == date("H:i",strtotime($row->FINISH_JAM_FORCE_MAJOR)) ){
			$array[42] = "0";
			$array[43] = "s/d";
			$array[44] = "0";
		}else{
			$array[42] = date("H:i",strtotime($row->START_JAM_FORCE_MAJOR));
			$array[43] = "s/d";
			$array[44] = date("H:i",strtotime($row->FINISH_JAM_FORCE_MAJOR));
		}
		if(date("H:i",strtotime($row->START_JAM_LAIN_LAIN)) == date("H:i",strtotime($row->FINISH_JAM_LAIN_LAIN))){
			$array[46] = "0";
			$array[47] = "s/d";
			$array[48] = "0";
		}else{
			$array[46] = date("H:i",strtotime($row->START_JAM_LAIN_LAIN));
			$array[47] = "s/d";
			$array[48] = date("H:i",strtotime($row->FINISH_JAM_LAIN_LAIN));
		}
		
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
		for($i=0; $i<sizeof($columnIndex);$i++){
				$objSheet->getColumnDimension($columnIndex[$i])->setAutoSize(true);
		}
		// exit();
	}

	function executiveSummary($index,$nomorKK,$objPHPExcel, $objWriter, $objSheet)
        {

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
	    	$dataRoll = $this->Master_detail_emboss_model->groupByKodeRoll($nomorKK);
	    	$totalBahanDariGudang = 0;
	    	foreach ($dataRoll as $roll) {
	    		$totalBahanDariGudang = $totalBahanDariGudang + $this->Master_terima_foil_model->findByKodeRoll($roll->KODE_ROLL)->METER_DATANG;
	    	}
	    	$index = $index + 5;
			$objSheet->getStyle('B'.$index.':L'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('B'.$index.':L'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('B'.$index.':L'.$index);
			$objSheet->getCell('B'.$index)->setValue("Executive Summary Waktu Produksi Hologram Pita Cukai Ukuran 33cm");

			$index++;

			$objSheet->getStyle('D'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('D'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getCell('D'.$index)->setValue("Nomor KK : ");

			$objSheet->getStyle('E'.$index.':G'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('E'.$index.':G'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->mergeCells('E'.$index.':G'.$index);
			$objSheet->getCell('E'.$index)->setValue($nomorKK);

			$index++;

			$objSheet->getStyle('D'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('D'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getCell('D'.$index)->setValue("Macam :");

			$objSheet->getStyle('E'.$index.':G'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('E'.$index.':G'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->mergeCells('E'.$index.':G'.$index);
			$objSheet->getCell('E'.$index)->setValue("BCRI TAHUN ".$desain." SERI ".$seri);

			$index++;
			$objSheet->getStyle('D'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('D'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getCell('D'.$index)->setValue("Bahan Baku :");

			$objSheet->getStyle('E'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('E'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getCell('E'.$index)->setValue($totalBahanDariGudang);

			$index++;
			$objSheet->getStyle('D'.$index)->getFont()->setBold(true)->setSize(9);
			$objSheet->getStyle('D'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getCell('D'.$index)->setValue("Hasil :");
			$borders = array(
		      'borders' => array(
		        'inside'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
		          'color' => array(
		            'argb' => '00000000'
		          )
		        ),
		        'outline' => array(
		          'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
		          'color' => array(
		             'argb' => '00000000'
		          )
		        )
		      )
		    );
			$index++;
			$objSheet->getStyle('B'.$index.':L'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('B'.$index.':L'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('B'.$index.':L'.$index);
			$objSheet->getStyle('B'.$index.':L'.$index)->applyFromArray($borders);
			$objSheet->getCell('B'.$index)->setValue("MESIN PRODUKSI");

			$rowHeader = array();
			$rowHeader[0] = "Keterangan";
			$rowHeader[1] = "Mesin Emboss";
			$rowHeader[2] = "Mesin Demet";
			$rowHeader[3] = "Mesin Rewind";
			$rowHeader[4] = "Mesin Sensitizing";
			$rowHeader[5] = "Mesin Belah";

			$rowColumnIndex = array();
			$rowColumnIndex[0] = "B";
			$rowColumnIndex[1] = "C";
			$rowColumnIndex[2] = "E";
			$rowColumnIndex[3] = "G";
			$rowColumnIndex[4] = "I";
			$rowColumnIndex[5] = "K";

			$rowColumnComplete = array();
			$rowColumnComplete[0] = "B";
			$rowColumnComplete[1] = "C";
			$rowColumnComplete[2] = "D";
			$rowColumnComplete[3] = "E";
			$rowColumnComplete[4] = "F";
			$rowColumnComplete[5] = "G";
			$rowColumnComplete[6] = "H";
			$rowColumnComplete[7] = "I";
			$rowColumnComplete[8] = "J";
			$rowColumnComplete[9] = "K";
			$rowColumnComplete[10] = "L";

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

			$index++;
			$objSheet->mergeCells('C'.$index.':D'.$index);
			$objSheet->mergeCells('E'.$index.':F'.$index);
			$objSheet->mergeCells('G'.$index.':H'.$index);
			$objSheet->mergeCells('I'.$index.':J'.$index);
			$objSheet->mergeCells('K'.$index.':L'.$index);

			for($i = 0; $i<sizeof($rowHeader);$i++){
				$objSheet->getCell($rowColumnIndex[$i].$index)->setValue($rowHeader[$i]);
			}
			$startIndex = $index;
			for($i = 0; $i<(sizeof($rowTitle)+1);$i++){
				for($j=0;$j<sizeof($rowColumnComplete);$j++){
					$objSheet->getStyle($rowColumnComplete[$j].$index)->applyFromArray($borders);
					$objSheet->getStyle($rowColumnComplete[$j].$index)->getFont()->setBold(true)->setSize(11);
				}
				$index++;
			}


			$dataEmboss = $this->Master_detail_emboss_model->countTimeProses($nomorKK);
			$dataDemet = $this->Master_detail_demet_model->countTimeProses($nomorKK);
			$dataRewind = $this->Master_detail_rewind_model->countTimeProses($nomorKK);
			$dataSensitizing = $this->Master_detail_sensi_model->countTimeProses($nomorKK);
			$dataBelah = $this->Master_detail_belah_model->countTimeProses($nomorKK);
			$emboss = array();
			$emboss[0] = $dataEmboss[0]->JAM_PROSES;
			$emboss[1] = $dataEmboss[0]->JAM_PERSIAPAN;
			$emboss[2] = $dataEmboss[0]->JAM_TROUBLE_PROSES_PROD;
			$emboss[3] = $dataEmboss[0]->JAM_TROUBLE_MESIN;
			$emboss[4] = $dataEmboss[0]->JAM_TUNGGU_BAHAN;
			$emboss[5] = $dataEmboss[0]->JAM_TUNGGU_CORE;
			$emboss[6] = $dataEmboss[0]->JAM_GANTI_SILINDER;
			$emboss[7] = $dataEmboss[0]->JAM_FORCE_MAJOR;
			$emboss[8] = $dataEmboss[0]->JAM_LAIN_LAIN;

			$demet = array();
			$demet[0] = $dataDemet[0]->JAM_PROSES;
			$demet[1] = $dataDemet[0]->JAM_PERSIAPAN;
			$demet[2] = $dataDemet[0]->JAM_TROUBLE_PROSES_PROD;
			$demet[3] = $dataDemet[0]->JAM_TROUBLE_MESIN;
			$demet[4] = $dataDemet[0]->JAM_TUNGGU_BAHAN;
			$demet[5] = $dataDemet[0]->JAM_TUNGGU_CORE;
			$demet[6] = $dataDemet[0]->JAM_GANTI_SILINDER;
			$demet[7] = $dataDemet[0]->JAM_FORCE_MAJOR;
			$demet[8] = $dataDemet[0]->JAM_LAIN_LAIN;

			$rewind = array();
			$rewind[0] = $dataRewind[0]->JAM_PROSES;
			$rewind[1] = $dataRewind[0]->JAM_PERSIAPAN;
			$rewind[2] = $dataRewind[0]->JAM_TROUBLE_PROSES_PROD;
			$rewind[3] = $dataRewind[0]->JAM_TROUBLE_MESIN;
			$rewind[4] = $dataRewind[0]->JAM_TUNGGU_BAHAN;
			$rewind[5] = $dataRewind[0]->JAM_TUNGGU_CORE;
			$rewind[6] = $dataRewind[0]->JAM_GANTI_SILINDER;
			$rewind[7] = $dataRewind[0]->JAM_FORCE_MAJOR;
			$rewind[8] = $dataRewind[0]->JAM_LAIN_LAIN;

			$sensi = array();
			$sensi[0] = $dataSensitizing[0]->JAM_PROSES;
			$sensi[1] = $dataSensitizing[0]->JAM_PERSIAPAN;
			$sensi[2] = $dataSensitizing[0]->JAM_TROUBLE_PROSES_PROD;
			$sensi[3] = $dataSensitizing[0]->JAM_TROUBLE_MESIN;
			$sensi[4] = $dataSensitizing[0]->JAM_TUNGGU_BAHAN;
			$sensi[5] = $dataSensitizing[0]->JAM_TUNGGU_CORE;
			$sensi[6] = $dataSensitizing[0]->JAM_GANTI_SILINDER;
			$sensi[7] = $dataSensitizing[0]->JAM_FORCE_MAJOR;
			$sensi[8] = $dataSensitizing[0]->JAM_LAIN_LAIN;

			$belah = array();
			$belah[0] = $dataBelah[0]->JAM_PROSES;
			$belah[1] = $dataBelah[0]->JAM_PERSIAPAN;
			$belah[2] = $dataBelah[0]->JAM_TROUBLE_PROSES_PROD;
			$belah[3] = $dataBelah[0]->JAM_TROUBLE_MESIN;
			$belah[4] = $dataBelah[0]->JAM_TUNGGU_BAHAN;
			$belah[5] = $dataBelah[0]->JAM_TUNGGU_CORE;
			$belah[6] = $dataBelah[0]->JAM_GANTI_SILINDER;
			$belah[7] = $dataBelah[0]->JAM_FORCE_MAJOR;
			$belah[8] = $dataBelah[0]->JAM_LAIN_LAIN;

			$startIndex++;
			$startSum = $startIndex+1;
			for($i = 0; $i<sizeof($rowTitle);$i++){
					$objSheet->getCell('B'.$startIndex)->setValue($rowTitle[$i]);
					if($i<10 && $i>0){
						$objSheet->getCell('C'.$startIndex)->setValue('=('.round(str_replace(",",".",$emboss[($i-1)]), 0, PHP_ROUND_HALF_UP).'/86400)');
						$objSheet->getCell('E'.$startIndex)->setValue('=('.round(str_replace(",",".",$demet[($i-1)]), 0, PHP_ROUND_HALF_UP).'/86400)');
						$objSheet->getCell('G'.$startIndex)->setValue('=('.round(str_replace(",",".",$rewind[($i-1)]), 0, PHP_ROUND_HALF_UP).'/86400)');
						$objSheet->getCell('I'.$startIndex)->setValue('=('.round(str_replace(",",".",$sensi[($i-1)]), 0, PHP_ROUND_HALF_UP).'/86400)');
						$objSheet->getCell('K'.$startIndex)->setValue('=('.round(str_replace(",",".",$belah[($i-1)]), 0, PHP_ROUND_HALF_UP).'/86400)');
						$objSheet->getStyle('C'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getStyle('E'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getStyle('G'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getStyle('I'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getStyle('K'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');

					}else if($i==10){
						$objSheet->getStyle('C'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('C'.$startIndex)->setValue('=SUM(C'.$startSum.':C'.($startIndex-1).')');
						$objSheet->getStyle('E'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('E'.$startIndex)->setValue('=SUM(E'.$startSum.':E'.($startIndex-1).')');
						$objSheet->getStyle('G'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('G'.$startIndex)->setValue('=SUM(G'.$startSum.':G'.($startIndex-1).')');
						$objSheet->getStyle('I'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('I'.$startIndex)->setValue('=SUM(I'.$startSum.':I'.($startIndex-1).')');
						$objSheet->getStyle('K'.$startIndex)->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('K'.$startIndex)->setValue('=SUM(K'.$startSum.':K'.($startIndex-1).')');

						$objSheet->getStyle('C'.($startSum-1))->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('C'.($startSum-1))->setValue('=SUM(C'.$startSum.':C'.($startIndex-1).')');
						$objSheet->getStyle('E'.($startSum-1))->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('E'.($startSum-1))->setValue('=SUM(E'.$startSum.':E'.($startIndex-1).')');
						$objSheet->getStyle('G'.($startSum-1))->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('G'.($startSum-1))->setValue('=SUM(G'.$startSum.':G'.($startIndex-1).')');
						$objSheet->getStyle('I'.($startSum-1))->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('I'.($startSum-1))->setValue('=SUM(I'.$startSum.':I'.($startIndex-1).')');
						$objSheet->getStyle('K'.($startSum-1))->getNumberFormat()->setFormatCode('[h]:mm:ss');
						$objSheet->getCell('K'.($startSum-1))->setValue('=SUM(K'.$startSum.':K'.($startIndex-1).')');
					}
					
					$startIndex++;
			}

        }

        public function generateLaporanBulanan(){

        	$bulan = $this->input->post('bulan');
        	$tahun = $this->input->post('tahun');
        	$proses = $this->input->post('proses');
        	$mesin = $this->input->post('mesin');

        	$targetBapob = null;
        	if($proses == 'EMBOSS'){
        		$dataRealisasi = $this->Master_detail_emboss_model->groupByProductionDate($bulan,$tahun,$mesin);
        		$targetBapob = $this->Master_mesin_model->findByName('Mesin Emboss');
        	}else if($proses == 'DEMET'){
        		$dataRealisasi = $this->Master_detail_demet_model->groupByProductionDate($bulan,$tahun,$mesin);
        		$targetBapob = $this->Master_mesin_model->findByName("Mesin Demet");
        	}else if($proses == 'REWIND'){
        		$dataRealisasi = $this->Master_detail_rewind_model->groupByProductionDate($bulan,$tahun,$mesin);
        		$targetBapob = $this->Master_mesin_model->findByName("Mesin Rewind");
        	}else if($proses == 'SENSI'){
        		$dataRealisasi = $this->Master_detail_sensi_model->groupByProductionDate($bulan,$tahun,$mesin);
        		$targetBapob = $this->Master_mesin_model->findByName("Mesin Sensitizing");

        	}else if($proses == 'BELAH'){
        		$dataRealisasi = $this->Master_detail_belah_model->groupByProductionDate($bulan,$tahun,$mesin);
        		$targetBapob = $this->Master_mesin_model->findByName("Mesin Belah");
        	}

			$namaBulan = null;
			if($bulan == '01'){
				$namaBulan = "JANUARI";
			}else if($bulan = '02'){
				$namaBulan = "FEBRUARI";
			}else if($bulan = '03'){
				$namaBulan = "MARET";
			}else if($bulan = '04'){
				$namaBulan = "APRIL";
			}else if($bulan = '05'){
				$namaBulan = "MEI";
			}else if($bulan = '06'){
				$namaBulan = "JUNI";
			}else if($bulan = '07'){
				$namaBulan = "JULI";
			}else if($bulan = '08'){
				$namaBulan = "AGUSTUS";
			}else if($bulan = '09'){
				$namaBulan = "SEPTEMBER";
			}else if($bulan = '10'){
				$namaBulan = "OKTOBER";
			}else if($bulan = '11'){
				$namaBulan = "NOVEMBER";
			}else if($bulan = '12'){
				$namaBulan = "DESEMBER";
			}
        	// =========== CREATE EXCEL FILE ================//
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
			$objSheet->setTitle('Laporan Bulanan');
			
			// ================= CREATE HEADER ==============================//

			$index = 1;
			$objSheet->getStyle('A'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->mergeCells('A'.$index.':C'.($index));
			$objSheet->getCell('A'.$index)->setValue("PROSES FLOW MESIN ".$proses." ".$mesin);

			$index++;
			$objSheet->getStyle('A'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->mergeCells('A'.$index.':C'.($index));
			$objSheet->getCell('A'.$index)->setValue("Periode : ".$namaBulan."/".$tahun);

			$index++;
			$objSheet->getStyle('A'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->mergeCells('A'.$index.':C'.($index));
			$objSheet->getCell('A'.$index)->setValue("TARGET/MESIN/JAM : ".(($targetBapob[0]->KECEPATAN_MESIN)*60)."m/jam");

			//================= COLUMN HEADER ==============================//
			$index++;
			$index++;
			$objSheet->getStyle('A'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('A'.$index.':A'.($index+3));
			$objSheet->getCell('A'.$index)->setValue("DATE");

			$objSheet->getStyle('B'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('B'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('B'.($index).':D'.($index+1));
			$objSheet->getCell('B'.$index)->setValue("Production Time");

			$index++;
			$index++;
			$objSheet->getStyle('B'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('B'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('B'.$index)->setValue("Office Hours");

			$objSheet->getStyle('C'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('C'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('C'.$index)->setValue("Overtime");

			$objSheet->getStyle('D'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('D'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('D'.$index)->setValue("Total");

			$index--;
			$index--;
			$objSheet->getStyle('E'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('E'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('E'.$index.':E'.($index+3));
			$objSheet->getCell('E'.$index)->setValue("OPERATING TIME");

			$objSheet->getStyle('F'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('F'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('F'.($index).':M'.($index+1));
			$objSheet->getCell('F'.$index)->setValue("DOWN TIME");

			$downTime = array();
			$downTime[0] = "A";
			$downTime[1] = "B";
			$downTime[2] = "C";
			$downTime[3] = "D";
			$downTime[4] = "E";
			$downTime[5] = "F";
			$downTime[6] = "G";
			$downTime[7] = "H";

			$columnTitle = array();
			$columnTitle[0] = "F";
			$columnTitle[1] = "G";
			$columnTitle[2] = "H";
			$columnTitle[3] = "I";
			$columnTitle[4] = "J";
			$columnTitle[5] = "K";
			$columnTitle[6] = "L";
			$columnTitle[7] = "M";

			$column = array();
			$column [0] = "A";
			$column [1] = "B";
			$column [2] = "C";
			$column [3] = "D";
			$column [4] = "E";
			$column [5] = "F";
			$column [6] = "G";
			$column [7] = "H";
			$column [8] = "I";
			$column [9] = "J";
			$column [10] = "K";
			$column [11] = "L";
			$column [12] = "M";
			$column [13] = "N";
			$column [14] = "O";
			$column [15] = "P";
			$column [16] = "Q";
			$column [17] = "R";
			$column [18] = "S";
			$column [19] = "T";
			$column [20] = "U";

			$index++;
			$index++;
			for($i=0;$i<sizeof($downTime);$i++){
				$objSheet->getStyle($columnTitle [$i].$index)->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle($columnTitle [$i].$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->getCell($columnTitle [$i].$index)->setValue($downTime[$i]);
			}

			$index--;
			$index--;
			$objSheet->getStyle('N'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('N'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('N'.$index.':N'.($index+2));
			$objSheet->getCell('N'.$index)->setValue("Production Targets");

			$index++;
			$index++;
			$index++;
			$objSheet->getStyle('N'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('N'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('N'.$index)->setValue("meter");

			$index--;
			$index--;
			$index--;
			$objSheet->getStyle('O'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('O'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('O'.$index.':Q'.$index);
			$objSheet->getCell('O'.$index)->setValue("Realisation of Production (meter)");

			$index++;
			$objSheet->getStyle('O'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('O'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('O'.$index)->setValue("Seri I/2017");

			$objSheet->getStyle('P'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('P'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('P'.$index)->setValue("Seri III / TA 2017");

			$objSheet->getStyle('Q'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('Q'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('Q'.$index)->setValue("MMEA");

			$index++;
			$index++;
			$objSheet->getStyle('O'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('O'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('O'.$index)->setValue("Uk.66 Cm");

			$objSheet->getStyle('P'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('P'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('P'.$index)->setValue("Uk.66 Cm");

			$objSheet->getStyle('Q'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('Q'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('Q'.$index)->setValue("Uk.66 Cm");

			$index--;
			$index--;
			$index--;
			$objSheet->getStyle('R'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('R'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('R'.$index.':R'.($index+1));
			$objSheet->getCell('R'.$index)->setValue("Deviasi");

			$objSheet->getStyle('S'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('S'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('S'.$index.':S'.($index+1));
			$objSheet->getCell('S'.$index)->setValue("Speed");

			$objSheet->getStyle('T'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('T'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('T'.$index.':T'.($index+1));
			$objSheet->getCell('T'.$index)->setValue("PCH");

			$index++;
			$index++;
			$objSheet->getStyle('R'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('R'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('R'.$index)->setValue("+/-");

			$objSheet->getStyle('S'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('S'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getCell('S'.$index)->setValue("Meter/menit");

			$index--;
			$index--;
			
			$objSheet->getStyle('U'.$index)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle('U'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->mergeCells('U'.$index.':U'.($index+2));
			$objSheet->getCell('U'.$index)->setValue("INFORMATION");


			$borders = array(
		      'borders' => array(
		        'inside'     => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN,
		          'color' => array(
		            'argb' => '00000000'
		          )
		        ),
		        'outline' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN,
		          'color' => array(
		             'argb' => '00000000'
		          )
		        )
		      )
		    );

			for($i=0;$i<4;$i++){
				$objSheet->getStyle('A'.$index.':U'.$index)->applyFromArray($borders);
				$index++;
			}

			// $index++;
			foreach($dataRealisasi as $row) {
				$objSheet->getStyle($downTime[$i].$index)->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle($downTime[$i].$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objSheet->getCell('A'.$index)->setValue($row->TGL_PRODUKSI);
				$objSheet->getCell('B'.$index)->setValue('14:00');
				$objSheet->getCell('E'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_PROSES), 0, PHP_ROUND_HALF_UP).'/86400)');

				$objSheet->getCell('F'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_PERSIAPAN), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('G'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_TROUBLE_PROSES_PROD), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('H'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_TROUBLE_MESIN), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('I'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_TUNGGU_BAHAN), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('J'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_TUNGGU_CORE), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('K'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_GANTI_SILINDER), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('L'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_FORCE_MAJOR), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('M'.$index)->setValue('=('.round(str_replace(",",".",$row->JAM_LAIN_LAIN), 0, PHP_ROUND_HALF_UP).'/86400)');
				$objSheet->getCell('D'.$index)->setValue('=SUM(E'.$index.':M'.$index.')');
				$objSheet->getCell('C'.$index)->setValue('=(D'.$index.'-B'.$index.')');
				$objSheet->getCell('N'.$index)->setValue('=+((E'.$index.'+F'.$index.'+K'.$index.')*24)*('.$targetBapob[0]->KECEPATAN_MESIN.'*60)');

				$seri1 = $this->Master_detail_emboss_model->countResultBySeriAndDate($row->TGL_PRODUKSI,"1",$mesin);
				$seri2 = $this->Master_detail_emboss_model->countResultBySeriAndDate($row->TGL_PRODUKSI,"3",$mesin);
				$seriMMEA = $this->Master_detail_emboss_model->countResultBySeriAndDate($row->TGL_PRODUKSI,"MMEA",$mesin);

				if($seri1 != null){
					$objSheet->getCell('O'.$index)->setValue($seri1->HASIL);
				}
				if($seri2 != null){
					$objSheet->getCell('P'.$index)->setValue($seri2->HASIL);
				}
				if($seriMMEA != null){
					$objSheet->getCell('Q'.$index)->setValue($seriMMEA->HASIL);
				}

				$objSheet->getStyle('B'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('C'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('D'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('E'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('F'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('G'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('H'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('I'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('J'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('K'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('L'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('M'.$index)->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
				$objSheet->getStyle('A'.$index.':U'.$index)->applyFromArray($borders);
				$index++;
			}

			for($i=0; $i<sizeof($column);$i++){
				$objSheet->getColumnDimension($column[$i])->setAutoSize(true);
			}
			$objSheet->getColumnDimension('I')->setAutoSize(true);
		    
			$filename = "LAPORAN PRODUKSI PER BULAN";
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
			header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
			$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
        	// foreach ($dataRealisasi as $row) {
        		      	
        	// }
        }
}