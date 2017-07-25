<?php

class Ppc extends Controller {

	function Ppc()
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
			if($data["status"]=="PPC"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_home',$data);
				$this->load->view('ppc/v_footer',$data);
			}
			else{
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
	function showDataMesin(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			if($data["status"]=="PPC"){
				$data['result'] = $this->Master_mesin_model->getAllData();
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_master_mesin_home',$data);
				$this->load->view('ppc/v_footer',$data);
			}
			else{
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

	function showDataFormula(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];

			if($data["status"]=="PPC"){
				$data['result'] = $this->Master_formula_model->getAllData();
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_master_formula_home',$data);
				$this->load->view('ppc/v_footer',$data);
			}
			else{
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

	function createHeaderKK(){

		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$sessionHeader = isset($_SESSION['data_header']);
		$dataBapob = $this->Master_bapob_model->getDefaultBapob();		
		if($dataBapob !=NULL){
			if($session!=""){
				if($sessionHeader != ""){
					$data["header"] = $_SESSION['data_header'];
				}else{
					$data["header"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["bapob"] = $dataBapob[0];
				$_SESSION['data_bapob']=$dataBapob[0];
				$data["masterBahan"] = $this->Master_bahan_model->getAllData();
				$getLastNumber = $this->Master_kk_model->getLastNumber(date("Y"));
				$bulan = $this->convertToRomawi(date("m"));
				if(sizeof($getLastNumber) >0){
					$lastNumber = substr(($getLastNumber[0]->NOMOR_KK),0,3);
					$currentNumber = intval($lastNumber)+1;
					if($currentNumber <10){
						$nomorBaru = "00".$currentNumber;
					}else if($currentNumber >9 && $currentNumber <100){
						$nomorBaru = "0".$currentNumber;
					}
					$nomorBaru = $nomorBaru."/PNP-HLG/PPC/KKM/".$bulan."/".date("Y");
					// $nomorBaru = "013/PNP-HLG/PPC/KKM/III/2017";
				}else{
					$nomorBaru = "001/PNP-HLG/PPC/KKM/".$bulan."/".date("Y");
					// $nomorBaru = "001/PNP-HLG/PPC/KKM/XII/2016";
				}
				
				$data["nomorKkBaru"] = $nomorBaru;
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_master_kk_add',$data);
					$this->load->view('ppc/v_footer',$data);
				}
				else{
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
	}

	function saveHeaderKK(){
		$x = $this->input->post('chooseBahan');
		$bahanBaku = explode("@", $x);

		if($bahanBaku[4] === ""){
			$bahanBaku[4] = 0; 
		}
		if($bahanBaku[3] === ""){
			$bahanBaku[3] = 0;
		}
		if($bahanBaku[2] === ""){
			$bahanBaku[2] = 0;
		}
		$tahun = $this->input->post('tahun');
		$seri = $this->input->post('seri');

		$data['NAMA_BAHAN_BAKU'] = $bahanBaku[1];
		$data['KODE_BAHAN'] = $bahanBaku[0];
		$data['LEBAR_BAHAN_BAKU'] = $bahanBaku[2];
		$data['GSM_BAHAN_BAKU'] = $bahanBaku[3];
		$data['PANJANG_BAHAN_BAKU'] = $bahanBaku[4];

		$data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['TGL_PROSES_MESIN'] = $this->input->post('tanggalProses');
		$jumlahPesanan = $this->input->post('jumlahPesanan');
		if (stristr($jumlahPesanan, ',') !== FALSE) {
		  $x = str_replace(",", ".", $jumlahPesanan);
		  $data['JML_PESANAN'] = $x;
		}else{
		  $data['JML_PESANAN'] = $this->input->post('jumlahPesanan');
		}
		$data['MACAM'] = $this->input->post('macam');
		$data['tahun'] = $tahun;
		$data['tahunKKdibuat'] = date("Y");
		$data['delivery_time'] = date("M")."-".date("Y");
		$data['seri'] = $seri;
		$data['panjangWastePerekatan'] = $this->replaceCommas($this->input->post('jumlahWastePerekatan'));
		$data['panjangWastePita'] = $this->replaceCommas($this->input->post('jumlahWastePita'));
		$data['panjangWasteBelah'] = $this->replaceCommas($this->input->post('jumlahWasteBelah'));
		$data['konversi_roll'] = $this->input->post('konversiRoll');
		$data['bahan_konversi'] = $this->replaceCommas($this->input->post('bahanKonversi'));
		$x = str_replace(",", ".", $this->input->post('percentWasteBelah'));
		$percentWasteBelahKonversi = str_replace("%", "", $x);
		$data['percent_belah_konversi'] = $percentWasteBelahKonversi;

		$jumlahPesanan = $this->replaceCommas($this->input->post('jumlahPesanan'));
		$wasteProses = $_SESSION['data_bapob']->WASTE_BELAH;
		$wasteDalamPersen = $wasteProses/100;
		$data['PANJANG_BAHAN'] = $this->replaceCommas($this->input->post('panjangBahan'));
		$data['JML_PESANAN_KONVERSI'] = $this->replaceCommas($this->input->post('jumlahPesananKonversi'));

		$_SESSION['data_header']=$data;
		$this->session->set_flashdata('success', 'Data KK Berhasil disimpan di session');
		$x = str_replace("/", "-", $this->input->post('noKK'));
		$fileLocation = '//192.168.17.102/Test/'.$x.'.xlsx';
		if (file_exists($fileLocation)) {
			$data['NO_KK'] = null;
			$_SESSION['data_header']=$data;
			$this->session->set_flashdata('warning', 'Nomor KK Sudah Di Cetak');
			redirect("ppc/createHeaderKK");
		} else {
			if($this->Master_kk_model->checkNumber($data['NO_KK'] )){
				$data['NO_KK'] = null;
				$_SESSION['data_header']=$data;
				$this->session->set_flashdata('warning', 'Nomor KK Sudah Di Cetak');
				redirect("ppc/createHeaderKK");
			}else{
				$data['NO_KK'] = $this->input->post('noKK');
				$_SESSION['data_header']=$data;
				$this->session->set_flashdata('success', 'Data KK Berhasil disimpan di session');
				redirect("ppc/addProsesEmboss");
			}
		}
	}

	function saveEmbossOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin  = explode("-", $input);
		$data['ID_MESIN'] = $mesin[0];
		$data['NAMA_PROSES'] = 'Proses Emboss';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_PCH'] = $this->input->post('stelPCH');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $_SESSION['prosesEmbossOnBapob']->WASTE_PROSES;
		$data['FORMULA'] = $this->input->post('formula');
		$data['HASIL'] = $this->input->post('hasil');
		$data['delivery_time'] = $this->input->post('deliveryDate');
		// $data['delivery_time_ind'] = $this->input->post('delTimeInd');
		$_SESSION['proses_emboss']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/addProsesDemet");
	}

	function addProsesEmboss(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$sessionHeader =isset($_SESSION['data_header']);
			if($sessionHeader!="") {
				$emboss = isset($_SESSION['proses_emboss']);
				if($emboss != ""){
					$sessionHeader = $_SESSION['proses_emboss'];
					$data["emboss"] = $_SESSION['proses_emboss'];
				}else{
					$data["emboss"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["header"] = $_SESSION['data_header'];
				$data["bapob"] = $_SESSION['data_bapob'];
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Emboss');
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesEmbossOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				// $data["delivery_time"] = $_SESSION['delivery_emboss'];
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_emboss',$data);
					$this->load->view('ppc/v_footer',$data);
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
					alert("Mohon isi Data Kartu Kerja");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/createHeaderKK'>";
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

	function addProsesDemet(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$sessionEmboss=isset($_SESSION['proses_emboss']);
			if($sessionEmboss!="") {
				$emboss = isset($_SESSION['proses_demet']);
				if($emboss != ""){
					$data["demet"] = $_SESSION['proses_demet'];
				}else{
					$data["demet"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["header"] = $_SESSION['data_header'];
				$data["emboss"] = $_SESSION['proses_emboss'];
				$data["bapob"] = $_SESSION['data_bapob'];
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Demet');
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesDemetOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_demet',$data);
					$this->load->view('ppc/v_footer',$data);
				}
				else{
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
					alert("Mohon Isi Proses Emboss Dahulu");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesEmboss'>";
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

	function saveDemetOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin  = explode("-", $input);
		$data['ID_MESIN'] = $mesin[0];
		$data['NAMA_PROSES'] = 'Proses Demet';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $_SESSION['prosesDemetOnBapob']->WASTE_PROSES;
		$data['HASIL'] = $this->input->post('hasil');
		$data['delivery_time'] = $this->input->post('deliveryDate');
		// $data['delivery_time_ind'] = $this->input->post('delTimeInd');
		$_SESSION['proses_demet']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/addProsesRewind");
	}
	
	function addProsesRewind(){
		
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$sessionDemet=isset($_SESSION['proses_demet']);
			if($sessionDemet!="") {
				$rewind = isset($_SESSION['proses_rewind']);
				if($rewind != ""){
					$data["rewind"] = $_SESSION['proses_rewind'];
				}else{
					$data["rewind"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["header"] = $_SESSION['data_header'];
				$data["demet"] = $_SESSION['proses_demet'];
				$data["bapob"] = $_SESSION['data_bapob'];
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Rewind');
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesRewindOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_rewind',$data);
					$this->load->view('ppc/v_footer',$data);
				}
				else{
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
					alert("Mohon Isi Proses Demet");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesDemet'>";
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

	function saveRewindOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin  = explode("-", $input);
		$data['ID_MESIN'] = $mesin[0];
		$data['NAMA_PROSES'] = 'Proses Rewind';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $_SESSION['prosesRewindOnBapob']->WASTE_PROSES;
		$data['HASIL'] = $this->input->post('hasil');
		$data['delivery_time'] = $this->input->post('deliveryDate');
		// $data['delivery_time_ind'] = $this->input->post('delTimeInd');
		$_SESSION['proses_rewind']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/addProsesSensi");
	}
	function addProsesSensi(){
		
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$sessionRewind=isset($_SESSION['proses_rewind']);
			if($sessionRewind!="") {
				$sensi = isset($_SESSION['proses_sensi']);
				if($sensi!= ""){
					$data["sensi"] = $_SESSION['proses_sensi'];
				}else{
					$data["sensi"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["header"] = $_SESSION['data_header'];
				$data["rewind"] = $_SESSION['proses_rewind'];
				$data["bapob"] = $_SESSION['data_bapob'];
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Sensitizing');
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesSensiOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_sensitizing',$data);
					$this->load->view('ppc/v_footer',$data);
				}
				else{
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
					alert("Mohon Isi Proses Rewind");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesRewind'>";
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

	function saveSensiOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin  = explode("-", $input);
		$data['ID_MESIN'] = $mesin[0];
		$data['NAMA_PROSES'] = 'Proses Sensi';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $_SESSION['prosesSensiOnBapob']->WASTE_PROSES;
		$data['HASIL'] = $this->input->post('hasil');
		$data['STEL_SILINDER'] = $this->input->post('stelSilinder');
		$data['delivery_time'] = $this->input->post('deliveryDate');
		// $data['delivery_time_ind'] = $this->input->post('delTimeInd');
		$_SESSION['proses_sensi']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/addProsesBelah");
	}

	function addProsesBelah(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$sessionSensi=isset($_SESSION['proses_sensi']);
			if($sessionSensi!="") {
				$belah = isset($_SESSION['proses_belah']);
				if($belah!= ""){
					$data["belah"] = $_SESSION['proses_belah'];
				}else{
					$data["belah"] = "";
				}
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["header"] = $_SESSION['data_header'];
				$data["sensi"] = $_SESSION['proses_sensi'];
				$data["bapob"] = $_SESSION['data_bapob'];
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Belah');
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_belah',$data);
					$this->load->view('ppc/v_footer',$data);
				
				}
				else{
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
					alert("Mohon Isi Proses Sensi");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesSensi'>";
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

	function replaceCommas($char){
		$x = str_replace(",", "", $char);
		return $x;
	}
	function saveBelahOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin  = explode("-", $input);
		$data['ID_MESIN'] = $mesin[0];
		$data['NAMA_PROSES'] = 'Proses Belah dan Sortir';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$x = str_replace(",", ".", $this->input->post('wasteProses'));
		$percentWasteBelah= str_replace("%", "", $x);
		$data['WASTE_PROSES'] = floatval($percentWasteBelah);
		$data['HASIL'] = $this->input->post('hasil');
		$data['delivery_time'] = $this->input->post('deliveryDate');
		// $data['delivery_time_ind'] = $this->input->post('delTimeInd');
		$_SESSION['proses_belah']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/preview");

	}

	function preview(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
				
				$pecah=explode("|",$session);
				$data["nim"]=$pecah[0];
				$data["nama"]=$pecah[1];
				$data["status"]=$pecah[2];
				$data["bapob"] = $_SESSION['data_bapob'];
				$data["header"] = $_SESSION['data_header'];
				$data["sensi"] = $_SESSION['proses_sensi'];
				$data["emboss"] = $_SESSION['proses_emboss'];
				$data["demet"] = $_SESSION['proses_demet'];
				$data["rewind"] = $_SESSION['proses_rewind'];
				$data["sensi"] = $_SESSION['proses_sensi'];
				$data["belah"] = $_SESSION['proses_belah'];

				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_preview_kk',$data);
					$this->load->view('ppc/v_footer',$data);
				
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

	function saveAllData(){
		$header = $_SESSION['data_header'];
		$emboss = $_SESSION['proses_emboss'];
		$demet = $_SESSION['proses_demet'];
		$rewind = $_SESSION['proses_rewind'];
		$sensi = $_SESSION['proses_sensi'];
		$belah = $_SESSION['proses_belah'];
		$bapob = $_SESSION['data_bapob'];
		$emboss["STEL_SILINDER"] = 'test update';
		if($header["bahan_konversi"] != "-"){
			$emboss["PANJANG_BAHAN"] = $header["bahan_konversi"];
		}else{
			$emboss["PANJANG_BAHAN"] = $header["PANJANG_BAHAN"];
		}
		$emboss["ID_BAPOB"] = $bapob->ID_BAPOB;
		if($this->Master_kk_model->saveData($header)){
			if($this->Master_proses_model->saveData($emboss)){
				$demet["STEL_SILINDER"] = '0';
				$demet["STEL_PCH"] = '0';
				$demet["PANJANG_BAHAN"] = intval($emboss["HASIL"]);
				$demet["ID_BAPOB"] = $bapob->ID_BAPOB;
				if($this->Master_proses_model->saveData($demet)){
					$rewind["STEL_SILINDER"] = '0';
					$rewind["STEL_PCH"] = '0';
					$rewind["PANJANG_BAHAN"] = intval($demet["HASIL"]);
					$rewind["ID_BAPOB"] = $bapob->ID_BAPOB;
					if($this->Master_proses_model->saveData($rewind)){
						$sensi["STEL_PCH"] = '0';
						$sensi["PANJANG_BAHAN"] = intval($rewind["HASIL"]);
						$sensi["ID_BAPOB"] = $bapob->ID_BAPOB;
						if($this->Master_proses_model->saveData($sensi)){
							$belah["STEL_SILINDER"] = '0';
							$belah["STEL_PCH"] = '0';
							$belah["PANJANG_BAHAN"] = intval($sensi["HASIL"]);
							$belah["ID_BAPOB"] = $bapob->ID_BAPOB;
							if($this->Master_proses_model->saveData($belah)){
									$this->cetakKK();
									redirect("ppc/downloadPage");
							}
						}
					}
				}
			}
		}
	}

	function downloadPage(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
				$pecah=explode("|",$session);
				$data["nim"]	=$pecah[0];
				$data["nama"]	=$pecah[1];
				$data["status"]	=$pecah[2];
				$data["bapob"] 	= $_SESSION['data_bapob'];
				$data["header"] = $_SESSION['data_header']['NO_KK'];
				$_SESSION['data_header'] = null;
				$_SESSION['proses_emboss'] = null;
				$_SESSION['proses_sensi'] = null;
				$_SESSION['proses_demet'] = null;
				$_SESSION['proses_rewind'] = null;
				$_SESSION['proses_belah'] = null;
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_download_page',$data);
					$this->load->view('ppc/v_footer',$data);
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

	function cetakKK()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load

            $dataHeader = isset($_SESSION['data_header']);
            $prosesSensi = isset($_SESSION['proses_sensi']);
            $prosesBelah = isset($_SESSION['proses_belah']);
            $prosesEmboss = isset($_SESSION['proses_emboss']);
            $prosesDemet = isset($_SESSION['proses_demet']);
            $prosesRewind = isset($_SESSION['proses_rewind']);

            if($dataHeader==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Header di Session Kosong");
				</script>
				<?php
            }else if($prosesEmboss==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Emboss di Session Kosong");
				</script>
				<?php
            }else if($prosesDemet==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Demet di Session Kosong");
				</script>
				<?php
            }else if($prosesRewind==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Rewind di Session Kosong");
				</script>
				<?php
            }else if($prosesSensi==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Sensi di Session Kosong");
				</script>
				<?php
            }else if($prosesBelah==""){
            	?>
				<script type="text/javascript" language="javascript">
					alert("Data Belah di Session Kosong");
				</script>
				<?php
            }else{

            	$data 	= array();
            	$header = $_SESSION['data_header'];
				$emboss = $_SESSION['proses_emboss'];
				$demet 	= $_SESSION['proses_demet'];
				$rewind = $_SESSION['proses_rewind'];
				$sensi 	= $_SESSION['proses_sensi'];
				$belah 	= $_SESSION['proses_belah'];
				$bapob 	= $_SESSION['data_bapob'];

				$this->load->library("PHPExcel");

				
	            $objPHPExcel = new PHPExcel();
	 
	            $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');

				// set default font size
				$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

				require_once APPPATH.'libraries\dompdf\dompdf_config.inc.php';

				$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
				$rendererLibraryPath = APPPATH.'libraries\dompdf';
				if (!PHPExcel_Settings::setPdfRenderer(
					$rendererName,
					$rendererLibraryPath
					)) {
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
				$objSheet->setTitle('KK-Metalis-New');
				// let's bold and size the header font and write the header
				// as you can see, we can specify a range of cells, like here: cells from A1 to A4
				// write header
				$objSheet->getStyle('C3:K3')->getFont()->setBold(true)->setSize(14);
				$objSheet->getStyle('C3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('C3:K3');
				$objSheet->getCell('C3')->setValue('PT. PURA NUSAPERSADA UNIT HOLOGRAFI');

				$objSheet->getStyle('C4:K4')->getFont()->setBold(true)->setSize(14);
				$objSheet->getStyle('C4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('C4:K4');
				$objSheet->getCell('C4')->setValue('KARTU KERJA MESIN');

				$objSheet->getStyle('C5:K5')->getFont()->setBold(true)->setSize(14);
				$objSheet->getStyle('C5:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('C5:K5');
				$objSheet->getCell('C5')->setValue('NO : '.$header["NO_KK"]);

				// $objSheet->getCell('A5')->setValue('No. KK');
				$objSheet->getCell('A7')->setValue('No. BAPOB');
				$objSheet->getCell('A8')->setValue('Macam');
				$objSheet->getCell('A9')->setValue('Jml Pesanan (Konversi)');
				$objSheet->getCell('A12')->setValue('Hasil Belah (Konversi)');

				for($i=7; $i<13; $i++){
					$objSheet->getCell('B'.$i)->setValue(':');
				}

				// $objSheet->mergeCells('C6:E6');
				// $objSheet->getCell('C6')->setValue($header["NO_KK"]);

				$objSheet->mergeCells('C7:D7');
				$objSheet->getCell('C7')->setValue($bapob->NOMOR_BAPOB);

				$objSheet->mergeCells('C8:E8');
				$objSheet->getStyle('C8')->getFont()->setBold(true)->setSize(12);
				$objSheet->getCell('C8')->setValue($header["MACAM"]." Tahun ".$header["tahun"]." ".$header["seri"]);
				$objSheet->getStyle('C9')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('C9')->setValue($header["JML_PESANAN_KONVERSI"]);
				$objSheet->getCell('A10')->setValue("Waste Pita ");
				$objSheet->getCell('A11')->setValue("Waste Perekatan ");
				$objSheet->getCell('C10')->setValue($bapob->WASTE_PITA."%");
				$objSheet->getCell('C11')->setValue($bapob->WASTE_PEREKATAN."%");
				$objSheet->getStyle('C12')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('C12')->setValue($header["panjangWastePita"]);
				$objSheet->getCell('D9')->setValue("meter");
				$objSheet->getCell('D12')->setValue("meter");
				$objSheet->getCell('E12')->setValue("Uk. 66 Cm");

				$objSheet->mergeCells('H7:I7');
				$objSheet->getCell('H7')->setValue("Tgl Pros Msn ");

				$objSheet->mergeCells('H8:I8');
				$objSheet->getCell('H8')->setValue("Bahan ");

				$objSheet->mergeCells('H9:I9');
				$objSheet->getCell('H9')->setValue("Panjang Bhn");
				$objSheet->mergeCells('H10:I10');
				$objSheet->getCell('H10')->setValue("Konversi Roll");
				$objSheet->getCell('K10')->setValue($header["konversi_roll"]);
				$objSheet->getCell('L10')->setValue("Roll");
				$objSheet->mergeCells('H11:I11');
				$objSheet->getCell('H11')->setValue("Bahan (konversi)");
				$objSheet->getCell('L11')->setValue("Meter");
				$objSheet->getCell('K11')->setValue(number_format($header["bahan_konversi"]));
				$objSheet->mergeCells('H12:I12');
				$objSheet->getCell('H12')->setValue("Waste Belah");
				$objSheet->mergeCells('H12:I12');
				$objSheet->getCell('L12')->setValue($header["percent_belah_konversi"]."%");
							
				for($i=7; $i<13; $i++){
						$objSheet->getCell('J'.$i)->setValue(':');
				}
				$kolom = array();
				$kolom[0] = "A";
				$kolom[1] = "B";
				$kolom[2] = "C";
				$kolom[3] = "D";
				$kolom[4] = "E";
				$kolom[5] = "F";
				$kolom[6] = "G";
				$kolom[7] = "H";
				$kolom[8] = "I";
				$kolom[9] = "J";
				$kolom[10] = "K";
				$kolom[11] = "L";
				$kolom[12] = "M";
				$kolom[13] = "N";
				$kolom[14] = "O";
				$kolom[15] = "P";
				$kolom[16] = "Q";

				$objSheet->getCell('K7')->setValue($header["TGL_PROSES_MESIN"]);

				$objSheet->mergeCells('K8:N8');
				$objSheet->getCell('K8')->setValue($header["NAMA_BAHAN_BAKU"]);
				$objSheet->getStyle('K9')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('K9')->setValue($header["PANJANG_BAHAN"]);
				$objSheet->getCell('L9')->setValue("meter");
				$objSheet->getCell('M9')->setValue("UK");
				$objSheet->getCell('N9')->setValue("66 Cm");

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].'12')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				}

				$row = 13;
				$endLineOfSensi = 0;

				//Mulai proses pertama
					$this->cetakEmboss($objSheet, $emboss, $header, $row, $kolom);
				//ini proses selanjutnya
					$this->cetakDemet($objSheet, $demet, $emboss, $header, $row, $kolom);
				//Ini Proses Selanjutnya
					$this->cetakRewind($objSheet, $rewind, $header, $row, $kolom);
				//ini proses selanjutnya
					$this->cetakSensi($objSheet,$sensi,$rewind, $header, $row, $kolom, $endLineOfSensi);
				//proses belah dan sortir
					$this->cetakBelah($objSheet,$belah,$header,$row, $kolom, $endLineOfSensi);

				$row++;
				$objSheet->getStyle('A'.($row))->getFont()->setBold(true)->setSize(12);
				$objSheet->getCell('A'.($row))->setValue("Note");
				$objSheet->getCell('B'.($row))->setValue(':');
        		$objSheet->mergeCells('C'.$row.':K'.$row);
				$objSheet->getCell('C'.($row))->setValue('Pengerjaan setiap proses harus acc QC');

				$row++;
				$objSheet->getCell('B'.($row))->setValue(':');
				$objSheet->mergeCells('C'.$row.':K'.$row);
				$objSheet->getCell('C'.($row))->setValue('Arah baca harus jelas, teks BC RI Sensitizing harus searah dengan logo BCRI');

				$row++;
				$objSheet->getCell('B'.($row))->setValue(':');
				$objSheet->mergeCells('C'.$row.':K'.$row);
				$objSheet->getCell('C'.($row))->setValue('Penyimpanan dan pengambilan harus sesuai dengan ketentuan yang berlaku');

				// autosize the columns
				$objSheet->getColumnDimension('A')->setWidth(20);
				$objSheet->getColumnDimension('B')->setWidth(1);
				$objSheet->getColumnDimension('C')->setWidth(15);
				$objSheet->getColumnDimension('D')->setWidth(10);
				$objSheet->getColumnDimension('E')->setWidth(12);
				$objSheet->getColumnDimension('F')->setWidth(3);
				$objSheet->getColumnDimension('G')->setWidth(3);
				$objSheet->getColumnDimension('H')->setWidth(2);
				$objSheet->getColumnDimension('I')->setWidth(10);
				$objSheet->getColumnDimension('J')->setWidth(1);
				$objSheet->getColumnDimension('O')->setWidth(2);
				$objSheet->getColumnDimension('Q')->setWidth(3);
				$objSheet->getColumnDimension('M')->setWidth(3);
				$objSheet->getColumnDimension('N')->setWidth(7);
				$objSheet->getColumnDimension('I')->setAutoSize(true);
				$objSheet->getColumnDimension('K')->setWidth(15);
				$objSheet->getColumnDimension('P')->setWidth(12);

				// $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(300);

				$objWorksheet = $objPHPExcel->getActiveSheet()->setShowGridlines(false);
	            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
	            ob_end_clean();
	            $filename = str_replace("/","-",$header["NO_KK"]);
	            // $objWriter->save("//192.168.17.102/Test/".$filename.".xlsx");
	            // / $objWriter->save("..E://Test/".$filename.".xlsx");
	            $objWriter->save("D://Test/".$filename.".xlsx");
	            // $objWriter->save("V://Kartu Kerja Mesin/".$filename.".xlsx");
	            // $objWriter->save("..//..//..//..//saveHere/".$filename.".xlsx");
            }//end if - else
        }

        function cetakEmboss($objSheet, $emboss, $header, &$row, $kolom){

        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('A'.$row)->setValue('Proses (I)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('EMBOSS');

        	$row++;
        	$objSheet->getCell('A'.$row)->setValue('Bahan');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->mergeCells('C'.$row.':G'.$row);
        	$objSheet->getCell('C'.$row)->setValue('PETM 12 mic. Gudang Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.$row)->setValue('Target Prod');
        	$objSheet->getCell('J'.$row)->setValue(':');
        	$objSheet->mergeCells('K'.($row).':L'.($row));
        	$objSheet->getCell('K'.$row)->setValue($emboss["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.$row.':Q'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.$row)->setValue('WASTE');
        	$objSheet->getCell('O'.$row)->setValue(':');
        	$objSheet->getCell('P'.$row)->setValue($emboss["WASTE_PROSES"]);
        	$objSheet->getCell('Q'.$row)->setValue("%");

        	$row++;
        	$row++;
        	$objSheet->getCell('A'.$row)->setValue('Formula');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue($emboss["FORMULA"]);
        	$objSheet->getCell('I'.$row)->setValue('WAKTU');
        	$objSheet->getCell('J'.$row)->setValue(':');
        	$objSheet->getCell('k'.$row)->setValue('Stel PCH'); 
        	$objSheet->getCell('L'.$row)->setValue($emboss["STEL_PCH"]);
        	$objSheet->getStyle('N'.$row.':Q'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.$row)->setValue('Hasil');
        	$objSheet->getCell('O'.$row)->setValue(':');
        	$objSheet->getStyle('P'.$row)->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('P'.$row)->setValue(intval($emboss["HASIL"]));
        	$objSheet->getCell('Q'.$row)->setValue("m");

        	$row++;
        	$objSheet->getCell('C'.$row)->setValue("Jumlah");
        	$objSheet->getCell('D'.$row)->setValue(":");
        	$idMesin = $emboss["ID_MESIN"];
        	$formula = $this->Master_formula_model->findFormula1ByIdMesin($idMesin);
        	if(count($formula)>0){
        		$ukuran = $formula[0]->UKURAN;
        	}else{
        		echo " Ukuran di mesin emboss kosong, mohon check database";
        		exit();
        	}
        	$jml = $header["PANJANG_BAHAN"]/$ukuran;
        	$jml = round($jml, 0, PHP_ROUND_HALF_UP);
        	$objSheet->getCell('E'.$row)->setValue($jml." pch");
        	$objSheet->getCell('k'.$row)->setValue('Stel Bahan'); $objSheet->getCell('L'.$row)->setValue($emboss["STEL_BAHAN"]);

        	$row++;
        	$objSheet->getCell('C'.$row)->setValue("Uk");
        	$objSheet->getCell('D'.$row)->setValue(":");
        	$objSheet->getCell('E'.$row)->setValue("42 cm x 67 cm");
        	$objSheet->getCell('k'.$row)->setValue('Stel Proses');$objSheet->getCell('L'.$row)->setValue($emboss["LAMA_PROSES"]);
        	$objSheet->getStyle('L'.$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        	$row++;
        	$objSheet->getStyle('K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	$objSheet->getCell('k'.$row)->setValue('TOTAL');
        	$objSheet->getCell('L'.$row)->setValue($emboss["TOTAL_WAKTU"]);

        	$row++;
        	$objSheet->mergeCells('I'.($row).':L'.($row));
        	$objSheet->getCell('I'.$row)->setValue('DelTime : '.$emboss["delivery_time"]);
        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	}

        }

        function cetakDemet($objSheet,$demet,$emboss,$header,&$row,$kolom){

        		$row++;
				$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(12);
				$objSheet->getCell('A'.$row)->setValue('Proses (II)');
				$objSheet->getCell('B'.$row)->setValue(':');
				$objSheet->getCell('C'.$row)->setValue('DEMET');

				$objSheet->getCell('A'.($row+1))->setValue('Bahan');
				$objSheet->getCell('B'.($row+1))->setValue(':');
				$objSheet->mergeCells('C'.($row+1).':G'.($row+1));
				$objSheet->getCell('C'.($row+1))->setValue('PETM 12 mic. Holo Emboss Soft Yellow TA '.$header["tahun"]);
				$objSheet->getCell('I'.($row+1))->setValue('Target Prod');
				$objSheet->getCell('J'.($row+1))->setValue(':');
				$objSheet->mergeCells('K'.($row).':L'.($row));
				$objSheet->getCell('K'.($row+1))->setValue($demet["KECEPATAN_MESIN"]);
				$objSheet->getCell('I'.($row+2))->setValue('Waktu');
				$objSheet->getCell('J'.($row+2))->setValue(':');
				$objSheet->getCell('K'.($row+2))->setValue("Stel Bahan");
				$objSheet->getCell('L'.($row+2))->setValue($demet["STEL_BAHAN"]);

				$objSheet->getCell('K'.($row+3))->setValue("Proses");
				$objSheet->getStyle('L'.($row+3))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getCell('L'.($row+3))->setValue($demet["LAMA_PROSES"]);

				$objSheet->getCell('K'.($row+4))->setValue("TOTAL");
				$objSheet->getCell('L'.($row+4))->setValue($demet["TOTAL_WAKTU"]);

				$objSheet->getStyle('N'.($row+1).':Q'.($row+1))->getFont()->setBold(true)->setSize(12);
				$objSheet->getCell('N'.($row+1))->setValue('WASTE');
				$objSheet->getCell('O'.($row+1))->setValue(':');
				$objSheet->getCell('P'.($row+1))->setValue($demet["WASTE_PROSES"]);
				$objSheet->getCell('Q'.($row+1))->setValue("%");

				$objSheet->getStyle('N'.($row+3).':Q'.($row+3))->getFont()->setBold(true)->setSize(12);
				$objSheet->getCell('N'.($row+3))->setValue('Hasil');
				$objSheet->getCell('O'.($row+3))->setValue(':');
				$objSheet->getStyle('P'.($row+3))->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('P'.($row+3))->setValue(intval($demet["HASIL"]));
				$objSheet->getCell('Q'.($row+3))->setValue("m");

				$objSheet->getCell('A'.($row+2))->setValue('Formula');

				$idMesin = $demet["ID_MESIN"];
				$listFormula = $this->Master_formula_model->findFormula1ByIdMesin($idMesin);
				$generalWhite = 0;
				$mediumYra = 0;
				if(count($listFormula)<1){
					echo " Cannot read formula on demet, please check database";
        			exit();
				}

				foreach($listFormula as $r){
					$namaFormula = $r->NAMA_FORMULA_ANAK;
					$objSheet->getCell('B'.($row+2))->setValue(':');
					$objSheet->getCell('C'.($row+2))->setValue($namaFormula);
					$message = "";
					
					if(strpos( strtolower( $namaFormula ), strtolower( 'general' ) )){

						if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}
						// else if($header["GSM_BAHAN_BAKU"] == 0){
						// 	$message = "GSM Bahan Di Database == 0";
						// }
						else{

							$generalWhite = (intval($emboss["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*$r->GRAMATURE)/$r->SOLID_CONTAIN/1000;
    						$display = round($generalWhite, 2);
							$objSheet->getCell('E'.($row+2))->setValue($display." Kg");
						}
					}else if(stristr($namaFormula, 'medium') !== FALSE){
						$zzz = str_replace(",", ".", $r->UKURAN);
						$ukuran = floatval($zzz);
						$mediumYra = $generalWhite * $ukuran;
						$display = round($mediumYra, 2);
						$objSheet->getCell('E'.($row+2))->setValue($display." Kg");

					}else if(stristr($namaFormula, 'pigment') !== FALSE){
						if(stristr($namaFormula, 'red') !== FALSE){
							$pigmentRed = ($r->UKURAN/100)*$mediumYra;
							$display = round($pigmentRed, 2);
							$objSheet->getCell('E'.($row+2))->setValue($display." Kg");
						}else if(stristr($namaFormula, 'uv') !== FALSE){
							$pigmentUv= (($r->UKURAN/100)/100)*$generalWhite;
							$display = round($pigmentUv, 2);
							$objSheet->getCell('E'.($row+2))->setValue($display." Kg");
						}
						

					}else if (stristr($namaFormula, 'solvent') !== FALSE) {
						$solvent = $demet["HASIL"]/400;
						$solvent = round($solvent, 2);
						$objSheet->getStyle('E'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($row+2))->setValue($solvent." Kg");
					}

					if($message !== ""){
						echo $message;
						exit();
					}					
					$row++;
				}

				$row++;
				$row++;

				$objSheet->mergeCells('I'.($row).':L'.($row));
	        	$objSheet->getCell('I'.$row)->setValue('DelTime : '.$demet["delivery_time_ind"]);

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				}

        }
        function cetakRewind($objSheet, $rewind, $header, &$row, $kolom){

        	$row++;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('A'.$row)->setValue('Proses (III)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Rewind');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->mergeCells('C'.$row.':G'.$row);
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Demet Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->mergeCells('K'.($row).':L'.($row));
        	$objSheet->getCell('K'.($row))->setValue($rewind["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('WASTE');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getCell('P'.($row))->setValue($rewind["WASTE_PROSES"]);
        	$objSheet->getCell('Q'.($row))->setValue("%");

        	$row++;
        	$objSheet->getCell('I'.($row))->setValue('Waktu');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue("Stel Bahan");
        	$objSheet->getCell('L'.($row))->setValue($rewind["STEL_BAHAN"]);

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("Proses");
        	$objSheet->getStyle('L'.($row))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	$objSheet->getCell('L'.($row))->setValue($rewind["LAMA_PROSES"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('Hasil');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getStyle('P'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('P'.($row))->setValue(intval($rewind["HASIL"]));
        	$objSheet->getCell('Q'.($row))->setValue("m");

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("TOTAL");
        	$objSheet->getCell('L'.($row))->setValue($rewind["TOTAL_WAKTU"]);

        	$row++;
        	$objSheet->mergeCells('I'.($row).':L'.($row));
        	$objSheet->getCell('I'.$row)->setValue('DelTime : '.$rewind["delivery_time"]);
        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	}
        }

        function cetakSensi($objSheet, $sensi,$rewind, $header, &$row, $kolom, &$endLineOfSensi){
        	$row++;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('A'.$row)->setValue('Proses (IV)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Sensitizing');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->mergeCells('C'.$row.':G'.$row);
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Demet Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->mergeCells('K'.($row).':L'.($row));
        	$objSheet->getCell('K'.($row))->setValue($sensi["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('WASTE');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getCell('P'.($row))->setValue($sensi["WASTE_PROSES"]);
        	$objSheet->getCell('Q'.($row))->setValue("%");

        	$row++;
        	$start = $row;
        	$objSheet->getCell('I'.($row))->setValue('Waktu');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue("Stel Silinder 1");
        	$objSheet->getCell('L'.($row))->setValue($sensi["STEL_SILINDER"]);

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("Stel Bahan");
        	$objSheet->getCell('L'.($row))->setValue($sensi["STEL_BAHAN"]);

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("Proses");
        	$objSheet->getStyle('L'.($row))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	$objSheet->getCell('L'.($row))->setValue($sensi["LAMA_PROSES"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('Hasil');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getStyle('P'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('P'.($row))->setValue(intval($sensi["HASIL"]));
        	$objSheet->getCell('Q'.($row))->setValue("m");

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("TOTAL");
        	$objSheet->getCell('L'.($row))->setValue($sensi["TOTAL_WAKTU"]);

				//bikin formula proses sensi
        	$idMesin = $sensi["ID_MESIN"];
        	$listFormula1 = $this->Master_formula_model->findFormula1ByIdMesin($idMesin);
			$listFormula2 = $this->Master_formula_model->findFormula2ByIdMesin($idMesin);
			$listFormula3 = $this->Master_formula_model->findFormula3ByIdMesin($idMesin);
			
			
			if(count($listFormula1) >0){

				$objSheet->getCell('A'.($start))->setValue('Formula 01');
        		$objSheet->getCell('B'.($start))->setValue(':');
        		$mediumPs = 0;
        		$message = "";
        		foreach($listFormula1 as $r){
					$namaFormula = $r->NAMA_FORMULA_ANAK;
					$objSheet->getCell('C'.($start))->setValue($namaFormula);
					if(stristr($namaFormula, 'general') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}
						// else if($header["GSM_BAHAN_BAKU"] == 0){
						// 	$message = "GSM Bahan Di Database == 0";
						// }
						else{
							$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*$r->GRAMATURE)/$r->SOLID_CONTAIN/1000;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'solvent') !== FALSE) {
						$solvent = $sensi["HASIL"]/$r->UKURAN;
						$solvent = round($solvent, 2);
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($solvent)." Kg");

					}else if(stristr($namaFormula, 'pigment') !== FALSE){
						
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(round($mediumPs*($r->UKURAN)/100,2)." Kg");					
					}


					$start++;
				}
				if($message !== ""){
						echo $message;
						exit();
				}
				$objSheet->getCell('C'.($start))->setValue("Silinder Motif Bingkai BC ".$header["tahun"]." ,".$header["seri"]);

			}

			$start++;
			$start++;
			if(count($listFormula2)>0){
				$objSheet->getCell('A'.($start))->setValue('Formula 02');
        		$objSheet->getCell('B'.($start))->setValue(':');
        		$message = "";
        		foreach($listFormula2 as $r){
					$namaFormula = $r->NAMA_FORMULA_ANAK;
					$objSheet->getCell('C'.($start))->setValue($namaFormula);
					if(stristr($namaFormula, 'medium') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}
						// else if($header["GSM_BAHAN_BAKU"] == 0){
						// 	$message = "GSM Bahan Di Database == 0";
						// }
						else{
							$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*($r->GRAMATURE))/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$toluol = $sensi["HASIL"]/$r->UKURAN;
						$toluol = round($toluol, 2);
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($toluol)." Kg");

					}

					$start++;
				}
				if($message !== ""){
						echo $message;
						exit();
				
				}
				$objSheet->getCell('C'.($start))->setValue("Silinder Raster 80 Barcode ");

			}
			$start++;
			$start++;
			if(count($listFormula3)>0){
				$objSheet->getCell('A'.($start))->setValue('Formula 03');
        		$objSheet->getCell('B'.($start))->setValue(':');
        		foreach($listFormula3 as $r){
					$namaFormula = $r->NAMA_FORMULA_ANAK;
					$objSheet->getCell('C'.($start))->setValue($namaFormula);
					if(stristr($namaFormula, 'readible') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}
						// else if($header["GSM_BAHAN_BAKU"] == 0){
						// 	$message = "GSM Bahan Di Database == 0";
						// }
						else{
						$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*$r->GRAMATURE)/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$toluol = $sensi["HASIL"]/$r->UKURAN;
						$toluol = round($toluol, 2);
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($toluol)." Kg");
					}
					$start++;
				}
				if($message !== ""){
						echo $message;
						exit();
				
				}
				$objSheet->mergeCells('C'.$start.':E'.$start);
				$objSheet->getCell('C'.($start))->setValue("Silinder Raster 80 barcode ".$header["tahun"]." ,".$header["seri"]);
			}

        	
        	if($start < $row){
        		$endLineOfSensi = $row;
        	}else{
        		$endLineOfSensi = $start;

        	}

        	$endLineOfSensi++;
        	$objSheet->mergeCells('I'.($endLineOfSensi).':L'.($endLineOfSensi));
        	$objSheet->getCell('I'.$endLineOfSensi)->setValue('DelTime : '.$sensi["delivery_time"]);

        	for($i = 0; $i<17; $i++){

        		$objSheet->getStyle(''.$kolom[$i].$endLineOfSensi)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	}

        }

        function cetakBelah($objSheet, $belah, $header, &$row, $kolom, $endLineOfSensi){

        	$endLineOfSensi++;
        	$row = $endLineOfSensi;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('A'.$row)->setValue('Proses (V)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Belah + Sortir');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->mergeCells('C'.$row.':G'.$row);
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Sensi Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->mergeCells('K'.($row).':L'.($row));
        	$objSheet->getCell('K'.($row))->setValue($belah["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('WASTE');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getCell('P'.($row))->setValue($belah["WASTE_PROSES"]);
        	$objSheet->getCell('Q'.($row))->setValue("%");

        	$row++;
        	$row++;
        	$objSheet->getStyle('C'.($row).':G'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->mergeCells('C'.($row).':D'.($row));
        	$objSheet->getCell('C'.($row))->setValue('Hasil Belah ukuran 33 cm ');
        	$hasilBelah = $belah["HASIL"]*2;
        	$objSheet->getStyle('E'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('E'.($row))->setValue($hasilBelah);
        	$objSheet->mergeCells('F'.($row).':G'.($row));
        	$objSheet->getCell('F'.($row))->setValue('Meter');
        	$objSheet->getCell('I'.($row))->setValue('Waktu');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue("Stel Bahan");
        	$objSheet->getCell('L'.($row))->setValue($belah["STEL_BAHAN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(12);
        	$objSheet->getCell('N'.($row))->setValue('Hasil');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getStyle('P'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('P'.($row))->setValue(intval($belah["HASIL"]));
        	$objSheet->getCell('Q'.($row))->setValue("m");

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("Proses");
        	$objSheet->getStyle('L'.($row))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	$objSheet->getCell('L'.($row))->setValue($belah["LAMA_PROSES"]);


        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("TOTAL");
        	$objSheet->getCell('L'.($row))->setValue($belah["TOTAL_WAKTU"]);

        	$row++;
        	$objSheet->mergeCells('I'.($row).':L'.($row));
        	$objSheet->getCell('I'.$row)->setValue('DelTime : '.$belah["delivery_time"]);

        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        	}
        }

        function convertToRomawi($number){
        	if($number == "01"){
        		return "I";
        	}else if($number == "02"){
        		return "II";
        	}else if($number == "03"){
        		return "III";
        	}else if($number == "04"){
        		return "IV";
        	}else if($number == "05"){
        		return "V";
        	}else if($number == "06"){
        		return "VI";
        	}else if($number == "07"){
        		return "VII";
        	}else if($number == "08"){
        		return "VIII";
        	}else if($number == "09"){
        		return "IX";
        	}else if($number == "10"){
        		return "X";
        	}else if($number == "11"){
        		return "XI";
        	}else if($number == "12"){
        		return "XII";
        	}
        }

        function download($filename = NULL) {
		    // load download helder
		    $fileName = $this->input->post('fileName');
		    $this->load->helper('download');
		    // read file contents
		    $data = file_get_contents("//192.168.17.102/Test/".$fileName.".pdf");
		    force_download($filename, $data);
		}

        function viewListKK(){
		
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

			if($data["status"]=="PPC"){
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_list_file', $data);
				$this->load->view('ppc/v_footer',$data);
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

}