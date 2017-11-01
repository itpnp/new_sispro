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
		$this->load->model('Master_detail_emboss_model');
		$this->load->model('Master_detail_demet_model');
		$this->load->model('Master_detail_rewind_model');
		$this->load->model('Master_detail_sensi_model');
		$this->load->model('Master_detail_belah_model');
		$this->load->model('Master_terima_foil_model');
		$this->load->model('Master_laporan_emboss_model');
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

				$kkAndBapob = array();
				$index = 0;
				foreach ($dataBapob as $row) {
					$kkAndBapob[$index][0] = $row->DESAIN;
					$getLastNumber = $this->Master_kk_model->getLastNumber($row->DESAIN);
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
					}else{
						$nomorBaru = "001/PNP-HLG/PPC/KKM/".$bulan."/".date("Y");
					}
					$kkAndBapob[$index][1] = $nomorBaru;
					$kkAndBapob[$index][2] = $row->NOMOR_BAPOB;
					$kkAndBapob[$index][3] = $row->WASTE_PEREKATAN;
					$kkAndBapob[$index][4] = $row->WASTE_PITA;
					$kkAndBapob[$index][5] = $row->WASTE_BELAH;
					$index++;
				}
				
				// for($i=0; $i<sizeof($kkAndBapob);$i++){
				// 	echo $kkAndBapob[$i][0]." Bapob : ".$kkAndBapob[$i][1]." KK : ".$kkAndBapob[$i][2];
				// 	echo "<br>";
				// }
				// exit();
				$data["kkAndBapob"] = $kkAndBapob;
				// $data["bapob"] = $dataBapob[0];
				

				// $data["masterBahan"] = $this->Master_bahan_model->getAllData();
				$data["masterBahan"] = $this->Master_bahan_model->getAllDataArray();
				// $getLastNumber = $this->Master_kk_model->getLastNumber(date("Y"));
				// $bulan = $this->convertToRomawi(date("m"));
				// if(sizeof($getLastNumber) >0){
				// 	$lastNumber = substr(($getLastNumber[0]->NOMOR_KK),0,3);
				// 	$currentNumber = intval($lastNumber)+1;
				// 	if($currentNumber <10){
				// 		$nomorBaru = "00".$currentNumber;
				// 	}else if($currentNumber >9 && $currentNumber <100){
				// 		$nomorBaru = "0".$currentNumber;
				// 	}
				// 	$nomorBaru = $nomorBaru."/PNP-HLG/PPC/KKM/".$bulan."/".date("Y");
				// 	// $nomorBaru = "013/PNP-HLG/PPC/KKM/III/2017";
				// }else{
				// 	$nomorBaru = "001/PNP-HLG/PPC/KKM/".$bulan."/".date("Y");
				// 	// $nomorBaru = "001/PNP-HLG/PPC/KKM/XII/2016";
				// }
				
				$data["nomorKkBaru"] = $nomorBaru;
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_master_kk_add',$data);
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
		$tahun = $this->input->post('tahunDesain');
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
		$dataBapob = $this->Master_bapob_model->findByNumber($this->input->post('noBapob'));
		$_SESSION['data_bapob']=$dataBapob;
		$data['NAMA_BAHAN_BAPOB']=$dataBapob->BAHAN;
		$wasteProses = $dataBapob->WASTE_BELAH;
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
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Emboss',$data["bapob"]->DESAIN);
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesEmbossOnBapob']=$prosesOnBapob[0];

				// $data["masterMesin"] = $this->Master_mesin_model->getAllData();
				$data["masterMesin"] = $this->Master_mesin_model->getDataMesin($idMesin,$data["bapob"]->DESAIN);
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
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Demet',$data["bapob"]->DESAIN);
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesDemetOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getDataMesin($idMesin,$data["bapob"]->DESAIN);
				// $data["masterMesin"] = $this->Master_mesin_model->getAllData();
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
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Rewind',$data["bapob"]->DESAIN);
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesRewindOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getDataMesin($idMesin,$data["bapob"]->DESAIN);
				// $data["masterMesin"] = $this->Master_mesin_model->getAllData();
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
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Sensitizing',$data["bapob"]->DESAIN);
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$_SESSION['prosesSensiOnBapob']=$prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getDataMesin($idMesin,$data["bapob"]->DESAIN);
				// $data["masterMesin"] = $this->Master_mesin_model->getAllData();
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
				$dataMesin = $this->Master_mesin_model->findByName('Mesin Belah',$data["bapob"]->DESAIN);
				$data["mesin"] = $dataMesin[0];
				$idBapob = $data["bapob"]->ID_BAPOB;
				$idMesin = $data["mesin"]->ID_MESIN;
				$prosesOnBapob = $this->Master_proses_bapob_model->findProsesByBapobAndMesin($idBapob, $idMesin);
				$data["prosesOnBapob"] = $prosesOnBapob[0];
				$data["masterMesin"] = $this->Master_mesin_model->getDataMesin($idMesin,$data["bapob"]->DESAIN);
				// $data["masterMesin"] = $this->Master_mesin_model->getAllData();
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

            $dataHeader 	= isset($_SESSION['data_header']);
            $prosesSensi 	= isset($_SESSION['proses_sensi']);
            $prosesBelah 	= isset($_SESSION['proses_belah']);
            $prosesEmboss 	= isset($_SESSION['proses_emboss']);
            $prosesDemet 	= isset($_SESSION['proses_demet']);
            $prosesRewind 	= isset($_SESSION['proses_rewind']);

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
				$objSheet->getCell('C8')->setValue($header["MACAM"]." ".$header["seri"]);
				// $objSheet->getCell('C8')->setValue($header["MACAM"]." Tahun ".$header["tahun"]." ".$header["seri"]);
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
	            $objWriter->save("//192.168.17.102/Test/".$filename.".xlsx");
	            // $objWriter->save("E://Test/".$filename.".xlsx");
	            // $objWriter->save("E://KK/".$filename.".xlsx");
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
        	$objSheet->getCell('C'.$row)->setValue($header["NAMA_BAHAN_BAPOB"]);
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
        	$idMesin = $emboss["ID_MESIN"];
        	$formula = $this->Master_formula_model->findFormula1ByIdMesin($idMesin);
        	$objSheet->getCell('A'.$row)->setValue('Formula');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	if(count($formula)>0){
        		$objSheet->getCell('C'.$row)->setValue($formula[0]->NAMA_FORMULA_ANAK);
        	}else{
        		echo $idMesin;
        		echo "<br>";
        		echo " Ukuran di mesin emboss kosong, mohon check database";
        		exit();	
        	}
        	// $objSheet->getCell('C'.$row)->setValue($emboss["FORMULA"]);
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
        	
        	
        	if(count($formula)>0){
        		$ukuran = $formula[0]->UKURAN;
        	}else{
        		echo $idMesin;
        		echo "<br>";
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
				$objSheet->getCell('C'.($row+1))->setValue($header["NAMA_BAHAN_BAPOB"]);
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
	        	$objSheet->getCell('I'.$row)->setValue('DelTime : '.$demet["delivery_time"]);

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
        	$objSheet->getCell('C'.($row))->setValue($header["NAMA_BAHAN_BAPOB"]);
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
        	$objSheet->getCell('C'.($row))->setValue($header["NAMA_BAHAN_BAPOB"]);
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
					if(stristr($namaFormula, 'silinder') !== FALSE ){
						$objSheet->getCell('C'.($start))->setValue($namaFormula." ,".$header["seri"]);
					}else{
						$objSheet->getCell('C'.($start))->setValue($namaFormula);
					}
					if(stristr($namaFormula, 'general') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}else{
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
					}else if(stristr($namaFormula, 'medium') !== FALSE){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}else{
							$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*($r->GRAMATURE))/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
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
			}

			$start++;
			$start++;
			if(count($listFormula2)>0){
				$objSheet->getCell('A'.($start))->setValue('Formula 02');
        		$objSheet->getCell('B'.($start))->setValue(':');
        		$message = "";
        		foreach($listFormula2 as $r){
					$namaFormula = $r->NAMA_FORMULA_ANAK;
					if(stristr($namaFormula, 'silinder') !== FALSE ){
						$objSheet->getCell('C'.($start))->setValue($namaFormula." ,".$header["seri"]);
					}else{
						$objSheet->getCell('C'.($start))->setValue($namaFormula);
					}
					if(stristr($namaFormula, 'medium') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}else{
							$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*($r->GRAMATURE))/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$toluol = $sensi["HASIL"]/$r->UKURAN;
						$toluol = round($toluol, 2);
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($toluol)." Kg");
					}else if(stristr($namaFormula, 'readible') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}else{
						$mediumPs = (intval($rewind["HASIL"])*($header["LEBAR_BAHAN_BAKU"]/100)*$r->GRAMATURE)/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
						}
					}
					$start++;
				}
				if($message !== ""){
						echo $message;
						exit();
				}

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
        	$objSheet->getCell('C'.($row))->setValue($header["NAMA_BAHAN_BAPOB"]);
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
			$map = directory_map('//192.168.17.42/KK/');
			$max = sizeof($map);
			// ECHO $max;
			// exit();
			$listFiles = array();
			$index = 0;
			for($i=0; $i<$max;$i++){
				// echo $map[$i];
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
			if($data["status"]=="PPC"){
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_laporan_per_kk',$data);
				$this->load->view('ppc/v_footer',$data);
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
			if($data["status"]=="PPC"){
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_laporan_harian',$data);
				$this->load->view('ppc/v_footer',$data);
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
			if($data["status"]=="PPC"){
				$this->load->view('ppc/v_header',$data);
				$this->load->view('ppc/v_side_menu',$data);
				$this->load->view('ppc/v_laporan_bulanan',$data);
				$this->load->view('ppc/v_footer',$data);
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
		if($data["status"]=="PPC"){
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
		if($data["status"]=="PPC"){
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
			
			
				$this->generateLaporanHarian($proses,$data, $objPHPExcel, $rendererName, $rendererLibraryPath, $objWriter, $objSheet);
			

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
		if(sizeof($data)>0){
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
			}else if($bulan == '02'){
				$namaBulan = "FEBRUARI";
			}else if($bulan == '03'){
				$namaBulan = "MARET";
			}else if($bulan == '04'){
				$namaBulan = "APRIL";
			}else if($bulan == '05'){
				$namaBulan = "MEI";
			}else if($bulan == '06'){
				$namaBulan = "JUNI";
			}else if($bulan == '07'){
				$namaBulan = "JULI";
			}else if($bulan == '08'){
				$namaBulan = "AGUSTUS";
			}else if($bulan == '09'){
				$namaBulan = "SEPTEMBER";
			}else if($bulan == '10'){
				$namaBulan = "OKTOBER";
			}else if($bulan == '11'){
				$namaBulan = "NOVEMBER";
			}else if($bulan == '12'){
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