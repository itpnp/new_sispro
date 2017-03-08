<?php
class Master_kk_model extends Model
{
	public function Master_kk_model()
	{
		parent::Model();
	}

	function getLastNumber($tahun){
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_KK where TAHUN = '$tahun' order by NOMOR_KK DESC");
		return $t->result();
	}

	function saveData($data)
	{
		try{
			$x =date("d/m/Y", strtotime($data['TGL_PROSES_MESIN']));
			// $x = str_replace(" ", "/",$data['TGL_PROSES_MESIN']);
			$errors = array();
			$this->oracle_db=$this->load->database('oracle',true);
			$this->oracle_db->trans_begin();
			$success = $this->oracle_db->query("INSERT INTO TBL_MASTER_KK(NOMOR_KK,KODE_BAHAN,JML_PESANAN,DESAIN,TAHUN,NOMOR_BAPOB,TANGGAL_PROSES_MESIN, DELIVERY_TIME) VALUES (".$this->oracle_db->escape($data['NO_KK']).",".$this->oracle_db->escape($data['KODE_BAHAN']).",".$this->oracle_db->escape($data['JML_PESANAN']).",".$this->oracle_db->escape($data['tahun']).",".$this->oracle_db->escape($data['tahunKKdibuat']).",".$this->oracle_db->escape($data['ID_BAPOB']).",to_date(".$this->oracle_db->escape($x).",'DD/MM/YYYY'),".$this->oracle_db->escape($data['delivery_time']).")");
			$this->oracle_db->trans_commit();

			if(!$success){
				$success = false;
				$errNo   = $this->oracle_db->_error_number();
				$errMess = $this->oracle_db->_error_message();
				array_push($errors, array($errNo, $errMess));
			}
			return $success;
		}catch(Exception $e){
			var_dump($e);
		}

	}

	function checkNumber($number){
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_KK where NOMOR_KK = '$number'");
		$count  = $t->num_rows();

		if($count === 0){
			return false;
		}
			return true;		
	}
}