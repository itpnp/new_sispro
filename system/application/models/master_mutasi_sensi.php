<?php
class Master_mutasi_sensi extends Model
{
	public function Master_mutasi_sensi()
	{
		parent::Model();
	}

	
	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('ID_MUTASI');
		$t=$this->oracle_db->get('TBL_MUTASI_SENSI');
		return $t->result();
	}

	function getAllData(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by('ID_MUTASI','asc');
		$t=$this->oracle_db->get('TBL_MUTASI_SENSI');
		return $t->result();
	}

	// function updateMutasi($id,$data){
	// 	$this->oracle_db=$this->load->database('oracle',true);
	// 	$this->oracle_db->trans_begin();
	// 	$this->oracle_db->where('NO_MUTASI',$id);
	// 	$success = $this->oracle_db->update('TBL_MUTASI_SENSI', $data);
	// 	$this->oracle_db->trans_commit();
	// 	$this->oracle_db->trans_complete();
	// 	if(!$success){
	// 		$success = false;
	// 		$errNo   = $this->oracle_db->_error_number();
	// 		$errMess = $this->oracle_db->_error_message();
	// 		array_push($errors, array($errNo, $errMess));
	// 	}

	// 	return $success;

	// }
	function updateMutasi($id,$kodeRoll,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('ID_MUTASI',$id);
		$success = $this->oracle_db->update('TBL_MUTASI_SENSI', $data);
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
	// function saveMutasi($data, $dataDetailRewind){
	// 	$get= $this->getMaxNumber();
	// 	$id = $get[0]->ID_MUTASI;

	// 	if($id==null){
	// 		$id = 1;
	// 	}else{
	// 		$id = $id+1;
	// 	}

	// 	$data['ID_MUTASI'] = $id;
	// 	$this->oracle_db=$this->load->database('oracle',true);
	// 	$this->oracle_db->trans_begin();
	// 	foreach($dataDetailRewind as $row){
	// 		$rewind=explode("@",$row);
	// 		$data["KODE_SENSI"] = $rewind[3];
	// 		$data["TOTAL_BAHAN"] = $rewind[2];
	// 		$id++;
	// 		$data['ID_MUTASI'] = $id;
	// 		$success = $this->oracle_db->insert('TBL_MUTASI_SENSI', $data);
	// 	}
	// 	if($success){
	// 		$dataUpdate = array();
	// 		$dataUpdate['STATUS_MUTASI'] = "MUTASI";
	// 		foreach($dataDetailRewind as $row){
	// 			$getKodeRoll=explode("@",$row);
	// 			$this->oracle_db->where('NO_URUT_SENSI',$getKodeRoll[0]);
	// 				$success = $this->oracle_db->update('TBL_DETAIL_SENSI', $dataUpdate);
	// 				if(!$success){
	// 					break;
	// 				}
	// 		}
	// 		$this->oracle_db->trans_commit();
	// 		$this->oracle_db->trans_complete();
	// 			if(!$success){
	// 				$success = false;
	// 				$errNo   = $this->oracle_db->_error_number();
	// 				$errMess = $this->oracle_db->_error_message();
	// 				array_push($errors, array($errNo, $errMess));
	// 			}
	// 		}

	// 	return $success;
	// }
	function saveMutasi($data, $dataComplete){
		$get= $this->getMaxNumber();
		$id = $get[0]->ID_MUTASI;

		if($id==null){
			$id = 1;
		}else{
			$id = $id+1;
		}

		
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		foreach($data as $row){
			$row['ID_MUTASI'] = $id;
			// $emboss=explode("@",$row);
			// $data["KODE_EMBOSS"] = $emboss[3];
			// $data["TOTAL_BAHAN"] = $emboss[2];
			$success = $this->oracle_db->insert('TBL_MUTASI_SENSI', $row);
			$id++;
		}

		if($success){
			$dataUpdate = array();
			$dataUpdate['STATUS_MUTASI'] = "MUTASI";
			for($i=0;$i<count($dataComplete);$i++){
				// $getKodeRoll=explode("@",$row);
				$this->oracle_db->where('NO_URUT_SENSI',$dataComplete[$i][4]);
				$success = $this->oracle_db->update('TBL_DETAIL_SENSI', $dataUpdate);
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
	function chooseKodeRoll(){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	// $this->oracle_db->select('kode_roll,no_mutasi, sum(total_bahan) as total_bahan');
	   	$this->oracle_db->select('kode_roll, id_mutasi,no_mutasi,total_bahan');
	   	$this->oracle_db->from('TBL_MUTASI_SENSI');
		$this->oracle_db->where('STATUS_BELAH','progress');
	 //   	$this->oracle_db->group_by('kode_roll');
		// $this->oracle_db->group_by('no_mutasi'); 
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function checkNumber($noMutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_MUTASI',$noMutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_SENSI');
		$success = false;
		if($t->num_rows() > 0){
			$success = false;
		}else{
			$success = true;
		}
		return $success;
	}

	function countTotalLength($kodeRoll, $mutasi){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('kode_roll, no_mutasi, sum(total_bahan) as total_bahan');
	   	$this->oracle_db->from('TBL_MUTASI_SENSI');
	   	$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('ID_MUTASI',$mutasi);
	   	$this->oracle_db->group_by('kode_roll');
		$this->oracle_db->group_by('no_mutasi'); 
		$t=$this->oracle_db->get();
		return $t->row();
	}

	function findByRollAndMutasi($kodeRoll, $mutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('NO_MUTASI',$mutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_SENSI');
		return $t->result();
	}
}