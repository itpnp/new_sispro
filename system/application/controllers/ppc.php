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
		
		$data['NO_KK'] = $this->input->post('noKK');
		$data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['TGL_PROSES_MESIN'] = $this->input->post('tanggalProses');
		$data['JML_PESANAN'] = $this->input->post('jumlahPesanan');
		$data['MACAM'] = $this->input->post('macam');
		$jumlahPesanan = $this->input->post('jumlahPesanan');
		$wasteProses = $this->input->post('wasteProses');
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
		$mesin = $input.split("-");
		$data['ID_MESIN'] = $mesin[0];
		// $data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['NAMA_PROSES'] = 'Proses Emboss';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		// $data['PANJANG_BAHAN'] = $this->input->post('panjangBahan');
		$data['STEL_PCH'] = $this->input->post('stelPCH');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
		$data['FORMULA'] = $this->input->post('formula');
		$data['HASIL'] = $this->input->post('hasil');

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
					// $sessionHeader = $_SESSION['proses_demet'];
					// echo "ahahahah".$sessionHeader['URUTAN_PRODUKSI'];
					// echo exit();
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
		$mesin = $input.split("-");
		$data['ID_MESIN'] = $mesin[0];
		// $data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['NAMA_PROSES'] = 'Proses Emboss';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
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
					// $sessionHeader = $_SESSION['proses_rewind'];
					// echo "ahahahah".$sessionHeader['URUTAN_PRODUKSI'];
					// echo exit();
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
		$mesin = $input.split("-");
		$data['ID_MESIN'] = $mesin[0];
		// $data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['NAMA_PROSES'] = 'Proses Emboss';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
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
		$mesin = $input.split("-");
		$data['ID_MESIN'] = $mesin[0];
		// $data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['NAMA_PROSES'] = 'Proses Sens';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
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
				$data["masterMesin"] = $this->Master_mesin_model->getAllData();
				if($data["status"]=="PPC"){
					$data["tanggal"] = mdate($datestring, $time);
					$this->load->view('ppc/v_header',$data);
					$this->load->view('ppc/v_side_menu',$data);
					$this->load->view('ppc/v_add_proses_belah',$data);
					$this->load->view('ppc/v_footer',$data);
					if($data["belah"]!=""){
						$this->cetakKK();
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

	function saveBelahOnSession(){
		$input = ($this->input->post('chooseMesin'));
		$mesin = $input.split("-");
		$data['ID_MESIN'] = $mesin[0];
		// $data['ID_BAPOB'] = $this->input->post('noBapob');
		$data['NAMA_PROSES'] = 'Proses Belah dan Sortir';
		$data['URUTAN_PRODUKSI'] = $this->input->post('urutanProduksi');
		$data['KECEPATAN_MESIN'] = $this->input->post('targetProduksi');
		$data['STEL_BAHAN'] = $this->input->post('stelBahan');
		$data['LAMA_PROSES'] = $this->input->post('lamaProses');
		$data['TOTAL_WAKTU'] = $this->input->post('totalTime');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
		$data['HASIL'] = $this->input->post('hasil');
		$data['STEL_SILINDER'] = $this->input->post('stelSilinder');
		$_SESSION['proses_belah']=$data;
		$this->session->set_flashdata('success', 'Proses Berhasil disimpan di session');
		redirect("ppc/addProsesBelah");

	}

	function cetakKK()
        {
            //load librarynya terlebih dahulu
            //jika digunakan terus menerus lebih baik load ini ditaruh di auto load
            $this->load->library("PHPExcel");
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

            	$data = array();
            	$header = $_SESSION['data_header'];
				$emboss = $_SESSION['proses_emboss'];
				$demet= $_SESSION['proses_demet'];
				$rewind = $_SESSION['proses_rewind'];
				$sensi = $_SESSION['proses_sensi'];
				$belah = $_SESSION['proses_belah'];
				$bapob = $_SESSION['data_bapob'];

            	//proses cetak Kartu Kerja Mesin
            	//membuat objek PHPExcel
	            $objPHPExcel = new PHPExcel();
	 
	            $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');

				// set default font size
				$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

				// create the writer
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

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

				for($i=5; $i<9; $i++){
					$objSheet->getCell('B'.$i)->setValue(':');
				}

				$objSheet->mergeCells('C5:E5');
				$objSheet->getCell('C5')->setValue($header["NO_KK"]);

				$objSheet->mergeCells('C6:D6');
				$objSheet->getCell('C6')->setValue($bapob->NOMOR_BAPOB);

				$objSheet->mergeCells('C7:D7');
				$objSheet->getCell('C7')->setValue($header["MACAM"]);

				$objSheet->getCell('C8')->setValue($header["JML_PESANAN"]);
				$objSheet->getCell('D8')->setValue("meter");

				$objSheet->getCell('E8')->setValue("Uk. 66 Cm");

				$objSheet->mergeCells('H5:I5');
				$objSheet->getCell('H5')->setValue("Tgl Pros Msn ");

				$objSheet->mergeCells('H7:I7');
				$objSheet->getCell('H7')->setValue("Bahan ");

				$objSheet->mergeCells('H8:I8');
				$objSheet->getCell('H8')->setValue("Panjang Bhn");

				$objSheet->mergeCells('H9:I9');
				$objSheet->getCell('H9')->setValue("Waste Proses ");

				for($i=5; $i<10; $i++){
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
				$objSheet->getCell('K7')->setValue($bapob->NAMA_BAHAN);
				$objSheet->getCell('K8')->setValue($header["PANJANG_BAHAN"]);
				$objSheet->getCell('L8')->setValue("meter");
				$objSheet->getCell('M8')->setValue("UK");
				$objSheet->getCell('M8')->setValue("66 Cm");
				$objSheet->getCell('K9')->setValue($header["JUMLAH_WASTE_PROSES"]."%");

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].'9')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
				}
				
				$objSheet->getStyle('A10')->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('A10')->setValue('Proces (I)');
				$objSheet->getCell('B10')->setValue(':');
				$objSheet->getCell('C10')->setValue('EMBOSS');

				$objSheet->getCell('A11')->setValue('Bahan');
				$objSheet->getCell('B11')->setValue(':');
				$objSheet->getCell('C11')->setValue($bapob->NAMA_BAHAN);

				$objSheet->getCell('A13')->setValue('Bahan');
				$objSheet->getCell('B13')->setValue(':');
				$objSheet->getCell('C13')->setValue($emboss["FORMULA"]);
				$objSheet->getCell('C14')->setValue("Jumlah");
				$objSheet->getCell('C15')->setValue("Uk");
				$objSheet->getCell('D14')->setValue(":");
				$objSheet->getCell('D15')->setValue(":");

				$idMesin = $emboss["ID_MESIN"];
				$formula = $this->Master_formula_model->findByIdMesin($idMesin);
				$ukuran = $formula[0]->UKURAN;

				$jml = $header["PANJANG_BAHAN"]/$ukuran;

				$jml = round($jml, 0, PHP_ROUND_HALF_UP);

				$objSheet->getCell('E14')->setValue($jml." pch");
				$objSheet->getCell('E15')->setValue("42 cm x 67 cm");

				$objSheet->getCell('I11')->setValue('Target Prod');
				$objSheet->getCell('J11')->setValue(':');
				$objSheet->getCell('K11')->setValue($emboss["KECEPATAN_MESIN"]);

				$objSheet->getCell('I13')->setValue('WAKTU');
				$objSheet->getCell('J13')->setValue(':');
				$objSheet->getCell('k13')->setValue('Stel PCH'); $objSheet->getCell('L13')->setValue($emboss["STEL_PCH"]);
				$objSheet->getCell('k14')->setValue('Stel Bahan'); $objSheet->getCell('L14')->setValue($emboss["STEL_BAHAN"]);
				$objSheet->getCell('k14')->setValue('Stel Bahan'); $objSheet->getCell('L14')->setValue($emboss["STEL_BAHAN"]);
				$objSheet->getCell('k15')->setValue('Stel Proses');$objSheet->getCell('L15')->setValue($emboss["LAMA_PROSES"]);
				$objSheet->getStyle('L15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objSheet->getStyle('K16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objSheet->getCell('k16')->setValue('TOTAL');
				$objSheet->getCell('L16')->setValue($emboss["TOTAL_WAKTU"]);

				$objSheet->getStyle('N11:Q11')->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('N11')->setValue('WASTE');
				$objSheet->getCell('O11')->setValue(':');
				$objSheet->getCell('P11')->setValue($emboss["WASTE_PROSES"]);
				$objSheet->getCell('Q11')->setValue("%");

				$objSheet->getStyle('N13:Q13')->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('N13')->setValue('Hasil');
				$objSheet->getCell('O13')->setValue(':');
				$objSheet->getCell('P13')->setValue(intval($emboss["HASIL"]));
				$objSheet->getCell('Q13')->setValue("m");

				for($i = 0; $i<17; $i++){
					$objSheet->getStyle(''.$kolom[$i].'17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
				}

				//ini proses selanjutnya
				$row = 18;
				$objSheet->getStyle('A'.$row)->getFont()->setBold(true)->setSize(11);
				$objSheet->getCell('A'.$row)->setValue('Proces (II)');
				$objSheet->getCell('B'.$row)->setValue(':');
				$objSheet->getCell('C'.$row)->setValue('DEMET');

				$objSheet->getCell('A'.($row+1))->setValue('Bahan');
				$objSheet->getCell('B'.($row+1))->setValue(':');
				$objSheet->getCell('C'.($row+1))->setValue('Hasil Emboss');
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
				$objSheet->getCell('P'.($row+3))->setValue(intval($demet["HASIL"]));
				$objSheet->getCell('Q'.($row+3))->setValue("m");


				$objSheet->getCell('A'.($row+2))->setValue('Formula');
				$objSheet->getCell('B'.($row+2))->setValue(':');

				$idMesin = $demet["ID_MESIN"];
				$listFormula = $this->Master_formula_model->findByIdMesin($idMesin);

				foreach($listFormula as $r){
					$objSheet->getCell('C'.($row+2))->setValue($r->NAMA_FORMULA);
					$row++;
				}


				// autosize the columns
				$objSheet->getColumnDimension('A')->setAutoSize(true);
				$objSheet->getColumnDimension('B')->setWidth(2);
				$objSheet->getColumnDimension('C')->setAutoSize(true);
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
				header('Content-Disposition: attachment;filename="file.xlsx"');
				header('Cache-Control: max-age=0');
	           
	            //ubah nama file saat diunduh
	            // header('Content-Disposition: attachment;filename="hasilExcel.xlsx"');

	            //unduh file
	            $objWriter->save("php://output");
	 
	            //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
	            // Folder Documentation dan Example
	            // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu

            }//end if - else
           
 
        }
}