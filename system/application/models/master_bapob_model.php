<?php
class Master_bapob_model extends Model
{
	public function Master_bapob_model()
		{
			parent::Model();
		}

	public function getDefaultBapob()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_bapob a inner join tbl_master_bahan b on a.id_kode_bahan = b.kode_bahan  where a.status_default = 1");
			return $t->result();

		}

		public function getAllData()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT t.*,a.nama_bahan from tbl_master_bapob t,tbl_master_bahan a where t.id_kode_bahan =a.kode_bahan order by nomor_bapob,tanggal_dibuat desc");
		return $t->result();
	}	

	public function saveData($data)
	{
		try{

			$errors = array();

			$this->oracle_db=$this->load->database('oracle',true);
			$max_query=$this->oracle_db->query("SELECT NVL(MAX(id_bapob),0)+1 AS NO_URUT_BAPOB  FROM TBL_MASTER_BAPOB ");
			$max=$max_query->row();
			$no_urut=$max->NO_URUT_BAPOB;
			
			$this->oracle_db->trans_begin();
				// $this->oracle_db->insert('TBL_MASTER_MESIN',$data);
			$success = $this->oracle_db->query("INSERT INTO TBL_MASTER_BAPOB(ID_BAPOB,ID_KODE_BAHAN,JML_PESANAN,NOMOR_BAPOB,STATUS_LOCK,STATUS_DEFAULT,TANGGAL_DIBUAT) VALUES (".$this->oracle_db->escape($no_urut).",".$this->oracle_db->escape($data['ID_KODE_BAHAN']).",".$this->oracle_db->escape($data['JML_PESANAN']).",".$this->oracle_db->escape($data['NOMOR_BAPOB']).",'0','1',to_date(".$this->oracle_db->escape($data['TANGGAL_DIBUAT']).",'DD/MM/YYYY'))");

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

}