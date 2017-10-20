<?php

class AdminProduksiEmboss extends Controller {
	function AdminProduksiEmboss()
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
			if($data["status"]=="ADMEMBOSS"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_home',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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

	function addLaporanProduksiEmboss(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["masterBahan"] = $this->Master_bahan_model->getBahanFoil();
			if($data["status"]=="ADMEMBOSS"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_choose_bahan_emboss',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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

	function chooseKodeRoll(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$input = $this->input->post('chooseBahan');
			$kodeBahan  = explode("@", $input);
			$hitungBahan = 0;
			$selisihBahan = 0;
			$data['list_kode_roll'] = $this->Master_terima_foil_model->getDataByKodeBahan($kodeBahan[0]);

 			for($i=0;$i<sizeof($data['list_kode_roll']);$i++){
			 $bahanSudahDigunakan = 0;
			 $checkExistingData = $this->Master_detail_emboss_model->findByRoll($data['list_kode_roll'][$i]->KODE_ROLL);
			 
			 if(sizeof($checkExistingData)>0){
				$bahanSudahDigunakan = 0;
				foreach ($checkExistingData as $row1) {
					$bahanSudahDigunakan = $bahanSudahDigunakan + $row1->BAIK_METER +$row1->RETUR_METER + $row1->REJECT_METER+ $row1->SELISIH_BAHAN;
					$data['list_kode_roll'][$i]->SELISIH_BAHAN = $selisihBahan;
				}
				
					
				if($bahanSudahDigunakan == $data['list_kode_roll'][$i]->METER_DATANG){
					$data['list_kode_roll'][$i]->METER_DATANG = 0;
				}else if($bahanSudahDigunakan < $data['list_kode_roll'][$i]->METER_DATANG){
					$data['list_kode_roll'][$i]->METER_DATANG = $data['list_kode_roll'][$i]->METER_DATANG - $bahanSudahDigunakan;
				}
			 }


			}
			if($data["status"]=="ADMEMBOSS"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_choose_kode_roll',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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

	function addProduksiEmboss($param){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$pecahParam = explode("@",$param);
			$data["totalBahan"] = $pecahParam[1];
			$data["idRoll"] =  $pecahParam[2];
			$data["kode_roll"] =  $pecahParam[0];
			$checkExistingData = $this->Master_detail_emboss_model->findByRoll($data["kode_roll"]);
			$selisihBahan = 0;
			foreach ($checkExistingData as $row1) {
				if($row1->SELISIH_BAHAN!=null && $row1->SELISIH_BAHAN>0){
					$selisihBahan = $row1->SELISIH_BAHAN;
					$data["totalBahan"] = $data["totalBahan"]-$selisihBahan;
					break;
				}
			}
			$data["selisihBahan"] = $selisihBahan;
			$this->session->set_flashdata('param', $param);
			$data["master_kk"] = $this->Master_kk_model->getDataKK();
			if($data["status"]=="ADMEMBOSS"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/add_laporan_produksi_emboss',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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

	function saveLaporanEmboss(){
		$noUrut = $this->Master_detail_emboss_model->getMaxNumber();
		$noUrut = $noUrut[0]->NO_URUT_EMBOSS;
		$kodeEmboss = $this->Master_detail_emboss_model->getKodeEmboss($noUrut);
		$kodeEmboss = $kodeEmboss[0]->KODE_EMBOSS;
		$kodeEmboss = explode("-", $kodeEmboss);
		$kodeEmboss = $kodeEmboss[1];
		$noUrut = $noUrut+1;
		$kodeEmboss = $kodeEmboss + 1;
		$nomorKK = $this->input->post('chooseKK');
		$temp = $this->session->flashdata('param');

		$hasilBaik = str_replace(".", "", $this->input->post('hasilBaik'));
		$hasilRusak = str_replace(".", "", $this->input->post('hasilRusak'));
		$reject = str_replace(".", "", $this->input->post('hasilReject'));
		$totalHitung = $hasilBaik + $hasilRusak + $reject;
		$bahanDariGudang= $this->input->post('totalBahan');

		if($totalHitung > $bahanDariGudang){
			$this->session->set_flashdata('error', 'Total Bahan Tidak Sesuai');
			redirect("AdminProduksiEmboss/addProduksiEmboss/".$temp);
		}else if($nomorKK == "0-0"){
			$this->session->set_flashdata('error', 'Nomor KK Tidak Boleh Kosong');
			redirect("AdminProduksiEmboss/addProduksiEmboss/".$temp);
		}else{
			$nomorKK = explode("@", $nomorKK);
			$data['NO_URUT_EMBOSS'] = $noUrut;
			$data['KODE_EMBOSS'] = "EMB-".$kodeEmboss;
			$data['NO_BON_EMBOSS'] = $this->input->post('nomorBon');
			$data['KODE_ROLL'] = $this->input->post('kodeRoll');
			$data['TGL_BON_EMBOSS'] = $this->input->post('tanggalProses');
			$data['SHIFT_EMBOSS'] = $this->input->post('shift');
			$data['BAIK_METER'] = $hasilBaik;
			$data['REJECT_METER'] = $reject;
			$data['RETUR_METER'] = $hasilRusak;
			$data['NOMOR_KK'] = $nomorKK[0];
			$data['TOTAL_BAHAN'] = $bahanDariGudang;
			$data['SISA_BAIK'] = $bahanDariGudang - $totalHitung;
			$data['MESIN_EMBOSS'] = $this->input->post('mesinEmboss');
			$data['STATUS_MUTASI'] = "BELUM MUTASI";
			$data['SELISIH_BAHAN'] = $this->input->post('selisihBahan');
			$data['ID_ROLL'] = $this->session->flashdata('idRoll');
			$data['TGL_PRODUKSI'] = $this->input->post('tanggalMutasi');
			$data['KODE_BAHAN_BARU'] = $nomorKK[2];

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

			if($this->Master_detail_emboss_model->saveLaporanEmboss($data)){
				$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
				$pecahParam = explode("@",$temp);
				$sisaBahan = $bahanDariGudang - $totalHitung;
				$pecahParam = $pecahParam[0]."@".$sisaBahan."@".$pecahParam[2];
				if($sisaBahan == 0){
					redirect("AdminProduksiEmboss/addLaporanProduksiEmboss/");
				}else{
					redirect("AdminProduksiEmboss/addProduksiEmboss/".$pecahParam);
				}

			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiEmboss/addProduksiEmboss/".$this->session->flashdata('param'));
			}
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
			$data["listEmboss"] = $this->Master_detail_emboss_model->getAlldata();
			if($data["status"]=="ADMEMBOSS"){
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_list_data', $data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
			$data["listEmboss"] = $this->Master_detail_emboss_model->getDataBeforeMutation();
			if($data["status"]=="ADMEMBOSS"){
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_mutasi', $data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
			$data["listRoll"] = $this->Master_detail_emboss_model->dataMutasi();
			if($data["status"]=="ADMEMBOSS"){
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_data_mutasi', $data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
		$kodeRoll = $this->input->post('kodeRoll');
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$data["listEmboss"] = $this->Master_detail_emboss_model->findByRollBeforeMutation($kodeRoll);
			if($data["status"]=="ADMEMBOSS"){
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_mutasi', $data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
			$input = array();

			//Menampilkan data laporan emboss yang siap di mutasi ke demet
			$dataMutasi = $this->Master_detail_emboss_model->getDataBeforeMutation();

			//Mengambil no urut yang dipilih oleh pengguna
			// foreach ($dataMutasi as $row) {
			// 	$x = $this->input->post($row->NO_URUT_EMBOSS);
			// 	// $input[] = $x."@".$row->KODE_ROLL_ASAL;
			// 	if($x != ""){
			// 		$input[] = $x."@".$row->KODE_ROLL."@".$row->BAIK_METER."@".$row->KODE_EMBOSS;
			// 	}
				
			// }
			$index = 0;
			foreach ($dataMutasi as $row) {
				$x = $this->input->post($row->NO_URUT_EMBOSS);
				if($x != ""){
					$input[$index][0] = $row->KODE_ROLL;
					$input[$index][1] = $row->BAIK_METER;
					$input[$index][2] = $row->KODE_EMBOSS;
					$input[$index][3] = $row->ID_ROLL;
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

			// for($i=0; $i<count($showInput); $i++) {
			// 	echo "Roll show : ".$showInput[$i][0];
			// 	echo "<br>";
			// 	echo "Panjang : ".$showInput[$i][1];
			// 	echo "<br>";
			// 	echo "<br>";
			// }
			// exit();
			$temp = array();
			$temp['dataInsert'] = $showInput;
			$temp['dataUpdate'] = $input;
			$this->session->set_flashdata('data', $temp);
			$data['nomorMutasi'] = $this->Master_mutasi_emboss->generateNewNumber();
			// if($countData == 1){
			// 	//if user only selects one data then
			// 	//Use kode_roll column in table tbl_detail_emboss as kode_roll_baru in tbl_mutasi_emboss
			// 	$getKodeRoll=explode("@",$input[0]);
			// 	foreach ($dataMutasi as $key) {
			// 		if($key->NO_URUT_EMBOSS == $getKodeRoll[0]){
			// 			$kodeRollBaru = $key->KODE_ROLL;
			// 			$data["kodeRollBaru"] = $kodeRollBaru;
			// 			$data["hasilBaik"] = $key->BAIK_METER;
			// 			$data["idRoll"] =  $key->ID_ROLL;
			// 		}
			// 	}
				
			// }else if($countData>1){
			// 	$data["hasilBaik"] = 0;
			// 	//if user selects more than one data then
			// 	//System checking whether the data selected by user has same kode_roll or not
			// 	$getKodeRoll=explode("@",$input[0]);
			// 	// $compareKodeRoll = explode("/",$getKodeRoll[1]);
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
			// 		//If validation true then
			// 		//Use kode_roll_asal in table tbl_detail_emboss as kode_roll_baru in tbl_mutasi_emboss
			// 		$data["kodeRollBaru"] = $compareKodeRoll;
					
			// 		//System add BAIK_METER
					
			// 		for($i=0; $i<count($dataMutasi); $i++){
			// 			$data["idRoll"] =  $dataMutasi[$i]->ID_ROLL;
			// 		}
					
			// 	}else{
			// 		//If validation false then
			// 		//User redirected to v_mutasi.php
			// 	   $this->session->set_flashdata('warning', 'Kode Roll Berbeda');
			// 	   echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/AdminProduksiEmboss/mutasiBarang'>";
			// 	}
			// }
			$data['dataInput'] = $showInput;
			if($data["status"]=="ADMEMBOSS"){
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_save_mutasi', $data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
		// if($this->Master_mutasi_emboss->checkNumber($this->input->post('noMutasi'))){
			$dataMutasi = array();
			$temp = $this->session->flashdata('data');
			$mutasi = $temp['dataInsert'];
			$update = $temp['dataUpdate'];

			// $mutasi = $this->input->post('dataInput');
			// for($i=0; $i<count($mutasi); $i++) {
			// 	echo "Roll show : ".$mutasi[$i][0];
			// 	echo "<br>";
			// 	echo "Panjang : ".$mutasi[$i][1];
			// 	echo "<br>";
			// 	echo "<br>";
			// }
			// exit();
			for($i=0;$i<count($mutasi);$i++){
				$data = array(
				'NO_MUTASI' => $this->input->post('noMutasi'),
				'TGL_MUTASI' => $this->input->post('tanggalMutasi'),
				'KODE_ROLL' => $mutasi[$i][0],
				'KODE_EMBOSS' => $mutasi[$i][2],
				'TOTAL_BAHAN' => $mutasi[$i][1],
				'ID_ROLL' => $mutasi[$i][3],
				'STATUS_DEMET' => 'progress'
				);
				$dataMutasi[$i] = $data;
			}
			// $data = array(
			// 'NO_MUTASI' => $this->input->post('noMutasi'),
			// 'TGL_MUTASI' => $this->input->post('tanggalMutasi'),
			// 'KODE_ROLL' => $this->input->post('kodeRollBaru'),
			// 'TOTAL_BAHAN' => $this->input->post('hasilBaik'),
			// 'ID_ROLL' => $this->input->post('idRoll'),
			// 'STATUS_DEMET' => 'progress'
			// );
			// $kodeEmboss = $this->session->flashdata('kodeEmboss');

			if($this->Master_mutasi_emboss->saveMutasi($dataMutasi,$update)){
				$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
				redirect("AdminProduksiEmboss/mutasiBarang/");
			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiEmboss/mutasiBarang/");
			}	

		// }else{
		// 	$this->session->set_flashdata('error', 'Nomor mutasi sudah digunakan');
		// 	redirect("AdminProduksiEmboss/mutasiBarang/");
		// }
		
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
			if($data["status"]=="ADMEMBOSS"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_report',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
        		redirect("AdminProduksiEmboss/reportPage/");
        	}else if($startDate == null && $endDate != null){
        		redirect("AdminProduksiEmboss/reportPage/");
        	}else if($startDate == null && $endDate == null && $nomorKK=="0-0"){
        		redirect("AdminProduksiEmboss/reportPage/");
        	}
        	
        	$nomorKK = $this->input->post('chooseKK');
			$nomorKK = explode("@", $nomorKK);
			$nomorKK = $nomorKK[0];

        	if($nomorKK!="0-0" && $startDate == null && $endDate == null){
        		$data = $this->Master_detail_emboss_model->findByKK($nomorKK);
        	}else if($nomorKK!="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_emboss_model->findByDateRangeAndKK($startDate,$endDate,$nomorKK);
        	}else if($nomorKK=="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_emboss_model->findByDateRange($startDate,$endDate);
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
				$objSheet->setTitle('Monitoring Hasil - Emboss');
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
				$objSheet->getCell('D5')->setValue('EMBOSS');

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
				$columnTitle[5] = "MSN EMBOSS";
				$columnTitle[6] = "SHIFT";
				$columnTitle[7] = "KODE ROLL";
				$columnTitle[8] = "TOTAL BAHAN";
				$columnTitle[9] = "BAIK EMBOSS";
				$columnTitle[10] = "RUSAK EMBOSS";
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
					$array[1] = "1";
					$stamp = strtotime($row->TGL_PRODUKSI);
					$array[2] = date("m",$stamp);
					$array[3] = $row->TGL_PRODUKSI;
					$array[4] = $row->NOMOR_KK;
					$array[5] = $row->MESIN_EMBOSS;
					$array[6] = $row->SHIFT_EMBOSS;
					$array[7] = $row->KODE_ROLL;
					$array[8] = $row->TOTAL_BAHAN;
					$array[9] = $row->BAIK_METER;
					$array[10] = $row->RETUR_METER;
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
		        $filename = "LAPORAN EMBOSS";
		        // We'll be outputting an excel file
				header('Content-type: application/vnd.ms-excel');

				// It will be called file.xls
				header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');

				// Write file to the browser
				$objWriter->save('php://output');
		        // $objWriter->save("D://Test/".$filename.".xlsx");
			}else{
		    	$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
				redirect("AdminProduksiEmboss/reportPage/");
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
			if($data["status"]=="ADMEMBOSS"){
				$this->session->set_flashdata('paramEdit', $param);
				$data["laporanEmboss"] = $this->Master_detail_emboss_model->findById($param);
				if($data["laporanEmboss"]->TGL_PRODUKSI != null){
					$data["laporanEmboss"]->TGL_PRODUKSI = $this->tanggal_indo($data["laporanEmboss"]->TGL_PRODUKSI );
				}

				if($data["laporanEmboss"]->TGL_BON_EMBOSS != null){
					$data["laporanEmboss"]->TGL_BON_EMBOSS = $this->tanggal_indo($data["laporanEmboss"]->TGL_BON_EMBOSS );
				}

				$data["master_kk"] = $this->Master_kk_model->getDataKK();
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_PERSIAPAN)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_PERSIAPAN))){
					$data["laporanEmboss"]->START_JAM_PERSIAPAN = "0";
					$data["laporanEmboss"]->FINISH_JAM_PERSIAPAN = "0";
				}

				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_PRODUKSI)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_PRODUKSI))){
					$data["laporanEmboss"]->START_JAM_PRODUKSI = "0";
					$data["laporanEmboss"]->FINISH_JAM_PRODUKSI = "0";
				}

				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_TROUBLE_MESIN)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_TROUBLE_MESIN))){
					$data["laporanEmboss"]->START_JAM_TROUBLE_MESIN = "0";
					$data["laporanEmboss"]->FINISH_JAM_TROUBLE_MESIN = "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_TUNGGU_BAHAN)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_TUNGGU_BAHAN))){
					$data["laporanEmboss"]->START_JAM_TUNGGU_BAHAN= "0";
					$data["laporanEmboss"]->FINISH_JAM_TUNGGU_BAHAN= "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_TUNGGU_CORE)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_TUNGGU_CORE))){
					$data["laporanEmboss"]->START_JAM_TUNGGU_CORE = "0";
					$data["laporanEmboss"]->FINISH_JAM_TUNGGU_CORE = "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_FORCE_MAJOR)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_FORCE_MAJOR))){
					$data["laporanEmboss"]->START_JAM_FORCE_MAJOR = "0";
					$data["laporanEmboss"]->FINISH_JAM_FORCE_MAJOR = "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_GANTI_SILINDER_SERI)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_GANTI_SILINDER_SERI))){
					$data["laporanEmboss"]->START_JAM_GANTI_SILINDER_SERI = "0";
					$data["laporanEmboss"]->FINISH_JAM_GANTI_SILINDER_SERI = "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_LAIN_LAIN)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_LAIN_LAIN))){
					$data["laporanEmboss"]->START_JAM_LAIN_LAIN = "0";
					$data["laporanEmboss"]->FINISH_JAM_LAIN_LAIN = "0";
				}
				if(date("H:i",strtotime($data["laporanEmboss"] ->START_JAM_TROUBLE_PRODUKSI)) == date("H:i",strtotime($data["laporanEmboss"] ->FINISH_JAM_TROUBLE_PRODUKSI))){
					$data["laporanEmboss"]->START_JAM_TROUBLE_PRODUKSI = "0";
					$data["laporanEmboss"]->FINISH_JAM_TROUBLE_PRODUKSI = "0";
				}
				$this->load->view('AdminProduksiEmboss/v_header',$data);
				$this->load->view('AdminProduksiEmboss/v_sidebar',$data);
				$this->load->view('AdminProduksiEmboss/v_edit_laporan',$data);
				$this->load->view('AdminProduksiEmboss/v_footer',$data);
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
	$kodeRoll 		= $this->input->post('kodeRoll');
	$mesin 			= $this->input->post('mesinEmboss');
	$shift 			= $this->input->post('shift');
	$nomorKK 		= $this->input->post('nomorKK');
	$tglProduksi 	= $this->input->post('tanggalProduksiEdit');
	$baikMeter 		= str_replace(".", "",$this->input->post('hasilBaik'));
	$wasteMeter 	= str_replace(".", "",$this->input->post('hasilRusak'));
	$rejectMeter 	= str_replace(".", "",$this->input->post('hasilReject'));
	$selisihBahan 	= str_replace(".", "",$this->input->post('selisihBahan'));
	$noUrut			= $this->input->post('idData');
	$totalBahan 	= str_replace(".", "",$this->input->post('totalBahan'));
	$noBon 			= $this->input->post('nomorBon');
	$tanggalBon 	= $this->input->post('tanggalBon');
	//======= End Get Input Post ========//
	
	//======== Count Total Used Foil On Same Roll =====//
	$checkExistingData = $this->Master_detail_emboss_model->findByRoll($kodeRoll);
	$usedFoil = 0;
	if(sizeof($checkExistingData)>0){
		foreach ($checkExistingData as $row) {
			if($row->NO_URUT_EMBOSS != $noUrut){
			$usedFoil = $usedFoil + $row->BAIK_METER +$row->RETUR_METER + $row->REJECT_METER;
			}
		}
	}
	//======= End Count Total Used Foil On Same Roll =====//
	//get length from warehouse
	$lengthFromWarehouse = 0;
	$dataFromWarehouse = $this->Master_terima_foil_model->findByKodeRoll($kodeRoll);
	$lengthFromWarehouse = $dataFromWarehouse->METER_DATANG;
	//define length parameter
	$deviationObject = 0;
	$lengthParameter = 0;
	if($selisihBahan != 0){
		$deviationObject = $selisihBahan;
	}else{
	if(sizeof($checkExistingData)>0){
		foreach ($checkExistingData as $row) {
			if($row->SELISIH_BAHAN != 0){
				$deviationObject = $row->SELISIH_BAHAN;
				break;
			}
		}
	}
	}

	if($deviationObject!=0){
		if($deviationObject<0){
			$lengthParameter = $lengthFromWarehouse + $deviationObject;
		}else if ($deviationObject>0){
			$lengthParameter = $lengthFromWarehouse + $deviationObject;
		}
	}else{
		$lengthParameter = $lengthFromWarehouse;
	}

	//====== check if total data no more than its parameter ====//
	$newTotalLength = $baikMeter+$wasteMeter+$rejectMeter+$usedFoil;
	if($lengthParameter<$newTotalLength){
		$this->session->set_flashdata('error',' Total Bahan Tidak Sesuai '.$newTotalLength);
		$temp = $this->session->flashdata('paramEdit');
		redirect("AdminProduksiEmboss/editLaporan/".$temp);
	}

	//====== Get Production Variable Time =========//
	$nomorKK = explode("@", $nomorKK);
	$data['NO_BON_EMBOSS']  = $noBon;
	$data['KODE_ROLL'] 		= $kodeRoll;
	$data['TGL_BON_EMBOSS'] = $tanggalBon;
	$data['SHIFT_EMBOSS'] 	= $shift;
	$data['BAIK_METER'] 	= $baikMeter;
	$data['REJECT_METER'] 	= $rejectMeter;
	$data['RETUR_METER'] 	= $wasteMeter;
	$data['NOMOR_KK'] 		= $nomorKK[0];
	$data['TOTAL_BAHAN'] 	= $totalBahan;
	// $data['SISA_BAIK'] = $bahanDariGudang - $totalHitung;
	$data['MESIN_EMBOSS'] 	= $mesin;
	// $data['STATUS_MUTASI'] = "BELUM MUTASI";
	$data['SELISIH_BAHAN'] 	= $selisihBahan;
	// $data['ID_ROLL'] = $this->session->flashdata('idRoll');
	$data['TGL_PRODUKSI'] 	= $tglProduksi;
	$data['KODE_BAHAN_BARU'] = $nomorKK[2];
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
	if($this->Master_detail_emboss_model->updateData($noUrut, $data)){
		redirect("AdminProduksiEmboss/listData/");
	}else{
		$this->session->set_flashdata('error',' Total Bahan Tidak Sesuai '.$newTotalLength);
		$temp = $this->session->flashdata('paramEdit');
		redirect("AdminProduksiEmboss/editLaporan/".$temp);
	}
}



}
