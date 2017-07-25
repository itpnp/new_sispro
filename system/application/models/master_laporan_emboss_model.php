<?php
class Master_laporan_emboss_model extends Model
{
	public function Master_laporan_emboss_model()
	{
		parent::Model();
	}

	function getDataByKodeRoll($kodeRoll)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(KODE_ROLL like '%$kodeRoll%')", NULL, FALSE);
		$this->oracle_db->order_by("NO_URUT_EMBOSS", 'desc');
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

}