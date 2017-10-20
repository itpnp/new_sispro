<?php
class Master_mutasi_emboss extends Model
{
	public function Master_mutasi_emboss()
	{
		parent::Model();
	}

	
	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('ID_MUTASI');
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		return $t->result();
	}

	function getAllData(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by('ID_MUTASI','asc');
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		return $t->result();
	}
	function updateDetail($id,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_URUT_EMBOSS',$id);
		$success = $this->oracle_db->update('TBL_DETAIL_EMBOSS', $data);
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

	function checkNumber($noMutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_MUTASI',$noMutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		$success = false;
		if($t->num_rows() > 0){
			$success = false;
		}else{
			$success = true;
		}
		return $success;
	}

	function checkNumberByDate($noMutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select('*');
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_MUTASI',$noMutasi);
		$query=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		if($query->num_rows() > 0){
			$result = $query->row();
		}else{
			$result = null;
		}
		return $result;
	}

	function generateNewNumber(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select('MAX(ID_MUTASI) AS biggest, NO_MUTASI');
		$this->oracle_db->trans_begin();
		$this->oracle_db->group_by('ID_MUTASI');
		$this->oracle_db->group_by('NO_MUTASI'); 
		$query=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		if($query->num_rows() > 0){
			$result = $query->row()->NO_MUTASI;
			$result++;
			$result="00".$result;
		}else{
			$result = null;
		}
		return $result;
	}

	function updateMutasi($id,$kodeRoll,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('ID_MUTASI',$id);
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$success = $this->oracle_db->update('TBL_MUTASI_EMBOSS', $data);
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

	// function saveMutasi($data, $dataDetailEmboss){
	// 	$get= $this->getMaxNumber();
	// 	$id = $get[0]->ID_MUTASI;

	// 	if($id==null){
	// 		$id = 1;
	// 	}else{
	// 		$id = $id+1;
	// 	}

		
	// 	$this->oracle_db=$this->load->database('oracle',true);
	// 	$this->oracle_db->trans_begin();
	// 	foreach($dataDetailEmboss as $row){
	// 		$data['ID_MUTASI'] = $id;
	// 		$emboss=explode("@",$row);
	// 		$data["KODE_EMBOSS"] = $emboss[3];
	// 		$data["TOTAL_BAHAN"] = $emboss[2];
	// 		$success = $this->oracle_db->insert('TBL_MUTASI_EMBOSS', $data);
	// 		$id++;
	// 	}
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
			$success = $this->oracle_db->insert('TBL_MUTASI_EMBOSS', $row);
			$id++;
		}

		if($success){
			$dataUpdate = array();
			$dataUpdate['STATUS_MUTASI'] = "MUTASI";
			for($i=0;$i<count($dataComplete);$i++){
				// $getKodeRoll=explode("@",$row);
				$this->oracle_db->where('NO_URUT_EMBOSS',$dataComplete[$i][4]);
				$success = $this->oracle_db->update('TBL_DETAIL_EMBOSS', $dataUpdate);
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
	function findByKodeRoll($kodeRoll){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('KODE_ROLL_BARU',$kodeRoll);
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		return $t->result();
	}

	function getDataWithSameRoll($kodeRoll){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(KODE_ROLL_BARU like '%$kodeRoll%')", NULL, FALSE);
		$this->oracle_db->order_by('ID_MUTASI','desc');
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		return $t->result();
	}

	function findByRollAndMutasi($kodeRoll, $mutasi){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('NO_MUTASI',$mutasi);
		$t=$this->oracle_db->get('TBL_MUTASI_EMBOSS');
		return $t->result();
	}

	function countTotalLength($kodeRoll, $mutasi){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('kode_roll, no_mutasi, sum(total_bahan) as total_bahan');
	   	$this->oracle_db->from('TBL_MUTASI_EMBOSS');
	   	$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('ID_MUTASI',$mutasi);
	   	$this->oracle_db->group_by('kode_roll');
		$this->oracle_db->group_by('no_mutasi'); 
		$t=$this->oracle_db->get();
		return $t->row();
	}
}