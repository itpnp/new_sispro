<?php
class AdminProduksiNeraca extends Controller {
	function AdminProduksiNeraca()
	{
		parent::Controller();
		session_start();
		ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->library("PHPExcel");
		$this->load->plugin();
		$this->load->model('Master_neraca');

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
			if($data["status"]=="ADMKW"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_home',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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

	function neracaGudang(){

	}

	function neracaEmboss(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMKW"){
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_neraca_emboss',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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

	function generateNeracaEmboss(){
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		// writer already created the first sheet for us, let's get it
		$objSheet = $objPHPExcel->getActiveSheet();
		// rename the sheet
		$objSheet->setTitle('NERACA EMBOSS');

		$rowTitle1 = array();
		$rowTitle1[] = 'C';
		$rowTitle1[] = 'D';
		$rowTitle1[] = 'F';
		$rowTitle1[] = 'I';
		$rowTitle1[] = 'J';
		$rowTitle1[] = 'L';
		$rowTitle1[] = 'M';
		$rowTitle1[] = 'N';
		$rowTitle1[] = 'Q';
		$rowTitle1[] = 'S';

		$rowTitle2 = array();
		$rowTitle2[0] = 'C';
		$rowTitle2[1] = 'D';
		$rowTitle2[2] = 'E';
		$rowTitle2[3] = 'F';
		$rowTitle2[4] = 'G';
		$rowTitle2[5] = 'H';
		$rowTitle2[6] = 'I';
		$rowTitle2[7] = 'J';
		$rowTitle2[8] = 'K';
		$rowTitle2[9] = 'L';
		$rowTitle2[10] = 'M';
		$rowTitle2[11] = 'N';
		$rowTitle2[12] = 'O';
		$rowTitle2[13] = 'P';
		$rowTitle2[14] = 'Q';
		$rowTitle2[15] = 'R';
		$rowTitle2[16] = 'S';
		$rowTitle2[17] = 'T';
		$rowTitle2[18] = 'U';
		$rowTitle2[19] = 'V';
		$rowTitle2[20] = 'W';
		$rowTitle2[21] = 'X';
		$rowKK = 1;
		$rowHeader = 5;
		// write header
		$objSheet->getCell('C'.$rowHeader)->setValue('Tanggal');
		$objSheet->mergeCells('C5:C10');
		$objSheet->getCell('D'.$rowHeader)->setValue('Saldo Awal');
		$objSheet->mergeCells('D5:F7');
		$objSheet->getCell('G'.$rowHeader)->setValue('Bon Gudang (DEBIT)');
		$objSheet->mergeCells('G5:I7');
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Emboss (KREDIT)');
		$objSheet->mergeCells('J5:U6');
		$objSheet->getCell('V'.$rowHeader)->setValue('Saldo Akhir');
		$objSheet->mergeCells('V5:X7');

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
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Baik');
		$objSheet->mergeCells('J7:L7');
		$objSheet->getCell('M'.$rowHeader)->setValue('Waste');
		$objSheet->mergeCells('M7:O7');
		$objSheet->getCell('P'.$rowHeader)->setValue('Reject');
		$objSheet->mergeCells('P7:U7');
		

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('P'.$rowHeader)->setValue('Selisih Teller');
		$objSheet->mergeCells('P8:R8');
		$objSheet->getCell('S'.$rowHeader)->setValue('Bahan');
		$objSheet->mergeCells('S8:U8');
		
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}


		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('E'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('F'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('G'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('H'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('I'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('J'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('K'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('L'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('M'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('N'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('O'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('P'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('Q'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('R'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('S'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('T'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('U'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('V'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('W'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('X'.$rowHeader)->setValue('MMEA');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('E'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('F'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('H'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('I'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('J'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('K'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('L'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('M'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('N'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('O'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('P'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('Q'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('R'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('S'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('T'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('U'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('V'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('W'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('X'.$rowHeader)->setValue('(Meter)');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}
		//end of header file

		$rowHeader++;
		//get data
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$d=cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

		$kkCompare = null;
		$kkCompare2 = null;
		$kkCompareMMEA = null;
		$batasAtas = "1-".$bulan."-".$tahun;
		$countDebit1 = $this->Master_neraca->countTotalDebit($batasAtas,'2017','1');
		$countKredit1 = $this->Master_neraca->countTotalKredit($batasAtas,'2017','1');
		if($countDebit1 == null || $countKredit1==null){
			$saldoAwal1 = 0;
		}else{
			$saldoAwal1 = $countDebit1-$countKredit1;
		}

		$countDebit2 = $this->Master_neraca->countTotalDebit($batasAtas,'2017','3');
		$countKredit2 = $this->Master_neraca->countTotalKredit($batasAtas,'2017','3');
		if($countDebit2 == null || $countKredit2==null){
			$saldoAwal2 = 0;
		}else{
			$saldoAwal2 = $countDebit2-$countKredit2;
		}

		$countDebitMMEA = $this->Master_neraca->countTotalDebit($batasAtas,'2017',null);
		$countKreditMMEA = $this->Master_neraca->countTotalKredit($batasAtas,'2017',null);
		if($countDebitMMEA == null || $countKreditMMEA==null){
			$saldoAwalMMEA = 0;
		}else{
			$saldoAwalMMEA = $countDebitMMEA-$countKreditMMEA;
		}
		
		//ambil data daftar tanggal
		for($i=0;$i<$d;$i++) {
			$tanggal = ($i+1)."-".$bulan."-".$tahun;
			$objSheet->getCell($rowTitle2[0].$rowHeader)->setValue($tanggal);

			$seri1 = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"1");
			$seri2 = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"3");
			$seriMMEA = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"MMEA");

			$waste1 = $this->Master_neraca->embossCountWasteBySeriAndDate($tanggal,"1");
			$waste2 = $this->Master_neraca->embossCountWasteBySeriAndDate($tanggal,"3");
			$wasteMMEA = $this->Master_neraca->embossCountWasteBySeriAndDate($tanggal,"MMEA");

			$bonGudangMMEA= $this->Master_neraca->findBonGudang($tanggal,"MMEA");
			$bonGudang1 = $this->Master_neraca->findBonGudang($tanggal,"1");
			$bonGudang2 = $this->Master_neraca->findBonGudang($tanggal,"3");

			$objSheet->getCell($rowTitle2[1].$rowHeader)->setValue($saldoAwal1);
			$objSheet->getCell($rowTitle2[2].$rowHeader)->setValue($saldoAwal2);

			if($bonGudang1 != null){
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue($bonGudang1->HASIL);
				$gudang1 = $bonGudang1->HASIL;
			}else{
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue("0");
				$gudang1 = 0;
			}

			if($bonGudang2 != null){
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue($bonGudang2->HASIL);
				$gudang2 = $bonGudang2->HASIL;
			}else{
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue("0");
				$gudang2 = 0;
			}

			if($bonGudangMMEA != null){
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue($bonGudangMMEA->HASIL);
			}else{
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue("0");
			}

			if($seri1 != null){
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue($seri1->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue("0");
			}
			if($waste1 != null){
				if($kkCompare != null){
					if($kkCompare != $waste1->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare = $waste1->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare = $waste1->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}

				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue($waste1->WASTE);
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue($waste1->SELISIH);
				$objSheet->getCell($rowTitle2[16].$rowHeader)->setValue($waste1->REJECT);
				$objSheet->getCell($rowTitle2[19].$rowHeader)->setValue('=('.$rowTitle2[1].$rowHeader.'+'.$rowTitle2[4].$rowHeader.')-('.$rowTitle2[7].$rowHeader.'+'.$rowTitle2[10].$rowHeader.'+'.$rowTitle2[13].$rowHeader.'+'.$rowTitle2[16].$rowHeader.')');
				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$gudang1)-(($seri1->TOTAL_BAHAN)+($waste1->WASTE)+($waste1->SELISIH)+($waste1->REJECT));
				}else{
					$saldoAwal1 = ($saldoAwal1+$gudang1)-((0)+($waste1->WASTE)+($waste1->SELISIH)+($waste1->REJECT));
				}
				
			}else{
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[16].$rowHeader)->setValue("0");
				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$emboss1)-(($seri1->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal1 = ($saldoAwal1+$emboss1)-((0)+(0)+(0));
				}
			}
			if($seri2 != null){
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue($seri2->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue("0");
			}
			if($waste2 != null){
				if($kkCompare2 != null){
					if($kkCompare2 != $waste2 ->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2/3");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare2 = $waste2 ->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare2 = $waste2 ->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2/3");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue($waste2->WASTE);
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue($waste2->SELISIH);
				$objSheet->getCell($rowTitle2[17].$rowHeader)->setValue($waste2->REJECT);
				$objSheet->getCell($rowTitle2[20].$rowHeader)->setValue('=('.$rowTitle2[2].$rowHeader.'+'.$rowTitle2[5].$rowHeader.')-('.$rowTitle2[8].$rowHeader.'+'.$rowTitle2[11].$rowHeader.'+'.$rowTitle2[14].$rowHeader.'+'.$rowTitle2[17].$rowHeader.')');

				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$gudang2)-(($seri2->TOTAL_BAHAN)+($waste2->WASTE)+($waste2->SELISIH)+($waste2->REJECT));
				}else{
					$saldoAwal2 = ($saldoAwal2+$gudang2)-((0)+($waste2->WASTE)+($waste2->SELISIH)+($waste2->REJECT));
				}

			}else{
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[17].$rowHeader)->setValue("0");
				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$emboss1)-(($seri2->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal2 = ($saldoAwal2+$emboss1)-((0)+(0)+(0));
				}
			}
			if($seriMMEA != null){
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue($seriMMEA->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue("0");
			}
			if($wasteMMEA != null){
				if($kkCompareMMEA != null){
					if($kkCompareMMEA != $wasteMMEA->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue($wasteMMEA->WASTE);
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue($wasteMMEA->SELISIH);
				$objSheet->getCell($rowTitle2[18].$rowHeader)->setValue($wasteMMEA->REJECT);
			}else{
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[18].$rowHeader)->setValue("0");
			}
			for($j = 0; $j < count($rowTitle2); $j++){
			$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->applyFromArray($borders);
			}
			$rowHeader++;
		}
		// exit();
		$filename = "NERACA EMBOSS";
			// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
		$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
	}

	function neracaDemet(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMKW"){
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_neraca_demet',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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

	function generateNeracaDemet(){
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		// writer already created the first sheet for us, let's get it
		$objSheet = $objPHPExcel->getActiveSheet();
		// rename the sheet
		$objSheet->setTitle('NERACA DEMET');

		$rowTitle1 = array();
		$rowTitle1[] = 'C';
		$rowTitle1[] = 'D';
		$rowTitle1[] = 'F';
		$rowTitle1[] = 'I';
		$rowTitle1[] = 'J';
		$rowTitle1[] = 'L';
		$rowTitle1[] = 'M';
		$rowTitle1[] = 'N';
		$rowTitle1[] = 'Q';
		$rowTitle1[] = 'S';

		$rowTitle2 = array();
		$rowTitle2[0] = 'C';
		$rowTitle2[1] = 'D';
		$rowTitle2[2] = 'E';
		$rowTitle2[3] = 'F';
		$rowTitle2[4] = 'G';
		$rowTitle2[5] = 'H';
		$rowTitle2[6] = 'I';
		$rowTitle2[7] = 'J';
		$rowTitle2[8] = 'K';
		$rowTitle2[9] = 'L';
		$rowTitle2[10] = 'M';
		$rowTitle2[11] = 'N';
		$rowTitle2[12] = 'O';
		$rowTitle2[13] = 'P';
		$rowTitle2[14] = 'Q';
		$rowTitle2[15] = 'R';
		$rowTitle2[16] = 'S';
		$rowTitle2[17] = 'T';
		$rowTitle2[18] = 'U';

		//Define start index 
		$rowKK = 1;
		$rowHeader = 5;
		// write header
		$objSheet->getCell('C'.$rowHeader)->setValue('Tanggal');
		$objSheet->mergeCells('C5:C10');
		$objSheet->getCell('D'.$rowHeader)->setValue('Saldo Awal');
		$objSheet->mergeCells('D5:F7');
		$objSheet->getCell('G'.$rowHeader)->setValue('Penerimaan (DEBIT)');
		$objSheet->mergeCells('G5:I7');
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Demet (KREDIT)');
		$objSheet->mergeCells('J5:R6');
		$objSheet->getCell('S'.$rowHeader)->setValue('Saldo Akhir');
		$objSheet->mergeCells('S5:U7');

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
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Baik');
		$objSheet->mergeCells('J7:L7');
		$objSheet->getCell('M'.$rowHeader)->setValue('Reject');
		$objSheet->mergeCells('M7:O7');
		$objSheet->getCell('P'.$rowHeader)->setValue('Waste');
		$objSheet->mergeCells('P7:R7');		

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;		
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}


		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('E'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('F'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('G'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('H'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('I'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('J'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('K'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('L'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('M'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('N'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('O'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('P'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('Q'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('R'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('S'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('T'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('U'.$rowHeader)->setValue('MMEA');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('E'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('F'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('H'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('I'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('J'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('K'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('L'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('M'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('N'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('O'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('P'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('Q'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('R'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('S'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('T'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('U'.$rowHeader)->setValue('(Meter)');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}
		//end of header file
		$rowHeader++;
		//get data
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$d=cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

		$kkCompare = null;
		$kkCompare2 = null;
		$kkCompareMMEA = null;
		$batasAtas = "1-".$bulan."-".$tahun;
		$countDebit1 = $this->Master_neraca->countTotalDebitDemet($batasAtas,'2017','1');
		$countKredit1 = $this->Master_neraca->countTotalKreditDemet($batasAtas,'2017','1');
		if($countDebit1 == null || $countKredit1==null){
			$saldoAwal1 = 0;
		}else{
			$saldoAwal1 = $countDebit1-$countKredit1;
		}

		$countDebit2 = $this->Master_neraca->countTotalDebitDemet($batasAtas,'2017','3');
		$countKredit2 = $this->Master_neraca->countTotalKreditDemet($batasAtas,'2017','3');
		if($countDebit2 == null || $countKredit2==null){
			$saldoAwal2 = 0;
		}else{
			$saldoAwal2 = $countDebit2-$countKredit2;
		}

		$countDebitMMEA = $this->Master_neraca->countTotalDebitDemet($batasAtas,'2017',null);
		$countKreditMMEA = $this->Master_neraca->countTotalKreditDemet($batasAtas,'2017',null);
		if($countDebitMMEA == null || $countKreditMMEA==null){
			$saldoAwalMMEA = 0;
		}else{
			$saldoAwalMMEA = $countDebitMMEA-$countKreditMMEA;
		}
		
		for($i=0;$i<$d;$i++) {
			$tanggal = ($i+1)."-".$bulan."-".$tahun;
			$objSheet->getCell($rowTitle2[0].$rowHeader)->setValue($tanggal);

			$bonEmbossMMEA = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"MMEA");
			$bonEmboss1 = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"1");
			$bonEmboss2 = $this->Master_neraca->embossCountResultBySeriAndDate($tanggal,"3");

			$seri1 = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"1");
			$seri2 = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"3");
			$seriMMEA = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"MMEA");

			$waste1 = $this->Master_neraca->demetCountWasteBySeriAndDate($tanggal,"1");
			$waste2 = $this->Master_neraca->demetCountWasteBySeriAndDate($tanggal,"3");
			$wasteMMEA = $this->Master_neraca->demetCountWasteBySeriAndDate($tanggal,"MMEA");

			$objSheet->getCell($rowTitle2[1].$rowHeader)->setValue($saldoAwal1);
			$objSheet->getCell($rowTitle2[2].$rowHeader)->setValue($saldoAwal2);
			$objSheet->getCell($rowTitle2[3].$rowHeader)->setValue($saldoAwalMMEA);

			if($bonEmboss1 != null){
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue($bonEmboss1->TOTAL_BAHAN);
				$emboss1 = $bonEmboss1->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue("0");
				$emboss1 = 0;
			}

			if($bonEmboss2 != null){
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue($bonEmboss2->TOTAL_BAHAN);
				$emboss2 = $bonEmboss2->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue("0");
				$emboss2 = 0;
			}

			if($bonEmbossMMEA != null){
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue($bonEmbossMMEA->TOTAL_BAHAN);
				$embossMMEA = $bonEmbossMMEA->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue("0");
				$embossMMEA = 0;
			}

			if($seri1 != null){
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue($seri1->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue("0");
			}

			if($seri2 != null){
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue($seri2->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue("0");
			}

			if($seriMMEA != null){
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue($seriMMEA->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue("0");
			}


			//waste dan kk
			if($waste1 != null){
				if($kkCompare != null){
					if($kkCompare != $waste1->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare = $waste1->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare = $waste1->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue($waste1->WASTE);
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue($waste1->REJECT);
				$objSheet->getCell($rowTitle2[16].$rowHeader)->setValue('=('.$rowTitle2[1].$rowHeader.'+'.$rowTitle2[4].$rowHeader.')-('.$rowTitle2[7].$rowHeader.'+'.$rowTitle2[10].$rowHeader.'+'.$rowTitle2[13].$rowHeader.')');

				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$emboss1)-(($seri1->TOTAL_BAHAN)+($waste1->WASTE)+($waste1->REJECT));
				}else{
					$saldoAwal1 = ($saldoAwal1+$emboss1)-((0)+($waste1->WASTE)+($waste1->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue("0");
				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$emboss1)-(($seri1->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal1 = ($saldoAwal1+$emboss1)-((0)+(0)+(0));
				}
			}

			if($waste2 != null){
				if($kkCompare2 != null){
					if($kkCompare2 != $waste2->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare2 = $waste2->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare2 = $waste2->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue($waste2->WASTE);
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue($waste2->REJECT);
				$objSheet->getCell($rowTitle2[17].$rowHeader)->setValue('=('.$rowTitle2[2].$rowHeader.'+'.$rowTitle2[5].$rowHeader.')-('.$rowTitle2[8].$rowHeader.'+'.$rowTitle2[11].$rowHeader.'+'.$rowTitle2[14].$rowHeader.')');

				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$emboss2)-(($seri2->TOTAL_BAHAN)+($waste2->WASTE)+($waste2->REJECT));
				}else{
					$saldoAwal2 = ($saldoAwal2+$emboss2)-((0)+($waste2->WASTE)+($waste2->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue("0");
				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$emboss2)-(($seri2->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal2 = ($saldoAwal2+$emboss2)-((0)+(0)+(0));
				}
			}

			if($wasteMMEA != null){
				if($kkCompareMMEA != null){
					if($kkCompareMMEA != $wasteMMEA->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue($wasteMMEA->WASTE);
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue($wasteMMEA->REJECT);
				$objSheet->getCell($rowTitle2[18].$rowHeader)->setValue('=('.$rowTitle2[3].$rowHeader.'+'.$rowTitle2[6].$rowHeader.')-('.$rowTitle2[9].$rowHeader.'+'.$rowTitle2[12].$rowHeader.'+'.$rowTitle2[15].$rowHeader.')');

				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$embossMMEA)-(($seriMMEA->TOTAL_BAHAN)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$embossMMEA)-((0)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue("0");
				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$embossMMEA)-(($seriMMEA->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$embossMMEA)-((0)+(0)+(0));
				}
			}

			//Add Border
			for($j = 0; $j < count($rowTitle2); $j++){
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->applyFromArray($borders);
			}
			//End Of Add Border
			$rowHeader++;

		}
		$filename = "NERACA DEMET";
			// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
		$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
	}

	function neracaRewind(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMKW"){
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_neraca_rewind',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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

	function generateNeracaRewind(){
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		// writer already created the first sheet for us, let's get it
		$objSheet = $objPHPExcel->getActiveSheet();
		// rename the sheet
		$objSheet->setTitle('NERACA REWIND');

		$rowTitle1 = array();
		$rowTitle1[] = 'C';
		$rowTitle1[] = 'D';
		$rowTitle1[] = 'F';
		$rowTitle1[] = 'I';
		$rowTitle1[] = 'J';
		$rowTitle1[] = 'L';
		$rowTitle1[] = 'M';
		$rowTitle1[] = 'N';
		$rowTitle1[] = 'Q';
		$rowTitle1[] = 'S';

		$rowTitle2 = array();
		$rowTitle2[0] = 'C';
		$rowTitle2[1] = 'D';
		$rowTitle2[2] = 'E';
		$rowTitle2[3] = 'F';
		$rowTitle2[4] = 'G';
		$rowTitle2[5] = 'H';
		$rowTitle2[6] = 'I';
		$rowTitle2[7] = 'J';
		$rowTitle2[8] = 'K';
		$rowTitle2[9] = 'L';
		$rowTitle2[10] = 'M';
		$rowTitle2[11] = 'N';
		$rowTitle2[12] = 'O';
		$rowTitle2[13] = 'P';
		$rowTitle2[14] = 'Q';
		$rowTitle2[15] = 'R';
		$rowTitle2[16] = 'S';
		$rowTitle2[17] = 'T';
		$rowTitle2[18] = 'U';

		//Define start index 
		$rowKK = 1;
		$rowHeader = 5;
		// write header
		$objSheet->getCell('C'.$rowHeader)->setValue('Tanggal');
		$objSheet->mergeCells('C5:C10');
		$objSheet->getCell('D'.$rowHeader)->setValue('Saldo Awal');
		$objSheet->mergeCells('D5:F7');
		$objSheet->getCell('G'.$rowHeader)->setValue('Penerimaan (DEBIT)');
		$objSheet->mergeCells('G5:I7');
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Rewind (KREDIT)');
		$objSheet->mergeCells('J5:R6');
		$objSheet->getCell('S'.$rowHeader)->setValue('Saldo Akhir');
		$objSheet->mergeCells('S5:U7');

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
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Baik');
		$objSheet->mergeCells('J7:L7');
		$objSheet->getCell('M'.$rowHeader)->setValue('Reject');
		$objSheet->mergeCells('M7:O7');
		$objSheet->getCell('P'.$rowHeader)->setValue('Waste');
		$objSheet->mergeCells('P7:R7');		

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;		
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}


		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('E'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('F'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('G'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('H'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('I'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('J'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('K'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('L'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('M'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('N'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('O'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('P'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('Q'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('R'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('S'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('T'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('U'.$rowHeader)->setValue('MMEA');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('E'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('F'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('H'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('I'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('J'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('K'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('L'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('M'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('N'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('O'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('P'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('Q'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('R'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('S'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('T'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('U'.$rowHeader)->setValue('(Meter)');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}
		//end of header file
		$rowHeader++;
		//get data
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$d=cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

		$kkCompare = null;
		$kkCompare2 = null;
		$kkCompareMMEA = null;
		$batasAtas = "1-".$bulan."-".$tahun;
		$countDebit1 = $this->Master_neraca->countTotalDebitRewind($batasAtas,'2017','1');
		$countKredit1 = $this->Master_neraca->countTotalKreditRewind($batasAtas,'2017','1');
		if($countDebit1 == null || $countKredit1==null){
			$saldoAwal1 = 0;
		}else{
			$saldoAwal1 = $countDebit1-$countKredit1;
		}

		$countDebit2 = $this->Master_neraca->countTotalDebitRewind($batasAtas,'2017','3');
		$countKredit2 = $this->Master_neraca->countTotalKreditRewind($batasAtas,'2017','3');
		if($countDebit2 == null || $countKredit2==null){
			$saldoAwal2 = 0;
		}else{
			$saldoAwal2 = $countDebit2-$countKredit2;
		}

		$countDebitMMEA = $this->Master_neraca->countTotalDebitRewind($batasAtas,'2017',null);
		$countKreditMMEA = $this->Master_neraca->countTotalKreditRewind($batasAtas,'2017',null);
		if($countDebitMMEA == null || $countKreditMMEA==null){
			$saldoAwalMMEA = 0;
		}else{
			$saldoAwalMMEA = $countDebitMMEA-$countKreditMMEA;
		}
		
		for($i=0;$i<$d;$i++) {
			$tanggal = ($i+1)."-".$bulan."-".$tahun;
			$objSheet->getCell($rowTitle2[0].$rowHeader)->setValue($tanggal);

			$bonDemetMMEA = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"MMEA");
			$bonDemet1 = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"1");
			$bonDemet2 = $this->Master_neraca->demetCountResultBySeriAndDate($tanggal,"3");

			$seri1 = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"1");
			$seri2 = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"3");
			$seriMMEA = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"MMEA");

			$waste1 = $this->Master_neraca->rewindCountWasteBySeriAndDate($tanggal,"1");
			$waste2 = $this->Master_neraca->rewindCountWasteBySeriAndDate($tanggal,"3");
			$wasteMMEA = $this->Master_neraca->rewindCountWasteBySeriAndDate($tanggal,"MMEA");

			$objSheet->getCell($rowTitle2[1].$rowHeader)->setValue($saldoAwal1);
			$objSheet->getCell($rowTitle2[2].$rowHeader)->setValue($saldoAwal2);
			$objSheet->getCell($rowTitle2[3].$rowHeader)->setValue($saldoAwalMMEA);

			if($bonDemet1 != null){
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue($bonDemet1->TOTAL_BAHAN);
				$demet1 = $bonDemet1->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue("0");
				$demet1 = 0;
			}

			if($bonDemet2 != null){
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue($bonDemet2->TOTAL_BAHAN);
				$demet2 = $bonDemet2->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue("0");
				$demet2 = 0;
			}

			if($bonDemetMMEA != null){
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue($bonDemetMMEA->TOTAL_BAHAN);
				$demetMMEA = $bonDemetMMEA->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue("0");
				$demetMMEA = 0;
			}

			if($seri1 != null){
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue($seri1->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue("0");
			}

			if($seri2 != null){
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue($seri2->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue("0");
			}

			if($seriMMEA != null){
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue($seriMMEA->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue("0");
			}

			//waste dan kk
			if($waste1 != null){
				if($kkCompare != null){
					if($kkCompare != $waste1->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare = $waste1->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare = $waste1->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue($waste1->WASTE);
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue($waste1->REJECT);

				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$demet1)-(($seri1->TOTAL_BAHAN)+($waste1->WASTE)+($waste1->REJECT));
				}else{
					$saldoAwal1 = ($saldoAwal1+$demet1)-((0)+($waste1->WASTE)+($waste1->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue("0");
				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$demet1)-(($seri1->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal1 = ($saldoAwal1+$demet1)-((0)+(0)+(0));
				}
			}

			if($waste2 != null){
				if($kkCompare2 != null){
					if($kkCompare2 != $waste2->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare2 = $waste2->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare2 = $waste2->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue($waste2->WASTE);
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue($waste2->REJECT);

				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$demet2)-(($seri2->TOTAL_BAHAN)+($waste2->WASTE)+($waste2->REJECT));
				}else{
					$saldoAwal2 = ($saldoAwal2+$demet2)-((0)+($waste2->WASTE)+($waste2->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue("0");
				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$demet2)-(($seri2->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal2 = ($saldoAwal2+$demet2)-((0)+(0)+(0));
				}
			}

			if($wasteMMEA != null){
				if($kkCompareMMEA != null){
					if($kkCompareMMEA != $wasteMMEA->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue($wasteMMEA->WASTE);
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue($wasteMMEA->REJECT);
				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$demetMMEA)-(($seriMMEA->TOTAL_BAHAN)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$demetMMEA)-((0)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue("0");
				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$demetMMEA)-(($seriMMEA->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$demetMMEA)-((0)+(0)+(0));
				}
			}

			$objSheet->getCell($rowTitle2[16].$rowHeader)->setValue('=('.$rowTitle2[1].$rowHeader.'+'.$rowTitle2[4].$rowHeader.')-('.$rowTitle2[7].$rowHeader.'+'.$rowTitle2[10].$rowHeader.'+'.$rowTitle2[13].$rowHeader.')');
			$objSheet->getCell($rowTitle2[17].$rowHeader)->setValue('=('.$rowTitle2[2].$rowHeader.'+'.$rowTitle2[5].$rowHeader.')-('.$rowTitle2[8].$rowHeader.'+'.$rowTitle2[11].$rowHeader.'+'.$rowTitle2[14].$rowHeader.')');
			$objSheet->getCell($rowTitle2[18].$rowHeader)->setValue('=('.$rowTitle2[3].$rowHeader.'+'.$rowTitle2[6].$rowHeader.')-('.$rowTitle2[9].$rowHeader.'+'.$rowTitle2[12].$rowHeader.'+'.$rowTitle2[15].$rowHeader.')');

			//Add Border
			for($j = 0; $j < count($rowTitle2); $j++){
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->applyFromArray($borders);
			}
			//End Of Add Border
			$rowHeader++;

		}
		$filename = "NERACA REWIND";
			// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
		$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
	}

	function neracaBelah(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMKW"){
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_neraca_belah',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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

	function generateNeracaBelah(){
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		// writer already created the first sheet for us, let's get it
		$objSheet = $objPHPExcel->getActiveSheet();
		// rename the sheet
		$objSheet->setTitle('NERACA BELAH');

		$rowTitle1 = array();
		$rowTitle1[] = 'C';
		$rowTitle1[] = 'D';
		$rowTitle1[] = 'F';
		$rowTitle1[] = 'I';
		$rowTitle1[] = 'J';
		$rowTitle1[] = 'L';
		$rowTitle1[] = 'M';
		$rowTitle1[] = 'N';
		$rowTitle1[] = 'Q';
		$rowTitle1[] = 'S';

		$rowTitle2 = array();
		$rowTitle2[] = 'C';
		$rowTitle2[] = 'D';
		$rowTitle2[] = 'E';
		$rowTitle2[] = 'F';
		$rowTitle2[] = 'G';
		$rowTitle2[] = 'H';
		$rowTitle2[] = 'I';
		$rowTitle2[] = 'J';
		$rowTitle2[] = 'K';
		$rowTitle2[] = 'L';
		$rowTitle2[] = 'M';
		$rowTitle2[] = 'N';
		$rowTitle2[] = 'O';
		$rowTitle2[] = 'P';
		$rowTitle2[] = 'Q';
		$rowTitle2[] = 'R';
		$rowTitle2[] = 'S';
		$rowTitle2[] = 'T';
		$rowTitle2[] = 'U';
		$rowTitle2[] = 'V';

		$rowHeader = 7;
		// write header
		$objSheet->getCell('C'.$rowHeader)->setValue('TGL');
		$objSheet->mergeCells('C7:C9');
		$objSheet->getCell('D'.$rowHeader)->setValue('Saldo Awal');
		$objSheet->mergeCells('D7:E7');
		$objSheet->getCell('F'.$rowHeader)->setValue('Penerimaan');
		$objSheet->mergeCells('F7:G7');
		$objSheet->getCell('H'.$rowHeader)->setValue('Nomor');
		$objSheet->getCell('I'.$rowHeader)->setValue('Mutasi Belah ke Gudang WIP');
		$objSheet->mergeCells('I7:L7');
		$objSheet->getCell('M'.$rowHeader)->setValue('WASTE SERI I');
		$objSheet->mergeCells('M7:N8');
		$objSheet->getCell('O'.$rowHeader)->setValue('WASTE SERI III');
		$objSheet->mergeCells('O7:Q8');
		$objSheet->getCell('R'.$rowHeader)->setValue('BA Pemusnahan');
		$objSheet->mergeCells('R7:T8');
		$objSheet->getCell('U'.$rowHeader)->setValue('Saldo Akhir');
		$objSheet->mergeCells('U7:V8');

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

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}
		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('I');
		$objSheet->getCell('E'.$rowHeader)->setValue('III');
		$objSheet->getCell('F'.$rowHeader)->setValue('Seri I');
		$objSheet->getCell('G'.$rowHeader)->setValue('Seri III');
		$objSheet->getCell('H'.$rowHeader)->setValue('Mutasi');
		$objSheet->getCell('I'.$rowHeader)->setValue('Nomor');
		$objSheet->getCell('J'.$rowHeader)->setValue('Seri I');
		$objSheet->mergeCells('J8:J9');
		$objSheet->getCell('K'.$rowHeader)->setValue('Nomor');
		$objSheet->getCell('L'.$rowHeader)->setValue('Seri III');
		$objSheet->mergeCells('L8:L9');
		

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('I'.$rowHeader)->setValue('Mutasi');
		$objSheet->getCell('K'.$rowHeader)->setValue('Mutasi');
		$objSheet->getCell('R'.$rowHeader)->setValue('No');
		$objSheet->getCell('S'.$rowHeader)->setValue('Seri I');
		$objSheet->getCell('T'.$rowHeader)->setValue('Seri III');
		$objSheet->getCell('U'.$rowHeader)->setValue('Seri I');
		$objSheet->getCell('V'.$rowHeader)->setValue('Seri III');
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}


		$filename = "NERACA BELAH";
			// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
		$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
	}

	function neracaSensi(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMKW"){
				$this->load->view('AdminProduksiNeraca/v_header',$data);
				$this->load->view('AdminProduksiNeraca/v_sidebar',$data);
				$this->load->view('AdminProduksiNeraca/v_neraca_sensi',$data);
				$this->load->view('AdminProduksiNeraca/v_footer',$data);
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
	function generateNeracaSensi(){
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		// writer already created the first sheet for us, let's get it
		$objSheet = $objPHPExcel->getActiveSheet();
		// rename the sheet
		$objSheet->setTitle('NERACA SENSI');

		$rowTitle1 = array();
		$rowTitle1[] = 'C';
		$rowTitle1[] = 'D';
		$rowTitle1[] = 'F';
		$rowTitle1[] = 'I';
		$rowTitle1[] = 'J';
		$rowTitle1[] = 'L';
		$rowTitle1[] = 'M';
		$rowTitle1[] = 'N';
		$rowTitle1[] = 'Q';
		$rowTitle1[] = 'S';

		$rowTitle2 = array();
		$rowTitle2[0] = 'C';
		$rowTitle2[1] = 'D';
		$rowTitle2[2] = 'E';
		$rowTitle2[3] = 'F';
		$rowTitle2[4] = 'G';
		$rowTitle2[5] = 'H';
		$rowTitle2[6] = 'I';
		$rowTitle2[7] = 'J';
		$rowTitle2[8] = 'K';
		$rowTitle2[9] = 'L';
		$rowTitle2[10] = 'M';
		$rowTitle2[11] = 'N';
		$rowTitle2[12] = 'O';
		$rowTitle2[13] = 'P';
		$rowTitle2[14] = 'Q';
		$rowTitle2[15] = 'R';
		$rowTitle2[16] = 'S';
		$rowTitle2[17] = 'T';
		$rowTitle2[18] = 'U';

		//Define start index 
		$rowKK = 1;
		$rowHeader = 5;
		// write header
		$objSheet->getCell('C'.$rowHeader)->setValue('Tanggal');
		$objSheet->mergeCells('C5:C10');
		$objSheet->getCell('D'.$rowHeader)->setValue('Saldo Awal');
		$objSheet->mergeCells('D5:F7');
		$objSheet->getCell('G'.$rowHeader)->setValue('Penerimaan (DEBIT)');
		$objSheet->mergeCells('G5:I7');
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Sensi (KREDIT)');
		$objSheet->mergeCells('J5:R6');
		$objSheet->getCell('S'.$rowHeader)->setValue('Saldo Akhir');
		$objSheet->mergeCells('S5:U7');

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
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('J'.$rowHeader)->setValue('Hasil Baik');
		$objSheet->mergeCells('J7:L7');
		$objSheet->getCell('M'.$rowHeader)->setValue('Reject');
		$objSheet->mergeCells('M7:O7');
		$objSheet->getCell('P'.$rowHeader)->setValue('Waste');
		$objSheet->mergeCells('P7:R7');		

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;		
		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}


		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('E'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('F'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('G'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('H'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('I'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('J'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('K'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('L'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('M'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('N'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('O'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('P'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('Q'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('R'.$rowHeader)->setValue('MMEA');
		$objSheet->getCell('S'.$rowHeader)->setValue('Seri 1');
		$objSheet->getCell('T'.$rowHeader)->setValue('Seri 2/3');
		$objSheet->getCell('U'.$rowHeader)->setValue('MMEA');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}

		$rowHeader++;
		$objSheet->getCell('D'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('E'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('F'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('H'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('I'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('J'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('K'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('L'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('M'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('N'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('O'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('P'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('Q'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('G'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('R'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('S'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('T'.$rowHeader)->setValue('(Meter)');
		$objSheet->getCell('U'.$rowHeader)->setValue('(Meter)');

		for($i = 0; $i < count($rowTitle2); $i++){
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle($rowTitle2[$i].''.$rowHeader)->applyFromArray($borders);
		}
		//end of header file
		$rowHeader++;
		//get data
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$d=cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

		$kkCompare = null;
		$kkCompare2 = null;
		$kkCompareMMEA = null;
		$batasAtas = "1-".$bulan."-".$tahun;

		$countDebit1 = $this->Master_neraca->countTotalDebitSensi($batasAtas,'2017','1');
		$countKredit1 = $this->Master_neraca->countTotalKreditSensi($batasAtas,'2017','1');
		if($countDebit1 == null || $countKredit1==null){
			$saldoAwal1 = 0;
		}else{
			$saldoAwal1 = $countDebit1-$countKredit1;
		}

		$countDebit2 = $this->Master_neraca->countTotalDebitSensi($batasAtas,'2017','3');
		$countKredit2 = $this->Master_neraca->countTotalKreditSensi($batasAtas,'2017','3');
		if($countDebit2 == null || $countKredit2==null){
			$saldoAwal2 = 0;
		}else{
			$saldoAwal2 = $countDebit2-$countKredit2;
		}

		$countDebitMMEA = $this->Master_neraca->countTotalDebitSensi($batasAtas,'2017',null);
		$countKreditMMEA = $this->Master_neraca->countTotalKreditSensi($batasAtas,'2017',null);
		if($countDebitMMEA == null || $countKreditMMEA==null){
			$saldoAwalMMEA = 0;
		}else{
			$saldoAwalMMEA = $countDebitMMEA-$countKreditMMEA;
		}
		
		for($i=0;$i<$d;$i++) {
			$tanggal = ($i+1)."-".$bulan."-".$tahun;
			$objSheet->getCell($rowTitle2[0].$rowHeader)->setValue($tanggal);

			$bonRewindMMEA = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"MMEA");
			$bonRewind1 = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"1");
			$bonRewind2 = $this->Master_neraca->rewindCountResultBySeriAndDate($tanggal,"3");

			$seri1 = $this->Master_neraca->sensiCountResultBySeriAndDate($tanggal,"1");
			$seri2 = $this->Master_neraca->sensiCountResultBySeriAndDate($tanggal,"3");
			$seriMMEA = $this->Master_neraca->sensiCountResultBySeriAndDate($tanggal,"MMEA");

			$waste1 = $this->Master_neraca->sensiCountWasteBySeriAndDate($tanggal,"1");
			$waste2 = $this->Master_neraca->sensiCountWasteBySeriAndDate($tanggal,"3");
			$wasteMMEA = $this->Master_neraca->sensiCountWasteBySeriAndDate($tanggal,"MMEA");

			$objSheet->getCell($rowTitle2[1].$rowHeader)->setValue($saldoAwal1);
			$objSheet->getCell($rowTitle2[2].$rowHeader)->setValue($saldoAwal2);
			$objSheet->getCell($rowTitle2[3].$rowHeader)->setValue($saldoAwalMMEA);

			if($bonRewind1 != null){
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue($bonRewind1->TOTAL_BAHAN);
				$rewind1 = $bonRewind1->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[4].$rowHeader)->setValue("0");
				$demet1 = 0;
			}

			if($bonRewind2 != null){
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue($bonRewind2->TOTAL_BAHAN);
				$rewind2 = $bonRewind2->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[5].$rowHeader)->setValue("0");
				$rewind2 = 0;
			}

			if($bonRewindMMEA != null){
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue($bonRewindMMEA->TOTAL_BAHAN);
				$rewindMMEA = $bonRewindMMEA->TOTAL_BAHAN;
			}else{
				$objSheet->getCell($rowTitle2[6].$rowHeader)->setValue("0");
				$rewindMMEA = 0;
			}

			if($seri1 != null){
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue($seri1->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[7].$rowHeader)->setValue("0");
			}

			if($seri2 != null){
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue($seri2->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[8].$rowHeader)->setValue("0");
			}

			if($seriMMEA != null){
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue($seriMMEA->TOTAL_BAHAN);
			}else{
				$objSheet->getCell($rowTitle2[9].$rowHeader)->setValue("0");
			}

			//waste dan kk
			if($waste1 != null){
				if($kkCompare != null){
					if($kkCompare != $waste1->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare = $waste1->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare = $waste1->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste1->NOMOR_KK." Seri : 1");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue($waste1->WASTE);
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue($waste1->REJECT);

				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$rewind1)-(($seri1->TOTAL_BAHAN)+($waste1->WASTE)+($waste1->REJECT));
				}else{
					$saldoAwal1 = ($saldoAwal1+$rewind1)-((0)+($waste1->WASTE)+($waste1->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[10].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[13].$rowHeader)->setValue("0");
				if($seri1 != null){
					$saldoAwal1 = ($saldoAwal1+$rewind1)-(($seri1->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal1 = ($saldoAwal1+$rewind1)-((0)+(0)+(0));
				}
			}

			if($waste2 != null){
				if($kkCompare2 != null){
					if($kkCompare2 != $waste2->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompare2 = $waste2->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompare2 = $waste2->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($waste2->NOMOR_KK." Seri : 2");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue($waste2->WASTE);
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue($waste2->REJECT);

				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$rewind2)-(($seri2->TOTAL_BAHAN)+($waste2->WASTE)+($waste2->REJECT));
				}else{
					$saldoAwal2 = ($saldoAwal2+$rewind2)-((0)+($waste2->WASTE)+($waste2->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[11].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[14].$rowHeader)->setValue("0");
				if($seri2 != null){
					$saldoAwal2 = ($saldoAwal2+$rewind2)-(($seri2->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwal2 = ($saldoAwal2+$rewind2)-((0)+(0)+(0));
				}
			}

			if($wasteMMEA != null){
				if($kkCompareMMEA != null){
					if($kkCompareMMEA != $wasteMMEA->NOMOR_KK){
						$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
						$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
						$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
						$rowKK++;
					}
				}else{
					$kkCompareMMEA = $wasteMMEA->NOMOR_KK;
					$objSheet->getCell("C".$rowKK)->setValue($wasteMMEA->NOMOR_KK." Seri : MMEA");
					$objSheet->mergeCells('C'.$rowKK.':F'.$rowKK);
					$rowKK++;
				}
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue($wasteMMEA->WASTE);
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue($wasteMMEA->REJECT);
				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$rewindMMEA)-(($seriMMEA->TOTAL_BAHAN)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$rewindMMEA)-((0)+($wasteMMEA->WASTE)+($wasteMMEA->REJECT));
				}
			}else{
				$objSheet->getCell($rowTitle2[12].$rowHeader)->setValue("0");
				$objSheet->getCell($rowTitle2[15].$rowHeader)->setValue("0");
				if($seriMMEA != null){
					$saldoAwalMMEA = ($saldoAwalMMEA+$rewindMMEA)-(($seriMMEA->TOTAL_BAHAN)+(0)+(0));
				}else{
					$saldoAwalMMEA = ($saldoAwalMMEA+$rewindMMEA)-((0)+(0)+(0));
				}
			}

			$objSheet->getCell($rowTitle2[16].$rowHeader)->setValue('=('.$rowTitle2[1].$rowHeader.'+'.$rowTitle2[4].$rowHeader.')-('.$rowTitle2[7].$rowHeader.'+'.$rowTitle2[10].$rowHeader.'+'.$rowTitle2[13].$rowHeader.')');
			$objSheet->getCell($rowTitle2[17].$rowHeader)->setValue('=('.$rowTitle2[2].$rowHeader.'+'.$rowTitle2[5].$rowHeader.')-('.$rowTitle2[8].$rowHeader.'+'.$rowTitle2[11].$rowHeader.'+'.$rowTitle2[14].$rowHeader.')');
			$objSheet->getCell($rowTitle2[18].$rowHeader)->setValue('=('.$rowTitle2[3].$rowHeader.'+'.$rowTitle2[6].$rowHeader.')-('.$rowTitle2[9].$rowHeader.'+'.$rowTitle2[12].$rowHeader.'+'.$rowTitle2[15].$rowHeader.')');

			//Add Border
			for($j = 0; $j < count($rowTitle2); $j++){
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getFont()->setBold(true)->setSize(11);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objSheet->getStyle($rowTitle2[$j].''.$rowHeader)->applyFromArray($borders);
			}
			//End Of Add Border
			$rowHeader++;

		}
		$filename = "NERACA SENSI";
			// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
			// Write file to the browser
		$objWriter->save('php://output');
			// $objWriter->save("D://Test/".$filename.".xlsx");
}
