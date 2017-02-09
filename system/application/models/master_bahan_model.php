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
}