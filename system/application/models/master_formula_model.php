<?php
class Master_formula_model extends Model
{
	public function Master_formula_model()
	{
		parent::Model();
	}

	public function getAllData()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->get('TBL_MASTER_FORMULA');
		return $t->result();
	}

	public function saveData($data)
	{
		try{

			$errors = array();

			$this->oracle_db=$this->load->database('oracle',true);
			$max_query=$this->oracle_db->query("SELECT NVL(MAX(id_formula),0)+1 AS NO_URUT_FORMULA  FROM TBL_MASTER_FORMULA ");
			$max=$max_query->row();
			$no_urut=$max->NO_URUT_FORMULA;
			$this->oracle_db->trans_begin();
				// $this->oracle_db->insert('TBL_MASTER_MESIN',$data);
			$success = $this->oracle_db->query("INSERT INTO TBL_MASTER_FORMULA(ID_FORMULA,NAMA_FORMULA,VISCOSITAS,SOLID_CONTAIN,GRAMATURE,BERAT,SUHU,ID_PROSES) VALUES (".$this->oracle_db->escape($no_urut).",".$this->oracle_db->escape($data['NAMA_FORMULA']).",".$this->oracle_db->escape($data['VISCOSITAS']).",".$this->oracle_db->escape($data['SOLID_CONTAIN']).",".$this->oracle_db->escape($data['GRAMATURE']).",".$this->oracle_db->escape($data['BERAT']).",".$this->oracle_db->escape($data['SUHU']).",'1')");

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
			$success = $this->oracle_db->query("UPDATE TBL_MASTER_FORMULA set NAMA_FORMULA = ".$this->oracle_db->escape($data['NAMA_FORMULA']).", VISCOSITAS = ".$this->oracle_db->escape($data['VISCOSITAS']).", SOLID_CONTAIN= ".$this->oracle_db->escape($data['SOLID_CONTAIN']).", GRAMATURE = ".$this->oracle_db->escape($data['GRAMATURE']).", BERAT = ".$this->oracle_db->escape($data['BERAT']).", SUHU = ".$this->oracle_db->escape($data['SUHU'])." where ID_FORMULA = ".$this->oracle_db->escape($data['ID_FORMULA'])." ");
			return $success;
		}catch(Exception $e){
			var_dump($e);
		}
	}

	public function findById($idFormula)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_FORMULA where ID_FORMULA = '$idFormula'");
		return $t;
	}

	public function findByIdMesin($idMesin)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_FORMULA where ID_Mesin= '$idMesin'");
		return $t->result();
	}
}