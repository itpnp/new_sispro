<?php
class Master_mesin_model extends Model
{
	public function Master_mesin_model()
	{
		parent::Model();
	}

	public function getAllData()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select('a.*, b.WASTE_PROSES as waste_bapob');    
	  	$this->oracle_db->from('TBL_MASTER_MESIN a');
	  	$this->oracle_db->join('TBL_MASTER_PROSES_BAPOB b', 'a.ID_MESIN= b.ID_MESIN');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	public function getDataMesin($idMesin, $desain)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select('a.*, b.WASTE_PROSES as waste_bapob');    
	  	$this->oracle_db->from('TBL_MASTER_MESIN a');
	  	$this->oracle_db->join('TBL_MASTER_PROSES_BAPOB b', 'a.ID_MESIN= b.ID_MESIN');
	  	$this->oracle_db->where('a.ID_MESIN',$idMesin);
	  	$this->oracle_db->where('a.DESAIN',$desain);
		$t=$this->oracle_db->get();
		return $t->result();
	}

	public function saveData($data)
	{
		try{

			$errors = array();

			$this->oracle_db=$this->load->database('oracle',true);
			$this->oracle_db->trans_begin();
				// $this->oracle_db->insert('TBL_MASTER_MESIN',$data);
			$success = $this->oracle_db->query("INSERT INTO TBL_MASTER_MESIN (ID_MESIN,NAMA_MESIN,KECEPATAN_MESIN,LAMA_PERSIAPAN,WASTE_STEL,ID_MASTER_PROSES,WASTE_PROSES) VALUES (".$this->oracle_db->escape($data['ID_MESIN']).",".$this->oracle_db->escape($data['NAMA_MESIN']).",".$this->oracle_db->escape($data['KECEPATAN_MESIN']).",".$this->oracle_db->escape($data['LAMA_PERSIAPAN']).",".$this->oracle_db->escape($data['WASTE_STEL']).",".$this->oracle_db->escape($data['ID_PROSES']).",".$this->oracle_db->escape($data['WASTE_PROSES']).")");

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
	public function updateData($data){
		try{

			$this->oracle_db=$this->load->database('oracle',true);
			$this->oracle_db->trans_begin();
			$success = $this->oracle_db->query("UPDATE TBL_MASTER_MESIN set NAMA_MESIN = ".$this->oracle_db->escape($data['NAMA_MESIN']).", KECEPATAN_MESIN = ".$this->oracle_db->escape($data['KECEPATAN_MESIN']).", LAMA_PERSIAPAN = ".$this->oracle_db->escape($data['LAMA_PERSIAPAN']).", WASTE_STEL = ".$this->oracle_db->escape($data['WASTE_STEL']).", ID_MASTER_PROSES = ".$this->oracle_db->escape($data['ID_PROSES']).", WASTE_PROSES = ".$this->oracle_db->escape($data['WASTE_PROSES'])." where ID_MESIN = ".$this->oracle_db->escape($data['ID_MESIN'])." ");
			return $success;
		}catch(Exception $e){
			var_dump($e);
		}
	}

	public function findById($idMesin)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_MESIN where ID_MESIN = '$idMesin'");
		return $t;
	}

	public function findByName($namaMesin,$tahunDesain)
	{
		try{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_MESIN where NAMA_MESIN = '$namaMesin' AND DESAIN = '$tahunDesain'");
		return $t->result();
		}catch(Exception $e){
			var_dump($e);
		}
	}
}