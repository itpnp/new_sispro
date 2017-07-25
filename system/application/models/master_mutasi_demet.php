<?php
class Master_mutasi_demet extends Model
{
	public function Master_mutasi_demet()
	{
		parent::Model();
	}

	
	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('ID_MUTASI');
		$t=$this->oracle_db->get('TBL_MUTASI_DEMET');
		return $t->result();
	}

	function checkNumber($noMutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_MUTASI',$noMutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_DEMET');
		$success = false;
		if($t->num_rows() > 0){
			$success = false;
		}else{
			$success = true;
		}
		return $success;
	}

	function updateMutasi($id,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_MUTASI',$id);
		$success = $this->oracle_db->update('TBL_MUTASI_DEMET', $data);
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

	function saveMutasi($data, $dataDetailDemet){
		$get= $this->getMaxNumber();
		$id = $get[0]->ID_MUTASI;

		if($id==null){
			$id = 1;
		}else{
			$id = $id+1;
		}

		$data['ID_MUTASI'] = $id;
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		foreach($dataDetailDemet as $row){
			$demet=explode("@",$row);
			$data["KODE_DEMET"] = $demet[3];
			$data["TOTAL_BAHAN"] = $demet[2];
			$id++;
			$data['ID_MUTASI'] = $id;
			$success = $this->oracle_db->insert('TBL_MUTASI_DEMET', $data);
		}
		if($success){
			$dataUpdate = array();
			$dataUpdate['STATUS_MUTASI'] = "MUTASI";
			foreach($dataDetailDemet as $row){
				$getKodeRoll=explode("@",$row);
				$this->oracle_db->where('NO_URUT_DEMET',$getKodeRoll[0]);
					$success = $this->oracle_db->update('TBL_DETAIL_DEMET', $dataUpdate);
					if(!$success){
						break;
					}
			}
			$this->oracle_db->trans_commit();
			$this->oracle_db->trans_complete();
				if(!$success){
					$success = false;
					$errNo   = $this->oracle_db->_error_number();
					$errMess = $this->oracle_db->_error_message();
					array_push($errors, array($errNo, $errMess));
				}
			}

		return $success;
	}

	function findByRollAndMutasi($kodeRoll, $mutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('NO_MUTASI',$mutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_DEMET');
		return $t->result();
	}
}