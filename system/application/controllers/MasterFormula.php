<?php

class MasterFormula extends Controller {

function MasterFormula()
	{
		parent::Controller();
        session_start();
        ob_start();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->library(array('Pagination','image_lib','session'));
		$this->load->plugin();
		$this->load->model('Master_formula_model');

	}



function saveData(){

	$data['ID_FORMULA'] = $this->input->post('idFormula');;
	$data['NAMA_FORMULA'] = $this->input->post('namaFormula');
	$data['ID_MESIN'] = $this->input->post('mesin');
	$data['VISCOSITAS'] = $this->input->post('viscositas');
	$data['SOLID_CONTAIN'] = $this->input->post('solidContain');
	$data['GRAMATURE'] = $this->input->post('gramature');
	$data['BERAT'] =$this->input->post('berat');
	$data['SUHU'] = $this->input->post('suhu');
	

	$success = $this->Master_formula_model->saveData($data);
	if($success){
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pengembangan/showDataFormula'>";
	}
}

}