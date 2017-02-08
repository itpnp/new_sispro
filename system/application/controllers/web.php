<?php

class Web extends Controller {

	function Web()
	{
		parent::Controller();
		$this->load->helper(array('form','url', 'text_helper','date'));
		$this->load->database();
		$this->load->library(array('Pagination','user_agent'));
		$this->load->plugin();
		session_start();
	}

	function index()
	{
		$this->load->view('home/login');;
	}
	function login()
	{
		$username = $this->input->post('username');
		$pwd = $this->input->post('password');

		$this->load->model('Web_model');
		$hasil = $this->Web_model->Data_Login($username,$pwd);
		if (count($hasil->result_array())>0){
			foreach($hasil->result() as $items){
				$session_username=$items->USERNAME."|".$items->USERNAME."|".$items->BAGIAN;
				$tanda=$items->BAGIAN;
			}
			$_SESSION['username_belajar']=$session_username;
			if($tanda=="Pimpinan"){
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pimpinan'>";
			}
			else if($tanda=="Administrator"){
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin'>";
			}else if($tanda=="PGB"){
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pengembangan'>";
			}else if($tanda=="PPC"){
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/ppc'>";
			}
			else {
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/kabag'>";
			}
		}
		else{
			?>
			<script type="text/javascript">
				alert("Username atau Password Yang Anda Masukkan Salah..!!!");			
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}
	function logout()
	{
		session_destroy();
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}
?>