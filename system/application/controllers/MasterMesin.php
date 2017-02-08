<?php

class MasterMesin extends Controller {

function MasterMesin()
	{
		parent::Controller();
        session_start();
        ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
		$this->load->model('Admin_model');
		$this->load->model('Master_proses_model');

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
		if($data["status"]=="AdminR&D" || $data["status"]=="Administrator"){
			$data["tanggal"] = mdate($datestring, $time);
			$this->load->view('admin/bg_atas',$data);
			$this->load->view('admin/bg_menu',$data);
			$this->load->view('admin/master_mesin_home',$data);
			$this->load->view('admin/bg_ska',$data);
		}else{
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

function saveData(){

	$data['ID_MESIN'] = '1';
	$data['NAMA_MESIN'] = $this->input->post('namaMesin');
	$data['KECEPATAN_MESIN'] = $this->input->post('kecepatanMesin');
	$data['LAMA_PERSIAPAN'] = $this->input->post('lamaPersiapan');
	$data['WASTE_STEL'] = $this->input->post('wasteStel');
	$data['WASTE_PROSES'] = $WASTE_PROSES = $this->input->post('wasteProses');
	$data['ID_PROSES'] = $ID_PROSES = $this->input->post('proses');
	

	$success = $this->Master_proses_model->saveData($data);
	if($success){
		echo "success";
	}
}

}