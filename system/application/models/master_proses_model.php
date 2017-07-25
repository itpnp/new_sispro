<?php
class Master_proses_model extends Model
{
	public function Master_proses_model()
		{
			parent::Model();
		}

	public function getProses()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_proses_kk");
			return $t->result();
		}

	public function saveData($data)
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $idMesin = $data['ID_MESIN'];
		    $query=$this->oracle_db->query("SELECT * FROM TBL_MASTER_PROSES_KK");
		    $idMasterProses = 0;
		    if($query->num_rows() > 0){
		    	$this->oracle_db->select_max('ID_MASTER_PROSES_KK');
		    	$getLastId =$this->oracle_db->get('TBL_MASTER_PROSES_KK');
		    	$getLastId = $getLastId->result_array();
		    	$idMasterProses = $getLastId[0]['ID_MASTER_PROSES_KK']+1;
		    	$idMasterProses = $this->oracle_db->escape($idMasterProses);
		    }else{
		    	$idMasterProses = 1;
		    }

		    $query2=$this->oracle_db->query("SELECT * FROM TBL_MASTER_PROSES_KK where ID_MESIN = '$idMesin'");
		    $this->oracle_db->trans_begin();
		    if($query2->num_rows() > 0){
		    	$success = $this->oracle_db->query("UPDATE TBL_MASTER_PROSES_KK set ID_BAPOB = ".$this->oracle_db->escape($data['ID_BAPOB']).", NAMA_PROSES = ".$this->oracle_db->escape($data['NAMA_PROSES']).", KECEPATAN_MESIN= ".$this->oracle_db->escape($data['KECEPATAN_MESIN']).", URUTAN_PRODUKSI = ".$this->oracle_db->escape($data['URUTAN_PRODUKSI']).", PANJANG_BAHAN = ".$data['PANJANG_BAHAN'].", WASTE_PROSES = ".$this->oracle_db->escape($data['WASTE_PROSES']).", STEL_BAHAN = ".$this->oracle_db->escape($data['STEL_BAHAN']).", STEL_PCH = ".$this->oracle_db->escape($data['STEL_PCH']).", STEL_SILINDER = ".$this->oracle_db->escape($data['STEL_SILINDER'])." where ID_MESIN = ".$this->oracle_db->escape($data['ID_MESIN'])." ");
		    	
		    }else{
		    	$success = $this->oracle_db->query("INSERT INTO TBL_MASTER_PROSES_KK(ID_MESIN,ID_BAPOB,NAMA_PROSES,KECEPATAN_MESIN,URUTAN_PRODUKSI,PANJANG_BAHAN,WASTE_PROSES,STEL_BAHAN, STEL_PCH, STEL_SILINDER,ID_MASTER_PROSES_KK) VALUES (".$this->oracle_db->escape($data['ID_MESIN']).",".$this->oracle_db->escape($data['ID_BAPOB']).",".$this->oracle_db->escape($data['NAMA_PROSES']).",".$this->oracle_db->escape($data['KECEPATAN_MESIN']).",".$this->oracle_db->escape($data['URUTAN_PRODUKSI']).",".$data['PANJANG_BAHAN'].",".$this->oracle_db->escape($data['WASTE_PROSES']).",".$this->oracle_db->escape($data['STEL_BAHAN']).",".$this->oracle_db->escape($data['STEL_PCH']).",".$this->oracle_db->escape($data['STEL_SILINDER']).",'$idMasterProses')");
		    }
		    $this->oracle_db->trans_commit();
		    $this->oracle_db->trans_complete();
			if(!$success){
				$success = false;
				$errNo   = $this->oracle_db->_error_number();
				$errMess = $this->oracle_db->_error_message();
				array_push($errors, array($errNo, $errMess));
			}

			return $success;
		}
}