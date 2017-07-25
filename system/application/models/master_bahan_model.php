<?php
class Master_bahan_model extends Model
{
	public function Master_bahan_model()
	{
		parent::Model();
	}

	function getAllData()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(DESAIN='2016' OR DESAIN='2017')", NULL, FALSE);
		$this->oracle_db->where("(JENIS='FL')", NULL, FALSE);
		$t=$this->oracle_db->get('TBL_MASTER_BAHAN');
		return $t->result();
	}
	function getBahanFoil()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_bahan where JENIS='FL' and seri ='9' and aktif='1' ORDER BY KODE_BAHAN ");
			return $t->result();
		}
	function getBahanFoilByDesain($tahun){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('DESAIN',$tahun);
		$this->oracle_db->where("(JENIS='FL')", NULL, FALSE);
		$this->oracle_db->where("(AKTIF='1')", NULL, FALSE);
		$t=$this->oracle_db->get('TBL_MASTER_BAHAN');
		return $t->result();
	}

	function getBahanFoilByKodeBahan($kodeBahan){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where('KODE_BAHAN',$kodeBahan);
		$t=$this->oracle_db->get('TBL_MASTER_BAHAN');
		return $t->result();
	}

}