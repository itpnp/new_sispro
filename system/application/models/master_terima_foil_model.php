<?php
class Master_terima_foil_model extends Model
{
	public function Master_terima_foil_model()
	{
		parent::Model();
	}

	function getDataByKodeBahan($kodeBahan)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(KODE_BAHAN='$kodeBahan')", NULL, FALSE);
		$this->oracle_db->order_by("NO_URUT_DATANG", "asc");
		$t=$this->oracle_db->get('TBL_TERIMA_FOIL');
		return $t->result();
	}
	function getBahanFoil()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("select * from tbl_master_bahan where JENIS='FL' and seri ='9' and aktif='1' ORDER BY KODE_BAHAN ");
		return $t->result();
	}

	function findByKodeRoll($kodeRoll)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		$roll = null;
		if (strpos($kodeRoll, '/') !== false) {
			$roll=explode("/",$kodeRoll);
			$roll = $roll[0];
		}else{
			$roll = $kodeRoll;
		}
		// echo $roll." : ";
		$t=$this->oracle_db->query("select * from tbl_terima_foil where KODE_ROLL = '".$roll."'");
		return $t->row();
	}
}