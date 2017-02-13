<?php
class Master_bahan_model extends Model
{
	public function Master_bahan_model()
	{
		parent::Model();
	}

	public function getAllData()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(DESAIN='2016' OR DESAIN='2017')", NULL, FALSE);
		$t=$this->oracle_db->get('TBL_MASTER_BAHAN');
		return $t->result();
	}

	function getBahan()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_bahan where JENIS='FL' and seri ='9' and aktif='1' ORDER BY KODE_BAHAN ");
			return $t->result();
		}
}