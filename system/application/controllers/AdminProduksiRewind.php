<?php
class AdminProduksiRewind extends Controller {
	function AdminProduksiRewind()
	{
		parent::Controller();
		session_start();
		ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
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
		$this->load->model('Master_mutasi_demet');
		$this->load->model('Master_mutasi_rewind');
		
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
			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_home',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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

	function chooseDesain(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_choose_desain',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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
	function chooseRoll(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$tahun = $this->input->post('tahun');
			$data["masterBahan"] = $this->Master_bahan_model->getBahanFoilByDesain($tahun);
			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_choose_roll',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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
	function pilihBahanDariDemet(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			
			$data["dataBahan"] = $this->Master_detail_rewind_model->chooseKodeRoll();

			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_choose_data',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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

	function formLaporanRewind($param){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$this->session->set_flashdata('paramForm', $param);
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$separateParam = explode("@",$param);
			$data["kodeRoll"] = str_replace("_", "/",$separateParam[0]);
			$data["noMutasi"] = $separateParam[1];
			$data["totalBahan"] = $separateParam[2];
			$bahanSudahDigunakan = 0;
			$checkExistingData = $this->Master_detail_rewind_model->findByRoll($data["kodeRoll"],$data["noMutasi"] );
			if(sizeof($checkExistingData)>0){
				$bahanSudahDigunakan = 0;
				foreach ($checkExistingData as $row) {
					$bahanSudahDigunakan = $bahanSudahDigunakan + $row->BAIK_METER + $row->WASTE_METER + $row->REJECT_METER;
				}
				$data["totalBahan"] = $data["totalBahan"]- $bahanSudahDigunakan;
			}else{
				$data["totalBahan"] = $separateParam[2];
			}
			$temp = array();

			$temp["mutasiDemet"] = $data["noMutasi"];
			$temp["bahanSebelum"] = $data["totalBahan"];
			$temp["bahanSudahDigunakan"] = $bahanSudahDigunakan;
			$temp["totalBahanDariDemet"] = $separateParam[2];

			$this->session->set_flashdata('data', $temp);

			$data["master_kk"] = $this->Master_kk_model->getDataKK();
			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_form_laporan_rewind',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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

	function saveLaporanRewind(){
		$noUrut = $this->Master_detail_rewind_model->getMaxNumber();
		$lastData = $this->Master_detail_rewind_model->getLastCode();
		$hasilBaik = str_replace(".", "", $this->input->post('hasilBaik'));
		$hasilRusak = str_replace(".", "", $this->input->post('hasilRusak'));
		$reject = str_replace(".", "", $this->input->post('hasilReject'));
		$totalHitung = $hasilBaik + $hasilRusak + $reject;
		$bahanDariDemet = $this->input->post('totalBahan');
		$nomorKK = $this->input->post('chooseKK');
		
		$paramForm= $this->session->flashdata('paramForm');
		$temp = $this->session->flashdata('data');

		if($totalHitung > $bahanDariDemet){
			$this->session->set_flashdata('error', 'Total Bahan Tidak Sesuai');
			redirect("AdminProduksiRewind/formLaporanRewind/".$paramForm);
		}else if($nomorKK == "0-0"){
			$this->session->set_flashdata('error', 'Nomor KK Tidak Boleh Kosong');
			redirect("AdminProduksiRewind/formLaporanRewind/".$paramForm);
		}else{

			$noUrut = $noUrut + 1;
			$kodeRewind = explode("-", $lastData[0]->KODE_REWIND);
			$kodeRewind = $kodeRewind[1];
			$kodeRewind = $kodeRewind + 1;

			$nomorKK = explode("@", $nomorKK);

			$data['NO_URUT_REWIND'] = $noUrut;
			$data['KODE_REWIND'] = "RWD-".$kodeRewind;

			$data['KODE_ROLL'] = $this->input->post('kodeRoll');
			$data['SHIFT_REWIND'] = $this->input->post('shift');
			$data['BAIK_METER'] = $hasilBaik;
			$data['REJECT_METER'] = $reject;
			$data['WASTE_METER'] = $hasilRusak;
			$data['NO_MUTASI_DEMET'] = $temp['mutasiDemet'];
			$data['STATUS_MUTASI'] = 'BELUM DIMUTASI';
			$data['TOTAL_BAHAN'] = $bahanDariDemet;
			$data['SISA_BAIK'] = $bahanDariDemet - $totalHitung;
			$data['MESIN_REWIND'] = $this->input->post('mesinRewind');

			$data['NOMOR_KK'] = $nomorKK[0];
			$data['TGL_PRODUKSI'] = $this->input->post('tanggalProduksi');
			$data['KODE_BAHAN'] = $nomorKK[2];
			$data['START_JAM_PRODUKSI'] = $this->input->post('startTimeProduksi');
			$data['FINISH_JAM_PRODUKSI'] = $this->input->post('endTimeProduksi');
			$data['NO_MUTASI_REWIND'] = '0';

		$data['START_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeProduksi')));
		$data['FINISH_JAM_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeProduksi')));

		$data['START_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimePersiapan')));
		$data['FINISH_JAM_PERSIAPAN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimePersiapan')));

		$data['START_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleProduksi')));
		$data['FINISH_JAM_TROUBLE_PRODUKSI'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleProduksi')));

		$data['START_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('startTimeTroubleMesin')));
		$data['FINISH_JAM_TROUBLE_MESIN'] = date('Y-m-d H:i',strtotime($this->input->post('endTimeTroubleMesin')));

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

			if($this->Master_detail_rewind_model->saveLaporanRewind($data)){
				$bahanSudahDigunakan = $temp['bahanSudahDigunakan'];
				$Sebelum = $temp['bahanSebelum'];
				$totalBahanDariDemet = $temp['totalBahanDariDemet'];

				if($bahanSudahDigunakan>0){
					$hitungTotalBahan = $bahanSudahDigunakan + $data['BAIK_METER'] + $data['REJECT_METER'] + $data['WASTE_METER'];
					if($hitungTotalBahan==$totalBahanDariDemet){
						$dataUpdate = array(
						'STATUS_REWIND' => "finish"
						);
					}else{
						$dataUpdate = array(
						'STATUS_REWIND' => "progress"
						);
					}
				}else{
					$hitungTotalBahan = $data['BAIK_METER'] + $data['REJECT_METER'] + $data['WASTE_METER'];
					if($hitungTotalBahan==$totalBahanDariDemet){
						$dataUpdate = array(
						'STATUS_REWIND' => "finish"
						);
					}else{
						$dataUpdate = array(
						'STATUS_REWIND' => "progress"
						);
					}
				}
				
				// $noUrutDemet =  $this->session->flashdata('noUrutDemet');
				if($this->Master_mutasi_demet->updateMutasi($temp['mutasiDemet'],$dataUpdate)){
					$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
					redirect("AdminProduksiRewind/pilihBahanDariDemet");
				}else{
					$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
					redirect("AdminProduksiRewind/pilihBahanDariDemet");
				}
			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiRewind/pilihBahanDariDemet");
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
			$data["listRewind"] = $this->Master_detail_rewind_model->getDataForMutation();

			if($data["status"]=="ADMREWIND"){
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_pilih_mutasi', $data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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
			$dataMutasi = $this->Master_detail_rewind_model->getDataForMutation();

			//Mengambil no urut yang dipilih oleh pengguna
			foreach ($dataMutasi as $row) {
				$x = $this->input->post($row->NO_URUT_REWIND);
				// $input[] = $x."@".$row->KODE_ROLL_ASAL;
				if($x != ""){
					$input[] = $x."@".$row->KODE_ROLL."@".$row->BAIK_METER."@".$row->KODE_REWIND;
					$data["nomorKK"] =  $row->NOMOR_KK;

				}
			}
			//Checking how many data user chooses
			$countData = count($input);
			$this->session->set_flashdata('kodeRewind', $input);

			if($countData == 1){

				//if user only selects one data then
				//Use kode_roll column in table tbl_detail_emboss as kode_roll_baru in tbl_mutasi_emboss
				$getKodeRoll=explode("@",$input[0]);
				foreach ($dataMutasi as $key) {
					if($key->NO_URUT_REWIND == $getKodeRoll[0]){
						$kodeRollBaru = $key->KODE_ROLL;
						$data["kodeRoll"] = $kodeRollBaru;
						$data["hasilBaik"] = $key->BAIK_METER;
						// $data["idRoll"] =  $key->ID_ROLL;
					}
				}
				
			}else if($countData>1){
				$data["hasilBaik"] = 0;

				//if user selects more than one data then
				//System checking whether the data selected by user has same kode_roll or not
				$getKodeRoll=explode("@",$input[0]);
				$compareKodeRoll = $getKodeRoll[1] ;
				$validation = false;
				foreach ($input as $row) {
					$getKodeRoll=explode("@",$row);
					if($compareKodeRoll != $getKodeRoll[1] ){
						$validation = false;
						break;
					}else{
						$data["hasilBaik"] = $data["hasilBaik"] + $getKodeRoll[2];

						$validation = true;
					}
									}
				if($validation){
					$data["kodeRoll"] = $compareKodeRoll;					
					// for($i=0; $i<count($dataMutasi); $i++){
						// $data["idRoll"] =  $dataMutasi[$i]->ID_ROLL;
					// }
					
				}else{
					//If validation false then
					//User redirected to v_mutasi.php
				   $this->session->set_flashdata('warning', 'Kode Roll Berbeda');
				   echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/AdminProduksiDemet/mutasiBarang'>";
				}
			}
			if($data["status"]=="ADMREWIND"){
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_mutasi', $data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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

		if($this->Master_mutasi_rewind->checkNumber($this->input->post('noMutasi'))){
			$data = array(
				'NO_MUTASI' => $this->input->post('noMutasi'),
				'TGL_MUTASI' => $this->input->post('tanggalMutasi'),
				'TOTAL_BAHAN' => $this->input->post('totalBahan'),
				'KODE_ROLL' => $this->input->post('kodeRoll'),
				'STATUS_SENSI' => "progress"
			);

			$kkAndRoll = $this->session->flashdata('kodeRewind');
			if($this->Master_mutasi_rewind->saveMutasi($data, $kkAndRoll)){
				$this->session->set_flashdata('success', 'Proses Berhasil Disimpan');
				redirect("AdminProduksiRewind/mutasiBarang/");
			}else{
				$this->session->set_flashdata('error', 'Proses Gagal Disimpan');
				redirect("AdminProduksiRewind/mutasiBarang/");
			}
		}else{
			$this->session->set_flashdata('error', 'Number Already Exist !');
			redirect("AdminProduksiRewind/mutasiBarang/");
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
			$data["listRewind"] = $this->Master_detail_rewind_model->getAlldata();
			if($data["status"]=="ADMREWIND"){
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_list_data', $data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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
			if($data["status"]=="ADMREWIND"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('AdminProduksiRewind/v_header',$data);
				$this->load->view('AdminProduksiRewind/v_sidebar',$data);
				$this->load->view('AdminProduksiRewind/v_report',$data);
				$this->load->view('AdminProduksiRewind/v_footer',$data);
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
        		redirect("AdminProduksiRewind/reportPage/");
        	}else if($startDate == null && $endDate != null){
        		redirect("AdminProduksiRewind/reportPage/");
        	}else if($startDate == null && $endDate == null && $nomorKK=="0-0"){
        		redirect("AdminProduksiRewind/reportPage/");
        	}
        	
        	$nomorKK = $this->input->post('chooseKK');
			$nomorKK = explode("@", $nomorKK);
			$nomorKK = $nomorKK[0];

        	if($nomorKK!="0-0" && $startDate == null && $endDate == null){
        		$data = $this->Master_detail_rewind_model->findByKK($nomorKK);
        	}else if($nomorKK!="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_rewind_model->findByDateRangeAndKK($startDate,$endDate,$nomorKK);
        	}else if($nomorKK=="0-0" && $startDate != null && $endDate != null){
        		$data = $this->Master_detail_rewind_model->findByDateRange($startDate,$endDate);
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
				$objSheet->setTitle('Monitoring Hasil - Rewind');
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
				$columnTitle[5] = "MSN DEMET";
				$columnTitle[6] = "SHIFT";
				$columnTitle[7] = "KODE ROLL";
				$columnTitle[8] = "TOTAL BAHAN";
				$columnTitle[9] = "BAIK REWIND";
				$columnTitle[10] = "RUSAK REWIND";
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
					$array[1] = "III";
					$stamp = strtotime($row->TGL_PRODUKSI);
					$array[2] = date("m",$stamp);
					$array[3] = $row->TGL_PRODUKSI;
					$array[4] = $row->NOMOR_KK;
					$array[5] = $row->MESIN_REWIND;
					$array[6] = $row->SHIFT_REWIND;
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
		        $filename = "TEST LAPORAN REWIND";
		        // We'll be outputting an excel file
				header('Content-type: application/vnd.ms-excel');

				// It will be called file.xls
				header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');

				// Write file to the browser
				$objWriter->save('php://output');
		        // $objWriter->save("D://Test/".$filename.".xlsx");

		    }else{
		    	$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
				redirect("AdminProduksiRewind/reportPage/");
	        }

        }

}