<?php
class AdminProduksiSensitizing extends Controller {
	function AdminProduksiSensitizing()
	{
		parent::Controller();
		session_start();
		ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
		$this->load->model('Master_bahan_model');
		$this->load->model('Master_kk_model');
		$this->load->model('Master_terima_foil_model');
		$this->load->model('Master_detail_sensi_model');
		$this->load->model('Master_mutasi_rewind');
		$this->load->model('Master_mutasi_sensi');
		
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
			if($data["status"]=="ADMSENSI"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_home',$data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function chooseData(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["masterBahan"] = $this->Master_detail_sensi_model->chooseKodeRoll();

			for($i=0;$i<sizeof($data['masterBahan']);$i++){
			 $bahanSudahDigunakan = 0;
			 $checkExistingData = $this->Master_detail_sensi_model->findByRollAndMutasi($data["masterBahan"][$i]->KODE_ROLL,$data["masterBahan"][$i]->ID_MUTASI);
			 if(sizeof($checkExistingData)>0){
				$bahanSudahDigunakan = 0;
				foreach ($checkExistingData as $row1) {
					$bahanSudahDigunakan = $bahanSudahDigunakan + $row1->BAIK_METER +$row1->WASTE_METER + $row1->REJECT_METER;
				}
				
				if($bahanSudahDigunakan == $data['masterBahan'][$i]->TOTAL_BAHAN){
					// unset($data['masterBahan'][$i]);
					$data['masterBahan'][$i]->TOTAL_BAHAN = 0;
				}else if($bahanSudahDigunakan < $data['masterBahan'][$i]->TOTAL_BAHAN){
					$data['masterBahan'][$i]->TOTAL_BAHAN = $data['masterBahan'][$i]->TOTAL_BAHAN- $bahanSudahDigunakan;
				}
			 }


			}
			if($data["status"]=="ADMSENSI"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_choose_data',$data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function formLaporanSensi($param){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];

			$separateParam = $pecah=explode("@",$param);

			$data["kodeRoll"] = $separateParam[0];
			$data["noMutasi"] = $separateParam[1];
			$data["totalBahan"] = $separateParam[2];
			// $bahanSudahDigunakan = 0;

			// $checkExistingData = $this->Master_detail_sensi_model->findByRollAndMutasi($data["kodeRoll"],$data["noMutasi"]);
			// if(sizeof($checkExistingData)>0){
			// 	$bahanSudahDigunakan = 0;
			// 	foreach ($checkExistingData as $row) {
			// 		$bahanSudahDigunakan = $bahanSudahDigunakan + $row->BAIK_METER + $row->WASTE_METER + $row->REJECT_METER;
			// 	}
			// 	$data["totalBahan"] = $data["totalBahan"] - $bahanSudahDigunakan;
			// }else{
			// 	$data["totalBahan"] = $separateParam[2];
			// }

			$temp = array();
			$temp["mutasiRewind"] = $this->Master_mutasi_rewind->findByRollAndMutasi($data["kodeRoll"], $data["noMutasi"]);
			$temp["bahanSebelum"] = $data["totalBahan"];
			$temp["bahanSudahDigunakan"] = $data["totalBahan"];
			$temp["totalBahanDariRewind"] = $separateParam[2];
			$temp["param"] = $param;

			$this->session->set_flashdata('data', $temp);

			$data["master_kk"] = $this->Master_kk_model->getDataKK();
			if($data["status"]=="ADMSENSI"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_form_laporan_sensi',$data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function saveLaporanSensitizing(){

		$noUrut = $this->Master_detail_sensi_model->getMaxNumber();
		$lastData = $this->Master_detail_sensi_model->getLastCode();

		$hasilBaik = str_replace(".", "", $this->input->post('hasilBaik'));
		$hasilRusak = str_replace(".", "", $this->input->post('hasilRusak'));
		$reject = str_replace(".", "", $this->input->post('hasilReject'));
		$totalHitung = $hasilBaik + $hasilRusak + $reject;
		$bahanDariRewind = $this->input->post('totalBahan');
		$temp = $this->session->flashdata('data');
		$nomorKK = $this->input->post('chooseKK');

		if($totalHitung > $bahanDariRewind){
			$this->session->set_flashdata('error', 'Total Bahan Tidak Sesuai');
			redirect("AdminProduksiSensitizing/formLaporanSensi/".$temp['param']);
		}else if($nomorKK == "0-0"){
			$this->session->set_flashdata('error', 'Nomor KK Tidak Boleh Kosong');
			redirect("AdminProduksiSensitizing/formLaporanSensi/".$temp['param']);
		}else{

			$noUrut = $noUrut[0]->NO_URUT_SENSI;
			$noUrut = $noUrut + 1;
			$kodeSensi = explode("-", $lastData[0]->KODE_SENSI);
			$kodeSensi = $kodeSensi[1];
			$kodeSensi = $kodeSensi + 1;

			$nomorKK = explode("@", $nomorKK);

			$data['NO_URUT_SENSI'] = $noUrut;
			$data['KODE_SENSI'] = "SEN-".$kodeSensi;

			$data['KODE_ROLL'] = $this->input->post('kodeRoll');
			$data['SHIFT_SENSI'] = $this->input->post('shift');
			$data['BAIK_METER'] = $hasilBaik;
			$data['TOTAL_BAHAN'] = $bahanDariRewind;
			$data['SISA_BAIK'] = $bahanDariRewind - $totalHitung;
			$data['REJECT_METER'] = $reject;
			$data['WASTE_METER'] = $hasilRusak;
			$data['STATUS_MUTASI'] = 'BELUM MUTASI';
			$data['NO_MUTASI_REWIND'] = $temp['mutasiRewind'][0]->ID_MUTASI;
			
			$data['MESIN_SENSI'] = $this->input->post('mesinSensi');

			$data['NOMOR_KK'] = $nomorKK[0];
			$data['TGL_PRODUKSI'] = $this->input->post('tanggalProduksi');
			$data['KODE_BAHAN'] = $nomorKK[2];
			$data['START_JAM_PRODUKSI'] = $this->input->post('startTimeProduksi');
			$data['FINISH_JAM_PRODUKSI'] = $this->input->post('endTimeProduksi');
			$data['NO_MUTASI_SENSI'] = '0';

		$data['START_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeProduksi')));
		
		if(strtotime($this->input->post('endTimeProduksi'))<strtotime($this->input->post('startTimeProduksi'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeProduksi')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_PRODUKSI'] = $finishDate;
		}else{
			$data['FINISH_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeProduksi')));
		}

		$data['START_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimePersiapan')));
		if(strtotime($this->input->post('endTimePersiapan'))<strtotime($this->input->post('startTimePersiapan'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimePersiapan')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_PERSIAPAN'] = $finishDate;
		}else{
			$data['FINISH_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimePersiapan')));
		}

		$data['START_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleProduksi')));
		if(strtotime($this->input->post('endTimeTroubleProduksi'))<strtotime($this->input->post('startTimeTroubleProduksi'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleProduksi')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_TROUBLE_PRODUKSI'] = $finishDate;
		}else{
			$data['FINISH_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleProduksi')));
		}

		$data['START_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleMesin')));
		if(strtotime($this->input->post('endTimeTroubleMesin'))<strtotime($this->input->post('startTimeTroubleMesin'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleMesin')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_TROUBLE_MESIN'] = $finishDate;
		}else{
			$data['FINISH_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleMesin')));
		}

		$data['START_JAM_TUNGGU_BAHAN'] =  date('Y-m-d H:i',strtotime($this->input->post('startTimeTungguBahan')));
		$data['FINISH_JAM_TUNGGU_BAHAN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTungguBahan')));

		$data['START_JAM_TUNGGU_CORE'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTungguCore')));
		$data['FINISH_JAM_TUNGGU_CORE'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTungguCore')));

		$data['START_JAM_FORCE_MAJOR'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeForceMajor')));
		$data['FINISH_JAM_FORCE_MAJOR'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeForceMajor')));

		$data['START_JAM_GANTI_SILINDER_SERI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeGantiSilinder')));
		$data['FINISH_JAM_GANTI_SILINDER_SERI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeGantiSilinder')));

		$data['START_JAM_LAIN_LAIN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimelain')));
		$data['FINISH_JAM_LAIN_LAIN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimelain')));

			if($this->Master_detail_sensi_model->saveLaporanSensi($data)){
				$bahanSudahDigunakan = $temp['bahanSudahDigunakan'];
				$Sebelum = $temp['bahanSebelum'];
				$totalBahanDariRewind = $temp['totalBahanDariRewind'];

				// if($bahanSudahDigunakan>0){
				// 	$hitungTotalBahan = $bahanSudahDigunakan + $data['BAIK_METER'] + $data['REJECT_METER'] + $data['WASTE_METER'];
				// 	if($hitungTotalBahan==$totalBahanDariRewind){
				// 		$dataUpdate = array(
				// 		'STATUS_SENSI' => "finish"
				// 		);
				// 	}else{
				// 		$dataUpdate = array(
				// 		'STATUS_SENSI' => "progress"
				// 		);
				// 	}
				// }else{
					$hitungTotalBahan = $data['BAIK_METER'] + $data['REJECT_METER'] + $data['WASTE_METER'];
					if($hitungTotalBahan==$totalBahanDariRewind){
						$dataUpdate = array(
						'STATUS_SENSI' => "finish"
						);
					}else{
						$dataUpdate = array(
						'STATUS_SENSI' => "progress"
						);
					}
				// }
				
				// $idMutasi =  $this->session->flashdata('idMutasi');
				$data['KODE_ROLL'] = $temp['mutasiRewind'][0]->KODE_ROLL;
				if($this->Master_mutasi_rewind->updateMutasi($temp['mutasiRewind'][0]->ID_MUTASI,$data['KODE_ROLL'],$dataUpdate)){
					$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
					redirect("AdminProduksiSensitizing/chooseData");
				}else{
					$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
					redirect("AdminProduksiSensitizing/chooseData");
				}
			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiSensitizing/chooseData");
			}
		}
		
	}
	function mutasiBarang(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["listSensi"] = $this->Master_detail_sensi_model->getDataForMutation();

			if($data["status"]=="ADMSENSI"){
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_pilih_mutasi', $data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function findByRollBeforeMutation(){

		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$kodeRoll = $this->input->post('kodeRoll');
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["listSensi"] = $this->Master_detail_sensi_model->findByRollBeforeMutation($kodeRoll);

			if($data["status"]=="ADMSENSI"){
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_pilih_mutasi', $data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function formMutasi(){
		
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["kodeRollBaru"] = "";
			// $kodeEmboss = $this->input->post('name1');
			// $this->session->set_flashdata('kodeEmboss', $kodeEmboss);
			$input = array();

			//Menampilkan data laporan emboss yang siap di mutasi ke demet
			$dataMutasi = $this->Master_detail_sensi_model->getDataForMutation();

			//Mengambil no urut yang dipilih oleh pengguna
			// foreach ($dataMutasi as $row) {
			// 	$x = $this->input->post($row->NO_URUT_SENSI);
			// 	// $input[] = $x."@".$row->KODE_ROLL_ASAL;
			// 	if($x != ""){
			// 		$input[] = $x."@".$row->KODE_ROLL."@".$row->BAIK_METER."@".$row->KODE_SENSI;
			// 		$data["nomorKK"] =  $row->NOMOR_KK;

			// 	}
			// }
			//Checking how many data user chooses
			$index = 0;
			foreach ($dataMutasi as $row) {
				$x = $this->input->post($row->NO_URUT_SENSI);
				if($x != ""){
					$input[$index][0] = $row->KODE_ROLL;
					$input[$index][1] = $row->BAIK_METER;
					$input[$index][2] = $row->KODE_SENSI;
					$input[$index][3] = "";
					$input[$index][4] = $x;
					$index++;
				}
			}
			$index = 0;
			//Checking how many data user chooses
			$showInput = array();
			$countData = count($input);
			$rollExist = false;
		
			if($countData == 1){
				$showInput[$index][0] = $input[0][0];
				$showInput[$index][1] = $input[0][1];
			}else if($countData > 1){
				for($i=0; $i<$countData; $i++) {
					if(count($showInput)>0){
						for($j=0; $j<count($showInput); $j++) {
							if($showInput[$j][0]==$input[$i][0]){
								$rollExist = true;
								$showInput[$j][1] = $showInput[$j][1]+$input[$i][1];
							}
						}

						if(!$rollExist){
							$showInput[$index][0] = $input[$i][0];
							$showInput[$index][1] = $input[$i][1];
							$showInput[$index][2] = $input[$i][2];
							$showInput[$index][3] = $input[$i][3];
							$showInput[$index][4] = $input[$i][4];
							$index++;
						}
						$rollExist = false;
					}else if(count($showInput)==0){
						$showInput[$index][0] = $input[$i][0];
						$showInput[$index][1] = $input[$i][1];
						$showInput[$index][2] = $input[$i][2];
						$showInput[$index][3] = $input[$i][3];
						$showInput[$index][4] = $input[$i][4];
						$index++;
					}
				}
			}
			// $countData = count($input);
			// $this->session->set_flashdata('kodeSensi', $input);

			// if($countData == 1){

			// 	//if user only selects one data then
			// 	//Use kode_roll column in table tbl_detail_emboss as kode_roll_baru in tbl_mutasi_emboss
			// 	$getKodeRoll=explode("@",$input[0]);
			// 	foreach ($dataMutasi as $key) {
			// 		if($key->NO_URUT_SENSI == $getKodeRoll[0]){
			// 			$kodeRollBaru = $key->KODE_ROLL;
			// 			$data["kodeRoll"] = $kodeRollBaru;
			// 			$data["hasilBaik"] = $key->BAIK_METER;
			// 			// $data["idRoll"] =  $key->ID_ROLL;
			// 		}
			// 	}
				
			// }else if($countData>1){
			// 	$data["hasilBaik"] = 0;

			// 	//if user selects more than one data then
			// 	//System checking whether the data selected by user has same kode_roll or not
			// 	$getKodeRoll=explode("@",$input[0]);
			// 	$compareKodeRoll = $getKodeRoll[1] ;
			// 	$validation = false;
			// 	foreach ($input as $row) {
			// 		$getKodeRoll=explode("@",$row);
			// 		if($compareKodeRoll != $getKodeRoll[1] ){
			// 			$validation = false;
			// 			break;
			// 		}else{
			// 			$data["hasilBaik"] = $data["hasilBaik"] + $getKodeRoll[2];

			// 			$validation = true;
			// 		}
			// 						}
			// 	if($validation){
			// 		$data["kodeRoll"] = $compareKodeRoll;
					
			// 	}else{
			// 		//If validation false then
			// 		//User redirected to v_mutasi.php
			// 	   $this->session->set_flashdata('warning', 'Kode Roll Berbeda');
			// 	   echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/AdminProduksiSensitizing/mutasiBarang'>";
			// 	}
			// }
			$temp = array();
			$temp['dataInsert'] = $showInput;
			$temp['dataUpdate'] = $input;
			$data['dataInput'] = $showInput;
			$this->session->set_flashdata('data', $temp);
			if($data["status"]=="ADMSENSI"){
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_mutasi', $data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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


	function saveMutasi(){
		// if($this->Master_mutasi_sensi->checkNumber($this->input->post('noMutasi'))){
			$dataMutasi = array();
			$temp = $this->session->flashdata('data');
			$mutasi = $temp['dataInsert'];
			$update = $temp['dataUpdate'];
			// $data = array(
			// 	'NO_MUTASI' => $this->input->post('noMutasi'),
			// 	'TGL_MUTASI' => $this->input->post('tanggalMutasi'),
			// 	'TOTAL_BAHAN' => $this->input->post('totalBahan'),
			// 	'KODE_ROLL' => $this->input->post('kodeRoll'),
			// 	'STATUS_BELAH' => "progress"
			// );
			for($i=0;$i<count($mutasi);$i++){
				$data = array(
				'NO_MUTASI' => $this->input->post('noMutasi'),
				'TGL_MUTASI' => $this->input->post('tanggalMutasi'),
				'KODE_ROLL' => $mutasi[$i][0],
				'KODE_SENSI' => $mutasi[$i][2],
				'TOTAL_BAHAN' => $mutasi[$i][1],
				// 'ID_ROLL' => $mutasi[$i][3],
				'STATUS_BELAH' => 'progress'
				);
				$dataMutasi[$i] = $data;
			}
			// $kodeSensi = $this->session->flashdata('kodeSensi');
			// if($this->Master_mutasi_sensi->saveMutasi($data, $kodeSensi)){
			if($this->Master_mutasi_sensi->saveMutasi($dataMutasi,$update)){
				$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
				redirect("AdminProduksiSensitizing/mutasiBarang/");
			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiSensitizing/mutasiBarang/");
			}
		// }else{
		// 	$this->session->set_flashdata('error', 'Number Already Exist !');
		// 	redirect("AdminProduksiSensitizing/mutasiBarang/");
		// }

	}
	function dataMutasi(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["listRoll"] = $this->Master_detail_sensi_model->dataMutasi();
			if($data["status"]=="ADMSENSI"){
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_data_mutasi', $data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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
	function listData(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["listSensi"] = $this->Master_detail_sensi_model->getAlldata();
			if($data["status"]=="ADMSENSI"){
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_list_data', $data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

	function reportPage(){
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
			if($data["status"]=="ADMSENSI"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_report',$data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

        	$startDate = $this->input->post('startDate');
        	$endDate = $this->input->post('endDate');
        	$nomorKK = $this->input->post('chooseKK');

        	if($startDate != null && $endDate == null){
        		redirect("AdminProduksiSensitizing/reportPage/");
        	}else if($startDate == null && $endDate != null){
        		redirect("AdminProduksiSensitizing/reportPage/");
        	}else if($startDate == null && $endDate == null && $nomorKK=="0-0"){
        		redirect("AdminProduksiSensitizing/reportPage/");
        	}
        	
        	$nomorKK = $this->input->post('chooseKK');
			$nomorKK = explode("@", $nomorKK);
			$nomorKK = $nomorKK[0];

        	if($nomorKK!="0-0" && $startDate == null && $endDate == null){
        		$data = $this->Master_detail_sensi_model->findByKK($nomorKK);
        	}else if($nomorKK!="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_sensi_model->findByDateRangeAndKK($startDate,$endDate,$nomorKK);
        	}else if($nomorKK=="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_sensi_model->findByDateRange($startDate,$endDate);
        	}

        	if(sizeof($data)>0){

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
				$objSheet->setTitle('Monitoring Hasil - SENSITIZING');
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
				$objSheet->getCell('D5')->setValue('SENSITIZING');

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
				$columnTitle[5] = "MSN DEMET";
				$columnTitle[6] = "SHIFT";
				$columnTitle[7] = "KODE ROLL";
				$columnTitle[8] = "TOTAL BAHAN";
				$columnTitle[9] = "BAIK SENSI";
				$columnTitle[10] = "RUSAK SENSI";
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
					$array[0] = "-";
					$array[1] = "IV";
					$stamp = strtotime($row->TGL_PRODUKSI);
					$array[2] = date("m",$stamp);
					$array[3] = $row->TGL_PRODUKSI;
					$array[4] = $row->NOMOR_KK;
					$array[5] = $row->MESIN_SENSI;
					$array[6] = $row->SHIFT_SENSI;
					$array[7] = $row->KODE_ROLL;
					$array[8] = $row->TOTAL_BAHAN;
					$array[9] = $row->BAIK_METER;
					$array[10] = $row->WASTE_METER;
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
		        $filename = "TEST LAPORAN SENSITIZING";
		        // We'll be outputting an excel file
				header('Content-type: application/vnd.ms-excel');

				// It will be called file.xls
				header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');

				// Write file to the browser
				$objWriter->save('php://output');
		        // $objWriter->save("D://Test/".$filename.".xlsx");

		    }else{
		    	$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
				redirect("AdminProduksiSensitizing/reportPage/");
	        }

        }

    function tanggal_indo($tanggal)
	{
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split = explode('-', $tanggal);
		return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
	}

    function editLaporan($param){
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMSENSI"){
				$this->session->set_flashdata('paramEdit', $param);
				$data["laporanSensi"] = $this->Master_detail_sensi_model->findById($param);
				if($data["laporanSensi"]->TGL_PRODUKSI != null){
					$data["laporanSensi"]->TGL_PRODUKSI = $this->tanggal_indo($data["laporanSensi"]->TGL_PRODUKSI );
				}
				$data["master_kk"] = $this->Master_kk_model->getDataKK();
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_PERSIAPAN)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_PERSIAPAN))){
					$data["laporanSensi"]->START_JAM_PERSIAPAN = "0";
					$data["laporanSensi"]->FINISH_JAM_PERSIAPAN = "0";
				}

				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_PRODUKSI)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_PRODUKSI))){
					$data["laporanSensi"]->START_JAM_PRODUKSI = "0";
					$data["laporanSensi"]->FINISH_JAM_PRODUKSI = "0";
				}

				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_TROUBLE_MESIN)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_TROUBLE_MESIN))){
					$data["laporanSensi"]->START_JAM_TROUBLE_MESIN = "0";
					$data["laporanSensi"]->FINISH_JAM_TROUBLE_MESIN = "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_TUNGGU_BAHAN)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_TUNGGU_BAHAN))){
					$data["laporanSensi"]->START_JAM_TUNGGU_BAHAN= "0";
					$data["laporanSensi"]->FINISH_JAM_TUNGGU_BAHAN= "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_TUNGGU_CORE)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_TUNGGU_CORE))){
					$data["laporanSensi"]->START_JAM_TUNGGU_CORE = "0";
					$data["laporanSensi"]->FINISH_JAM_TUNGGU_CORE = "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_FORCE_MAJOR)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_FORCE_MAJOR))){
					$data["laporanSensi"]->START_JAM_FORCE_MAJOR = "0";
					$data["laporanSensi"]->FINISH_JAM_FORCE_MAJOR = "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_GANTI_SILINDER_SERI)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_GANTI_SILINDER_SERI))){
					$data["laporanSensi"]->START_JAM_GANTI_SILINDER_SERI = "0";
					$data["laporanSensi"]->FINISH_JAM_GANTI_SILINDER_SERI = "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_LAIN_LAIN)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_LAIN_LAIN))){
					$data["laporanSensi"]->START_JAM_LAIN_LAIN = "0";
					$data["laporanSensi"]->FINISH_JAM_LAIN_LAIN = "0";
				}
				if(date("H:i",strtotime($data["laporanSensi"] ->START_JAM_TROUBLE_PRODUKSI)) == date("H:i",strtotime($data["laporanSensi"] ->FINISH_JAM_TROUBLE_PRODUKSI))){
					$data["laporanSensi"]->START_JAM_TROUBLE_PRODUKSI = "0";
					$data["laporanSensi"]->FINISH_JAM_TROUBLE_PRODUKSI = "0";
				}
				$this->load->view('AdminProduksiSensitizing/v_header',$data);
				$this->load->view('AdminProduksiSensitizing/v_sidebar',$data);
				$this->load->view('AdminProduksiSensitizing/v_edit_laporan',$data);
				$this->load->view('AdminProduksiSensitizing/v_footer',$data);
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

    function saveEdit(){
	//=========== Get Input Post =============//
	$kodeRoll 		= $this->input->post('kodeRoll');
	$mesin 			= $this->input->post('mesinSensi');
	$shift 			= $this->input->post('shift');
	$nomorKK 		= $this->input->post('nomorKK');
	$tglProduksi 	= $this->input->post('tanggalProduksi');
	$baikMeter 		= str_replace(".", "",$this->input->post('hasilBaik'));
	// $wasteMeter 	= str_replace(".", "",$this->input->post('hasilRusak'));
	$rejectMeter 	= str_replace(".", "",$this->input->post('hasilReject'));
	$noUrut			= $this->input->post('idData');
	$nomorMutasi 	= $this->input->post('nomorMutasiRewind');

	//======= End Get Input Post ========//

	//======== Count Total Used Foil On Same Roll =====//
	$checkExistingData = $this->Master_detail_sensi_model->findByRollAndMutasi($kodeRoll,$nomorMutasi);
	$usedFoil = 0;
	if(sizeof($checkExistingData)>0){
		foreach ($checkExistingData as $row) {
			if($row->NO_URUT_SENSI!= $noUrut){
				$usedFoil = $usedFoil + $row->BAIK_METER +$row->WASTE_METER + $row->REJECT_METER;
			}
		}
	}
	//======= End Count Total Used Foil On Same Roll =====//

	//get length from EMBOSS AND make parameter from it
	$lengthFromRewind 	= 0;
	$dataFromRewind	= $this->Master_mutasi_rewind->countTotalLength($kodeRoll,$nomorMutasi);
	$lengthFromRewind 	= $dataFromRewind->TOTAL_BAHAN;

	//====== check if total data no more than its parameter ====//
	$newTotalLength = $baikMeter+$rejectMeter+$usedFoil;
	if($lengthFromRewind<$newTotalLength){
		$this->session->set_flashdata('error',' Total Bahan Tidak Sesuai '.$newTotalLength);
		$temp = $this->session->flashdata('paramEdit');
		redirect("AdminProduksiSensitizing/editLaporan/".$temp);
	}

	//====== Get Production Variable Time =========//
	$nomorKK = explode("@", $nomorKK);
	$data['KODE_ROLL'] 		= $kodeRoll;
	$data['SHIFT_SENSI'] 	= $shift;
	$data['BAIK_METER'] 	= $baikMeter;
	$data['REJECT_METER'] 	= $rejectMeter;
	// $data['WASTE_METER'] 	= $wasteMeter;
	$data['NOMOR_KK'] 		= $nomorKK[0];
	$data['MESIN_SENSI'] 	= $mesin;
	$data['TGL_PRODUKSI'] 	= $tglProduksi;
	$data['KODE_BAHAN'] = $nomorKK[2];
	$data['START_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeProduksi')));
		
		if(strtotime($this->input->post('endTimeProduksi'))<strtotime($this->input->post('startTimeProduksi'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeProduksi')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_PRODUKSI'] = $finishDate;
		}else{
			$data['FINISH_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeProduksi')));
		}

		$data['START_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimePersiapan')));
		if(strtotime($this->input->post('endTimePersiapan'))<strtotime($this->input->post('startTimePersiapan'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimePersiapan')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_PERSIAPAN'] = $finishDate;
		}else{
			$data['FINISH_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimePersiapan')));
		}

		$data['START_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleProduksi')));
		if(strtotime($this->input->post('endTimeTroubleProduksi'))<strtotime($this->input->post('startTimeTroubleProduksi'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleProduksi')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_TROUBLE_PRODUKSI'] = $finishDate;
		}else{
			$data['FINISH_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleProduksi')));
		}

		$data['START_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleMesin')));
		if(strtotime($this->input->post('endTimeTroubleMesin'))<strtotime($this->input->post('startTimeTroubleMesin'))){
			$finishDate = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleMesin')));
			$finishDate = date('Y-m-d H:i', strtotime($finishDate.' +1 day'));
			$data['FINISH_JAM_TROUBLE_MESIN'] = $finishDate;
		}else{
			$data['FINISH_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleMesin')));
		}
	$data['START_JAM_TUNGGU_BAHAN'] =  date('Y-m-d H:i',strtotime($this->input->post('startTimeTungguBahan')));
	$data['FINISH_JAM_TUNGGU_BAHAN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTungguBahan')));
	$data['START_JAM_TUNGGU_CORE'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTungguCore')));
	$data['FINISH_JAM_TUNGGU_CORE'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTungguCore')));
	$data['START_JAM_FORCE_MAJOR'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeForceMajor')));
	$data['FINISH_JAM_FORCE_MAJOR'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeForceMajor')));
	$data['START_JAM_GANTI_SILINDER_SERI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeGantiSilinder')));
	$data['FINISH_JAM_GANTI_SILINDER_SERI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeGantiSilinder')));
	$data['START_JAM_LAIN_LAIN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimelain')));
	$data['FINISH_JAM_LAIN_LAIN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimelain')));

	$dataMutasi = array();
	if($newTotalLength<$lengthFromRewind){
		$dataMutasi['NO_MUTASI'] = $nomorMutasi;
		$dataMutasi['STATUS_SENSI'] = 'progress';
	}else{
		$dataMutasi['NO_MUTASI'] = $nomorMutasi;
		$dataMutasi['STATUS_SENSI'] = 'finish';
	}

	if($this->Master_detail_sensi_model->updateDataAndMutasi($noUrut, $data, $dataMutasi)){
		redirect("AdminProduksiSensitizing/listData/");
	}else{
		$this->session->set_flashdata('error',' Total Bahan Tidak Sesuai '.$newTotalLength);
		$temp = $this->session->flashdata('paramEdit');
		redirect("AdminProduksiSensitizing/editLaporan/".$temp);
	}
}

}