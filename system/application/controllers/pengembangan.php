<?php

class Pengembangan extends Controller {

	function Pengembangan()
	{
		parent::Controller();
		session_start();
		ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
		$this->load->model('Master_proses_model');
		$this->load->model('Master_mesin_model');
		$this->load->model('Master_formula_model');

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
		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data["tanggal"] = mdate($datestring, $time);
				$data['result'] = $this->Master_mesin_model->getAllData();
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/index',$data);
				$this->load->view('pengembangan/bg_ska',$data);
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

	function addDataMesin(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
		// $data['scriptmce'] = $this->scripttiny_mce();
			$data['masterProses'] = $this->Master_proses_model->getProses();
			if($data["status"]=="PGB"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_mesin_add');
				$this->load->view('pengembangan/bg_ska',$data);
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
		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data['result'] = $this->Master_mesin_model->getAllData();
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_mesin_home',$data);
				$this->load->view('pengembangan/bg_ska',$data);
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

	function updateDataMesin(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
			$idMesin = '';
			if ($this->uri->segment(3) === FALSE)
			{
    			$idMesin='';
			}else{
    			$idMesin = $this->uri->segment(3);
			}
			$data["mesin"] = $this->Master_mesin_model->findById($idMesin);
			$data['masterProses'] = $this->Master_proses_model->getProses();

		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_mesin_update', $data);
				$this->load->view('pengembangan/bg_ska',$data);
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

	function saveUpdateDataMesin(){

		$data['ID_MESIN'] = $this->input->post('idMesin');
		$data['NAMA_MESIN'] = $this->input->post('namaMesin');
		$data['KECEPATAN_MESIN'] = $this->input->post('kecepatanMesin');
		$data['LAMA_PERSIAPAN'] = $this->input->post('lamaPersiapan');
		$data['WASTE_STEL'] = $this->input->post('wasteStel');
		$data['WASTE_PROSES'] = $this->input->post('wasteProses');
		$data['ID_PROSES'] = $this->input->post('proses');

		$success = $this->Master_mesin_model->updateData($data);
		if($success){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pengembangan/editDataMesin'>";
		}
}

function editDataMesin(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data['result'] = $this->Master_mesin_model->getAllData();
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_mesin_bapob',$data);
				$this->load->view('pengembangan/bg_ska',$data);
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

	function editDataFormula(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data['result'] = $this->Master_formula_model->getAllData();
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_formula_bapob',$data);
				$this->load->view('pengembangan/bg_ska',$data);
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
		// $data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="PGB"){
				$data['result'] = $this->Master_formula_model->getAllData();
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_formula_home',$data);
				$this->load->view('pengembangan/bg_ska',$data);
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

function addDataFormula(){
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nim"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["status"]=$pecah[2];
		// $data['scriptmce'] = $this->scripttiny_mce();
			$data['masterMesin'] = $this->Master_mesin_model->getAllData();
			if($data["status"]=="PGB"){
				$data["tanggal"] = mdate($datestring, $time);
				$this->load->view('pengembangan/bg_atas',$data);
				$this->load->view('pengembangan/bg_menu',$data);
				$this->load->view('pengembangan/master_formula_add');
				$this->load->view('pengembangan/bg_ska',$data);
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
}