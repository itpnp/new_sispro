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
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
				$this->load->view('ppc/v_ide_menu',$data);
				$this->load->view('ppc/v_master_mesin_home',$data);
				$this->load->view('ppc/v_footer',$data);
			}
			else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Login dulu donk...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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

		$data['NO_KK'] = $this->input->post('noKK');
		$data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['TGL_PROSES_MESIN'] = $this->input->post('tanggalProses');
		$data['JML_PESANAN'] = $this->input->post('jumlahPesanan');
		$data['MACAM'] = $this->input->post('macam');
		$data['tahun'] = $tahun;
		$data['seri'] = $seri;
		$data['panjangWastePerekatan'] = $this->input->post('jumlahWastePerekatan');
		$data['panjangWastePita'] = $this->input->post('jumlahWastePita');
		$data['panjangWasteBelah'] = $this->input->post('jumlahWasteBelah');

		$jumlahPesanan = $this->input->post('jumlahPesanan');
		$wasteProses = $_SESSION['data_bapob']->WASTE_BELAH;
		$wasteDalamPersen = $wasteProses/100;

		$panjangBahan = $jumlahPesanan + ($jumlahPesanan * $wasteDalamPersen);
		$panjangBahan = round($panjangBahan, 0);
		$data['JUMLAH_WASTE_PROSES'] = $this->input->post('wasteProses');
		$data['PANJANG_BAHAN'] = $panjangBahan;

		$_SESSION['data_header']=$data;

		$this->session->set_flashdata('success', 'Data KK Berhasil disimpan di session');
		
		redirect("ppc/addProsesEmboss");

		// echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/createHeaderKK'>";	
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
		$_SESSION['delivery_emboss'] = $this->input->post('deliveryTime');
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
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_emboss',$data);
					$this->load->view('ppc/v_footer',$data);
				}
				else{
					?>
					<script type="text/javascript" language="javascript">
						alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
					</script>
					<?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
				$data["delivery_emboss"] = $_SESSION['delivery_emboss'];
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
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesBelah'>";
			}
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
		}


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
		$data['WASTE_PROSES'] = $_SESSION['data_bapob']->WASTE_BELAH;
		$data['HASIL'] = $this->input->post('hasil');
		$_SESSION['proses_belah']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		$this->saveAllData();

	}

	function saveAllData(){

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

					$header = $_SESSION['data_header'];
					$emboss = $_SESSION['proses_emboss'];
					$demet = $_SESSION['proses_demet'];
					$rewind = $_SESSION['proses_rewind'];
					$sensi = $_SESSION['proses_sensi'];
					$belah = $_SESSION['proses_belah'];
					$bapob = $_SESSION['data_bapob'];

					$emboss["STEL_SILINDER"] = 'test update';
					$emboss["PANJANG_BAHAN"] = $header["PANJANG_BAHAN"];
					$emboss["ID_BAPOB"] = $bapob->ID_BAPOB;

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
									}

								}
							}
						}
					}
					
				}
				else{
					?>
					<script type="text/javascript" language="javascript">
						alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
					</script>
					<?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
				}
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Please Fill Data KK First");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc/addProsesBelah'>";
			}
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Login dulu donk...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
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

	            require_once APPPATH.'libraries\dompdf\dompdf_config.inc.php';

				$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
				//$rendererLibrary = 'tcPDF5.9';
				// $rendererLibrary = 'mPDF5.4';
				$rendererLibraryPath = APPPATH.'libraries\dompdf';
            	//proses cetak Kartu Kerja Mesin
            	//membuat objek PHPExcel

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
				
	            $objPHPExcel = new PHPExcel();
	 
	            $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');

				// set default font size
				$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

				// create the writer
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
				// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');

				 // $objWriter->setSheetIndex(0);
				// $objWriter = new PHPExcel_Writer_PDF($objPHPExcel);

				/**

				 * Define currency and number format.

				 */

				// currency format, € with < 0 being in red color
				// $currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';

				// number format, with thousands separator and two decimal points.
				// $numberFormat = '#,#0.##;[Red]-#,#0.##';

				// writer already created the first sheet for us, let's get it
				$objSheet = $objPHPExcel->getActiveSheet();

				// rename the sheet
				$objSheet->setTitle('KK-Metalis-New');


				// let's bold and size the header font and write the header
				// as you can see, we can specify a range of cells, like here: cells from A1 to A4
				// write header
				$objSheet->getStyle('C3:K3')->getFont()->setBold(true)->setUnderline(true)->setSize(14);
				$objSheet->getStyle('C3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->mergeCells('C3:K3');
				$objSheet->getCell('C3')->setValue('KARTU KERJA MESIN');


				$objSheet->getCell('A5')->setValue('No. KK');
				$objSheet->getCell('A6')->setValue('No. BAPOB');
				$objSheet->getCell('A7')->setValue('Macam');
				$objSheet->getCell('A8')->setValue('Jml Pesanan');
				$objSheet->getCell('A9')->setValue('Hasil Belah');

				for($i=5; $i<10; $i++){
					$objSheet->getCell('B'.$i)->setValue(':');
				}

				$objSheet->mergeCells('C5:E5');
				$objSheet->getCell('C5')->setValue($header["NO_KK"]);

				$objSheet->mergeCells('C6:D6');
				$objSheet->getCell('C6')->setValue($bapob->NOMOR_BAPOB);

				$objSheet->mergeCells('C7:D7');
				$objSheet->getStyle('C7')->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('C7')->setValue($header["MACAM"]." Tahun ".$header["tahun"]." ".$header["seri"]);
				$objSheet->getStyle('C8')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('C8')->setValue($header["JML_PESANAN"]);
				$objSheet->getStyle('C9')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('C9')->setValue($header["panjangWastePita"]);
				$objSheet->getCell('D8')->setValue("meter");
				$objSheet->getCell('D9')->setValue("meter");
				$objSheet->getCell('E8')->setValue("Uk. 66 Cm");

				$objSheet->mergeCells('H5:I5');
				$objSheet->getCell('H5')->setValue("Tgl Pros Msn ");

				$objSheet->mergeCells('H7:I7');
				$objSheet->getCell('H7')->setValue("Bahan ");

				$objSheet->mergeCells('H8:I8');
				$objSheet->getCell('H8')->setValue("Panjang Bhn");

				$objSheet->mergeCells('H9:I9');
				$objSheet->getCell('H9')->setValue("Waste Pita ");
				$objSheet->getCell('H10')->setValue("Waste Belah ");

				for($i=5; $i<11; $i++){
					if($i!=6){
						$objSheet->getCell('J'.$i)->setValue(':');
					}
					
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

				$objSheet->getCell('K5')->setValue($header["TGL_PROSES_MESIN"]);

				$objSheet->mergeCells('K7:N7');
				$objSheet->getCell('K7')->setValue($header["NAMA_BAHAN_BAKU"]);
				$objSheet->getStyle('K8')->getNumberFormat()->setFormatCode('#,##0.00');
				$objSheet->getCell('K8')->setValue($header["panjangWasteBelah"]);
				$objSheet->getCell('L8')->setValue("meter");
				$objSheet->getCell('M8')->setValue("UK");
				$objSheet->getCell('M8')->setValue("66 Cm");
				$objSheet->getCell('K9')->setValue($bapob->WASTE_PITA."%");
				$objSheet->getCell('K10')->setValue($bapob->WASTE_BELAH."%");

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].'10')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
				}

				$row = 11;
				$endLineOfSensi = 0;

				//Mulai proses pertama
					$this->cetakEmboss($objSheet, $emboss, $header, $row, $kolom);
				//ini proses selanjutnya
					$this->cetakDemet($objSheet, $demet, $header, $row, $kolom);
				//Ini Proses Selanjutnya
					$this->cetakRewind($objSheet, $rewind, $header, $row, $kolom);
				//ini proses selanjutnya
					$this->cetakSensi($objSheet,$sensi, $header, $row, $kolom, $endLineOfSensi);
				//proses belah dan sortir
					$this->cetakBelah($objSheet,$belah,$header,$row, $kolom, $endLineOfSensi);

				$row++;
				$objSheet->getStyle('A'.($row))->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('A'.($row))->setValue("Note");
				$objSheet->getCell('B'.($row))->setValue(':');
				$objSheet->getCell('C'.($row))->setValue('Pengerjaan setiap proses harus acc QC');

				$row++;
				$objSheet->getCell('B'.($row))->setValue(':');
				$objSheet->getCell('C'.($row))->setValue('Arah baca harus jelas, teks BC RI Sensitizing harus searah dengan logo BCRI');

				$row++;
				$objSheet->getCell('B'.($row))->setValue(':');
				$objSheet->getCell('C'.($row))->setValue('Penyimpanan dan pengambilan harus sesuai dengan ketentuan yang berlaku');

				// autosize the columns
				$objSheet->getColumnDimension('A')->setAutoSize(true);
				$objSheet->getColumnDimension('B')->setWidth(2);
				$objSheet->getColumnDimension('C')->setWidth(15);;
				$objSheet->getColumnDimension('D')->setAutoSize(true);
				$objSheet->getColumnDimension('E')->setAutoSize(true);
				$objSheet->getColumnDimension('F')->setWidth(3);
				$objSheet->getColumnDimension('H')->setWidth(3);
				$objSheet->getColumnDimension('J')->setWidth(2);
				$objSheet->getColumnDimension('O')->setWidth(2);
				$objSheet->getColumnDimension('Q')->setWidth(3);
				$objSheet->getColumnDimension('M')->setWidth(5);
				$objSheet->getColumnDimension('I')->setAutoSize(true);
				$objSheet->getColumnDimension('K')->setAutoSize(true);
				$objSheet->getColumnDimension('P')->setAutoSize(true);

	            ob_end_clean();
	 
	            //sesuaikan headernya 
	            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$header["NO_KK"].'.xlsx"');
				header('Cache-Control: max-age=0');

				// header('Content-Type: application/pdf');
				// header('Content-Disposition: attachment;filename="'.$header["NO_KK"].'.pdf"');
				// header('Cache-Control: max-age=0');
				
	            //unduh file
	            $objWriter->save("php://output");

	            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
	            // Folder Documentation dan Example
	            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu

            }//end if - else
 
        }

        function cetakEmboss($objSheet, $emboss, $header, &$row, $kolom){

        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('A'.$row)->setValue('Proces (I)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('EMBOSS');

        	$row++;
        	$objSheet->getCell('A'.$row)->setValue('Bahan');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	// $objSheet->getCell('C'.$row)->setValue($header["NAMA_BAHAN_BAKU"]);
        	$objSheet->getCell('C'.$row)->setValue('PETM 12 mic. Gudang Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.$row)->setValue('Target Prod');
        	$objSheet->getCell('J'.$row)->setValue(':');
        	$objSheet->getCell('K'.$row)->setValue($emboss["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.$row.':Q'.$row)->getFont()->setBold(true)->setSize(11);
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
        	$objSheet->getStyle('N'.$row.':Q'.$row)->getFont()->setBold(true)->setSize(11);
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
        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        	}

        }

        function cetakDemet($objSheet, $demet, $header, &$row, $kolom){

        		$row++;
				$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('A'.$row)->setValue('Proces (II)');
				$objSheet->getCell('B'.$row)->setValue(':');
				$objSheet->getCell('C'.$row)->setValue('DEMET');

				$objSheet->getCell('A'.($row+1))->setValue('Bahan');
				$objSheet->getCell('B'.($row+1))->setValue(':');
				$objSheet->getCell('C'.($row+1))->setValue('PETM 12 mic. Holo Emboss Soft Yellow TA '.$header["tahun"]);
				$objSheet->getCell('I'.($row+1))->setValue('Target Prod');
				$objSheet->getCell('J'.($row+1))->setValue(':');
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

				$objSheet->getStyle('N'.($row+1).':Q'.($row+1))->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('N'.($row+1))->setValue('WASTE');
				$objSheet->getCell('O'.($row+1))->setValue(':');
				$objSheet->getCell('P'.($row+1))->setValue($demet["WASTE_PROSES"]);
				$objSheet->getCell('Q'.($row+1))->setValue("%");

				$objSheet->getStyle('N'.($row+3).':Q'.($row+3))->getFont()->setBold(true)->setSize(11);
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
						}else if($header["GSM_BAHAN_BAKU"] == 0){
							$message = "GSM Bahan Di Database == 0";
						}else{
							$generalWhite = ($header["PANJANG_BAHAN"]*($header["LEBAR_BAHAN_BAKU"]/100)*$header["GSM_BAHAN_BAKU"])/$r->SOLID_CONTAIN/1000 ;
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
							$pigmentUv= ($r->UKURAN/100)*$generalWhite;
							$display = round($pigmentUv, 2);
							$objSheet->getCell('E'.($row+2))->setValue($display." Kg");
						}
						

					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$objSheet->getStyle('E'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($row+2))->setValue(($demet["HASIL"]/400)." Kg");
					}

					if($message !== ""){
						echo $message;
						exit();
					}					
					$row++;
				}

				$row++;
				$row++;

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
				}

        }
        function cetakRewind($objSheet, $rewind, $header, &$row, $kolom){

        	$row++;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('A'.$row)->setValue('Proces (III)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Rewind');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Demet Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue($rewind["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
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
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('N'.($row))->setValue('Hasil');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getStyle('P'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('P'.($row))->setValue(intval($rewind["HASIL"]));
        	$objSheet->getCell('Q'.($row))->setValue("m");

        	$row++;
        	$objSheet->getCell('K'.($row))->setValue("TOTAL");
        	$objSheet->getCell('L'.($row))->setValue($rewind["TOTAL_WAKTU"]);

        	$row++;
        	$row++;

        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        	}
        }

        function cetakSensi($objSheet, $sensi, $header, &$row, $kolom, &$endLineOfSensi){
        	$row++;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('A'.$row)->setValue('Proces (IV)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Sensitizing');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Demet Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue($sensi["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
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
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
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
					if(stristr($namaFormula, 'medium') !== FALSE ){
						$gsm = str_replace(",", ".", $r->GRAMATURE);
						$gsm = floatval($gsm);
						
						if($gsm == 0){
							$message = " GRAMATURE Di Database == 0";
						}else if($r->SOLID_CONTAIN == 0){
							$message = " SOLID CONTAIN Di Database == 0";
						}else if($header["LEBAR_BAHAN_BAKU"] == 0){
							$message = "lebar Bahan Di Database == 0";
						}else if($header["GSM_BAHAN_BAKU"] == 0){
							$message = "GSM Bahan Di Database == 0";
						}else{
							$mediumPs = ($header["panjangWasteBelah"]*($header["LEBAR_BAHAN_BAKU"]/100)*$gsm)/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($sensi["HASIL"]/$r->UKURAN)." Kg");

					}else if(stristr($namaFormula, 'pigment') !== FALSE){
						
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(round(($mediumPs/(($r->UKURAN))/100),2)." Kg");					
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
						}else if($header["GSM_BAHAN_BAKU"] == 0){
							$message = "GSM Bahan Di Database == 0";
						}else{
							$mediumPs = ($header["panjangWasteBelah"]*($header["LEBAR_BAHAN_BAKU"]/100)*$gsm)/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($sensi["HASIL"]/$r->UKURAN)." Kg");

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
						}else if($header["GSM_BAHAN_BAKU"] == 0){
							$message = "GSM Bahan Di Database == 0";
						}else{
							$mediumPs = ($header["panjangWasteBelah"]*($header["LEBAR_BAHAN_BAKU"]/100)*$gsm)/$r->SOLID_CONTAIN/1000 ;
    						$display = round($mediumPs, 2);
    						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
							$objSheet->getCell('E'.($start))->setValue($display." Kg");
							// $objSheet->getCell('E'.($start))->setValue($r->GRAMATURE);
						}
					}else if (stristr($namaFormula, 'toluol') !== FALSE) {
						$objSheet->getStyle('E'.($start))->getNumberFormat()->setFormatCode('#,##0.00');
						$objSheet->getCell('E'.($start))->setValue(($sensi["HASIL"]/$r->UKURAN)." Kg");

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
        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$endLineOfSensi)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        	}

        }

        function cetakBelah($objSheet, $belah, $header, &$row, $kolom, $endLineOfSensi){

        	$endLineOfSensi++;
        	$row = $endLineOfSensi;
        	$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('A'.$row)->setValue('Proces (V)');
        	$objSheet->getCell('B'.$row)->setValue(':');
        	$objSheet->getCell('C'.$row)->setValue('Belah + Sortir');

        	$row++;
        	$objSheet->getCell('A'.($row))->setValue('Bahan');
        	$objSheet->getCell('B'.($row))->setValue(':');
        	$objSheet->getCell('C'.($row))->setValue('PETM 12 mic. Holo Sensi Soft Yellow TA '.$header["tahun"]);
        	$objSheet->getCell('I'.($row))->setValue('Target Prod');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue($belah["KECEPATAN_MESIN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
        	$objSheet->getCell('N'.($row))->setValue('WASTE');
        	$objSheet->getCell('O'.($row))->setValue(':');
        	$objSheet->getCell('P'.($row))->setValue($belah["WASTE_PROSES"]);
        	$objSheet->getCell('Q'.($row))->setValue("%");

        	$row++;
        	$row++;
        	$objSheet->getStyle('C'.($row).':G'.($row))->getFont()->setBold(true)->setSize(11);
        	$objSheet->mergeCells('C'.($row).':D'.($row));
        	$objSheet->getCell('C'.($row))->setValue('Hasil Belah ukuran 33 cm ');
        	$hasilBelah = $belah["HASIL"]*2;
        	$objSheet->getStyle('E'.($row))->getNumberFormat()->setFormatCode('#,##0.00');
        	$objSheet->getCell('E'.($row))->setValue($hasilBelah);
        	$objSheet->getCell('F'.($row))->setValue('Meter');
        	$objSheet->getCell('I'.($row))->setValue('Waktu');
        	$objSheet->getCell('J'.($row))->setValue(':');
        	$objSheet->getCell('K'.($row))->setValue("Stel Bahan");
        	$objSheet->getCell('L'.($row))->setValue($belah["STEL_BAHAN"]);
        	$objSheet->getStyle('N'.($row).':Q'.($row))->getFont()->setBold(true)->setSize(11);
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
        	for($i = 0; $i<17; $i++){
        		$objSheet->getStyle(''.$kolom[$i].$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        	}
        }
}